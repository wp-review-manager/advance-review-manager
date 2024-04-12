<?php
namespace ADReviewManager\Views;
use ADReviewManager\Classes\Helper;
use ADReviewManager\Services\ArrayHelper as Arr;
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
<div data-template-type="<?php echo $form->post_name ?>" data-form-id="<?php echo $form->ID ?>" class="review-template_settings_wrapper">
    <div class="review-template">
        <?php
        if (empty($reviews)) {
            echo '<p style="padding: 20px">No reviews yet</p>';
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

                    <input class="adrm-filter-by-star"  type="radio" name="review-filter" id="1-star" value="1">
                    <label  for="1-star"><p>*</p>1</label>

                    <input class="adrm-filter-by-star" type="radio" name="review-filter" id="2-star" value="2">
                    <label for="2-star"><p>*</p>2</label>

                    <input class="adrm-filter-by-star" type="radio" name="review-filter" id="3-star" value="3">
                    <label for="3-star"><p>*</p>3</label>

                    <input class="adrm-filter-by-star" type="radio" name="review-filter" id="4-star" value="4">
                    <label for="4-star"><p>*</p>4</label>

                    <input class="adrm-filter-by-star" type="radio" name="review-filter" id="5-star" value="5">
                    <label for="5-star"><p>*</p>5</label>

                </div>
            </div>
        </div>
        <div class="adrm_food_review_template_wrapper">
        <h3 class="adrm-heading">CUSTOMER REVIEWS (<?php echo $total_reviews ?>)</h3>

            <?php foreach ($reviews as $review) {
                $average_rating = Arr::get($review, 'average_rating');
                $created_at = Arr::get($review, 'created_at');
                $review = Arr::get($review, 'meta.formFieldData', []);
                $ratings = Arr::get($review, 'ratings', []);
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
        <?php if($enablePagination == 'true') {?>
        <div class="adrm-pagination">
            <button class="adrm-prev-page">Prev</button>
            <ul class="adrm-page-numbers">
                <?php for($i = 1; $i <= $total_page; $i++) { ?>
                    <li class="adrm-page-number <?php echo $i == 1 ? 'active' : '' ?>"><?php echo $i ?></li>
                <?php } ?>
            </ul>
            <button class="adrm-next-page">Next</button>
        </div>
        <?php } ?>

        <?php } ?>
    </div>
</div>

