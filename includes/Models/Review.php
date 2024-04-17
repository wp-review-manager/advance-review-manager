<?php
declare(strict_types=1);

namespace ADReviewManager\Models;
use ADReviewManager\Services\ArrayHelper as Arr;

class Review extends Model
{
    public function create() {
        $nonce = $_REQUEST['nonce'] ?? $_REQUEST['nonce'] ?? '';

        if (!wp_verify_nonce($nonce, 'advance-review-manager-nonce')) {
            wp_send_json_error(
                [
                    'message' => "Nonce verification failed."
                ],
            423);
        } else {
            global $wpdb;
            $data = self::sanitizeData($_POST);
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

        $nonce = $_REQUEST['nonce'] ?? $_REQUEST['nonce'] ?? $nonce;

        if (!wp_verify_nonce($nonce, 'advance-review-manager-nonce')) {
            wp_send_json_error(
                [
                    'message' => "Nonce verification failed."
                ],
            423);
        } else {
            global $wpdb;
            // Sanitize input
            $formID = sanitize_text_field($formID);
            $sortOrder = $sort == 'newest' ? 'DESC' : 'ASC';
        
            // Fetch pagination settings
            $template_settings = maybe_unserialize(get_post_meta($formID, 'adrm_template_settings', true));
            $pagination = Arr::get($template_settings, 'pagination', []);
            $limit = Arr::get($pagination, 'per_page', 10);
            $page = max(1, Arr::get($_REQUEST, 'page', 1)); // Ensure page is at least 1
            $offset = ($page - 1) * $limit;
           
            if (Arr::get($pagination, 'enable') == 'false') {
                $limit = 100000000000;
                $offset = 0;
            }

            // Fetch reviews
            $sql = $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}adrm_reviews WHERE form_id = %d ORDER BY created_at $sortOrder LIMIT %d OFFSET %d",
                $formID,
                $limit,
                $offset
            );
    
            $reviews = $wpdb->get_results($sql, ARRAY_A);
        
            // Fetch total reviews count
            $total_reviews_sql = $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}adrm_reviews WHERE form_id = %d",
                $formID
            );
    
            $all_reviews= $wpdb->get_results($total_reviews_sql, ARRAY_A);
            $total_reviews = count($all_reviews);
        
            // Process reviews
            $reviews = static::processReviewData($reviews);
            $all_reviews = static::processReviewData($all_reviews);
        
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
        $reviewID = sanitize_text_field($reviewID);
        $sql = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}adrm_reviews WHERE id = %d",
            $reviewID
        );
        $review = $wpdb->get_row($sql, ARRAY_A);
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