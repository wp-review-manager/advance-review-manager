<?php

namespace WPReviewManager\Models;
use WPReviewManager\Classes\DemoTemplates;
use WPReviewManager\Services\ArrayHelper as Arr;

class ReviewForm
{
    public function getReviewForms()
    {
        return 'getReviewForms';
    }

    public function getReviewForm($id)
    {
        return 'getReviewForm';
    }

    public static function storeData()
    {
        $nonce = $_REQUEST['nonce'];
        $postTitle = $_REQUEST['post_title'];
        $template = $_REQUEST['template'];

        if (!$postTitle) {
            $postTitle = 'Blank Form';
        }

        $data = array(
            'post_title' => sanitize_text_field($postTitle),
            'post_status' => 'publish'
        );

        do_action('wprm/before_review_form_create', $data, $template);
        $formId = static::store($data);

        wp_update_post([
            'ID' => $formId,
            'post_title' => sanitize_text_field($data['post_title']) . ' (#' . $formId . ')'
        ]);

        if (is_wp_error($formId)) {
            throw new Exception(esc_html($formId->get_error_message()));
        }

        // do_action('wprm/review_form_created', $formId, $data, $template);
        self::insertTemplate($formId, $data, $template);

        return $formId;
    }

    public static function insertTemplate($reviewFormId, $data, $template)
    {
        
        $template_data = Arr::get($template, 'formFields', null);
        if ($template_data == null) {
            wp_send_json_success( array(
                'form_id' => $reviewFormId,
                'message' => 'Blank Form created!'
            ),200 );
        }
        $template['formFields'] = maybe_serialize( $template_data );
        $metaValue = $template['formFields'];
        update_post_meta($reviewFormId, 'wprm_form_fields', $metaValue);

        wp_send_json_success( array(
            'form_id' => $reviewFormId,
            'message' => 'Form created!'
        ),200 );
    }

    public static function store($data)
    {
        $data['post_type'] = 'wp_review_form';
        $data['post_status'] = 'publish';
        $id = wp_insert_post($data);
        return $id;
    }

    public function updateReviewForm($request)
    {
        return 'updateReviewForm';
    }

    public function deleteReviewForm($id)
    {
        return 'deleteReviewForm';
    }

    public static function insertTemplateForm($reviewFormId, $data, $template)
    {
        return DemoTemplates::insertTemplate($reviewFormId, $data, $template);
    }
}