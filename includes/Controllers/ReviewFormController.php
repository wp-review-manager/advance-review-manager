<?php
declare(strict_types=1);

namespace WPReviewManager\Controllers;

use WPReviewManager\Models\ReviewForm;

class ReviewFormController
{
    public function getReviewForms()
    {
        return (new ReviewForm())->getReviewForms();
    }

    public static function getReviewForm()
    {
        try{
            return (new ReviewForm)->getReviewForm();
        } catch(\Exception $e) {
            wp_send_json_error(
                [
                    'message' => $e->getMessage()
                ],
            423);
        }
    }

    public static function createReviewForm()
    {
        try {
            (new ReviewForm)->create();
        } catch (\Exception $e) {
            wp_send_json_error(
                [
                    'message' => $e->getMessage()
                ],
            423);
        }
    }

    public static function saveReviewForm()
    {
        try{
            return (new ReviewForm)->saveReviewForm();
        } catch(\Exception $e) {
            wp_send_json_error(
                [
                    'message' => $e->getMessage()
                ],
            423);
        }
    }

    public function deleteReviewForm($id)
    {
        return (new ReviewForm())->deleteReviewForm($id);
    }
}