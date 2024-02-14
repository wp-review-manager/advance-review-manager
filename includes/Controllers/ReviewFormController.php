<?php

namespace WPReviewManager\Controllers;

use WPReviewManager\Models\ReviewForm;

class ReviewFormController
{
    public static function getReviewForms()
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
            ReviewForm::storeData();
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