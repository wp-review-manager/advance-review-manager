<template>
  <el-dialog modal-class="WPRM-app-modal-wrapper" v-model="dialogVisible" :title="title" :width="width"
    :before-close="handleClose">
    <slot></slot>
    <template #footer>
      <span class="dialog-footer">
        <el-button @click="handleClose">{{ cancelBtnLabel }}</el-button>
        <el-button type="primary" @click="handleSuccess">
          {{ confirmBtnLabel }}
        </el-button>
      </span>
    </template>
  </el-dialog>
</template>

<script>
export default {
  data() {
    return {
      dialogVisible: false
    }
  },
  props: {
    dialogVisibleProp: {
      type: Boolean,
      required: true
    },
    cancelBtnLabel: {
      type: String,
      default: 'Cancel'
    },
    confirmBtnLabel: {
      type: String,
      default: 'Confirm'
    },
    title: {
      type: String,
      default: 'Choose Your Feedback Template'
    },
    width: {
      type: String,
      default: '30%'
    }
  },
  watch: {
    dialogVisibleProp: {
      immediate: true,
      handler(val) {
        console.log(val);
        this.dialogVisible = val;
      }
    }
  },
  methods: {
    handleClose() {
      this.dialogVisible = false;
      this.$emit('update:handleDialogClose', false);
    },
    handleSuccess() {
      this.dialogVisible = false;
      this.$emit('update:handleDialogClose', true);
    }
  }
}
</script>
<style scoped>
.dialog-footer button:first-child {
  margin-right: 10px;
}
</style>
