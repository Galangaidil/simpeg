<script setup>
import { computed } from "vue";

const props = defineProps(['value', 'requiredData']);

const classes = computed(() => props.requiredData
    ? "after:content-['*'] after:ml-0.5 after:text-red-500 block font-medium text-sm text-gray-700"
    : 'block font-medium text-sm text-gray-700'
);
</script>

<template>
    <label :class="classes">
        <span v-if="props.value">{{ props.value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
