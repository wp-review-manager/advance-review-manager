<template>
  <div
    v-loading="loading"
    class="adrm-form-editor adrm-box-editor"
  >
    <div class="adrm-form-editor__header">
      <div class="adrm-form-editor__header__title">
        <router-link style="margin-bottom: -19px;" to="/">
        <span
          style="width: 1em; height: 1em; margin-right: 8px"
          class="dashicons dashicons-arrow-left-alt"
        />
        </router-link>
        <el-input
          v-if="title_editable"
          v-model="title"
          style="min-width: 764px;"
          @blur="title_editable = false"
        />
        <h2
          v-else
          style="cursor: pointer"
          @click="title_editable = true"
        >
          {{ title }} <span class="dashicons dashicons-edit" />
        </h2>
      </div>
      <div class="adrm-form-editor__header__action">
        <el-button
          type="default"
          @click="redirectToPreview()"
        >
          <span
            style="margin-right: 8px"
            class="dashicons dashicons-visibility"
          />
          Preview
        </el-button>
        <el-button
          type="success"
          @click="saveForm()"
        >
          Save Settings
        </el-button>
      </div>
    </div>

    <div class="adrm-form-body">
      <div class="adrm-form-body__left">
        <draggable
          class="dragArea list-group w-full adrm-dynamicForm"
          :list="templateFormComponents"
          group="people"
          :move="checkMove"
          @change="log"
        >
          <!-- <div class="adrm-dynamicForm" label-width="120px"> -->
          <el-row
            v-for="(field, fieldIndex) in templateFormComponents"
            :key="field.name"
            class="adrm-dynamicForm__item"
          >
            <AppForm
              :field="field"
              :class="field.enabled == 'false' ? 'disabled' : ''"
            />
            <div class="form-item-delete-btn">
              <div
                v-if="field.type == 'rating' && !single_review_template"
                class="adrm-plus-btn"
              >
                <Icon
                  icon="Plus"
                  @click="addMoreRatingField(fieldIndex)"
                />
              </div>
    
              <div
                v-if="field.type == 'rating' && !single_review_template"
                class="adrm-plus-btn"
              >
                <Icon
                  icon="Delete"
                  @click="deleteOption(fieldIndex)"
                />
              </div>

              <el-switch
                v-model="field.enabled"
                inactive-value="false"
                active-value="true"
                @change="checkIsValidForDisabled(field)"
              />
            </div>
          </el-row>
          <!-- </div> -->
        </draggable>
      </div>
      <!-- <div class="adrm-form-body__right">
        <h2>Form components</h2>
        <draggable class="dragArea list-group w-full" :list="allFormComponents"
          :group="{ name: 'people', pull: 'clone', put: false }" :sort="true" :move="checkMove" @change="log">
          <div v-for="element in allFormComponents" :key="element.name"
            class="list-group-item bg-gray-300 m-1 p-3 rounded-md text-center drag-disabled">
            {{ element.name }}
          </div>
        </draggable>
      </div> -->
    </div>
    <!-- <div v-else class="adrm-form-body">
      <ReviewTemplate :reviews="reviews" />
    </div> -->
  </div>
</template>

<script>
import AppForm from '../Common/AppForm.vue';
import Icon from '../../Icons/Index.vue';
import { ElNotification } from 'element-plus';
import ReviewTemplate from './ReviewTemplate.vue';
import debounce from 'lodash/debounce';
import { VueDraggableNext } from 'vue-draggable-next';
import { formTemplate, formFields } from '../HomePage/home_helper.js';

export default {
  components: {
    AppForm,
    draggable: VueDraggableNext,
    ReviewTemplate,
    Icon
  },
  data() {
    return {
      editor_mode: 'Review Template',
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
      single_review_template: false
    };
  },
  mounted() {
    this.getForm();
    // this.templateFormComponents = formTemplate['hotel_review_form'].formFields;
    // console.log(this.templateFormComponents);
  },
  methods: {
    getRatingFieldNumber() {
      return this.templateFormComponents.filter(field => field.type === 'rating').length;
    },
    addMoreRatingField(fieldIndex) {
      const ratingFieldNumber = this.getRatingFieldNumber();
      const newField = {
        name: 'rating_' + ratingFieldNumber,
        type: 'rating',
        label: 'Rating ' + ratingFieldNumber,
        value: 0,
        enabled: 'true',
        template_required: 'false',
        options: [
          { label: '1 Star', value: 1 },
          { label: '2 Stars', value: 2 },
          { label: '3 Stars', value: 3 },
          { label: '4 Stars', value: 4 },
          { label: '5 Stars', value: 5 },
        ],
      };
      this.templateFormComponents.splice(fieldIndex + 1, 0, newField);
    },
    checkIsValidForDisabled(field) {
      if (field.template_required == 'true') {
        field.enabled = 'true';
        ElNotification({
          title: 'Error',
          message: 'Cannot disable a required field.',
          type: 'error',
          position: 'bottom-right'
        });
      }
    },
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
  
    checkMove(event) {
      // const hasDuplicate = this.countOccurrences(event.to, event.draggedContext.element) > 1;
      // console.log('checkMove', hasDuplicate);
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
      this.$get('',
        {
          action: 'ad_review_manager_ajax',
          route: 'get_review_form',
          nonce: window.ADRMAdmin.adrm_nonce,
          form_id: this.$route.params.id,
        }).then( (response) => {
          this.templateFormComponents = response.data.form.form_fields;
          this.reviews = response.data.reviews;
          this.title = response.data.form.post_title;
          this.loading = false;
          this.preview_url = response.data.form.preview_url;
          this.shortcode = response.data.form.shortcode;
          this.isItSingleReviewTemp(response.data.form.post_name);
        }).catch((error) => {
          this.loading = false;
          console.log(error);
        });
    },
    isItSingleReviewTemp(post_name) {
      if (post_name == "book-review-form-template") 
      this.single_review_template = true;
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
      const formData = this.updateDuplicateNames(this.templateFormComponents);
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
    deleteOption(fieldIndex) {
            this.templateFormComponents.splice(fieldIndex, 1);
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
