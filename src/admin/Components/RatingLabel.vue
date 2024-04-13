<template>
  <div class="adrm-star-rating">
    <span v-for="star in 5">
      <label
        name="rating"
        :class=" star <= rating ? 'active' : ''"
        value="1"
      >★</label>
    </span>
  </div>
</template>

<script>
export default {
    name: 'RatingLabel',
    props: {
        rating: {
            type: Number,
            required: true,
        },
    },
    methods: {
        getRating() {
            return this.rating;
        },
    },
};
</script>

<style lang="scss">

</style>