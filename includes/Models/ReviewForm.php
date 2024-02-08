<?php

namespace WPReviewManager\Models;
use WPReviewManager\Classes\DemoTemplates;

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

        do_action('wprm/review_form_created', $formId, $data, $template);

        return $formId;
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