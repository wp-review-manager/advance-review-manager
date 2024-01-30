<template>
  <div>
    <component :is="dynamicComponent" />
  </div>
</template>
  
<script>
import { defineAsyncComponent } from 'vue';
import Duplicate from './Duplicate.vue';
import Star from './Star.vue';
export default {
    props: {
        icon: String
    },
    data() {
        return {
            dynamicComponent: null
        };
    },
    watch: {
        icon: {
            immediate: true,
            handler(newComponent) {
                this.dynamicComponent = defineAsyncComponent(() =>
                    import(`./${newComponent}.vue`)
                );
            }
        }
    }
};
</script>