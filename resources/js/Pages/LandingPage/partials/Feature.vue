<script setup>
import { Link } from '@inertiajs/inertia-vue3';

</script>

<template>
    <section class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-700">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">
            <h2 class="text-4xl font-bold dark:text-white text-center mb-8">Fitur</h2>
            <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
                <Link href="/" class="font-bold">Simpeg</Link> memiliki dua fitur utama, yaitu presensi dan permohonan pengajuan cuti.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="py-8 px-4 lg:py-16 lg:px-12">
                <h3 class="text-3xl font-bold dark:text-white mb-8">Presensi</h3>

                <p class="mb-8 text-gray-500 dark:text-gray-400 text-lg font-normal lg:text-xl">
                    Lakukan presensi dengan cepat dan mudah menggunakan aplikasi mobile Simpeg.
                </p>

                <div class="border-t border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400">
                    <ul class="mt-8 space-y-1 max-w-md list-inside text-gray-500 dark:text-gray-400">
                        <li class="flex items-center font-semibold">
                            <svg class="w-4 h-4 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Sekali tekan, Done! Presensi berhasil disimpan
                        </li>

                        <li class="flex items-center font-semibold">
                            <svg class="w-4 h-4 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Detail, semuanya dicatat
                        </li>

                        <li class="flex items-center font-semibold">
                            <svg class="w-4 h-4 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Kelola status kehadiran
                        </li>
                    </ul>
                </div>
            </div>
            <div>
                <img src="/feature-attendance.webp" alt="feature attendance"
                    class="w-full h-auto lg:rounded-l-xl lg:border-l">
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="py-8 px-4 lg:py-16 lg:px-12">
                <h3 class="text-3xl font-bold dark:text-white mb-8">Cuti</h3>

                <p class="mb-8 text-gray-500 dark:text-gray-400 text-lg font-normal lg:text-xl">
                    Ajukan permohonan cuti menggunakan aplikasi web.
                </p>

                <div class="border-t border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400">
                    <ul class="mt-8 space-y-1 max-w-md list-inside text-gray-500 dark:text-gray-400">
                        <li class="flex items-center font-semibold">
                            <svg class="w-4 h-4 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0"
                                 fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            Detail pegawai yang mengajukan cuti
                        </li>

                        <li class="flex items-center font-semibold">
                            <svg class="w-4 h-4 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0"
                                 fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            Tanggal mulai dan dan selesai cuti
                        </li>

                        <li class="flex items-center font-semibold">
                            <svg class="w-4 h-4 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0"
                                 fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            Kelola status cuti
                        </li>
                    </ul>
                </div>
            </div>
            <div class="lg:order-first">
                <img src="/feature-offwork.webp" alt="feature offwork"
                     class="w-full h-auto lg:rounded-r-xl lg:border-r">
            </div>
        </div>
    </section>
</template>
