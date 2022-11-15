<template>
    <textarea :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" rows="4" class="block p-2.5 w-full text-sm text-gray-900 rounded-md border-gray-300 focus:ring focus:ring-indigo-200 focus:border-indigo-300 focus:ring-opacity-50" placeholder="Tulis deskripsi..."></textarea>
</template>

<script>
export default {
    props: ['modelValue'],
    emits: ['update:modelValue']
}
</script>
