<template>
  <div v-loading="loading" class="adrm-form-editor adrm-box-editor">
    <div class="adrm-form-editor__header">
      <div class="adrm-form-editor__header__title">
        <span style="width: 1em; height: 1em; margin-right: 8px" class="dashicons dashicons-arrow-left-alt" />
        <el-input v-if="title_editable" v-model="title" style="min-width: 764px;" @blur="title_editable = false" />
        <h2 v-else style="cursor: pointer" @click="title_editable = true">
          {{ title }} <span class="dashicons dashicons-edit" />
        </h2>
      </div>
      <div class="adrm-form-editor__header__action">
        <el-button @click="redirectToPreview()" type="default">
          <span style="margin-right: 8px" class="dashicons dashicons-visibility" />
          Preview
        </el-button>
        <el-button type="success" @click="saveForm()">
          Save Settings
        </el-button>
      </div>
    </div>
    <div class="adrm-form-editor__action">
      <div class="adrm-form-editor__action_left">
        <div class="adrm-radio-group-wrapper">
          <el-radio-group v-model="editor_mode">
            <el-radio-button label="Review Template">Review Template</el-radio-button>
            <el-radio-button label="Review Form">Review Form</el-radio-button>
          </el-radio-group>
        </div>
      </div>
      <div class="adrm-form-editor__action_right">
        <button class="adrm-shortcode" v-clipboard:success="clipboardSuccessHandler" v-clipboard="'swdugsuyg'">
          {{ shortcode }}
        </button>
      </div>
    </div>
    {{ editor_mode }}
    <div v-if="editor_mode == 'Review Form'" class="adrm-form-body">
      <div class="adrm-form-body__left">
        <draggable class="dragArea list-group w-full adrm-dynamicForm" :list="templateFormComponents" group="people"
          :move="checkMove" @change="log">
          <!-- <div class="adrm-dynamicForm" label-width="120px"> -->
          <el-row v-for="(field, fieldIndex) in templateFormComponents" :key="field.name"
            class="adrm-dynamicForm__item">
            <AppForm :field="field" />
            <el-button @click="deleteFormItem(fieldIndex)" class="form-item-delete-btn" type="" circle>
              <span class="dashicons dashicons-trash"></span>
            </el-button>
          </el-row>
          <!-- </div> -->
        </draggable>
      </div>
      <div class="adrm-form-body__right">
        <h2>Form components</h2>
        <draggable class="dragArea list-group w-full" :list="allFormComponents"
          :group="{ name: 'people', pull: 'clone', put: false }" :sort="true" :move="checkMove" @change="log">
          <div v-for="element in allFormComponents" :key="element.name"
            class="list-group-item bg-gray-300 m-1 p-3 rounded-md text-center drag-disabled">
            {{ element.name }}
          </div>
        </draggable>
      </div>
    </div>
    <div v-else class="adrm-form-body">
      <ReviewTemplate :reviews="reviews" />
    </div>
  </div>
</template>

<script>
import AppForm from '../Common/AppForm.vue';
import { ElNotification } from 'element-plus'
import ReviewTemplate from './ReviewTemplate.vue';
import debounce from 'lodash/debounce';
import { VueDraggableNext } from 'vue-draggable-next';
import { formTemplate, formFields } from '../HomePage/home_helper.js';

