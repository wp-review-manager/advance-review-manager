<?php
namespace ADReviewManager\Modules\Exterior;
use ADReviewManager\Services\AccessControl;
use ADReviewManager\Models\ReviewForm;
use ADReviewManager\Models\Review;
use ADReviewManager\Classes\View;
use ADReviewManager\Classes\Helper;
use ADReviewManager\Classes\Vite;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('ADReviewManager\Services\AccessControl', true)) {
    require ADRM_DIR . 'includes/services/AccessControl.php';
}

class ProcessDemoPage {
    public function handleExteriorPages() {
        $nonce = $_POST['nonce'] ?? $_GET['nonce'] ?? '';
        if ($nonce && wp_verify_nonce( sanitize_text_field( wp_unslash($nonce)), 'advance-review-manager-nonce') && isset($_GET['adrm_review_preview']) &&  $_GET['adrm_review_preview']) {
            $hasDemoAccess = AccessControl::hasTopLevelMenuPermission();
            $hasDemoAccess = apply_filters('adrm/can_see_demo_form', $hasDemoAccess);
            if (!current_user_can($hasDemoAccess)) {
                $accessStatus = AccessControl::hasGrandAccess();
                $hasDemoAccess = $accessStatus['has_access'];
            }
            if ($hasDemoAccess) {
                $formId = intval($_GET['adrm_review_preview']);
                Vite::enqueueScript('adrm-form-preview-js', 'public/js/form_preview.js', array('jquery'), ADRM_VERSION, true);
                Vite::enqueueStyle('adrm-global-styling', 'scss/admin/app.scss', array(), ADRM_VERSION);

                $preview_localized =  array(
                    //'image_upload_url' => admin_url('admin-ajax.php?action=wpf_global_settings_handler&route=wpf_upload_image'),
                    'assets_url' => ADRM_URL . 'assets/',
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'adrm_nonce' => wp_create_nonce('advance-review-manager-nonce'),
                    'user_id' => get_current_user_id(),
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
        $response = (new Review)->getReviews($formId);
        $edit_url = site_url() . "/wp-admin/admin.php?page=advance-review-manager.php#/form/edit/". $form->ID;
        if (!empty($form)) {
            wp_head();
            ?>
            <div style="display: flex;justify-content: space-between;padding: 20px;background: #9e9e9e4f;">
                <div style="display: flex; align-items: center; gap: 20px">
                    <h4 style="margin: 0"><?php echo esc_html($form->post_title) ?></h4>
                    <a style="font-size: 20px" href="<?php echo esc_url($edit_url) ?>">Edit form</a>
                </div>
                <div style="padding: 4px 8px;background: #fff;border-radius: 4px;">
                    <?php echo esc_html($form->shortcode) ?>
                </div>
            </div>
            <?php
            View::render('preview_review', [
            'form' => $form,
            'reviews' => $response['reviews'],
            'allowed_html_tags' => Helper::allowedHTMLTags(),
            'total_reviews' => $response['total_reviews'],
            'pagination' => $response['pagination'],
            'all_reviews' => $response['all_reviews'],
            'show_review_form' => $showReviewForm,
            'show_review_template' => $showReviewTemplate
            ] );
            ?>
                <div class="adrm_preview_footer" style="max-width: 1000px; margin: 0 auto">
                    <p>You are seeing preview version of Advance review manager. This form is only accessible for Admin users. Other users
                        may not access this page. To use this for in a page please use the following shortcode: [advance-review-manager id='<?php echo esc_html(intval($formId)); ?>']</p>
                </div>
            <?php
            wp_footer();
            exit();
        }
    }
}