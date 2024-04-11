<template>
  <div class="relative overflow-x-auto adrm-table-wrapper">
    <table
      v-if="items?.length"
      class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
    >
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
          <span v-if="column.field == 'reviews'" style="text-decoration: underline;">
              <router-link :to="`/form/edit/${item.ID}/reviews`">
                {{ item[column.field] }}
              </router-link>
            </span>
            <!-- Normal columns -->
            <span v-else-if="column.field !== 'actions'">

              {{ item[column.field] }}
            </span>
            <!-- Actions column is a special case -->
            <div v-else style="display: flex; gap: 20px;">
              <button v-if="item[column.field]?.edit" type="button" @click="editItem(item)">
                <Icons icon="Edit" />
              </button>
              <button v-if="item[column.field]?.delete" @click="deleteItem(item)">
                <Icons icon="Delete" />
              </button>
              <button class="">
                <Icons @click="redirectPreviewUrl(item.preview_url)" icon="Eye" />
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <div
      v-else
      class="flex items-center justify-center h-96"
    >
      <el-empty :image-size="200" />
    </div>
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
    },
    redirectPreviewUrl(url) {
      window.open(url, '_blank');
    }
  }
};
</script>