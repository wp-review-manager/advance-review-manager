<?php
namespace ADReviewManager\Views;
use ADReviewManager\Classes\Helper;
use ADReviewManager\Services\ArrayHelper as Arr;
/**
 * Class ReviewsTemplate
 * @package ADReviewManager\Views
 */
?>
<div class="review-template_settings_wrapper">
    <div class="review-template" style="background: #4caf500f;">
        <h3>Reviews (<?php echo $total_reviews ?>)</h3>
        <?php
        if (empty($reviews)) {
            echo '<p>No reviews yet</p>';
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
                <?php echo get_avatar(Arr::get($review, 'email'), 96) ?>
            </div>
            <div class="adrm_review_temp_one_content">
                <div class="adrm_review_temp_one_content_header">
                    <div class="left">
                        <p class="date"><?php echo (new Helper)->formatDate($created_at);  ?></p>
                        <h3 class="adrm_review_temp_one_content_header_name">
                            <?php echo Arr::get($review, 'name'); ?>
                        </h3>
                    </div>
                    <div class="adrm_rating">
                        <div class="adrm-star-rating">
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <label name="rating" class="<?php echo $i <= $average_rating ? 'active' : ''; ?>" value="<?php echo $i; ?>">★</label>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="adrm_review_temp_one_content_body">
                    <p class="review"><?php echo Arr::get($review, 'message'); ?></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
