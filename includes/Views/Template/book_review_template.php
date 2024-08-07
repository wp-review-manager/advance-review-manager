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
             $review = Arr::get($review, 'meta.formFieldData', []);
             $ratings = Arr::get($review, 'ratings', []);
        ?>
        <div class="adrm_review_temp_one"><!-- {{ review }} -->
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
            </div>
        </div>
        <?php } ?>
    </div>
</div>
