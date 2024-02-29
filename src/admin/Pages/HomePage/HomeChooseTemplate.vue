<template>
  <div class="adrm-template-modal">
    <div class="adrm-search-container">
      <div class="filter-btn">
        <el-radio-group
          v-model="radio1"
          size="large"
        >
          <el-radio-button label="New York" />
          <el-radio-button label="Washington" />
          <el-radio-button label="Los Angeles" />
          <el-radio-button label="Chicago" />
        </el-radio-group>
      </div>
      <div class="search-btn">
        <el-input
          v-model="input2"
          placeholder="Type something"
          prefix-icon="el-icon-search"
        />
      </div>
    </div>

    <div class="adrm-card-wrapper">
      <ChooseTemplateCard :form-templates="formTemplates" />
    </div>
  </div>
</template>

<script>
import ChooseTemplateCard from './ChooseTemplateCard.vue';
export default {
    components: {
        ChooseTemplateCard
    },
    props: {
        formTemplates: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            radio1: 'New York',
            input2: ''
        };
    }
};
</script>