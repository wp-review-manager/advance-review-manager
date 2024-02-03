<template>
    <div class="WPRM-search-container">
        <div class="filter-btn">
            <el-radio-group v-model="radio1" size="large">
                <el-radio-button label="New York"></el-radio-button>
                <el-radio-button label="Washington"></el-radio-button>
                <el-radio-button label="Los Angeles"></el-radio-button>
                <el-radio-button label="Chicago"></el-radio-button>
            </el-radio-group>
        </div>
        <div class="search-btn">
            <el-input placeholder="Type something" prefix-icon="el-icon-search" v-model="input2">
            </el-input>
        </div>
    </div>

    <div class="WPRM_card_wrapper">
        <ChooseTemplateCard :formTemplate="formTemplate" />
    </div>
</template>

<script>
import ChooseTemplateCard from './ChooseTemplateCard.vue';
export default {
    components: {
        ChooseTemplateCard
    },
    data() {
        return {
            radio1: 'New York'
        };
    },
    props: {
        formTemplate: {
            type: Array,
            default: []
        }
    }
};
</script>