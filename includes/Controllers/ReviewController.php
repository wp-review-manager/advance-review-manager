<?php
declare(strict_types=1);

namespace ADReviewManager\Controllers;
use ADReviewManager\Services\ArrayHelper as Arr;
use ADReviewManager\Models\Review;

class ReviewController
{
    public static function createReview()
    {
        try {
            (new Review)->create();
        } catch (\Exception $e) {
            wp_send_json_error(
                [
                    'message' => $e->getMessage()
                ],
            423);
        }
    }

    public function getReviews()
    {
        $filter = Arr::get($_REQUEST, 'filter', []);
        $sort = Arr::get($_REQUEST, 'sort', 'newest');

        $formID = sanitize_text_field($_REQUEST['formID']);
        $sort = sanitize_text_field($sort);
        $filter = sanitize_text_field($filter);

        $response = (new Review)->getReviews($formID, $filter, $sort);
        wp_send_json_success($response);
    }

    public function getFormattedReviews()
    {
        $filter = Arr::get($_REQUEST, 'filter', []);
        $sort = Arr::get($_REQUEST, 'sort', 'newest');

        $formID = sanitize_text_field($_REQUEST['formID']);
        $sort = sanitize_text_field($sort);
        $filter = sanitize_text_field($filter);

        $response = (new Review)->getReviews($formID, $filter, $sort);
        $formattedReviews = $this->formatReviews($response['reviews']);
        $response['reviews'] = $formattedReviews;
        unset($response['meta']);
        wp_send_json_success($response);
    }

    public function formatReviews($reviews)
    {
        $formattedReviews = [];
        foreach ($reviews as $review) {
            $meta = maybe_unserialize($review['meta']);
            $email = Arr::get($meta, 'formFieldData.email', '');
            $message = Arr::get($meta, 'formFieldData.message', '');

            $formattedReviews[] = [
                'id' => $review['id'],
                'rating' => $review['average_rating'],
                'avatar' => get_avatar_url($email) ? get_avatar_url($email) : Arr::get($review, 'avatar', ''),
                'email' => $email,
                'message' => $message,
                'created_at' => $review['created_at'],
                'updated_at' => $review['updated_at'],
            ];
        }
  
        return $formattedReviews;
    }
}