<template>
  <div class="adrm-card-container">
    <div
      v-for="(template, index) in formTemplates"
      :key="index"
      class="adrm-card"
    >
      <el-card :body-style="{ padding: '0px' }">
        <img
          :src="getTemplateImage(template.thumbnail)"
          style="width: 100%; height: 200px; padding: 10px; padding-bottom: 0px;"
          alt="image"
          class="image"
        >
        <div style="padding: 14px">
          <p style="font-weight: 600; text-align: center; padding: 10px 0px;">{{ template.title }}</p>
          <div class="bottom">
            <el-button
              style="width: 100%;"
              type="primary"
              @click="saveForm(index)"
            >
              Choose Template
            </el-button>
          </div>
        </div>
      </el-card>
    </div>
  </div>
</template>
  
<script>

export default {
  props: {
    formTemplates: {
      type: Array,
      default: []
    }
  },
  data() {
    return {
      currentDate: new Date().toLocaleDateString()
    };
  },
  methods: {
    saveForm(id) {
      const _that = this;
      // jQuery.ajax({
      //   method: 'POST',
      //   url: window.ADRMAdmin.ajax_url,
      //   dataType: "json",
      //   data: {
      //     action: "ad_review_manager_ajax",
      //     route: "create_review_form",
      //     nonce: window.ADRMAdmin.ADrm_nonce,
      //     post_title: this.formTemplates[id].title,
      //     template: this.formTemplates[id]
      //   },
      //   success(res) {
      //     _that.$router.push({ name: 'edit-form', params: { id: res?.data?.form_id } });
      //   },
      //   error(err) {
      //     console.log(err);
      //   }
      // });
      this.$post('',
          {
            action: 'ad_review_manager_ajax',
            route: 'create_review_form',
            nonce: window.ADRMAdmin.adrm_nonce,
            post_title: this.formTemplates[id].title,
            template: this.formTemplates[id]
          }).then(function (res) {
            _that.$router.push({ name: 'edit-form', params: { id: res?.data?.form_id } });
          }).catch(function (error) {
              console.log(error);
          });
    },
    getTemplateImage(image) {
      return window.ADRMAdmin.assets_url + image;
    }
  }
};
</script>
  
<style>
.time {
  font-size: 12px;
  color: #999;
}

.bottom {
  margin-top: 13px;
  line-height: 12px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.button {
  padding: 0;
  min-height: auto;
}

.image {
  width: 100%;
  display: block;
}
</style>
  