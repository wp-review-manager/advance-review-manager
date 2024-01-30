<template>
  <div class="wpf-dashboard">
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
            type="search"
            class="block WPRM-search-input w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-yellow-700 focus:border-yellow-700  dark:text-white"
            placeholder="Search Mockups, Logos..."
            required
          >
          <button
            type="submit"
            class="text-white absolute end-1.5 bottom-1.5 h-8  rounded-lg px-4 py-2 bg-yellow-700"
            style="line-height: 1.04rem;"
          >
            Search
          </button>
        </div>
      </div>
      <div class="w-2/4 float-right leading-normal">
        <button
          type="button"
          class="float-right focus:outline-none text-white bg-yellow-700 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-1  dark:focus:ring-yellow-900"
        >
          Create
          Your Form
        </button>
      </div>
    </div>
    <Table
      :columns="columns"
      :items="data"
      @edit-item="editHandler"
      @delete-item="deleteHandler"
    />
  </div>
</template>
<script>
import Table from './Common/Table.vue';
export default {
  name: "AdminLayout",
  components: {
    Table
  },
  data() {
    return {
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
          actions: {
            edit: true,
            delete: true
          }
        }
      ]
    };
  },
  methods: {
    editHandler(item) {
      console.log(item);
    },
    deleteHandler(item) {
      console.log(item);
    }
  }
};
</script>
