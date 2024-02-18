<?php
declare(strict_types=1);

namespace WPReviewManager\Controllers;
use WPReviewManager\Services\ArrayHelper as Arr;
use WPReviewManager\Models\Review;

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
}