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
        $formID = sanitize_text_field($_REQUEST['formID']);
        $filter = Arr::get($_REQUEST, 'filter', []);
        $filter = sanitize_text_field($filter);

        $reviews = (new Review)->getReviews($formID, $filter);
        wp_send_json_success($reviews);
    }
}