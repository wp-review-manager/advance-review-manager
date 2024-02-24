<template>
    <div class="review-template_settings_wrapper">
      <div class="review-template">
        <ReviewTemplateOne :reviews="reviews"/>
      </div>
      <div class="review-template-settings">
        <p>Settings</p>
      </div>
    </div>
  </template>
  
  <script>
  import ReviewTemplateOne from './Template/ReviewTemplateOne.vue';
  export default {
    components: {
      ReviewTemplateOne
    },
    data() {
      return {
        newComment: '',
        comments: [],
        likes: 0,
      };
    },
    props: {
      reviews: {
        type: Array,
        required: true,
      },
    },
    methods: {
      
    },
  };
  </script>
  
  <style lang="scss">
  </style>