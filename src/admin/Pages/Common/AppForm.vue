<template>
  <el-col :span="12">
    <el-form-item label-position="top">
      <input v-if="labelEditAble" v-model="field.label" class="label-editor-input" type="text" placeholder=""
        @blur="labelEditAble = false" @keyup.enter="labelEditAble = false">
      <label v-else class="form-label" for="inputField" @click="labelEditAble = true">{{ field.label }}
        <EditPen style="width: 1em; height: 1em; margin-right: 8px" />
      </label>
      <template
        v-if="field.type === 'text' || field.type === 'email' || field.type === 'phone' || field.type === 'date' || field.type === 'url' || field.type === 'number' || field.type === 'hidden' || field.type === 'color'">
        <el-input v-model="field.placeholder" :type="field.type" :placeholder="field.placeholder" />
      </template>

      <template v-else-if="field.type === 'textarea'">
        <el-input v-model="field.placeholder" type="textarea" :placeholder="field.placeholder" />
      </template>

      <template v-else-if="field.type === 'rating'">
        <el-rate v-model="field.value" :allow-half="true" size="large" class="ml-4" />
      </template>

      <template v-else-if="field.type === 'file'">
        <AppFileUpload :product="field.value" />
      </template>

      <template v-else-if="field.type === 'radio'">
        <!-- <div class="ml-2 flex items-center text-sm"> -->
        <el-radio-group v-model="field.value" class="ml-4">
          <el-radio v-for="option in field.options" :key="option.value" :label="option.value">
            {{ option.label }}
          </el-radio>
        </el-radio-group>
        <!-- </div> -->
      </template>
      <template v-else-if="field.type === 'checkbox'">
        <el-checkbox-group v-model="field.value" class="ml-4 mt-3.5">
          <el-checkbox v-for="option in field.options" :key="option.value" :label="option.value">
            {{ option.label }}
          </el-checkbox>
        </el-checkbox-group>
      </template>
      <template v-else-if="field.type === 'select'">
        <el-select v-model="field.value">
          <el-option v-for="option in field.options" :key="option.value" :label="option.label" :value="option.value" />
        </el-select>
      </template>
      <template v-else-if="field.type === 'submit'">
        <el-button type="primary" class="ml-4">{{ field.label }}</el-button>
      </template>
    </el-form-item>
  </el-col>
</template>

<script>
import AppFileUpload from "./AppFileUpload.vue";
export default {
  components: {
    AppFileUpload
  },
  props: {
    field: {
      type: Object,
      default: () => { },
    },
  },
  data() {
    return {
      // JSON data for form fields
      labelEditAble: false,
    };
  },
  methods: {
    handleUploadSuccess(response, file, fileList) {
      // Handle file upload success
      this.formData[file.name] = fileList;
    },
    handleUploadError(error, file, fileList) {
      // Handle file upload error
      console.error(error);
    },
  },
};
</script>
