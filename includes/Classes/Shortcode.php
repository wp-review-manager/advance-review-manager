<?php
declare(strict_types=1);

namespace ADReviewManager\Classes;
use ADReviewManager\Classes\View;
use ADReviewManager\Classes\Helper;
use ADReviewManager\Models\ReviewForm;
use ADReviewManager\Models\Review;
use ADReviewManager\Services\ArrayHelper as Arr;

if (!defined('ABSPATH')) {
    exit;
}

class Shortcode {
    
    public function registerShortCodes() {
        $this->ADReviewManagerShortCode();
    }

    public function ADReviewManagerShortCode() {
        add_shortcode('advance-review-manager', function ($args) {
            $formId = Arr::get($args, 'id');

            $showReviewForm = Arr::get($args, 'show_review_form', 'yes');
            $showReviewTemplate = Arr::get($args, 'show_review_template', 'yes');
     
            Vite::enqueueScript('adrm-form-preview-js', 'public/js/form_preview.js', array('jquery'), ADRM_VERSION, true);
            Vite::enqueueStyle('adrm-global-styling', 'scss/admin/app.scss', array(), ADRM_VERSION);

            $preview_localized =  array(
                //'image_upload_url' => admin_url('admin-ajax.php?action=wpf_global_settings_handler&route=wpf_upload_image'),
                'assets_url' => ADRM_URL . 'assets/',
                'ajax_url' => admin_url('admin-ajax.php'),
                'adrm_nonce' => wp_create_nonce('advance-review-manager-nonce'),
            );
            wp_localize_script('adrm-form-preview-js', 'ADRMPublic', $preview_localized);
            
            $form = (new ReviewForm)->getReviewForm($formId);
            $nonce = wp_create_nonce('advance-review-manager-nonce');
            
            $response = (new Review)->getReviews($formId);

            if (!empty($form)) {
               return View::make('preview_review', [
                'form' => $form,
                'reviews' => $response['reviews'],
                'allowed_html_tags' => Helper::allowedHTMLTags(),
                'total_reviews' => $response['total_reviews'],
                'pagination' => $response['pagination'],
                'all_reviews' => $response['all_reviews'],
                'show_review_form' => $showReviewForm,
                'show_review_template' => $showReviewTemplate
               ] );
            }  
        });
    }
}
