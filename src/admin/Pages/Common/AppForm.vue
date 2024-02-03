<template>
  <el-col :span="12">
    <el-form-item label-position="top">
      <input @blur="labelEditAble = false" class="label-editor-input" type="text" @keyup.enter="labelEditAble = false"
        v-if="labelEditAble" v-model="field.label" placeholder="" />
      <label class="form-label" @click="labelEditAble = true" v-else for="inputField">{{ field.label }}
        <EditPen style="width: 1em; height: 1em; margin-right: 8px" />
      </label>
      <template v-if="field.type === 'text' || field.type === 'email' || field.type === 'phone'">
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
