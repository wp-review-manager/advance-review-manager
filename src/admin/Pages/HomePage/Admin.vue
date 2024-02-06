<template>
  <div class="wpf-dashboard">
    <!-- Start Top Search bar Page -->
    <div class="p-2 flex flex-row justify-between items-center bg-white border border-gray-200 rounded-lg mb-3 ">
      <div class="object-cover w-2/4 gap-x-8 rounded-t-lg h-96 md:h-auto md:rounded-none md:rounded-s-lg">
        <div class="relative">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
          </div>
          <input id="default-search" type="search"
            class="block WPRM-search-input w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-yellow-700 focus:border-yellow-700  dark:text-white"
            placeholder="Search Mockups, Logos..." required>
          <button type="submit" class="text-white absolute end-1.5 bottom-1.5 h-8 el-button--success rounded-lg px-4 py-2"
            style="line-height: 1.04rem;">
            Search
          </button>
        </div>
      </div>
      <div class="w-2/4 float-right leading-normal">
        <el-button class="float-right" type="success" @click="dialogVisibleProp = true">
          Create Your Form
        </el-button>
      </div>
    </div>
    <!-- End Start Page -->
    <!-- Start Create Feedback Form Modal-->
    <AppModal width="70%" :dialog-visible-prop="dialogVisibleProp" :confirm-btn-label="'Create a blank form'"
      @update:handle-dialog-close="handleDialogClose">
      <div class="WPRM-choose-template-form">
        <HomeChooseTemplate :formTemplates="formTemplate" />
      </div>
    </AppModal>
    <!-- End Create Feedback Form Modal-->

    <!-- Start Table -->
    <AppTable :columns="columns" :items="data" @edit-item="editHandler" @delete-item="deleteHandler" />
    <!-- End Table -->
  </div>
</template>
<script>
import { tableColumns, tableData, formTemplate } from './home_helper.js';
import AppTable from '../Common/AppTable.vue';
import AppModal from '../Common/AppModal.vue';
import HomeChooseTemplate from './HomeChooseTemplate.vue';
import AppForm from '../Common/AppForm.vue';
export default {
  name: "AdminLayout",
  components: {
    AppTable,
    AppModal,
    AppForm,
    HomeChooseTemplate
  },
  data() {
    return {
      dialogVisibleProp: false,
      columns: tableColumns,
      data: tableData,
      formTemplate: formTemplate
    };
  },
  methods: {
    editHandler(item) {
      console.log(item, 'edit');
    },
    handleDialogClose(successOrCancel) {
      // check if the user clicked on the confirm button or not
      if (successOrCancel) {
        // user clicked on the confirm button
        console.log({ formData: this.formData });
        console.log("User clicked on the confirm button");
      } else {
        // user clicked on the cancel button
        console.log("User clicked on the cancel button");
      }
      this.dialogVisibleProp = false;
    },
    deleteHandler(item) {
      console.log(item);
    }
  }
};
</script>
