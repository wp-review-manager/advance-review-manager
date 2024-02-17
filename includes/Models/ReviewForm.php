<?php
declare(strict_types=1);

namespace WPReviewManager\Models;
use WPReviewManager\Services\ArrayHelper as Arr;

class ReviewForm extends Model
{
    public function getReviewForms()
    {
        $search_string = Arr::get($_REQUEST, 'search_string', "");
        $post_query_array = [
            'post_type' => 'wp_review_form',
            'post_status' => 'publish',
            'numberposts' => -1
        ];
        
        if($search_string) {
            $post_query_array['s'] = $search_string;
        }

       $all_forms = get_posts($post_query_array);

        if (empty($all_forms)) {
            wp_send_json_error(
                [
                    'message' => "No forms found."
                ],423);
        }

        $forms = [];
        foreach ($all_forms as $form) {
            $form->shortcode = '[wp-review-manager id="' . $form->ID . '"]';
            $form->actions = array(
                'edit' => true,
                'delete' => true,
            );
            $form->reviews = '100';
            $form->form_fields = maybe_unserialize(get_post_meta($form->ID, 'wprm_form_fields', true));
            $form->preview_url = site_url('?wp_paymentform_preview=' . $form->ID);
            $forms[] = $form;
        }

        wp_send_json_success(
            [
                'forms' => $forms,
                'message' => "Forms retried."
            ],
        200);
    }

    public function getReviewForm()
    {
        $reviewFormId = $_REQUEST['form_id'];

        $reviewForm = get_post($reviewFormId, 'OBJECT');
        if (!$reviewForm || $reviewForm->post_type != 'wp_review_form') {
            wp_send_json_error(
                [
                    'message' => "Form not found."
                ],423);
        }

        $data = maybe_unserialize(get_post_meta($reviewFormId, 'wprm_form_fields', true));

        $reviewForm->form_fields = $data ? $data : [];
        $reviewForm->preview_url = site_url('?wp_paymentform_preview=' . $reviewForm->ID);

        wp_send_json_success(
            [
                'form' => $reviewForm,
                'message' => "Form info retrived."
            ],
        200);
    }

    public function saveReviewForm()
    {
        $reviewFormId = $_REQUEST['form_id'];
        $formFields = maybe_serialize($_REQUEST['formFields']);

        wp_update_post([
            'ID' => $reviewFormId,
            'post_title' => sanitize_text_field( $_REQUEST['post_title'] )
        ]);

        if (is_wp_error($reviewFormId)) {
            wp_send_json_error(
                [
                    'message' => $reviewFormId->get_error_message()
                ],
            423);
        }

        update_post_meta($reviewFormId, 'wprm_form_fields', $formFields);

        wp_send_json_success( array(
            'form_id' => $reviewFormId,
            'message' => 'Form saved!'
        ),200 );
    }

    public function create()
    {   
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
        $reviewFormId = $this->store($data);

        wp_update_post([
            'ID' => $reviewFormId,
            'post_title' => sanitize_text_field($data['post_title']) . ' (#' . $reviewFormId . ')'
        ]);

        if (is_wp_error($reviewFormId)) {
            wp_send_json_error(
                [
                    'message' => $reviewFormId->get_error_message()
                ],
            423);
        }

        static::insertTemplate($reviewFormId, $template);
    }

    public static function insertTemplate($reviewFormId, $template)
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

    private function store($data)
    {
        $data['post_type'] = 'wp_review_form';
        $data['post_status'] = 'publish';
        $id = wp_insert_post($data);
        return $id;
    }

    public function deleteReviewForm($id)
    {
        return 'deleteReviewForm';
    }

}