<?php
declare(strict_types=1);

namespace WPReviewManager\Controllers;
use WPReviewManager\Services\ArrayHelper as Arr;
use WPReviewManager\Models\ReviewForm;

class ReviewFormController
{
    public static function getReviewForms()
    {
        return (new ReviewForm())->getReviewForms();
    }

    public static function deleteReviewForm()
    {
        $form_id = Arr::get($_REQUEST, 'form_id', "");
        $form_id = sanitize_text_field($form_id);
        if (empty($form_id)) {
            wp_send_json_error(
                [
                    'message' => "Form Id not found."
                ],
            423);
        }
        return (new ReviewForm)->deleteReviewForm($form_id);
    }

    public static function getReviewForm()
    {
        try{
            $form_id = $_REQUEST['form_id'];
            $form =  (new ReviewForm)->getReviewForm($form_id);

            if(empty($form)) {
                wp_send_json_error(
                    [
                        'message' => "Form not found."
                    ],423);
            } else {
                wp_send_json_success( array(
                    'form' => $form,
                    'message' => 'Form retried!'
                ),200 );
            }
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
}