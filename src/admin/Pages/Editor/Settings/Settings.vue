<template>
    <div class="adrm-editor-settings-wrapper">
        <div class="adrm-editor-settings-body">
            <div class="adrm-editor-settings-sidebar">
                <ul>
                    <li>
                        <router-link :to="{ name: 'edit-form-settings-general' }">General</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'edit-form-settings-design' }">Design</router-link>
                    </li>
                </ul>
            </div>
            <div class="adrm-editor-settings-content">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form_id: this.$route.params.id,
            settings: {
                enable: true
            }
        }
    }
}
</script>