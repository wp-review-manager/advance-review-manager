<?php
declare(strict_types=1);

namespace ADReviewManager\Models;
use ADReviewManager\Services\ArrayHelper as Arr;

class Review extends Model
{
    public function create() {
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

    public function getReviews($formID, $filter = null, $sort = 'newest') {
        global $wpdb;
        $formID = sanitize_text_field($formID);
        $sortOrder = $sort == 'newest' ? 'DESC' : 'ASC';
        $sql = "SELECT * FROM {$wpdb->prefix}adrm_reviews WHERE form_id = {$formID} ORDER BY created_at $sortOrder";
        $reviews = $wpdb->get_results($sql, ARRAY_A);
        
        foreach ($reviews as $key => $review) {
            $reviews[$key]['meta'] = maybe_unserialize($review['meta']);
        }

        if (!empty($filter) && $filter != 'all') {  
            $reviews = array_filter($reviews, function($review) use ($filter) {
                $ratings = Arr::get($review, 'meta.formFieldData.ratings', []);
                $total_rating = 0;
                foreach ($ratings as $rating) {
                    $total_rating += Arr::get($rating, 'value');
                }
                $average_rating = round($total_rating / count($ratings));

                return $average_rating == $filter;
            });

        }

        $reviews = array_values($reviews);

        return $reviews;
    }

    public static function sanitizeData($data) {
        $data['formID'] = sanitize_text_field( $data['formID'] );
        foreach ($data['formData'] as $key => $value) {
            $data['formData'][$key]['name'] = sanitize_text_field( $value['name'] );
            $data['formData'][$key]['value'] = sanitize_text_field( $value['value'] );
            $data['formData'][$key]['label'] = sanitize_text_field( $value['label'] );
        }

        return $data; 
    }
}