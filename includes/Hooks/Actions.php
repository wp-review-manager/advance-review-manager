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
            // add_action('admin_menu', array($this, 'registerMenu'));
            add_action('wprm/review_form_created', function ($reviewFormId, $data, $template) {
                ReviewFormController::insertTemplate($reviewFormId, $data, $template);
            });
            
        }

        public function registerEndpoints()
        {
            add_action('wp_ajax_wp_review_manager_ajax', array($this, 'handleEndPoint'));
            add_action('wp_ajax_nopriv_wp_review_manager_ajax', array($this, 'handleEndPoint'));
        }
        public function handleEndPoint()
        {
            if(!wp_verify_nonce($_POST['nonce'], 'wp-review-manager-nonce') && AccessControl::hasTopLevelMenuPermission()){
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
                'save_review_form' => 'saveReviewFrom',
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
            // $formController = new \WPReviewManager\Classes\FormController();
            // wp_send_json_success($formController->getForms());
        }

        public function saveReviewForm()
        {
            // $formController = new \WPReviewManager\Classes\FormController();
            // wp_send_json_success($formController->saveForm());
        }

        public function getReviewForm()
        {
            // $formController = new \WPReviewManager\Classes\FormController();
            // wp_send_json_success($formController->getForm());
        }

}

