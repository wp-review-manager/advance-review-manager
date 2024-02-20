<template>
  <div
    v-loading="loading"
    class="WPRM-form-editor WPRM-box-wrapper"
  >
    <div class="WPRM-form-editor__header">
      <div class="WPRM-form-editor__header__title">
        <span
          style="width: 1em; height: 1em; margin-right: 8px"
          class="dashicons dashicons-arrow-left-alt"
        />
        <el-input
          v-if="title_editable"
          v-model="title"
          style="min-width: 764px;"
          @blur="title_editable = false"
        />
        <h2
          v-else
          style="cursor: pointer;"
          @click="title_editable = true"
        >
          {{ title }} <span class="dashicons dashicons-edit" />
        </h2>
      </div>
      <div class="WPRM-form-editor__header__action">
        <el-button @click="redirectToPreview()" type="default">
          <span style="margin-right: 8px;" class="dashicons dashicons-visibility" />
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
    <!-- <div class="WPRM-form-editor__action">
    </div> -->
    <div class="WPRM-form-body">
      <div class="WPRM-form-body__left">
        <draggable
          class="dragArea list-group w-full WPRM-dynamicForm"
          :list="templateFormComponents"
          group="people"
          :move="checkMove"
          @change="log"
        >
          <!-- <div class="WPRM-dynamicForm" label-width="120px"> -->
          <el-row
            v-for="field in templateFormComponents"
            :key="field.name"
          >
            <AppForm :field="field" />
          </el-row>
          <!-- </div> -->
        </draggable>
      </div>
      <div class="WPRM-form-body__right">
        <h2>Form components</h2>
        <draggable
          class="dragArea list-group w-full"
          :list="allFormComponents"
          :group="{ name: 'people', pull: 'clone', put: false }"
          :sort="true"
          :move="checkMove"
          @change="log"
        >
          <div
            v-for="element in allFormComponents"
            :key="element.name"
            class="list-group-item bg-gray-300 m-1 p-3 rounded-md text-center"
          >
            {{ element.name }}
          </div>
        </draggable>
      </div>
    </div>
  </div>
</template>
<script>
import AppForm from '../Common/AppForm.vue';
import { ElNotification } from 'element-plus'
import debounce from 'lodash/debounce';
import { VueDraggableNext } from 'vue-draggable-next';
import { formTemplate, formFields } from '../HomePage/home_helper.js';

export default {
    components: {
        AppForm,
        draggable: VueDraggableNext
    },
    data() {
        return {
            formTemplate: formTemplate,
            enabled: true,
            allFormComponents: formFields,
            templateFormComponents: [],
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
        checkMove(event) {
            // let hasDuplicate = this.countOccurrences(this.templateFormComponents, this.allFormComponents[event.draggedContext.index]);
            // if (hasDuplicate) {
            //     event.cancel = true;
            //     console.log("Cannot drop a duplicate item.");
            //     this.$notify.error({
            //         title: 'Error',
            //         message: 'Cannot drop a duplicate item.',
            //         position: 'bottom-right'
            //     });

            //     return false;
            // }
            // console.log('checkMove', event.draggedContext);
            // console.log('Future index: ' + event.draggedContext.futureIndex);
        },
        log(event) {
            const { moved, added } = event;
            console.log('log', event);
            if (moved) console.log('moved', moved);
            if (added) {
                this.templateFormComponents[added.newIndex] = JSON.parse(JSON.stringify(added.element));
            }
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
            // jQuery.$get({
            //     method: 'GET',
            //     url: window.WPRMAdmin.ajax_url,
            //     dataType: "json",
            //     data: {
            //         action: "wp_review_manager_ajax",
            //         route: "get_review_form",
            //         nonce: window.WPRMAdmin.wprm_nonce,
            //         form_id: this.$route.params.id,
            //     },
                
            //     success(res) {
            //         _that.templateFormComponents = res?.data?.form_fields;
            //         _that.title = res?.data?.post_title;
            //         _that.loading = false;
            //         _that.preview_url = res?.data?.preview_url;
            //     },
            //     error(err) {
            //         _that.loading = false;
            //         console.log(err);
            //     }
            // });
            this.$get('',
                {
                    action: 'wp_review_manager_ajax',
                    route: 'get_review_form',
                    nonce: window.WPRMAdmin.wprm_nonce,
                    form_id: this.$route.params.id,
                }).then(function (response) {
                    _that.templateFormComponents = response.data.form_fields;
                    _that.title = response.data.post_title;
                    _that.loading = false;
                    _that.preview_url = response.data.preview_url;
                }).catch(function (error) {
                    _that.loading = false;
                    console.log(error);
                });
        },
        saveForm() {
            const _that = this;
            jQuery.ajax({
                method: 'POST',
                url: window.WPRMAdmin.ajax_url,
                dataType: "json",
                data: {
                    action: "wp_review_manager_ajax",
                    route: "save_review_form",
                    nonce: window.WPRMAdmin.wprm_nonce,
                    post_title: this.title,
                    formFields: this.templateFormComponents,
                    form_id: this.$route.params.id,
                },
                success(res) {
                    console.log(res);
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
.WPRM-form-editor {
    padding: 20px;

    .WPRM-box-wrapper {
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        background-color: #fff;
    }
}
</style>

