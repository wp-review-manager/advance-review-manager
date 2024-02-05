<template>
  <div v-for="(template, index) in formTemplate" :key="index" class="WPRM_card">
    <el-card :body-style="{ padding: '0px' }">
      <img :src="getTemplateImage(template.thumbnail)" style="width: 100%; height: 200px" alt="image" class="image">
      <div style="padding: 14px">
        <span>{{ template.title }}</span>
        <div class="bottom">
          <el-button style="width: 100%;" type="primary" @click="saveForm(index)">
            Choose Template
          </el-button>
        </div>
      </div>
    </el-card>
  </div>
</template>
  
<script>
export default {
  props: {
    formTemplate: {
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
      console.log('Form saved');
      this.$router.push({ name: 'edit-form', params: { id: id } });
    },
    getTemplateImage(image) {
      return window.WPRMAdmin.assets_url + image;
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
  