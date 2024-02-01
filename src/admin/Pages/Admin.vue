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
    <AppModal width="70%" :dialog-visible-prop="dialogVisibleProp" @update:handle-dialog-close="handleDialogClose">
      <!-- {{ formData }} -->
      <div class="WPRM-choose-template-form">
        <AppForm :form-data="formData" :form-fields="formFields" />
      </div>
    </AppModal>
    <!-- End Create Feedback Form Modal-->

    <!-- Start Table -->
    <AppTable :columns="columns" :items="data" @edit-item="editHandler" @delete-item="deleteHandler" />
    <!-- End Table -->
  </div>
</template>
<script>
import AppTable from './Common/AppTable.vue';
import AppModal from './Common/AppModal.vue';
import AppForm from './Common/AppForm.vue';
export default {
  name: "AdminLayout",
  components: {
    AppTable,
    AppModal,
    AppForm
  },
  data() {
    return {
      dialogVisibleProp: false,
      columns: [
        {
          label: "Name",
          field: "name",
          sortable: true
        },
        {
          label: "Category",
          field: "category",
          sortable: true
        },
        {
          label: "Price",
          field: "price",
          sortable: true
        },
        {
          label: "Brand",
          field: "brand",
          sortable: true
        },
        {
          label: "Shortcode",
          field: "shortcode",
          sortable: true
        },
        {
          label: "Actions",
          field: "actions"
        }
      ],
      data: [
        {
          name: "Apple MacBook Pro 17",
          category: "Silver",
          price: "$2999",
          brand: "Apple",
          shortcode: "[wp-review-manager id=1]",
          actions: {
            edit: true,
            delete: true
          }
        },
        {
          name: "Microsoft Surface Pro",
          category: "White",
          price: "$1999",
          brand: "Microsoft",
          shortcode: "[wp-review-manager id=2]",
          actions: {
            edit: true,
            delete: true
          }
        },
        {
          name: "Magic Mouse 2",
          category: "Black",
          price: "$99",
          brand: "Apple",
          shortcode: "[wp-review-manager id=3]",
          actions: {
            edit: true,
            delete: true
          }
        }
      ],
      formData: {
        name: 'gjgjgjhgjh',
        email: '',
        phone: '',
        message: '',
        rating: 0,
        file: [
          {
            image_full: '',
            image_thumb: '',
            alt_text: '',
          }
        ],
        radio: '',
        checkbox: [],
        select: '',
      },
      formFields: [
        {
          label: 'Name',
          name: 'name',
          type: 'text',
          placeholder: 'Apple MacBook Pro 17',
        },
        {
          label: 'Email',
          name: 'email',
          type: 'email',
          placeholder: 'dasnites@gmail.com',
        },
        {
          label: 'Phone',
          name: 'phone',
          type: 'phone',
          placeholder: '01747102896',
        },
        {
          label: 'Message',
          name: 'message',
          type: 'textarea',
          placeholder: 'Your message',
        },
        {
          label: 'Rating',
          name: 'rating',
          type: 'rating',
        },
        {
          label: 'File',
          name: 'file',
          type: 'file',
          value: [
            {
              image_full: '',
              image_thumb: '',
              alt_text: '',
            }
          ],
        },
        {
          label: 'Radio',
          name: 'radio',
          type: 'radio',
          options: [
            {
              label: 'Option 1',
              value: 'option1',
            },
            {
              label: 'Option 2',
              value: 'option2',
            },
          ],
        },
        {
          label: 'Checkbox',
          name: 'checkbox',
          type: 'checkbox',
          options: [
            {
              label: 'Option 1',
              value: 'option1',
            },
            {
              label: 'Option 2',
              value: 'option2',
            },
          ],
        },

      ],
    };
  },
  methods: {
    editHandler(item) {
      console.log(item);
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
