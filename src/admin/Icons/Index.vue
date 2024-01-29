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
    data() {
        return {
            dynamicComponent: null
        };
    },
    props: {
        icon: String
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