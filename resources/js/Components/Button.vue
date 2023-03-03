<script setup>
import { ref } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    bg_color: {
        type: String,
        default: 'gray'
    }
});

const bg_color = ref('bg-' + props.bg_color + '-800 hover:bg-' + props.bg_color + '-700 active:bg-' + props.bg_color + '-900 focus:border-' + props.bg_color + '-900 focus:ring-' + props.bg_color + '-300');
</script>

<template>
    <button :type="type"
        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25 transition"
        :class="bg_color">
        <slot />
    </button>
</template>
