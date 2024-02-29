<?php
namespace ADReviewManager\Modules\Exterior;
use ADReviewManager\Services\AccessControl;
use ADReviewManager\Models\ReviewForm;
use ADReviewManager\Classes\View;
use ADReviewManager\Classes\Vite;

class ProcessDemoPage {
    public function handleExteriorPages() {
        // dd("hitt");
        if (isset($_GET['adrm_review_preview']) && $_GET['adrm_review_preview']) {
            $hasDemoAccess = AccessControl::hasTopLevelMenuPermission();
            $hasDemoAccess = apply_filters('adrm/can_see_demo_form', $hasDemoAccess);

            // if (!current_user_can($hasDemoAccess)) {
            //     $accessStatus = AccessControl::giveCustomAccess();
            //     $hasDemoAccess = $accessStatus['has_access'];
            // }
            if ($hasDemoAccess) {
                $formId = intval($_GET['adrm_review_preview']);
                Vite::enqueueStyle('dashicons');
                // Vite::enqueueScript('review_manager_public', 'public/js/form_preview.js', array('jquery'), WPRM_VERSION, true);
                // Vite::enqueueStyle('review_manager_public', 'public/css/form_preview.css', array(), WPRM_VERSION);
                // Vite::enqueueStyle('ADRM-global-styling', 'scss/admin/app.scss', array(), WPRM_VERSION);
                // $this->loadDefaultPageTemplate();
                
                $this->renderPreview($formId);
            }
        }
    }

    public function renderPreview($formId)
    {
        $form = (new ReviewForm)->getReviewForm($formId);
        if (!empty($form)) {
           View::render('preview_review', [
            'form' => $form,
            'preview_page' => 'yes'
           ] );
           exit();
        }
    }
}