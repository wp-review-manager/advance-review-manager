<?php
namespace WPReviewManager\Views;
use WPReviewManager\Classes\Helper;
use WPReviewManager\Services\ArrayHelper as Arr;
/**
 * Class ReviewsTemplate
 * @package WPReviewManager\Views
 */

class ReviewsTemplate {
    public function render($reviews = []) {
        ?>
        <style>
            div {
                padding: 0px;
            }
        </style>
        <div class="review-template_settings_wrapper">
            <div class="review-template" style="background: #4caf500f;">
                <h3>Reviews</h3>
                <?php
                if (empty($reviews)) {
                    echo '<p>No reviews yet</p>';
                }
                ?>
                <?php foreach ($reviews as $review) { ?>
                <div class="wprm_review_temp_one"><!-- {{ review }} -->
                    <div class="wprm_review_temp_one_avatar"><img src="https://cdn1.vectorstock.com/i/1000x1000/51/05/male-profile-avatar-with-brown-hair-vector-12055105.jpg" alt="Avatar"></div>
                    <div class="wprm_review_temp_one_content">
                        <div class="wprm_review_temp_one_content_header">
                            <div class="left">
                                <p class="date"><?php echo (new Helper)->formatDate(Arr::get($review, 'created_at'));  ?></p>
                                <h3 class="wprm_review_temp_one_content_header_name">John Doe</h3>
                            </div>
                            <div class="wprm_rating">
                                <div class="wprm-star-rating">
                                    <label name="rating" class="active" value="1">★</label>
                                    <label name="rating" class="active" value="2">★</label>
                                    <label name="rating" class="active" value="3">★</label>
                                    <label name="rating" value="4">★</label>
                                    <label name="rating" value="5">★</label>
                                </div>
                            </div>
                        </div>
                        <div class="wprm_review_temp_one_content_body">
                            <p class="review">This is a review of the product. It is a very good product. I would recommend it to
                                anyone.</p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php
    }
}