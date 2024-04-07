<?php
namespace ADReviewManager\Views;
use ADReviewManager\Classes\Helper;
use ADReviewManager\Services\ArrayHelper as Arr;
/**
 * Return a html review template for the food review form
 * get the reviews and form data and render the template
 */
?>
<div class="review-template_settings_wrapper">
    <div class="review-template" style="background: #4caf500f;">
        <?php
        if (empty($reviews)) {
            echo '<p>No reviews yet</p>';
            die();
        }
        ?>
        <h3>Reviews (<?php echo count($reviews)  ?>)</h3>
        <div class="review-filters">
            <div class="review-filter">
                <label for="review-sort">Sort by:</label>
                <select name="review-sort" id="review-sort">
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                </select>
            </div>
            <div class="review-filter">
                <label for="review-filter">Filter by:</label>
                <div class="filter-buttons">
                    <button value="all">All</button>
                    <button value="5">5 stars</button>
                    <button value="4">4 stars</button>
                    <button value="3">3 stars</button>
                    <button value="2">2 stars</button>
                    <button value="1">1 star</button>
                </div>
            </div>
        </div>
        <?php foreach ($reviews as $review) {
            $created_at = Arr::get($review, 'created_at');
            $review = Arr::get($review, 'meta.formFieldData', []);
            $ratings = Arr::get($review, 'ratings', []);
            $total_rating = 0;
            foreach ($ratings as $rating) {
                $total_rating += Arr::get($rating, 'value');
            }
            $average_rating = $total_rating / count($ratings);
        ?>
        <div class="adrm_food_review_template">
            <div class="adrm-reviewer-info">
                <div class="adrm-reviewer-avatar">
                   <?php echo get_avatar(Arr::get($review, 'email'), 96) ?>
                </div>
                <div class="adrm-reviewer-name">
                    <span><?php echo Arr::get($review, 'name'); ?></span>
                </div>
                <div class="adrm-reviewer-email">
                    <span><?php echo Arr::get($review, 'email'); ?></span>
                </div>

            </div>
            <div class="adrm-review-body">
                <div class="adrm-review-rating">
                    <div class="adrm-star-rating">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <label name="rating" class="<?php echo $i <= $average_rating ? 'active' : ''; ?>" value="<?php echo $i; ?>">★</label>
                        <?php } ?>
                    </div>
                    <span class="adrm-review-date"> Reviewed <?php echo (new Helper)->formatDate($created_at); ?></span>
                </div>
                <div class="adrm-review-content">
                    <p><?php echo Arr::get($review, 'message'); ?></p>
                </div>
                <div class="review-categories">
                    <?php foreach ($ratings as $rating) { ?>
                        <div class="adrm-star-rating">
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <label name="rating" class="<?php echo $i <= Arr::get($rating, 'value') ? 'active' : ''; ?>" value="<?php echo $i; ?>">★</label>
                            <?php } ?>
                            <p><?php echo Arr::get($rating, 'label'); ?></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

