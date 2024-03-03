<?php
declare(strict_types=1);

namespace ADReviewManager\Classes;
use ADReviewManager\Classes\View;
use ADReviewManager\Models\ReviewForm;
use ADReviewManager\Models\Review;
class Shortcode {
    
    public function registerShortCodes() {
        add_action('plugin_loaded', function() {
            $this->ADReviewManagerShortCode();
        });
    }

    public function ADReviewManagerShortCode() {
        add_shortcode('advance-review-manager', function ($args) {
            // dd($args);
            $formId = $args['id'];
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
            $reviews = (new Review)->getReviews($formId);
            // dd($form);
            if (!empty($form)) {
               View::render('preview_review', [
                'form' => $form,
                'preview_page' => 'yes',
                'reviews' => $reviews
               ] );
            }
        });
    }
}
