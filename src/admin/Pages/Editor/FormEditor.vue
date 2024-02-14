<template>
  <div
    v-loading="loading"
    class="WPRM-form-editor WPRM-box-wrapper"
  >
    <div class="WPRM-form-editor__header">
      <div class="WPRM-form-editor__header__title">
        <Back style="width: 1em; height: 1em; margin-right: 8px" />
        <h2>Form Editor</h2>
        <EditPen style="width: 1em; height: 1em; margin-right: 8px" />
      </div>
      <el-button
        type="success"
        @click="saveForm()"
      >
        Save Settings
      </el-button>
    </div>
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
            title: 'Form Editor'
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
            jQuery.ajax({
                method: 'GET',
                url: window.WPRMAdmin.ajax_url,
                dataType: "json",
                data: {
                    action: "wp_review_manager_ajax",
                    route: "get_review_form",
                    nonce: window.WPRMAdmin.wprm_nonce,
                    form_id: this.$route.params.id,
                },
                success(res) {
                    _that.templateFormComponents = res?.data?.form?.form_fields;
                    _that.title = res?.data?.form?.post_title;
                    _that.loading = false;
                },
                error(err) {
                    _that.loading = false;
                    console.log(err);
                }
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
                    this.$notify({
                        title: 'Success',
                        message: 'Form saved successfully',
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
    padding: 60px;

    .WPRM-box-wrapper {
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        background-color: #fff;
    }
}
</style>

