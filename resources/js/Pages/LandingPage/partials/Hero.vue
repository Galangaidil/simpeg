<script setup>
import {Link} from "@inertiajs/inertia-vue3";
</script>

<template>
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-32 lg:px-12">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                Sistem Informasi Kepegawaian
            </h1>
            <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
                Sistem internal perusahaan Tauke Sawit Dhea Putri Mustafa. Dibuat untuk mempermudah pegawai dalam melakukan presensi dan mengajukan permohonan cuti.
            </p>
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
                <Link :href="route('login')" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-900">
                    Login
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </Link>
                <a href="https://file.io/MY7WF6s6kXha" target="_blank" class="inline-flex justify-center items-center">
                    <img src="/google-play-badge.png" alt="Download App" class="h-12">
                </a>
            </div>
        </div>
    </section>
</template>
