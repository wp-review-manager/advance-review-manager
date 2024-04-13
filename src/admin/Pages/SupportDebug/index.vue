<template>
    <div class="adrm-support-debug-wrapper"> 
        <el-tabs type="border-card" class="adrm-tabs">
        <el-tab-pane>
            <template #label>
                <span class="custom-tabs-label">
                    <Icon icon="List" class="icon"/>
                    <span>Support & Docs</span>
                </span>
            </template>
            <SupportDocs />
        </el-tab-pane>
        <el-tab-pane label="Debug"> 
            <Debug />
        </el-tab-pane>
    </el-tabs>
    </div>
</template>

<script> 
import SupportDocs from './SupportDocs.vue';
import Debug from './Debug.vue';
import Icon from '../../Icons/Index.vue';
export default {
    name: 'index',
    components: {
        Icon,
        SupportDocs,
        Debug
    },
}
</script>