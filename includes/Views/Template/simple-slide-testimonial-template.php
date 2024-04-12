<?php
namespace ADReviewManager\Views\Template;
use ADReviewManager\Classes\Helper;
use ADReviewManager\Services\ArrayHelper as Arr;
/**
 * Class ReviewsTemplate
 * @package ADReviewManager\Views
 */
?>
<div data-form-id="<?php echo $form->ID ?>" data-template-type="<?php echo $form->post_name ?>" class="review-template_settings_wrapper">
    <div class="review-template">
        <div class="simple-slide-testimonial-template">
        <?php foreach ($reviews as $key => $review) {
             $average_rating = Arr::get($review, 'average_rating');
             $created_at = Arr::get($review, 'created_at');
             $review = Arr::get($review, 'meta.formFieldData', []);
             $ratings = Arr::get($review, 'ratings', []);
        ?>
            <div class="adrm-testimonial-container <?php echo $key == 0 ? 'active' : '' ?>">
                <div class="btn" id="btn-prev">
                    <span class="dashicons dashicons-arrow-left-alt2"></span>
                </div>
                <div class="btn" id="btn-next">
                    <span class="dashicons dashicons-arrow-right-alt2"></span>
                </div>
                <div class="adrm_rating">
                    <div class="adrm-star-rating">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <label name="rating" class="<?php echo $i <= $average_rating ? 'active' : ''; ?>" value="<?php echo $i; ?>">★</label>
                        <?php } ?>
                    </div>
                </div>
                <p class="testimonial">
                    <?php echo Arr::get($review, 'message', ''); ?>
                </p>
                <div class="user">
                    <div style="border-radius: 50%; overflow: hidden">
                        <?php echo get_avatar(Arr::get($review, 'email'), 96) ?>
                    </div>
                    <div class="user-details">
                        <h4 class="username"><?php echo Arr::get($review, 'name'); ?></h4>
                        <p class="role"><?php echo Arr::get($review, 'position'); ?></p>
                    </div>
                </div>
                <div class="progress-dots" id="progress-dots">
                    <?php for ($i=0; $i < count($reviews) ; $i++) { ?>
                        <div class="progress-dot <?php echo $i == 0 ? 'active' : '' ?>" id="progress-dot"></div>
                    <?php }?>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</div>