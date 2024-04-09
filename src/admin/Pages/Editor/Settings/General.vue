<template>
    <div>
        <div class="adrm-card">
            <div class="adrm-card-header">
                <h3>General Settings</h3>
            </div>
            <div class="adrm-card-body">
                <div class="adrm-card-body-item">
                    <div class="header">
                        <h4>Pagination Settings</h4>
                        <p>If you want to paginate data you enabled and modify settings</p>
                    </div>
                </div>
                <!-- <div class="adrm-form-group">
                    <label>
                        <input type="checkbox" v-model="settings.enable">
                        Enable
                    </label>
                </div> -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            settings: {
                enable: true
            }
        }
    }
}
</script>