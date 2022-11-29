<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import BackLink from '@/Components/BackLink.vue';
import {onMounted} from "vue";
import {Inertia} from '@inertiajs/inertia';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import dayjs from "dayjs";
import SuccessToast from "@/Components/SuccessToast.vue";

const props = defineProps(['attendance', 'username', 'location', 'status']);

onMounted(() => {
    const map = L.map('map').setView([props.attendance.latitude, props.attendance.longitude], 17);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const marker = L.marker([props.attendance.latitude, props.attendance.longitude]).addTo(map);
    marker.bindPopup(`<b>Posisi pegawai "${props.username}"</b>`);

    const latlngs = [
        [props.attendance.latitude, props.attendance.longitude],
        [props.location.latitude, props.location.longitude]
    ]

    const markerLocationActive = L.marker([props.location.latitude, props.location.longitude]).addTo(map);
    markerLocationActive.bindPopup(`<b>Lokasi aktif</b>`);

    const polyline = L.polyline(latlngs, {color: '#0284c7'}).addTo(map);
    polyline.bindPopup(`Jarak: ${props.attendance.distance} meter`).openPopup();
    map.fitBounds(polyline.getBounds());
})

const destroy = (id) => {
    if (confirm('Apakah anda yakin ingin menghapus presensi ini?')) {
        return Inertia.delete(route('attendances.destroy', id));
    }
}

const edit = (id) => {
    return Inertia.get(route('attendances.edit', id));
}

const formatTime = (time) => {
    return dayjs(time).format('DD MMMM YYYY HH.mm');
}

const form = useForm({
    status: props.attendance.status
})

const updateStatus = () => {
    return Inertia.put(route('attendances.update', props.attendance.id), form);
}
</script>

<template>
    <Head title="Detail presensi"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <BackLink :href="route('attendances.index')"/>

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Detail presensi
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-start md:items-center flex-col md:flex-row">
                            <div>
                                <span class="text-gray-500 text-sm">Tanggal</span>
                                <div class="text-gray-700 font-semibold">{{ formatTime(attendance.created_at) }}</div>
                            </div>

                            <div>
                                <span class="text-gray-500 text-sm">Pegawai</span>
                                <div class="text-gray-700 font-semibold">{{ username }}</div>
                            </div>

                            <div>
                                <span class="text-gray-500 text-sm">Latitude</span>
                                <div class="text-gray-700 font-semibold">{{ attendance.latitude }}</div>
                            </div>

                            <div>
                                <span class="text-gray-500 text-sm">Longitude</span>
                                <div class="text-gray-700 font-semibold">{{ attendance.longitude }}</div>
                            </div>

                            <div>
                                <span class="text-gray-500 text-sm">jarak</span>
                                <div class="text-gray-700 font-semibold">{{ attendance.distance }} meter</div>
                            </div>

                            <div>
                                <span class="text-gray-500 text-sm">Status</span>
                                <div class="flex items-center capitalize">
                                    <div class="h-2.5 w-2.5 rounded-full mr-2"
                                         :class="{
                                        'bg-green-400': attendance.status === 'hadir',
                                        'bg-red-500': attendance.status === 'alpha',
                                        'bg-gray-500' : attendance.status === 'izin'}"></div>
                                    {{ attendance.status }}
                                </div>
                            </div>
                        </div>

                        <div id="map" class="w-full h-[400px] rounded mt-4"></div>

                        <div v-if="$page.props.permissions.manage" class="mt-4 flex justify-between md:justify-end md:space-x-8 items-center">
                            <select v-if="$page.props.permissions.manage" v-model="form.status" @change="updateStatus" class="text-gray-500 capitalize rounded border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                                <option v-for="option in props.status" :value="option">{{ option }}</option>
                            </select>

                            <button @click="destroy(attendance.id)" type="button"
                                    class="flex justify-center space-x-2 uppercase tracking-widest text-sm px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-300 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Hapus</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <SuccessToast v-if="$page.props.flash.message" :message="$page.props.flash.message"/>
</template>
