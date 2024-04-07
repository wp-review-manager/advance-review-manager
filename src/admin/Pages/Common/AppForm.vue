<template>
  <el-col
    :span="12"
    style="margin: 10px 0px"
  >
    <el-form-item label-position="top">
      <input
        v-if="labelEditAble"
        v-model="field.label"
        class="label-editor-input"
        type="text"
        placeholder=""
        @blur="labelEditAble = false"
        @keyup.enter="labelEditAble = false"
      >
      <label
        v-else
        class="form-label mb-1"
        for="inputField"
        @click="labelEditAble = true"
      > {{ field.template_required == 'true' ? '*' : '' }} {{ field.label }}
        <p class="form-editor-label" style="color: rgb(64, 126, 234);">Click to edit <span class="dashicons dashicons-edit"></span></p>
      </label>

      <template
        v-if="field.type === 'text' || field.type === 'email' || field.type === 'phone' || field.type === 'date' || field.type === 'url' || field.type === 'number' || field.type === 'hidden' || field.type === 'color'"
      >
        <el-input
          v-model="field.placeholder"
          :type="field.type"
          :placeholder="field.placeholder"
        />
      </template>

      <template v-else-if="field.type === 'textarea'">
        <el-input
          v-model="field.placeholder"
          type="textarea"
          :placeholder="field.placeholder"
        />
      </template>

      <!-- <template v-else-if="field.type === 'rating'">
        <el-rate
          v-model="field.value"
          :allow-half="true"
          size="large"
        />
      </template> -->

      <template v-else-if="field.type === 'file'">
        <AppFileUpload
          class="mt-4"
          :product="field.value"
        />
      </template>

      <template v-else-if="field.type === 'radio'">
        <!-- <div class="ml-2 flex items-center text-sm"> -->
        <el-radio-group v-model="field.value">
          <el-radio
            v-for="option in field.options"
            :key="option.value"
            :label="option.value"
          >
            {{ option.label }}
          </el-radio>
        </el-radio-group>
        <!-- </div> -->
      </template>
      <template v-else-if="field.type === 'checkbox'">
        <el-checkbox-group v-model="field.value">
          <el-checkbox
            v-for="option in field.options"
            :key="option.value"
            :label="option.value"
          >
            {{ option.label }}
          </el-checkbox>
        </el-checkbox-group>
      </template>
      <template v-else-if="field.type === 'select' || field.type === 'rating'">
        <el-select v-model="field.value">
          <el-option
            v-for="option in field.options"
            :key="option.value"
            :label="option.label"
            :value="option.value"
          />
        </el-select>
      </template>
      <template v-else-if="field.type === 'submit'">
        <el-button type="primary">
          {{ field.label }}
        </el-button>
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
    handleUploadError(error) {
      // Handle file upload error
      console.error(error);
    },
  },
};
</script>
