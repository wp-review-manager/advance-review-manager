<template>
  <el-form
    ref="form"
    class="WPRM-dynamicForm"
    :model="formData"
    label-width="120px"
  >
    <el-row
      v-for="field in formFields"
      :key="field.name"
    >
      <el-col :span="12">
        <el-form-item label-position="top">
          <label for="inputField">{{ field.label }}</label>
          <template v-if="field.type === 'text' || field.type === 'email' || field.type === 'phone'">
            <el-input
              v-model="formData[field.name]"
              :type="field.type"
              :placeholder="field.placeholder"
            />
          </template>
          <template v-else-if="field.type === 'textarea'">
            <el-input
              v-model="formData[field.name]"
              type="textarea"
              :placeholder="field.placeholder"
            />
          </template>
          <template v-else-if="field.type === 'rating'">
            <el-rate v-model="formData[field.name]" />
          </template>
          <template v-else-if="field.type === 'file'">
            <el-upload
              action="/upload"
              :on-success="handleUploadSuccess"
              :on-error="handleUploadError"
              :file-list="formData[field.name]"
              :limit="1"
              :show-file-list="false"
            >
              <el-button
                slot="trigger"
                size="small"
                type="primary"
              >
                Upload
              </el-button>
            </el-upload>
          </template>
          <template v-else-if="field.type === 'radio'">
            <el-radio-group v-model="formData[field.name]">
              <el-radio
                v-for="option in field.options"
                :key="option.value"
                :label="option.value"
              >
                {{
                  option.label }}
              </el-radio>
            </el-radio-group>
          </template>
          <template v-else-if="field.type === 'checkbox'">
            <el-checkbox-group v-model="formData[field.name]">
              <el-checkbox
                v-for="option in field.options"
                :key="option.value"
                :label="option.value"
              >
                {{
                  option.label }}
              </el-checkbox>
            </el-checkbox-group>
          </template>
          <template v-else-if="field.type === 'select'">
            <el-select v-model="formData[field.name]">
              <el-option
                v-for="option in field.options"
                :key="option.value"
                :label="option.label"
                :value="option.value"
              />
            </el-select>
          </template>
        </el-form-item>
      </el-col>
    </el-row>
  </el-form>
</template>

<script>
export default {
  props: {
    formData: {
      type: Object,
      default: () => { },
    },
    formFields: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      // JSON data for form fields
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
