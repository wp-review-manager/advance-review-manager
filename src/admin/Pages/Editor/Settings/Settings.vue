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
                <router-view @updateSettings="updateSettings" :settings="settings"></router-view>
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
                pagination: {
                    enable: true,
                    per_page: 10
                }
            }
        }
    },
    methods: {
        updateSettings(settings) {
            const _that = this;
            jQuery.ajax({
                method: 'POST',
                url: window.ADRMAdmin.ajax_url,
                dataType: "json",
                data: {
                    action: "ad_review_manager_ajax",
                    route: "save_template_settings",
                    nonce: window.ADRMAdmin.adrm_nonce,
                    settings: settings,
                    form_id: this.$route.params.id,
                },
                success(res) {
                    ElNotification({
                        title: 'Success',
                        message: res.data.message,
                        type: 'success',
                        position: 'bottom-right'
                    });
                },
                error(err) {
                    console.log(err);
                }
            });
        },
        getSettings() {
            const _that = this;
            jQuery.ajax({
                method: 'GET',
                url: window.ADRMAdmin.ajax_url,
                dataType: "json",
                data: {
                    action: "ad_review_manager_ajax",
                    route: "get_template_settings",
                    nonce: window.ADRMAdmin.adrm_nonce,
                    form_id: this.$route.params.id,
                },
                success(res) {
                    console.log(res.data.settings)
                    if (res.data?.settings) {
                        _that.settings = res.data.settings;
                    }
                },
                error(err) {
                    console.log(err);
                }
            });
        }
    },
    mounted() {
        this.getSettings();
    }
}
</script>