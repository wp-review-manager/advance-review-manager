<template>
  <div>
    <!-- <component
      :is="dynamicComponent"
      v-if="dynamicComponent"
    /> -->
        <Editor v-if="icon == 'Editor'" />
        <Settings v-else-if="icon == 'Settings'" />
        <LeftBack v-else-if="icon == 'LeftBack'" />
        <Plus v-else-if="icon == 'Plus'" />

        <Eye v-else-if="icon == 'Eye'" />
        <Edit v-else-if="icon == 'Edit'" />
        <Delete v-else-if="icon == 'Delete'" />

        <List v-else-if="icon == 'List'" />

  </div>
</template>

<script>
import Editor from './Editor.vue';
import  Settings  from './Settings.vue'
import LeftBack from './LeftBack.vue';
import Plus from './Plus.vue';
import Eye from './Eye.vue';
import Edit from './Edit.vue';
import Delete from './Delete.vue';
import List from './List.vue';

import { shallowRef } from 'vue';
import { defineAsyncComponent } from 'vue';
// eslint-disable-next-line no-use-before-define
import Duplicate from './adrm-Duplicate.vue';
import Star from './adrm-Star.vue';
// import { Edit } from '@element-plus/icons-vue/dist/types';

export default {
    components: {
        Editor,
        Settings,
        LeftBack,
        Plus,
        Eye,
        Edit,
        Delete,
        List
    },
    props: {
        icon: {
            type: String,
            required: true,
            default: 'Star'
        }
    },
    // data() {
    //     const dynamicComponent = shallowRef(null);
    //     return {
    //         dynamicComponent
    //     };
    // },
    // watch: {
    //     icon: {
    //         immediate: true,
    //         handler(newComponent) {
    //             this.dynamicComponent = defineAsyncComponent(() =>
    //                 import(`./adrm-${newComponent}.vue`)
    //             );
    //         }
    //     }
    // }
};
</script>