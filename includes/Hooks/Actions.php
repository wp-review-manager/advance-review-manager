<?php
declare(strict_types=1);

namespace ADReviewManager\Hooks;

use ADReviewManager\Controllers\ReviewFormController;
use ADReviewManager\Controllers\ReviewController;
use ADReviewManager\Services\AccessControl;

class Actions{
    
        public function __construct()
        {
            $this->registerEndpoints();
            $this->registerHooks();
        }

        public function registerHooks()
        {
            // register necessary hooks here
            add_action( 'init', function () {
                $demoPage = new \ADReviewManager\Modules\Exterior\ProcessDemoPage();
                $demoPage->handleExteriorPages();
            }); 
        }

        public function registerEndpoints()
        {
            add_action('wp_ajax_ad_review_manager_ajax', array($this, 'handleEndPoint'));
            add_action('wp_ajax_nopriv_ad_review_manager_ajax', array($this, 'handleEndPoint'));
        }
        public function handleEndPoint()
        {
            $nonce = $_POST['nonce'] ?? $_GET['nonce'] ?? '';
            if(!wp_verify_nonce($nonce, 'advance-review-manager-nonce') && AccessControl::hasTopLevelMenuPermission()){
                wp_send_json([
                    "status" => 403,
                    "nonce" => $_POST['nonce'],
                    "success"=> false,
                    "message" => "Something went wrong! Request not valid.",
                ]);
                wp_die();
            }
    
            $route = sanitize_text_field($_REQUEST['route']);
    
            $validRoutes = array(
                'create_review_form' => 'createReviewForm',
                'save_review_form' => 'saveReviewForm',
                'get_review_forms' => 'getReviewForms',
                'get_review_form' => 'getReviewForm',
                'delete_review_form' => 'deleteReviewForm',
                'create_review' => 'createReview',
                'get_reviews' => 'getReviews',
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

}

