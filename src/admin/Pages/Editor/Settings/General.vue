<template>
  <div>
    <div class="adrm-card">
      <div class="adrm-card-header">
        <h3>General Settings</h3>
      </div>
      <div class="adrm-card-body">
        <div class="adrm-card-body-item">
          <div :class="settings.pagination.enable ? 'header' : 'header disabled'">
            <div>
              <h4>Pagination Settings</h4>
              <p>If you want to paginate data you enabled and modify settings</p>
            </div>
            <div>
              <el-switch
                v-model="settings.pagination.enable"
                active-value="true"
              />
            </div>
          </div>
          <div class="adrm-card-content">
            <p style="padding: 10px 0;">
              Select per page pagination data
            </p>
            <el-select
              v-model="settings.pagination.per_page"
              placeholder=""
            >
              <el-option
                :label="10"
                :value="10"
              />
              <el-option
                :label="20"
                :value="20"
              />
              <el-option
                :label="30"
                :value="30"
              />
              <el-option
                :label="40"
                :value="40"
              />
              <el-option
                :label="50"
                :value="50"
              />
            </el-select>
          </div>
        </div>
        <!-- <div class="adrm-form-group">
                    <label>
                        <input type="checkbox" v-model="settings.enable">
                        Enable
                    </label>
                </div> -->
      </div>
      <div class="adrm-card-footer">
        <el-button
          type="primary"
          @click="updateSettings()"
        >
          Update Settings
        </el-button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props: {
        settings: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
          
        };
    },
    methods: {
        updateSettings() {
            this.$emit('updateSettings', this.settings);
        }
    }
};
</script>