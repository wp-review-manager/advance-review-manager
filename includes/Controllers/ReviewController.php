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

        $reviews = (new Review)->getReviews($formID, $filter, $sort);
      
        wp_send_json_success($reviews);
    }
}