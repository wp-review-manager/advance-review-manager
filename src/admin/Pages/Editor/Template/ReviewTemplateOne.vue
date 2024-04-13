<template>
  <div>
    <div
      v-for="(review, index) in reviews"
      :key="index"
      class="adrm_review_temp_one"
    >
      <div class="adrm_review_temp_one_avatar">
        <img
          src="https://via.placeholder.com/150"
          alt="Avatar"
        >
      </div>
      <div class="adrm_review_temp_one_content">
        <div class="adrm_review_temp_one_content_header">
          <div class="left">
            <p class="date">
              {{ convertMysqlDateFormat(review.created_at) }}
            </p>
            <h3 class="adrm_review_temp_one_content_header_name">
              {{ review.meta.formFieldData.name }}
            </h3>
          </div>
          <div class="adrm_rating">
            <RatingLabel :rating="review.meta.formFieldData.rating" />
          </div>
        </div>
        <div class="adrm_review_temp_one_content_body">
          <p class="review">
            {{ review.meta.formFieldData.message }}
          </p>
        </div>
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