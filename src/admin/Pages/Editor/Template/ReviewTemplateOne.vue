<template>
    <div v-for="(review, index) in reviews" class="wprm_review_temp_one" :key="index">
        {{ review }}
        <div class="wprm_review_temp_one_avatar">
            <img src="https://via.placeholder.com/150" alt="Avatar" />
        </div>
        <div class="wprm_review_temp_one_content">
            <div class="wprm_review_temp_one_content_header">
                <div class="left">
                    <p class="date">{{ convertMysqlDateFormat(review.created_at) }}</p>
                    <h3 class="wprm_review_temp_one_content_header_name">John Doe</h3>
                </div>
                <div class="wprm_rating">
                    <RatingLabel :rating="review.rating" />
                </div>
            </div>
            <div class="wprm_review_temp_one_content_body">
                <p class="review">This is a review of the product. It is a very good product. I would recommend it to
                    anyone.</p>
            </div>
        </div>
    </div>
</template>
<script>
import RatingLabel from '../../../Components/RatingLabel.vue';
import { convertMysqlDateFormat } from '../../../helper.js';
export default {
    name: 'ReviewTemplateOne',
    components: {
        RatingLabel,
    },
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