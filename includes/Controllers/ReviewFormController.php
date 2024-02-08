<?php

namespace WPReviewManager\Controllers;

use WPReviewManager\Models\ReviewForm;

class ReviewFormController
{
    public function getReviewForms()
    {
        return (new ReviewForm())->getReviewForms();
    }

    public function getReviewForm($id)
    {
        return (new ReviewForm())->getReviewForm($id);
    }

    public static function createReviewForm()
    {
        try {
            $reviewFormId = ReviewForm::storeData();
        } catch (\Exception $e) {
            return array(
                'message' => $e->getMessage(),
            );
        }

        return array(
            'message' => __('Review Form successfully created.', 'wp-review-manager'),
            'reveiw_form_id' => $reviewFormId
        );
    }

    public function updateReviewForm($request)
    {
        return (new ReviewForm())->updateReviewForm($request);
    }

    public function deleteReviewForm($id)
    {
        return (new ReviewForm())->deleteReviewForm($id);
    }

    public static function insertTemplate($reviewFormId, $data, $template)
    {
        return ReviewForm::insertTemplateForm($reviewFormId, $data, $template);
    }
}