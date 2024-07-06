<?php 
namespace ADReviewManager\Views\Template;
use ADReviewManager\Services\ArrayHelper as Arr;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

class TemplateHelper {
    
    public static function getAverageRatingByCategories($reviews) {
        $categoriesReview = [];
        $total_average_rating = 0;
        $summary_by_rating = [];
        foreach ($reviews as $review) {
            $ratings = Arr::get($review, 'meta.formFieldData.ratings', []);
            $total_average_rating += Arr::get($review, 'average_rating', 0);
            foreach ($ratings as $rating) {
                $label = Arr::get($rating, 'label');
                $value = Arr::get($rating, 'value');
                if (!isset($categoriesReview[$label])) {
                    $categoriesReview[$label] = [];
                }
                
                $categoriesReview[$label]['total_rating'] = Arr::get($categoriesReview[$label], 'total_rating', 0) + $value;
                $categoriesReview[$label]['count_ratings'] = Arr::get($categoriesReview[$label], 'count_ratings', 0) + 1;
                $summary_by_rating[$value] = Arr::get($summary_by_rating, $value, 0) + 1;

            }
        }

        return array(
            'categoriesReview' => $categoriesReview,
            'total_average_rating' => number_format($total_average_rating / count($reviews), 2),
            'summary_by_rating' => $summary_by_rating
        );
    }

    public static function getReviewLabel ($rating) {
        if ($rating >= 4.5) {
            return 'Excellent';
        } else if ($rating >= 4) {
            return 'Very Good';
        } else if ($rating >= 3.5) {
            return 'Good';
        } else if ($rating >= 3) {
            return 'Fair';
        } else if ($rating >= 2.5) {
            return 'Average';
        } else if ($rating >= 2) {
            return 'Below Average';
        } else {
            return 'Poor';
        }
    }
}
