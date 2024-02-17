<?php
namespace WPReviewManager\Modules\Exterior;
use WPReviewManager\Services\AccessControl;
use WPReviewManager\Models\ReviewForm;
use WPReviewManager\Classes\View;

class ProcessDemoPage {
    public function handleExteriorPages() {
        if (isset($_GET['wprm_review_preview']) && $_GET['wprm_review_preview']) {
            $hasDemoAccess = AccessControl::hasTopLevelMenuPermission();
            $hasDemoAccess = apply_filters('wprm/can_see_demo_form', $hasDemoAccess);

            // if (!current_user_can($hasDemoAccess)) {
            //     $accessStatus = AccessControl::giveCustomAccess();
            //     $hasDemoAccess = $accessStatus['has_access'];
            // }
            if ($hasDemoAccess) {
                $formId = intval($_GET['wprm_review_preview']);
                wp_enqueue_style('dashicons');
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
            'form' => $form
           ] );
           exit();
        }
    }
}