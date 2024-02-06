<template>
    <div>
        <component v-if="dynamicComponent" :is="dynamicComponent" />
    </div>
</template>

<script>
import { shallowRef } from 'vue';
import { defineAsyncComponent } from 'vue';
// eslint-disable-next-line no-use-before-define
import Duplicate from './wprm-Duplicate.vue';
import Star from './wprm-Star.vue';

export default {
    props: {
        icon: String
    },
    data() {
        const dynamicComponent = shallowRef(null);
        return {
            dynamicComponent
        };
    },
    watch: {
        icon: {
            immediate: true,
            handler(newComponent) {
                // this.dynamicComponent = defineAsyncComponent(() =>
                //     import(`./wprm-${newComponent}.vue`)
                // );
            }
        }
    }
};
</script>