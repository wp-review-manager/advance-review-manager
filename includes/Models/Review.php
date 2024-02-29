<?php
declare(strict_types=1);

namespace WPReviewManager\Models;
use WPReviewManager\Services\ArrayHelper as Arr;

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
                $wpdb->prefix . 'wprm_reviews',
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

    public function getReviews($formID) {
        global $wpdb;
        $formID = sanitize_text_field($formID);
        $sql = "SELECT * FROM {$wpdb->prefix}wprm_reviews WHERE form_id = {$formID}";
        $reviews = $wpdb->get_results($sql, ARRAY_A);
        
        foreach ($reviews as $key => $review) {
            $reviews[$key]['meta'] = maybe_unserialize($review['meta']);
        }

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