export default {
  components: {
    AppForm,
    draggable: VueDraggableNext,
    ReviewTemplate
  },
  data() {
    return {
      editor_mode: 'Review Template',
      shortcode: '[adrm_review_form id="1"]',
      formTemplate: formTemplate,
      enabled: true,
      allFormComponents: formFields,
      templateFormComponents: [],
      reviews: [],
      dragging: false,
      debouncedCheckMove: null,
      loading: false,
      title: 'Form Editor',
      title_editable: false,
      preview_url: '',
    };
  },
  mounted() {
    this.getForm();
    // this.templateFormComponents = formTemplate['hotel_review_form'].formFields;
    // console.log(this.templateFormComponents);
  },
  methods: {
    add() {
      console.log('add');
    },
    redirectToPreview() {
      window.open(this.preview_url, '_blank');
    },
    replace() {
      console.log('replace');
    },
    deleteFormItem(index) {
      if (this.templateFormComponents[index].template_required == 'true') {
        ElNotification({
          title: 'Error',
          message: 'Cannot delete a required field.',
          type: 'error',
          position: 'bottom-right'
        });
        return;
      } else {
        this.templateFormComponents.splice(index, 1);
      }
    },
    clipboardSuccessHandler() {
      ElNotification({
        title: 'Success',
        message: 'Copied to clipboard',
        type: 'success',
        position: 'bottom-right'
      });
    },
    checkMove(event) {
      const hasDuplicate = this.countOccurrences(event.to, event.draggedContext.element) > 1;
      console.log('checkMove', hasDuplicate);
    //   if (hasDuplicate) {
    //       event.cancel = true;
    //       console.log("Cannot drop a duplicate item.");
    //       this.$notify.error({
    //           title: 'Error',
    //           message: 'Cannot drop a duplicate item.',
    //           position: 'bottom-right'
    //       });

    //       return false;
    //   }
    //   console.log('checkMove', event.draggedContext);
    //   console.log('Future index: ' + event.draggedContext.futureIndex);
    // },
    // log(event) {
    //   const { moved, added } = event;
    //   console.log('log', event);
    //   if (moved) console.log('moved', moved);
    //   if (added) {
    //     this.templateFormComponents[added.newIndex] = JSON.parse(JSON.stringify(added.element));
    //   }
    },
    countOccurrences(array, itemToFind) {
      let count = 0;
      const itemString = JSON.stringify(itemToFind);

      array.forEach(item => {
        const currentItemString = JSON.stringify(item);
        if (currentItemString === itemString) {
          count++;
        }
      });

      return count;
    },
    getForm() {
      this.loading = true;
      const _that = this;
      this.$get('',
        {
          action: 'ad_review_manager_ajax',
          route: 'get_review_form',
          nonce: window.ADRMAdmin.adrm_nonce,
          form_id: this.$route.params.id,
        }).then(function (response) {
          _that.templateFormComponents = response.data.form.form_fields;
          _that.reviews = response.data.reviews;
          _that.title = response.data.form.post_title;
          _that.loading = false;
          _that.preview_url = response.data.form.preview_url;
          _that.shortcode = response.data.form.shortcode;
        }).catch(function (error) {
          _that.loading = false;
          console.log(error);
        });
    },
    updateDuplicateNames(data) {
      const nameCount = {};

      for (let i = 0; i < data.length; i++) {
        const name = data[i].name;

        if (nameCount[name] !== undefined) {
          nameCount[name]++;
          data[i].name = `${name}_${nameCount[name]}`;
        } else {
          nameCount[name] = 0;
        }
      }
      console.log(data);
      return data;
    },
    saveForm() {
      let formData = this.updateDuplicateNames(this.templateFormComponents);
      const _that = this;
      jQuery.ajax({
        method: 'POST',
        url: window.ADRMAdmin.ajax_url,
        dataType: "json",
        data: {
          action: "ad_review_manager_ajax",
          route: "save_review_form",
          nonce: window.ADRMAdmin.adrm_nonce,
          post_title: this.title,
          formFields: formData,
          form_id: this.$route.params.id,
        },
        success(res) {
          ElNotification({
            title: 'Success',
            message: res.data.message,
            type: 'success',
            position: 'bottom-right'
          });
          // _that.$router.push({ name: 'edit-form', params: { id: res?.data?.form_id } });
        },
        error(err) {
          console.log(err);
        }
      });
    },
  }
};
</script>

<style scoped lang="scss">
.adrm-form-editor {
  padding: 20px;

  .adrm-box-editor {
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    background-color: #fff;
  }
  .drag-disabled {
    cursor: not-allowed;
  }
}
</style>
