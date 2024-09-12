<?php
declare(strict_types=1);

namespace ADReviewManager\Controllers;
use ADReviewManager\Services\ArrayHelper as Arr;
use ADReviewManager\Models\Review;
use ADReviewManager\Models\Comment;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('ADReviewManager\Services\ArrayHelper', true)) {
    require ADRM_DIR . 'includes/services/ArrayHelper.php';
}

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
        if (!isset( $_REQUEST['nonce'] ) || !wp_verify_nonce(sanitize_text_field( wp_unslash($_REQUEST['nonce'])), 'advance-review-manager-nonce')) {
            wp_send_json_error(
                [
                    'message' => "Nonce verification failed."
                ],
            423);
        } else {
            $request = $_REQUEST;
            $filter = Arr::get($request, 'filter', []);
            $sort = Arr::get($request, 'sort', 'newest');

            $formID = sanitize_text_field($request['formID']);
            $sort = sanitize_text_field($sort);
            $filter = sanitize_text_field($filter);

            $response = (new Review)->getReviews($formID, $filter, $sort);
            wp_send_json_success($response);
        }
    }

    public function getReview()
    {
        if (! isset( $_REQUEST['nonce'] ) || !wp_verify_nonce(sanitize_text_field( wp_unslash($_REQUEST['nonce'])), 'advance-review-manager-nonce')) {
            wp_send_json_error(
                [
                    'message' => "Nonce verification failed."
                ],
            423);
        } else {
            $request = $_REQUEST;
            $reviewID = sanitize_text_field($request['reviewID']);
            if (empty($reviewID)) {
                wp_send_json_error(
                    [
                        'message' => "Review Id not found."
                    ],
                423);
            }
            $response = (new Review)->getReview($reviewID);
            wp_send_json_success($response);
        }
    }

    public function deleteReview()
    {
        if (!isset( $_REQUEST['nonce'] ) || !wp_verify_nonce(sanitize_text_field( wp_unslash($_REQUEST['nonce'])), 'advance-review-manager-nonce')) {
            wp_send_json_error(
                [
                    'message' => "Nonce verification failed."
                ],
            423);
        } else {
            $request = $_REQUEST;
            $reviewID = sanitize_text_field($request['reviewID']);
            if (empty($reviewID)) {
                wp_send_json_error(
                    [
                        'message' => "Review Id not found."
                    ],
                423);
            }
            return (new Review)->deleteReview($reviewID);
        }
    }

    public function getFormattedReviews()
    {
        if (! isset( $_REQUEST['nonce'] ) || ! wp_verify_nonce(sanitize_text_field( wp_unslash($_REQUEST['nonce'])), 'advance-review-manager-nonce')) {
            wp_send_json_error(
                [
                    'message' => "Nonce verification failed."
                ],
            423);
        } else {
            $request = $_REQUEST;
            $filter =  sanitize_text_field(Arr::get($request, 'filter', []));
            $sort = sanitize_text_field(Arr::get($request, 'sort', 'newest'));

            $formID = sanitize_text_field($request['formID']);

            $response = (new Review)->getReviews($formID, $filter, $sort);
            $formattedReviews = $this->formatReviews($response['reviews']);
            $response['reviews'] = $formattedReviews;
            unset($response['meta']);
            wp_send_json_success($response);
        }
    }

    public function formatReviews($reviews)
    {
        $formattedReviews = [];
        foreach ($reviews as $review) {
            $meta = maybe_unserialize($review['meta']);
            $email = Arr::get($meta, 'formFieldData.email', '');
            $message = Arr::get($meta, 'formFieldData.message', '');
            $name = Arr::get($meta, 'formFieldData.name', '');
            $position = Arr::get($meta, 'formFieldData.position', '');
            $formattedReviews[] = [
                'id' => $review['id'],
                'rating' => $review['average_rating'],
                'avatar' => get_avatar_url($email) ? get_avatar_url($email) : Arr::get($review, 'avatar', ''),
                'email' => $email,
                'position' => $position,
                'message' => $message,
                'name' => $name,
                'created_at' => $review['created_at'],
                'updated_at' => $review['updated_at'],
            ];
        }
  
        return $formattedReviews;
    }

    public function createReviewReply($reply)
    {
        try{
            
            return (new Comment)->create($reply);

        } catch(\Exception $e) {
            wp_send_json_error(
                [
                    'message' => $e->getMessage()
                ],
            423);
        }
    }

    public function deleteReviewReply($replyId)
    {
        try {
            // write row sql query to delete the reply
            (new Comment())->deleteComment($replyId);
        }
        catch (\Exception $e) {
            wp_send_json_error(
                [
                    'message' => $e->getMessage()
                ],
            423);
        }
    }
}