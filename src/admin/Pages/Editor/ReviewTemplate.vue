<template>
    <div class="review-template">
      <div class="review-section">
        <textarea v-model="newComment" placeholder="Write your review here..."></textarea>
        <button @click="addComment">Submit</button>
      </div>
      <div class="like-section">
        <button @click="likeReview">Like</button>
        <p>{{ likes }} likes</p>
      </div>
      <div class="comments-section">
        <p v-for="(comment, index) in comments" :key="index">{{ comment }}</p>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        newComment: '',
        comments: [],
        likes: 0,
      };
    },
    methods: {
      addComment() {
        this.comments.push(this.newComment);
        this.newComment = '';
      },
      likeReview() {
        this.likes++;
      },
    },
  };
  </script>
  
  <style lang="scss">
  .review-template {
    .review-section {
      textarea {
        width: 100%;
        height: 100px;
        margin-bottom: 10px;
      }
    }
    .like-section {
      button {
        margin-right: 10px;
      }
    }
    .comments-section {
      p {
        border-bottom: 1px solid #ccc;
        padding: 10px 0;
      }
    }
  }
  </style>