<template>
  <div class="wpf-dashboard">
    <!-- Start Top Search bar Page -->
    <div class="p-2 flex flex-row justify-between items-center bg-white border border-gray-200 rounded-lg mb-3 ">
      <div class="object-cover w-2/4 gap-x-8 rounded-t-lg h-96 md:h-auto md:rounded-none md:rounded-s-lg">
        <div class="relative">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg
              class="w-4 h-4 text-gray-500 dark:text-gray-400"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 20 20"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
              />
            </svg>
          </div>
          <input
            id="default-search"
            v-model="forms_search_string"
            type="search"
            class="block WPRM-search-input w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-yellow-700 focus:border-yellow-700  dark:text-white"
            placeholder="Search Mockups, Logos..."
            required
            @keyup="getFormsDebounce()"
          >
          <button
            type="submit"
            class="text-white absolute end-1.5 bottom-1.5 h-8 el-button--success rounded-lg px-4 py-2"
            style="line-height: 1.04rem;"
            @click="getForms()"
          >
            Search
          </button>
        </div>
      </div>
      <div class="w-2/4 float-right leading-normal">
        <el-button
          class="float-right"
          type="success"
          @click="dialogVisibleProp = true"
        >
          Create Your Form
        </el-button>
      </div>
    </div>
    <!-- End Start Page -->
    <!-- Start Create Feedback Form Modal-->
    <AppModal
      width="70%"
      :dialog-visible-prop="dialogVisibleProp"
      :confirm-btn-label="'Create a blank form'"
      @update:handle-dialog-close="handleDialogClose"
    >
      <div class="WPRM-choose-template-form">
        <HomeChooseTemplate :form-templates="formTemplate" />
      </div>
    </AppModal>
    <AppModal
      width="40%"
      :dialog-visible-prop="dialogVisibleDeleteProp"
      :confirm-btn-label="'Delete'"
      :title="'Confirmation Delete Form !'"
      @update:handle-dialog-close="handleDelDialogClose"
    >
      <div class="WPRM-delete-confirmation">
        <p>Are you sure you want to delete this form?</p>
      </div>
    </AppModal>
    <!-- End Create Feedback Form Modal-->

    <!-- Start Table -->
    <AppTable
      v-if="!loading"
      :columns="columns"
      :items="data"
      @edit-item="editHandler"
      @delete-item="deleteHandler"
    />
    <div v-else>
      <el-skeleton :rows="5" />
    </div>
    <!-- End Table -->
  </div>
</template>
<script>
import { tableColumns, tableData, formTemplate } from './home_helper.js';
import AppTable from '../Common/AppTable.vue';
import AppModal from '../Common/AppModal.vue';
import HomeChooseTemplate from './HomeChooseTemplate.vue';
export default {
  name: "AdminLayout",
  components: {
    AppTable,
    AppModal,
    HomeChooseTemplate
  },
  data() {
    return {
      dialogVisibleProp: false,
      columns: tableColumns,
      data: tableData,
      formTemplate: formTemplate,
      forms_search_string: '',
      loading: false,
      timeout: null,
      dialogVisibleDeleteProp: false,
      deleteProductId: null
    };
  },
  mounted() {
    this.getForms();
  },
  methods: {
    getFormsDebounce() {
      this.loading = true;
      clearTimeout(this.timeout);
      this.timeout = setTimeout(() => {
          this.getForms();
          this.loading = false;
      }, 1000);
    },
    getForms() {
          this.loading = true;
          const _that = this;
          jQuery.ajax({
              method: 'GET',
              url: window.WPRMAdmin.ajax_url,
              dataType: "json",
              data: {
                  action: "wp_review_manager_ajax",
                  route: "get_review_forms",
                  nonce: window.WPRMAdmin.wprm_nonce,
                  search_string: this.forms_search_string
              },
              success(res) {
                  _that.loading = false;
                  _that.data = res?.data?.forms;
              },
              error(err) {
                  _that.loading = false;
                _that.data = [];
              }
          });
      },
    handleDialogClose(successOrCancel) {
      this.dialogVisibleProp = false;
    },
    // table actions
    editHandler(item) {
      this.$router.push({ name: 'edit-form', params: { id: item.ID } });
    },
    handleDelDialogClose(successOrCancel) {
      if (successOrCancel) {
        this.loading = true;
        const _that = this;
        jQuery.ajax({
          method: 'POST',
          url: window.WPRMAdmin.ajax_url,
          dataType: "json",
          data: {
            action: "wp_review_manager_ajax",
            route: "delete_review_form",
            nonce: window.WPRMAdmin.wprm_nonce,
            form_id: this.deleteProductId
          },
          success(res) {
            _that.loading = false;
            _that.getForms();
          },
          error(err) {
            _that.loading = false;
          }
        });
      }
      this.dialogVisibleDeleteProp = false;
    },
    deleteHandler(item) {
      this.deleteProductId = item?.ID;
      this.dialogVisibleDeleteProp = true;
    }
  }
};
</script>
