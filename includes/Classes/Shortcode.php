<?php
declare(strict_types=1);

namespace WPReviewManager\Classes;
use WPReviewManager\Classes\View;
use WPReviewManager\Models\ReviewForm;
class Shortcode {
    
    public function registerShortCodes() {
        add_action('plugin_loaded', function() {
            $this->WPReviewManagerShortcode();
        });
    }

    public function WPReviewManagerShortcode() {
        add_shortcode('wp-review-manager', function ($args) {
            // dd($args);
            $formId = $args['id'];
            Vite::enqueueScript('WPRM-form-preview-js', 'public/js/form_preview.js', array('jquery'), WPRM_VERSION, true);
            $preview_localized =  array(
                //'image_upload_url' => admin_url('admin-ajax.php?action=wpf_global_settings_handler&route=wpf_upload_image'),
                'assets_url' => WPRM_URL . 'assets/',
                'ajax_url' => admin_url('admin-ajax.php'),
                'wprm_nonce' => wp_create_nonce('wp-review-manager-nonce'),
            );
            wp_localize_script('WPRM-form-preview-js', 'WPRMPublic', $preview_localized);
            $form = (new ReviewForm)->getReviewForm($formId);
            // dd($form);
            if (!empty($form)) {
               View::render('preview_review', [
                'form' => $form,
                'preview_page' => 'yes'
               ] );
            }
        });
    }
}
