<template>
    <p> Review detail....</p>
</template>

<script>

export default {
    name: 'Review',
    components: {

    },
    data() {
        return {
            review: null
        }
    },
    methods: {
        getReview() {
            // this.$get('', {
            //     action: 'ad_review_manager_ajax',
            //     route: 'get_review',
            //     nonce: window.ADRMAdmin.adrm_nonce,
            //     review_id: this.$route.params.id
            // }).then((response) => {
            //     this.review = response.data.review;
            // }).catch(function (error) {
            //     console.log(error);
            // });
        }
    },
    created() {
        this.getReview();
    },
}
</script>