<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import {Link} from "@inertiajs/inertia-vue3";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {Inertia} from "@inertiajs/inertia";
</script>

<template>
    <header>
        <nav class="bg-white border-b border-gray-200 dark:border-gray-700 px-4 lg:px-6 py-2.5 dark:bg-gray-900">
            <div class="flex justify-between items-center container mx-auto">
                <Link href="/">
                    <ApplicationLogo class="px-4 py-2 rounded w-auto dark:text-white" />
                </Link>
                <PrimaryButton v-if="$page.props.auth.user" @click="Inertia.get(route('dashboard'))" class="dark:bg-gray-700">
                    Dashboard
                </PrimaryButton>
                <PrimaryButton v-else @click="Inertia.get(route('login'))" class="dark:bg-gray-700">
                    Login
                </PrimaryButton>
            </div>
        </nav>
    </header>
</template>
