<template>
    <div v-for="(review, index) in reviews" class="wprm_review_temp_one" :key="index">
        <!-- {{ review }} -->
        <div class="wprm_review_temp_one_avatar">
            <img src="https://via.placeholder.com/150" alt="Avatar" />
        </div>
        <div class="wprm_review_temp_one_content">
            <div class="wprm_review_temp_one_content_header">
                <div class="left">
                    <p class="date">{{ convertMysqlDateFormat(review.created_at) }}</p>
                    <h3 class="wprm_review_temp_one_content_header_name">John Doe</h3>
                </div>
                <div class="rating">
                    a234523
                </div>
                <!-- <div class="star-rating">
                    <input type="radio" id="5-stars" name="rating" value="5" />
                    <label for="5-stars" class="star">&#9733;</label>
                    <input type="radio" id="4-stars" name="rating" value="4" />
                    <label for="4-stars" class="star">&#9733;</label>
                    <input type="radio" id="3-stars" name="rating" value="3" />
                    <label for="3-stars" class="star">&#9733;</label>
                    <input type="radio" id="2-stars" name="rating" value="2" />
                    <label for="2-stars" class="star">&#9733;</label>
                    <input type="radio" id="1-star" name="rating" value="1" />
                    <label for="1-star" class="star">&#9733;</label>
                </div> -->
            </div>
            <div class="wprm_review_temp_one_content_body">
                <p class="review">This is a review of the product. It is a very good product. I would recommend it to
                    anyone.</p>
            </div>
        </div>
    </div>
</template>
<script>
import { convertMysqlDateFormat } from '../../../helper.js';
export default {
    props: {
        reviews: {
            type: Array,
            required: true,
        },
    },
    methods: {
        convertMysqlDateFormat,
    },
};
</script>