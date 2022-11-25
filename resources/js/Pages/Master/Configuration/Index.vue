<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Inertia } from "@inertiajs/inertia";
import SuccessToast from '@/Components/SuccessToast.vue';
import { onMounted } from 'vue';

const props = defineProps(['configuration', 'location']);

const formatSalary = Intl.NumberFormat('id-ID', {
    'style': "currency",
    'currency': 'IDR'
})

const edit = (id) => {
    return Inertia.get(route('configurations.edit', id));
}

onMounted(() => {
    const map = L.map('map').setView([props.location.latitude, props.location.longitude], 16);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const circle = L.circle([props.location.latitude, props.location.longitude], {
        color: '#22c55e',
        fillColor: '#bbf7d0',
        fillOpacity: 0.5,
        radius: props.configuration.accepted_distance
    }).addTo(map);

    circle.bindPopup(`
    <b>${props.location.name}</b><br>
    Radius presensi: ${props.configuration.accepted_distance} meter
    `);
})

</script>

<template>

    <Head title="Pengaturan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pengaturan
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="max-w-2xl">
                            <h1
                                class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 md:text-2xl lg:text-3xl">
                                Pengaturan
                            </h1>
                            <p class="text-sm font-normal text-gray-500 lg:text-lg">
                                Menampilkan konfigurasi sistem saat ini.
                            </p>
                        </div>

                        <div class="mt-4">
                            <div class="text-gray-500 text-sm">Gaji per bulan</div>
                            <div class="text-gray-900 font-semibold">{{ formatSalary.format(props.configuration.salary)
                                }}</div>
                        </div>
                        <div class="mt-4">
                            <div class="text-gray-500 text-sm">Jumlah hari kerja</div>
                            <div class="text-gray-900 font-semibold">{{ props.configuration.workday }} hari</div>
                        </div>
                        <div class="mt-4">
                            <div class="text-gray-500 text-sm">Lokasi presensi</div>
                            <div class="text-gray-900 font-semibold">{{ props.location.name }}</div>
                        </div>
                        <div class="mt-4">
                            <div class="text-gray-500 text-sm">Radius presensi</div>
                            <div class="text-gray-900 font-semibold">{{ props.configuration.accepted_distance }} meter
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="text-gray-500 text-sm">Jam kerja</div>
                            <div class="text-gray-900 font-semibold">
                                {{ props.configuration.start }} - {{ props.configuration.end }}
                            </div>
                        </div>

                        <PrimaryButton class="mt-4 flex items-center space-x-2" @click="edit(configuration.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5">
                                <path
                                    d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                <path
                                    d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                            </svg>
                            <span>Edit</span>
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>

        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h1
                            class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 md:text-2xl lg:text-3xl">
                            Lokasi presensi
                        </h1>

                        <div id="map" class="bg-gray-200 rounded h-96"></div>

                    </div>
                </div>
            </div>
        </div>


        <SuccessToast v-if="$page.props.flash.message" :message="$page.props.flash.message" />
    </AuthenticatedLayout>
</template>
