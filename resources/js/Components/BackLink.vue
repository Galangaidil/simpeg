<script setup>
import { Link } from '@inertiajs/inertia-vue3';

defineProps(['href']);
</script>

<template>
    <Link :href="href" class="p-1 rounded-full hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
            <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
        </svg>
    </Link>
</template>
