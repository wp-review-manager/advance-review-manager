<?php
namespace ADReviewManager\Modules\Exterior;
use ADReviewManager\Services\AccessControl;
use ADReviewManager\Models\ReviewForm;
use ADReviewManager\Models\Review;
use ADReviewManager\Classes\View;
use ADReviewManager\Classes\Vite;

class ProcessDemoPage {
    public function handleExteriorPages() {
        if (isset($_GET['adrm_review_preview']) && $_GET['adrm_review_preview']) {
            $hasDemoAccess = AccessControl::hasTopLevelMenuPermission();
            $hasDemoAccess = apply_filters('adrm/can_see_demo_form', $hasDemoAccess);

            if (!current_user_can($hasDemoAccess)) {
                $accessStatus = AccessControl::giveCustomAccess();
                $hasDemoAccess = $accessStatus['has_access'];
            }
            if ($hasDemoAccess) {
                $formId = intval($_GET['adrm_review_preview']);
                Vite::enqueueStyle('dashicons');
                Vite::enqueueScript('adrm-form-preview-js', 'public/js/form_preview.js', array('jquery'), ADRM_VERSION, true);
                Vite::enqueueStyle('adrm-global-styling', 'scss/admin/app.scss', array(), ADRM_VERSION);

                $preview_localized =  array(
                    //'image_upload_url' => admin_url('admin-ajax.php?action=wpf_global_settings_handler&route=wpf_upload_image'),
                    'assets_url' => ADRM_URL . 'assets/',
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'adrm_nonce' => wp_create_nonce('advance-review-manager-nonce'),
                );
                wp_localize_script('adrm-form-preview-js', 'ADRMPublic', $preview_localized);
                
                $this->renderPreview($formId);
            }
        }
    }

    public function renderPreview($formId)
    {
        //  echo do_shortcode('[advance-review-manager id="' . intval($formId) . '" show_review_template= "yes" show_review_form="yes"]');

        $showReviewForm = 'yes';
        $showReviewTemplate = 'yes';
        $form = (new ReviewForm)->getReviewForm($formId);
        $reviews = (new Review)->getReviews($formId);
        
        if (!empty($form)) {
            View::render('preview_review', [
            'form' => $form,
            'reviews' => $reviews,
            'show_review_form' => $showReviewForm,
            'show_review_template' => $showReviewTemplate
            ] );
            exit();
        }
    }
}