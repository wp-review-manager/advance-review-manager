<?php
namespace ADReviewManager\Views\Template;
use ADReviewManager\Classes\Helper;
use ADReviewManager\Services\ArrayHelper as Arr;
/**
 * Class ReviewsTemplate
 * @package ADReviewManager\Views
 */
$per_page = Arr::get($pagination, 'per_page');
$enablePagination = Arr::get($pagination, 'enable');
if ($enablePagination == 'true') {
    $total_page = ceil($total_reviews / $per_page);
}
?>
<div data-form-id="<?php echo $form->ID ?>" data-template-type="<?php echo $form->post_name ?>" class="review-template_settings_wrapper">
    <div class="review-template">
        <?php
        if (empty($all_reviews)) {
            echo '<p style="padding: 20px">No reviews yet</p>';
        }else {
            $reviewStats = TemplateHelper::getAverageRatingByCategories($all_reviews);
            $summary_by_rating = Arr::get($reviewStats, 'summary_by_rating', []);
            $total_average_rating = Arr::get($reviewStats, 'total_average_rating', 0);
            $review_label = TemplateHelper::getReviewLabel($total_average_rating); 
            // dd($summary_by_rating, $total_average_rating, $review_label)
        ?>
        <div class="adrm-product-review-stats-wrapper">
            <div class="adrm-product-review-stats">
                <div class="adrm-product-reviews-stats-heading">
                    <h2 class="average-rating"><?php echo $total_average_rating ?></h2>
                    <div>
                        <p>Average Rating</p>
                        <div class="ratings">
                            <div class="adrm_rating">
                                <div class="adrm-star-rating">
                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                        <label name="rating" class="<?php echo $i <= $total_average_rating ? 'active' : ''; ?>" value="<?php echo $i; ?>">★</label>
                                    <?php } ?>
                                </div>
                            </div>
                            <p><?php echo count($all_reviews) ?> Ratings</p>
                        </div>
                    </div>
                </div>
                <div class="adrm-product-rating-stats">
                    <?php foreach($summary_by_rating as $key => $summary) {
                    $average_rating =(($key * $summary) / ($summary * 5)) * 100;
                    ?>
                    <div class="adrm-progress-bar">
                        <div class="adrm_rating">
                            <div class="adrm-star-rating">
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <label name="rating" class="<?php echo $i <= $key ? 'active' : ''; ?>" value="<?php echo $i; ?>">★</label>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="bar" style="width: <?php echo $average_rating . "%" ?>">
                                <p class="percent"><?php echo $summary ?></p>
                            </div>
                        </div>
                        <p><?php echo $average_rating ?>%</p>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="adrm_product_review_temp">
        <?php foreach ($reviews as $review) {
             $average_rating = Arr::get($review, 'average_rating');
             $created_at = Arr::get($review, 'created_at');
             $review = Arr::get($review, 'meta.formFieldData', []);
             $ratings = Arr::get($review, 'ratings', []);
        ?>
        <div class="adrm_review_temp_one">
            <div class="adrm_review_temp_one_avatar">
                <?php echo get_avatar(Arr::get($review, 'email'), 96) ?>
            </div>
            <div class="adrm_review_temp_one_content">
                <div class="adrm_review_temp_one_content_header">
                    <div class="left">
                        <p class="date adrm-heading"><?php echo Arr::get($review, 'name'); ?></p>
                        <h3 class="adrm_review_temp_one_content_header_name adrm-heading">
                            <?php echo Arr::get($review, 'title'); ?>
                        </h3>
                    </div>
                    <div class="adrm_rating">
                        <p><?php echo (new Helper)->formatDate($created_at);  ?></p>
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
        <?php }?>
        </div>
        <?php
       if($enablePagination == 'true') {?>
        <div class="adrm-pagination">
            <button class="adrm-prev-page">Prev</button>
            <ul class="adrm-page-numbers">
                <?php for($i = 1; $i <= $total_page; $i++) { ?>
                    <li class="adrm-page-number <?php echo $i == 1 ? 'active' : '' ?>"><?php echo $i ?></li>
                <?php } ?>
            </ul>
            <button class="adrm-next-page">Next</button>
        </div>
        <?php }
    }?>
    </div>
</div>
