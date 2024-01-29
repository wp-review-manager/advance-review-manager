<template>
  <div class="wpf-dashboard">
    <Table @edit-item="editHandler" @delete-item="deleteHandler" :columns="columns" :items="data"></Table>
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
            edit: false,
            delete: true
          }
        },
        {
          name: "Magic Mouse 2",
          category: "Black",
          price: "$99",
          brand: "Apple",
          actions: {
            edit: false,
            delete: true
          }
        }
      ]
    }
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
