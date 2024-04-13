<template>
  <div>
    <div
      v-for="(item, i) in renderContent"
      :key="i"
      class="adrm-debug-item-line"
    >
      <p>{{ item.label }}:</p>
      <p
        class="result"
        :class="item.status === 'warn' ? 'status-warn' : ''"
        v-html="item.result"
      />
    </div>
  </div>
</template>

<script>
	export default {
        name: "DebugTemplate",
        props: {
            renderContent: {
                type: Array,
                required: true
            }
        }
    };
</script>
