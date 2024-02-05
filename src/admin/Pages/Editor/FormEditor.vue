<template>
    <div class="WPRM-form-editor WPRM-box-wrapper">
        <div class="WPRM-form-editor__header">
            <div class="WPRM-form-editor__header__title">
                <Back style="width: 1em; height: 1em; margin-right: 8px" />
                <h2>Form Editor</h2>
                <EditPen style="width: 1em; height: 1em; margin-right: 8px" />
            </div>
            <el-button type="success">
                Save Settings
            </el-button>
        </div>
        <div class="WPRM-form-body">
            <div class="WPRM-form-body__left">
                <draggable class="dragArea list-group w-full WPRM-dynamicForm" :list="templateFormComponents" group="people"
                    :move="checkMove" @change="log">
                    <!-- <div class="WPRM-dynamicForm" label-width="120px"> -->
                    <el-row v-for="field in templateFormComponents" :key="field.name">
                        <AppForm :field="field" />
                    </el-row>
                    <!-- </div> -->
                </draggable>
            </div>
            <div class="WPRM-form-body__right">
                <h2>Form components</h2>
                <draggable class="dragArea list-group w-full" :list="allFormComponents"
                    :group="{ name: 'people', pull: 'clone', put: false }" :sort="true" :move="checkMove" @change="log">
                    <div v-for="element in allFormComponents" :key="element.name"
                        class="list-group-item bg-gray-300 m-1 p-3 rounded-md text-center">
                        {{ element.name }}
                    </div>
                </draggable>
            </div>
        </div>
    </div>
</template>
<script>
import AppForm from '../Common/AppForm.vue';
import debounce from 'lodash/debounce';
import { VueDraggableNext } from 'vue-draggable-next';
import { formTemplate, formFields } from '../HomePage/home_helper.js';

export default {
    components: {
        AppForm,
        draggable: VueDraggableNext
    },
    data() {
        return {
            formTemplate: formTemplate,
            enabled: true,
            allFormComponents: formFields,
            templateFormComponents: [],
            dragging: false,
            debouncedCheckMove: null
        };
    },
    methods: {
        add() {
            console.log('add');
        },
        replace() {
            console.log('replace');
        },
        checkMove(event) {
            // let hasDuplicate = this.countOccurrences(this.templateFormComponents, this.allFormComponents[event.draggedContext.index]);
            // if (hasDuplicate) {
            //     event.cancel = true;
            //     console.log("Cannot drop a duplicate item.");
            //     this.$notify.error({
            //         title: 'Error',
            //         message: 'Cannot drop a duplicate item.',
            //         position: 'bottom-right'
            //     });

            //     return false;
            // }
            // console.log('checkMove', event.draggedContext);
            // console.log('Future index: ' + event.draggedContext.futureIndex);
        },
        log(event) {
            const { moved, added } = event;
            console.log('log', event);
            if (moved) console.log('moved', moved);
            if (added) console.log('added', added, added.element);
        },
        countOccurrences(array, itemToFind) {
            let count = 0;
            const itemString = JSON.stringify(itemToFind);

            array.forEach(item => {
                const currentItemString = JSON.stringify(item);
                if (currentItemString === itemString) {
                    count++;
                }
            });

            return count;
        }
    },
    mounted() {
        this.templateFormComponents = formTemplate[this.$route.params.id].formFields;
    }
};
</script>

<style scoped lang="scss">
.WPRM-form-editor {
    padding: 60px;

    .WPRM-box-wrapper {
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        background-color: #fff;
    }
}
</style>

