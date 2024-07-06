<?php
namespace ADReviewManager\Views\Template;
use ADReviewManager\Classes\Helper;
use ADReviewManager\Services\ArrayHelper as Arr;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

/**
 * Class ReviewsTemplate
 * @package ADReviewManager\Views
 */
?>
<div data-form-id="<?php echo esc_attr($form->ID) ?>" data-template-type="<?php echo esc_attr($form->post_name) ?>" class="review-template_settings_wrapper">
    <div class="review-template">
        <div class="simple-slide-testimonial-template">
        <?php foreach ($reviews as $key => $review) {
             $average_rating = Arr::get($review, 'average_rating');
             $created_at = Arr::get($review, 'created_at');
             $review = Arr::get($review, 'meta.formFieldData', []);
             $ratings = Arr::get($review, 'ratings', []);
        ?>
            <div class="adrm-testimonial-container <?php echo esc_attr($key == 0 ? 'active' : '') ?>">
                <div class="btn" id="btn-prev">
                    <span class="dashicons dashicons-arrow-left-alt2"></span>
                </div>
                <div class="btn" id="btn-next">
                    <span class="dashicons dashicons-arrow-right-alt2"></span>
                </div>
                <div class="adrm_rating">
                    <div class="adrm-star-rating">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <label name="rating" class="<?php echo esc_attr($i <= $average_rating ? 'active' : ''); ?>" value="<?php echo esc_html($i); ?>">★</label>
                        <?php } ?>
                    </div>
                </div>
                <p class="testimonial">
                    <?php echo esc_html(Arr::get($review, 'message', '')); ?>
                </p>
                <div class="user">
                    <div style="border-radius: 50%; overflow: hidden">
                        <?php echo wp_kses(get_avatar(Arr::get($review, 'email'), 96), $allowed_html_tags); ?>
                    </div>
                    <div class="user-details">
                        <h4 class="username"><?php echo esc_html(Arr::get($review, 'name')); ?></h4>
                        <p class="role"><?php echo esc_html(Arr::get($review, 'position')); ?></p>
                    </div>
                </div>
                <div class="progress-dots" id="progress-dots">
                    <?php for ($i=0; $i < count($reviews) ; $i++) { ?>
                        <div class="progress-dot <?php echo esc_attr($i == 0 ? 'active' : '') ?>" id="progress-dot"></div>
                    <?php }?>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</div>