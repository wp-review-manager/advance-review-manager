<template>
    <div>
        <div class="adrm-debug-item-line" v-for="(item, i) in renderContent" :key="i">
            <p>{{ item.label }}:</p>
            <p v-html="item.result"
                class="result"
                :class="item.status === 'warn' ? 'status-warn' : ''"
            >
            </p>
        </div>
    </div>
</template>

<script>
	export default {
        name: "DebugTemplate",
        props: ['renderContent']
    };
</script>
