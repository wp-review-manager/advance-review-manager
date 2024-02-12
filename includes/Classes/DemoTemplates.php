<?php

namespace WPReviewManager\Classes;

use WPReviewManager\Services\ArrayHelper;

if (!defined('ABSPATH')) {
    exit;
}

class DemoTemplates
{
    public static function insertTemplate($reviewFormId, $data, $template)
    {
        $demoForms = self::demoTemplates();
        // dd($template);
        $template['formFields'] = maybe_serialize( $template['formFields'] );
        dd($demoForms, $template);
        if (!isset($demoForms[$template])) {
            return;
        }
        $demoForm = $demoForms[$template];

        $data = ArrayHelper::get($demoForm, 'data');
        if (!$data) {
            return;
        }

        $data = json_decode($data, true);

        $metas = ArrayHelper::get($data, 'form_meta');
        if (!is_array($metas)) {
            return;
        }
        foreach ($metas as $metaKey => $metaValue) {
            update_post_meta($reviewFormId, $metaKey, $metaValue);
        }
    }

    public static function demoTemplates()
    {
        $demoTemplates = array(
            'blank_form' => array(
                'label' => 'Blank Form',
                'description' => 'Create a blank form',
                'category' => 'Basic',
                'preview_image' => WPRM_DIR . 'assets/images/forms/blank_form.svg',
                'data' => '{"post_content":"","post_title":"Blank Form","form_meta":{"wppayform_submit_button_settings":{"button_text":"Submit","processing_text":"Please Wait…","button_style":"wpf_default_btn","css_class":""},"wppapyform_paymentform_confirmation_settings":{"confirmation_type":"custom","redirectTo":"samePage","messageToShow":"<p>Form has been successfully submitted</p>","samePageFormBehavior":"hide_form"},"wppayform_form_design_settings":{"labelPlacement":"top","asteriskPlacement":"right","submit_button_position":"left","extra_styles":{"wpf_default_form_styles":"yes","wpf_bold_labels":"no"}},"wpf_email_notifications":[{"title":"Admin Email Notification","email_to":"{wp:admin_email}","reply_to":"{input.customer_email}","email_subject":"Contact form Submitted by {input.customer_name} #{submission.id}","email_body":"<p>The following data has been submitted by {input.customer_name}</p>\n<p>{submission.all_input_field_html}</p>\n<p>Form Page URL: {wp:post_url}</p>","from_name":"","from_email":"","format":"html","email_template":"default","cc_to":"","bcc_to":"","conditions":"","sending_action":"wppayform/after_form_submission_complete","status":"disabled"}]}}',
                'is_pro' => false
            ),
        );

        return $demoTemplates;
    }
}