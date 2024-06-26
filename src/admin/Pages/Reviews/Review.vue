<template>
  <div
    v-if="loaded"
    v-loading="fetching"
    class="adrm-review-wrapper"
  >
    <div class="adrm-review-header"> 
      <router-link :to="`/form/edit/${formID}/reviews`">
        <Icon icon="LeftBack" />
        Back to Reviews
      </router-link>
      <h3>{{ formTitle }} - Review ID - {{ $route.params.reviewId }}</h3>
    </div>
    <div
      class="adrm-review"
      style="display: flex; flex-direction: column; gap: 20px; background: #fff; padding: 30px;"
    > 
      <div class="adrm-review_main"> 
        <div class="adrm-review_main-header">
          <el-rate
            v-model="rating"
            disabled
            show-score
            text-color="#ff9900"
          />
          <span>{{ date }}</span>
        </div>
        <div class="adrm-review_main-middle"> 
          <div
            class="adrm-review_main-middle_left"
            style="display: flex; flex-direction: column;"
          > 
            <p
              class="adrm-review_message"
              style="display: block; font-size: 14px; color: #000; font-weight: 600; margin-bottom: 8px;"
            >
              &quot; {{ reviewData.message }}  &quot;
            </p>
            <p
              class="adrm-review_name"
              style="font-weight: 600; font-size: 12px; margin-bottom: 4px;"
            >
              {{ reviewData.name }}
            </p>
            <p
              class="adrm-review_email"
              style="font-weight: 600; font-size: 12px;"
            >
              {{ reviewData.email }}
            </p>
            <p
              v-if="reviewData.position"
              style="font-weight: bold; font-size: 12px; margin-top: 4px;"
            >
              {{ reviewData.position }}
            </p>
          </div>
          <div
            class="adrm-review_main-middle_right"
            style="display: flex; align-items: center"
          >
            <el-image
              :src="getThumbNail()"
              style="width: 80px"
            >
              <template #placeholder>
                <div class="image-slot">
                  Loading<span class="dot">...</span>
                </div>
              </template>
            </el-image>
          </div>
        </div>
      </div>
      <div
        v-if="reviewData.ratings.length > 1"
        class="adrm-review_meta"
      > 
        <span style="font-size: 16px; border-bottom: 1px dotted #555; text-align: center; color: #ff9900; padding-bottom: 6px;">Other ratings</span>
        <div
          class="adrm-review_meta-list"
          style="display: flex; gap: 20px; margin-top: 20px;"
        > 
          <el-table
            :data="reviewData.ratings"
            style="width: 100%"
          >
            <el-table-column
              prop="label"
              label="Label"
            />
            <el-table-column
              v-slot="scope"
              label="Value"
            > 
              <el-rate
                v-model="scope.row.value"
                disabled
                text-color="#ff9900"
              />
            </el-table-column>
          </el-table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment';
import Icon from '../../Icons/Index.vue';
export default {
    name: 'Review',
    components: {
        Icon
    },
    data() {
        return {
            review: [],
            reviewData: {},
            reviewMeta: {},
            formTitle: '',
            loading: false,
            loaded: false,
            formID: this.$route.params.id,
            fetching: false,
        };
    },
    computed: {
        reviewId() {
            return this.$route.params.reviewId;
        },
        rating() {
            const sum = this.reviewData.ratings.reduce((accumulator, rating) => accumulator 
            + parseInt(rating.value) , 0);
            return parseFloat(sum / this.reviewData.ratings.length).toFixed(1) ;

        },
        date() {
            return moment(this.reviewData.created_at).format('dddd D MMMM YYYY');
        },
    },
    created() {
        this.fetching = true;
        this.getForm();
        this.getReview();
    },
    methods: {
        getReview() {
            this.$get('', {
                action: 'ad_review_manager_ajax',
                route: 'get_review',
                nonce: window.ADRMAdmin.adrm_nonce,
                reviewID: this.$route.params.reviewId
            }).then((response) => {
                this.review = response.data;
                this.reviewData = response.data.meta.formFieldData;
                console.log('response...', response, this.review);
                this.loaded = true;
                this.fetching = false;
            }).catch(function (error) {
                this.fetching = false;
                console.log(error);
            });
        },
        getThumbNail() {
            console.log('...', this.review.avatar);
            const srcRegex = /src=['"]([^'"]+)['"]/;
            const match = this.review.avatar.match(srcRegex);
            const srcValue = match ? match[1] : null;
            return srcValue;
        },
        getForm() {

            this.loading = true;
            this.$get('',
                {
                action: 'ad_review_manager_ajax',
                route: 'get_review_form',
                nonce: window.ADRMAdmin.adrm_nonce,
                form_id: this.$route.params.id,
                }).then( (response) => {
                    this.formTitle = response.data.form.post_title;
                    this.loading = false;
                }).catch((error) => {
                    this.loading = false;
                    console.log(error);
                });
        },
    },
};
</script>