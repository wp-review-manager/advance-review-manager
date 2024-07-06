<?php
declare(strict_types=1);

namespace ADReviewManager\Models;
use ADReviewManager\Services\ArrayHelper as Arr;
if (!class_exists('ADReviewManager\Services\ArrayHelper', true)) {
    require ADRM_DIR . 'includes/services/ArrayHelper.php';
}

class Review extends Model
{
    public function create() {
        if (!wp_verify_nonce($_REQUEST['nonce'], 'advance-review-manager-nonce')) {
            wp_send_json_error(
                [
                    'message' => "Nonce verification failed."
                ],
            423);
        } else {
            global $wpdb;
            $data = $_POST;
            $data = self::sanitizeData($data);
            $formID = $data['formID'];
            $formData = array(
                'formComponent' => $data['formComponent'],
                'formFieldData' => $data['formFieldData'],
            );

            $formData = maybe_serialize($formData);

            try {
                $wpdb->insert(
                    $wpdb->prefix . 'adrm_reviews',
                    array(
                        'form_id' => $formID,
                        'meta' => $formData,
                        'created_at' => current_time('mysql'),
                        'updated_at' => current_time('mysql')
                    )
                );
                wp_send_json_success([
                    'message' => 'Review created successfully'
                ]);
            } catch (\Exception $e) {
                wp_send_json_error( [
                    'message' => $e->getMessage()
                ], 423);
            }
        }
    }

    public function getReviews($formID, $nonce = '', $filter = null, $sort = 'newest') {

        if (!wp_verify_nonce($_REQUEST['nonce'], 'advance-review-manager-nonce')) {
            wp_send_json_error(
                [
                    'message' => "Nonce verification failed."
                ],
            423);
        } else {
            global $wpdb;
            $request = $_REQUEST;
            // Sanitize input
            $formID = sanitize_text_field($formID);
            $sortOrder = $sort == 'newest' ? 'DESC' : 'ASC';

            // Fetch pagination settings
            $template_settings = maybe_unserialize(get_post_meta($formID, 'adrm_template_settings', true));
            $pagination = Arr::get($template_settings, 'pagination', []);
            $limit = Arr::get($pagination, 'per_page', 10);
            $page = max(1, sanitize_text_field(Arr::get($request, 'page', 1))); // Ensure page is at least 1
            $offset = ($page - 1) * $limit;

            if (Arr::get($pagination, 'enable') == 'false') {
                $limit = 1000000000; // Arbitrary large number to effectively disable pagination
                $offset = 0;
            }

            // Properly include ORDER BY in prepared SQL
            $table_name = "{$wpdb->prefix}adrm_reviews"; // Safe table name via WPDB prefix
            // $query = "SELECT * FROM $table_name WHERE form_id = %d";

            // // Add ORDER BY clause safely
            // $query .= sprintf(" ORDER BY created_at %s", in_array($sortOrder, ['ASC', 'DESC']) ? $sortOrder : 'ASC');

            // // Add LIMIT and OFFSET
            // $query .= " LIMIT %d OFFSET %d";

            if (!in_array(strtoupper($sortOrder), ['ASC', 'DESC'])) {
                $sortOrder = 'ASC';  // Default to 'ASC' if invalid
            }
            
            // Prepare SQL with safe placeholders for variables
            // $final_sql = $wpdb->prepare("SELECT * FROM $table_name WHERE form_id = %d ORDER BY created_at {$sortOrder} LIMIT %d OFFSET %d", $formID, $limit, $offset);
       
            $sql = $wpdb->prepare("SELECT * FROM %1s WHERE form_id = %d ORDER BY created_at %1s LIMIT %d OFFSET %d", $table_name, $formID, $sortOrder, $limit, $offset);
            $reviews = $wpdb->get_results($sql, ARRAY_A);

            // Fetch total reviews count
            // $total_reviews_sql = $wpdb->prepare(
            //     "SELECT COUNT(*) FROM {$wpdb->prefix}adrm_reviews WHERE form_id = %d",
            //     $formID
            // );

            $query = $wpdb->prepare("SELECT COUNT(*) FROM %1s WHERE form_id = %d", $table_name, $formID);
            $total_reviews = $wpdb->get_var($query);

            // Process reviews
            $reviews = static::processReviewData($reviews);
            $all_reviews = static::processReviewData($reviews);
        
            // Apply filter if provided
            if (!empty($filter) && $filter != 'all') {  
                $reviews = array_filter($reviews, function($review) use ($filter) {
                    return Arr::get($review, 'average_rating', 0) == $filter;
                });
            }
    
            return [
                'reviews' => array_values($reviews),
                'total_reviews' => $total_reviews,
                'pagination' => $pagination,
                'all_reviews' => $all_reviews
            ];
        }
       
    }

    public function getReview($reviewID)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'adrm_reviews';
        $reviewID = sanitize_text_field($reviewID);
        // $sql = $wpdb->prepare(
        //     "SELECT * FROM {$wpdb->prefix}adrm_reviews WHERE id = %d",
        //     $reviewID
        // );

        $query = $wpdb->prepare("SELECT * FROM %1s WHERE id = %d", $table_name, $reviewID);
        $review = $wpdb->get_row($query, ARRAY_A);
        if (!$review) {
            return [];
        }
        $review['meta'] = maybe_unserialize($review['meta']);
        $review['avatar'] = get_avatar(Arr::get($review, 'meta.formFieldData.email'));
        return $review;
    }

    public static function processReviewData($reviews) {
        foreach ($reviews as &$review) {
            $review['meta'] = maybe_unserialize($review['meta']);
            $review['avatar'] = get_avatar(Arr::get($review, 'meta.formFieldData.email'));
    
            // Calculate average rating
            $ratings = Arr::get($review, 'meta.formFieldData.ratings', []);
            $total_rating = array_reduce($ratings, function($acc, $rating) {
                return $acc + Arr::get($rating, 'value', 0);
            }, 0);
            $average_rating = count($ratings) > 0 ? round($total_rating / count($ratings)) : 0;
            $review['average_rating'] = $average_rating;
        }

        return $reviews;
    }

    public function deleteReview($reviewID) {
        global $wpdb;
        try {
            $wpdb->delete(
                $wpdb->prefix . 'adrm_reviews',
                array('id' => $reviewID)
            );
            wp_send_json_success([
                'message' => 'Review deleted successfully'
            ]);
        } catch (\Exception $e) {
            wp_send_json_error([
                'message' => $e->getMessage()
            ], 423);
        }
    }
    

    public static function sanitizeData($data) {
        $data['formID'] = sanitize_text_field( $data['formID'] );
    
        foreach ($data['formComponent'] as $key => $value) {
            $data['formComponent'][$key]['name'] = sanitize_text_field( $value['name'] );
            $data['formComponent'][$key]['value'] = sanitize_text_field( $value['value'] );
            $data['formComponent'][$key]['label'] = sanitize_text_field( $value['label'] );
        }
        foreach ($data['formFieldData'] as $key => $value) {
            if (is_array($value)) {
                // Mainly for ratings
                foreach ($value as $k => $v) {
                   if (is_array($v)) {
                        foreach ($v as $k1 => $v1) {
                            $data['formFieldData'][$key][$k][$k1] = sanitize_text_field($v1);
                        }
                    } else {
                        $data['formFieldData'][$key][$k] = sanitize_text_field($v);
                    }
                }
            } else {
                $data['formFieldData'][$key] = sanitize_text_field($value);
            }
        }

        return $data; 
    }
}