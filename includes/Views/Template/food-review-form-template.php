<?php
namespace ADReviewManager\Views;
use ADReviewManager\Classes\Helper;
use ADReviewManager\Services\ArrayHelper as Arr;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

/**
 * Return a html review template for the food review form
 * get the reviews and form data and render the template
 */
$per_page = Arr::get($pagination, 'per_page');
$enablePagination = Arr::get($pagination, 'enable');
if ($enablePagination == 'true') {
    $total_page = ceil($total_reviews / $per_page);
}

?>
<div data-template-type="<?php echo esc_html($form->post_name) ?>" data-form-id="<?php echo esc_html($form->ID) ?>" class="review-template_settings_wrapper">
    <div class="review-template">
        <?php
        if (empty($reviews)) {
            echo wp_kses('<p style="padding: 20px">No reviews yet</p>', $allowed_html_tags);
        } else { // Add the else condition here
        ?>
        <div class="review-filters">
            <div class="review-filter">
                <label for="review-sort">Sort by:</label>
                <select class="adrm-sort-input" name="review-sort" id="review-sort">
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                </select>
            </div>
            <div class="review-filter">
                <label for="review-filter">Filter by:</label>
                <div class="filter-radio-inputs">

                    <input class="adrm-filter-by-star" type="radio" name="review-filter" id="all" value="all" checked>
                    <label for="all">All</label>

                    <input class="adrm-filter-by-star"  type="radio" name="review-filter" id="5-star" value="5">
                    <label  for="5-star"><p>*</p>5</label>

                    <input class="adrm-filter-by-star" type="radio" name="review-filter" id="4-star" value="4">
                    <label for="4-star"><p>*</p>4</label>

                    <input class="adrm-filter-by-star" type="radio" name="review-filter" id="3-star" value="3">
                    <label for="3-star"><p>*</p>3</label>

                    <input class="adrm-filter-by-star" type="radio" name="review-filter" id="2-star" value="2">
                    <label for="2-star"><p>*</p>2</label>

                    <input class="adrm-filter-by-star" type="radio" name="review-filter" id="1-star" value="1">
                    <label for="1-star"><p>*</p>1</label>

                </div>
            </div>
        </div>
        <div class="adrm_food_review_template_wrapper">
        <h3 class="adrm-heading">CUSTOMER REVIEWS (<?php echo esc_html($total_reviews) ?>)</h3>

            <?php foreach ($reviews as $review) {
                $average_rating = Arr::get($review, 'average_rating');
                $created_at = Arr::get($review, 'created_at');
                $ratings = Arr::get($review, 'ratings', []);
                $reviewId = Arr::get($review, 'id');
                $comments = Arr::get($review, 'comments', []);
                $review = Arr::get($review, 'meta.formFieldData', []);
            ?>
            <div class="adrm_food_review_template">
                <div class="adrm_review_content"> 
                    <div class="adrm-reviewer-info">
                        <div class="adrm-reviewer-avatar">
                        <?php echo wp_kses(get_avatar(Arr::get($review, 'email'), 96), $allowed_html_tags) ?>
                        </div>
                        <div class="adrm-reviewer-name">
                            <span><?php echo esc_html(Arr::get($review, 'name')); ?></span>
                        </div>
                        <div class="adrm-reviewer-email">
                            <span><?php echo esc_html(Arr::get($review, 'email')); ?></span>
                        </div>

                    </div>
                    <div class="adrm-review-body" style="display:none; opacity: 0.5">
                        <div class="adrm-review-rating">
                            <div class="adrm-star-rating">
                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <label name="rating" class="<?php echo esc_attr($i <= $average_rating ? 'active' : ''); ?>" value="<?php echo esc_attr($i); ?>">★</label>
                                <?php } ?>
                            </div>
                            <span class="adrm-review-date"> Reviewed <?php echo esc_html((new Helper)->formatDate($created_at)); ?></span>
                        </div>
                        <div class="adrm-review-content">
                            <p><?php echo esc_html(Arr::get($review, 'message')); ?></p>
                        </div>
                        <div class="review-categories">
                            <?php if (!empty($review['ratings'])): ?>
                                <?php foreach ($review['ratings'] as $rating): ?>
                                    <div class="adrm-star-rating">
                                        <?php for ($index = 0; $index < 5; $index++): ?>
                                            <label name="rating" class="<?php echo $index < $rating['value'] ? 'active' : ''; ?>" value="<?php echo $index + 1; ?>">★</label>
                                        <?php endfor; ?>
                                        <p><?php echo htmlspecialchars($rating['label']); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <?php if(is_user_logged_in()) {?>
                            <button class="adrm-reply-btn"><?php echo __('Reply', 'advance-review-manager') ?></button>
                        <?php } ?>
                    </div>
                </div>
                <div class="adrm-reply">
                    <form class="adrm-reply-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
                        <input type="hidden" name="action" value="adrm_review_reply_action">
                        <input type="hidden" name="review_id" value="<?php echo esc_html($reviewId) ?>"/>
                        <?php wp_nonce_field('adrm_reply_nonce', 'adrm_reply_nonce_field'); ?>
                        <textarea name="reply" id="reply" cols="10" rows="6" ></textarea>
                        <button class="adrm-reply-button"><?php echo __('Submit', 'advance-review-manager') ?></button>
                    </form>
                </div>
                <?php if (count($comments)): ?>
                    <div class="adrm-review-reply-section" style="padding: 20px; margin-left: 20px !important; background: #ececec; border-radius: 8px; margin-bottom: 20px; display: flex; flex-direction: column; gap: 10px"> 
                        <h4 style="font-size: 16px; color: #333">Replies</h4>
                        <?php foreach ($comments as $comment) { ?>
                            <div class="adrm-review-comment" style="padding: 10px;">
                                <div> 
                                    <span style="font-size: 14px; color: #333"><?php echo esc_html(ucfirst($comment['name'])) ?></span>
                                </div>
                                <div class="adrm-review-comment-content" style="color: #333; font-size: 14px">
                                    <p><?php echo esc_html(Arr::get($comment, 'comment')); ?></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php } ?>
        </div>

        <?php if($enablePagination == 'true') {?>
            <div class="adrm-pagination">
                <button class="adrm-prev-page">Prev</button>
                <ul class="adrm-page-numbers">
                    <?php for($i = 1; $i <= $total_page; $i++) { ?>
                        <li class="adrm-page-number <?php echo esc_attr($i == 1 ? 'active' : '') ?>"><?php echo esc_attr($i) ?></li>
                    <?php } ?>
                </ul>
                <button class="adrm-next-page">Next</button>
            </div>
        <?php } ?>

        <?php } ?>
    </div>
</div>


