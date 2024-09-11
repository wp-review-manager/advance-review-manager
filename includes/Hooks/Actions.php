<?php
declare(strict_types=1);

namespace ADReviewManager\Hooks;

use ADReviewManager\Controllers\ReviewFormController;
use ADReviewManager\Controllers\ReviewController;
use ADReviewManager\Services\AccessControl;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('ADReviewManager\Services\AccessControl', true)) {
    require ADRM_DIR . 'includes/services/AccessControl.php';
}

class Actions{
    
        public function __construct()
        {
            $this->registerEndpoints();
            $this->registerHooks();
        }

        public function registerHooks()
        {
            // register necessary hooks here
            add_action('wp', function () {
                $demoPage = new \ADReviewManager\Modules\Exterior\ProcessDemoPage();
                $demoPage->handleExteriorPages();
            }); 
        }

        public function registerEndpoints()
        {
            add_action('wp_ajax_ad_review_manager_ajax', array($this, 'handleEndPoint'));
            add_action('wp_ajax_nopriv_ad_review_manager_ajax', array($this, 'handleEndPoint'));

            add_action('wp_ajax_adrm_review_reply_action', array($this, 'adrm_handle_reply'));
            add_action('wp_ajax_nopriv_adrm_review_reply_action', array($this, 'adrm_handle_reply'));
        }
        public function handleEndPoint()
        {
            if(! isset( $_REQUEST['nonce'] ) || !wp_verify_nonce(sanitize_text_field( wp_unslash($_REQUEST['nonce'])), 'advance-review-manager-nonce')  || ! AccessControl::hasTopLevelMenuPermission()){
                wp_send_json([
                    "status" => 403,
                    "success"=> false,
                    "message" => "Something went wrong! Request not valid.",
                ]);
                wp_die();
            }

            $postData = $_POST;
            $getData = $_GET;
            $request = $_REQUEST;
            $nonce = '';

            if (isset($_POST['nonce'])) {
                $nonce = sanitize_text_field(wp_unslash($postData['nonce']));
            } elseif (isset($_GET['nonce'])) {
                $nonce = sanitize_text_field(wp_unslash($getData['nonce']));
            }
    
            $route = sanitize_text_field($request['route']);
    
            $validRoutes = array(
                'create_review_form' => 'createReviewForm',
                'save_review_form' => 'saveReviewForm',
                'get_review_forms' => 'getReviewForms',
                'get_review_form' => 'getReviewForm',
                'delete_review_form' => 'deleteReviewForm',
                'create_review' => 'createReview',
                'get_reviews' => 'getReviews',
                'get_review' => 'getReview',
                'delete_review' => 'deleteReview',
                'get_formatted_reviews' => 'getFormattedReviews',
                'save_template_settings' => 'saveTemplateSettings',
                'get_template_settings' => 'getTemplateSettings',
                // debug info routes
                'debug_info_wp' => 'getDebugInfoWP',
                'debug_info_others' => 'getDebugInfoOthers',
                'debug_info_server' => 'getDebugInfoServer',
                'debug_info_adrm' => 'getDebugInfoADRM',
            );

            if (isset($validRoutes[$route])) {
                $this->{$validRoutes[$route]}();
            }
        }

        public function createReviewForm()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                ReviewFormController::createReviewForm();
            }
        }

        public function deleteReviewForm()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                (new ReviewFormController)->deleteReviewForm();
            }
        }

        public function getReviewForms()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                (new ReviewFormController)->getReviewForms();
             }
        }

        public function saveReviewForm()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                (new ReviewFormController)->saveReviewForm();
            }
        }

        public function getReviewForm()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
               ReviewFormController::getReviewForm();
            }
        }
        // start of review  endpoint
        public function createReview()
        {
            ReviewController::createReview();
        }

        public function getReviews()
        {
            (new ReviewController)->getReviews();
        }

        public function getReview()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                (new ReviewController)->getReview();
            }
        }

        public function deleteReview()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                (new ReviewController)->deleteReview();
            }
        }

        public function getFormattedReviews()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                (new ReviewController)->getFormattedReviews();
            }
        }

        // settings controller 
        public function saveTemplateSettings()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                (new ReviewFormController)->saveTemplateSettings();
            }
        }
        
        public function getTemplateSettings()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                (new ReviewFormController)->getTemplateSettings();
            }
        }

        public function adrm_handle_reply()
        {
            if (isset($_POST['adrm_public_nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['adrm_public_nonce'])), 'adrm_public_nonce')) {
                wp_send_json_error('Invalid nonce');
                return;
            }

            if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'advance-review-manager-nonce')) {
                wp_send_json_error('Invalid nonce');
                return;
            }

            if (isset($_POST['route'])) {
                // handle route
                $route = sanitize_text_field($_POST['route']);
                if ($route === 'delete_reply') {
                    $this->adrm_delete_reply();
                    return;
                }
            }

            $data = $_POST;

            // Get the value of the textarea input
            $reply_content = isset($data['reply']) ? sanitize_text_field($data['reply']) : '';
            $reviewId = isset($data['review_id']) ? sanitize_text_field($data['review_id']) : '';


            if (empty($reply_content)) {
                wp_send_json_error('Reply content is empty');
                return;
            }

            if (empty($reviewId)) {
                wp_send_json_error('Review ID is empty');
                return;
            }

            $reply = array(
                'comment' => $reply_content,
                'review_id' => $reviewId,
                'user_id' => get_current_user_id(),
            );
            // insert review reply 
            $reviewController = new ReviewController();
            $reviewController->createReviewReply($reply);
            // Respond with a success message or additional data
            wp_send_json_success(['message' => 'Reply submitted successfully'], 200);
        }

        public function adrm_delete_reply()
        { 
            $data = $_POST;

            $replyId = isset($data['reply_id']) ? sanitize_text_field($data['reply_id']) : '';
            
            if (empty($replyId)) {
                wp_send_json_error('Reply ID is empty');
                return;
            }

            if (!current_user_can('manage_options')) {
                wp_send_json_error('You do not have permission to delete this reply');
                return;
            }

            $reviewController = new ReviewController();
            $reviewController->DeleteReviewReply($replyId);

            // Respond with a success message or additional data
            wp_send_json_success(['message' => 'Reply deleted successfully'], 200);
        }

        public function getDebugInfoWP()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                (new \ADReviewManager\Controllers\GlobalSettingsController)->generateDebug('wp');
            }
        }

        public function getDebugInfoOthers()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                (new \ADReviewManager\Controllers\GlobalSettingsController)->generateDebug('others');
            }
        }

        public function getDebugInfoServer()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                (new \ADReviewManager\Controllers\GlobalSettingsController)->generateDebug('server');
            }
        }

        public function getDebugInfoADRM()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                (new \ADReviewManager\Controllers\GlobalSettingsController)->generateDebug('adrm');
            }
        }

}

