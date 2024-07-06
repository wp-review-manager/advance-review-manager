<?php
namespace ADReviewManager\Views;
use ADReviewManager\Classes\Helper;
use ADReviewManager\Services\ArrayHelper as Arr;
use ADReviewManager\Classes\View;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
/**
 * Class ReviewsTemplate
 * @package ADReviewManager\Views
 */

class ReviewsTemplate {
    public function render($reviews = [], $form, $total_reviews, $pagination, $all_reviews) {
        $template = 'Template.';
        if (str_contains($form->post_name, 'book-review-form-template')) {
            $template .= 'book_review_template';
        } else if (str_contains($form->post_name, 'food-review-form-template')) {
            $template .= 'food-review-form-template';
        } else if(str_contains($form->post_name, 'hotel-review-form-template')) {
            $template .= 'hotel-review-form-template';
        } else if(str_contains($form->post_name, 'product-review-form-template')) {
            $template .= 'product-review-form-template';
        }else if(str_contains($form->post_name, 'simple-slide-testimonial-template')) {
            $template .= 'simple-slide-testimonial-template';
        }

        View::render($template, [
            'reviews' => $reviews,
            'allowed_html_tags' => Helper::allowedHTMLTags(),
            'pagination' => $pagination,
            'total_reviews' => $total_reviews,
            'all_reviews' => $all_reviews,
            'form' => $form
        ]);
    }
}