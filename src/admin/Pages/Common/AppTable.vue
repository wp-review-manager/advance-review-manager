<template>
  <div class="relative overflow-x-auto WPRM-table-wrapper">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th
            v-for="(column, c_index) in columns"
            :key="c_index"
            scope="col"
            class="px-6 py-3"
          >
            {{ column.label }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(item, d_index) in items"
          :key="d_index"
          class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
        >
          <td
            v-for="(column, c_index) in columns"
            :key="c_index"
            scope="row"
            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
          >
            <span v-if="column.field !== 'actions'">{{ item[column.field] }}</span>
            <!-- Actions column is a special case -->
            <div v-else>
              <button
                v-if="item[column.field].edit"
                type="button"
                class="text-white mx-1 bg-blue-700 hover:bg-blue-800 font-medium rounded-full text-sm p-1.5 text-center inline-flex items-center me-2"
                @click="editItem(item)"
              >
                <span class="dashicons dashicons-edit" />
              </button>
              <button
                v-if="item[column.field].delete"
                type="button"
                class="text-white mx-1 bg-red-700 hover:bg-red-800 font-medium rounded-full text-sm p-1.5 text-center inline-flex items-center me-2"
                @click="deleteItem(item)"
              >
                <span class="dashicons dashicons-trash" />
              </button>
              <button
                class="text-white mx-1 bg-gray-700 hover:bg-gray-800 font-medium rounded-full text-sm p-1.5 text-center inline-flex items-center me-2"
              >
                <Icons icon='Duplicate' />
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import Icons from '../../Icons/Index.vue';
export default {
  name: "AppTable",
  components: {
    Icons
  },
  props: {
    columns: {
      type: Array,
      required: true
    },
    items: {
      type: Array,
      required: true
    }
  },
  emits: ['edit-item', 'delete-item'],
  methods: {
    editItem(item) {
      this.$emit('edit-item', item);
    },
    deleteItem(item) {
      this.$emit('delete-item', item);
    }
  }
};
</script>