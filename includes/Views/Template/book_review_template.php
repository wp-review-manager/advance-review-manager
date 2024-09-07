<?php
namespace ADReviewManager\Views;
use ADReviewManager\Classes\Helper;
use ADReviewManager\Services\ArrayHelper as Arr;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class ReviewsTemplate
 * @package ADReviewManager\Views
 */
?>
<div class="review-template_settings_wrapper">
    <div class="review-template padding-20">
        <h3 class="adrm-heading">CUSTOMER REVIEWS (<?php echo esc_html($total_reviews) ?>)</h3>
        <?php
        if (empty($reviews)) {
            echo wp_kses('<p style="padding: 20px">No reviews yet</p>', $allowed_html_tags);
        }
        ?>
        <?php foreach ($reviews as $review) {
             $average_rating = Arr::get($review, 'average_rating');
             $created_at = Arr::get($review, 'created_at');
             $reviewId = Arr::get($review, 'id');
             $comments = Arr::get($review, 'comments', []);
             $review = Arr::get($review, 'meta.formFieldData', []);
             $ratings = Arr::get($review, 'ratings', []);
        ?>
        <div class="adrm_review_temp_one adrm_review_temp_book"><!-- {{ review }} -->
            <div class="adrm_review_temp_one_avatar">
                <?php echo wp_kses(get_avatar(Arr::get($review, 'email'), 96), $allowed_html_tags) ?>
            </div>
            <div class="adrm_review_temp_one_content">
                <div class="adrm_review_temp_one_content_header">
                    <div class="left">
                        <p class="date adrm-heading"><?php echo esc_html((new Helper)->formatDate($created_at));  ?></p>
                        <h3 class="adrm_review_temp_one_content_header_name adrm-heading">
                            <?php echo esc_html(Arr::get($review, 'name')); ?>
                        </h3>
                    </div>
                    <div class="adrm_rating">
                        <div class="adrm-star-rating">
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <label name="rating" class="<?php echo esc_attr($i <= $average_rating ? 'active' : ''); ?>" value="<?php echo esc_attr($i); ?>">★</label>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="adrm_review_temp_one_content_body">
                    <p class="review"><?php echo esc_html(Arr::get($review, 'message')); ?></p>
                </div>
                   <?php if(is_user_logged_in()) {?>
                        <button class="adrm-reply-btn"><?php echo __('Reply', 'advance-review-manager') ?></button>
                    <?php } ?>
            </div>
            <div class="adrm-reply">
                <form class="adrm-reply-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
                    <input type="hidden" name="action" value="adrm_review_reply_action">
                    <input type="hidden" name="review_id" value="<?php echo esc_html($reviewId) ?>"/>
                    <?php wp_nonce_field('adrm_public_nonce', 'adrm_public_nonce'); ?>
                    <textarea name="reply" id="reply" cols="10" rows="6" ></textarea>
                    <button class="adrm-reply-button"><?php echo __('Submit', 'advance-review-manager') ?></button>
                </form>
            </div>
            <?php if (count($comments)): ?>
                <div class="adrm-review-reply-section"> 
                    <h4 style="font-size: 16px; color: #333">Replies</h4>
                    <?php foreach ($comments as $comment) { ?>
                        <div class="adrm-review-comment">
                            <div> 
                                <span style="font-size: 16px; color: #000"><?php echo esc_html(ucfirst($comment['name'])) ?></span>
                            </div>
                            <div class="adrm-review-comment-content">
                                <p><?php echo esc_html(Arr::get($comment, 'comment')); ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php endif; ?>
        </div>
        <?php } ?>
    </div>
</div>
