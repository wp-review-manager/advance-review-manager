<?php

namespace WPReviewManager\Hooks;

use WPReviewManager\Controllers\ReviewFormController;
use WPReviewManager\Services\AccessControl;

class Actions{
    
        public function __construct()
        {
            $this->registerEndpoints();
            $this->registerHooks();
        }

        public function registerHooks()
        {
            // register necessary hooks here
            
        }

        public function registerEndpoints()
        {
            add_action('wp_ajax_wp_review_manager_ajax', array($this, 'handleEndPoint'));
            add_action('wp_ajax_nopriv_wp_review_manager_ajax', array($this, 'handleEndPoint'));
        }
        public function handleEndPoint()
        {
            $nonce = $_POST['nonce'] ?? $_GET['nonce'] ?? '';
            if(!wp_verify_nonce($nonce, 'wp-review-manager-nonce') && AccessControl::hasTopLevelMenuPermission()){
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
            );

            if (isset($validRoutes[$route])) {
                $this->{$validRoutes[$route]}();
            }
        }

        public function createReviewForm()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                wp_send_json_success(ReviewFormController::createReviewForm());
            }
        }

        public function getReviewForms()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                ReviewFormController::getReviewForms();
             }
        }

        public function saveReviewForm()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
                wp_send_json_success(ReviewFormController::saveReviewForm());
            }
        }

        public function getReviewForm()
        {
            if (AccessControl::hasTopLevelMenuPermission()) {
               ReviewFormController::getReviewForm();
            }
        }

}

