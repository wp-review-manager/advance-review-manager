<?php
namespace ADReviewManager\Views;
use ADReviewManager\Classes\Helper;
use ADReviewManager\Services\ArrayHelper as Arr;
use ADReviewManager\Classes\View;
/**
 * Class ReviewsTemplate
 * @package ADReviewManager\Views
 */

class ReviewsTemplate {
    public function render($reviews = [], $form) {
        $template = 'Template.';

        if (str_contains($form->post_name, 'book-review-form-template')) {
            $template .= 'book_review_template';
        } else if (str_contains($form->post_name, 'food-review-form-template')) {
            $template .= 'food-review-form-template';
        }

        View::render($template, [
            'reviews' => $reviews,
            'form' => $form
        ]);
    }
}