<template>
    <div class="WPRM-form-editor WPRM-box-wrapper">
        <div class="WPRM-form-editor__header">
            <div class="WPRM-form-editor__header__title">
                <Back style="width: 1em; height: 1em; margin-right: 8px" />
                <h2>Form Editor</h2>
                <EditPen style="width: 1em; height: 1em; margin-right: 8px" />
            </div>
            <el-button type="success">Save Settings</el-button>
        </div>
        <div class="WPRM-form-body">
            <div class="WPRM-form-body__left">
                <draggable class="dragArea list-group w-full WPRM-dynamicForm" :list="list2" group="people" @change="log"
                    :move="checkMove">
                    <!-- <div class="WPRM-dynamicForm" label-width="120px"> -->
                    <el-row v-for="field in list2" :key="field.name">
                        <AppForm :field="field" />
                    </el-row>
                    <!-- </div> -->
                </draggable>
            </div>
            <div class="WPRM-form-body__right">
                <h2>Form components</h2>
                <draggable class="dragArea list-group w-full" :list="list1"
                    :group="{ name: 'people', pull: 'clone', put: false }" :sort="true" @change="log" :move="checkMove">
                    <div class="list-group-item bg-gray-300 m-1 p-3 rounded-md text-center" v-for="element in list1"
                        :key="element.name">
                        {{ element.name }}
                    </div>
                </draggable>
            </div>
        </div>
    </div>
</template>
<script>
import AppForm from '../Common/AppForm.vue';
import { VueDraggableNext } from 'vue-draggable-next';
import { formTemplate } from '../HomePage/home_helper.js';

export default {
    components: {
        AppForm,
        draggable: VueDraggableNext
    },
    data() {
        return {
            formTemplate: formTemplate,
            enabled: true,
            list1: [
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
            list2: formTemplate[0].formFields,
            dragging: false,
        };
    },
    methods: {
        add() {
            console.log('add')
        },
        replace() {
            console.log('replace')
        },
        checkMove(event) {
            console.log('checkMove', event.draggedContext)
            console.log('Future index: ' + event.draggedContext.futureIndex)
        },
        log(event) {
            const { moved, added } = event

            if (moved) console.log('moved', moved)
            if (added) console.log('added', added, added.element)
        },
    },
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

