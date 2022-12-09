<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import BackLink from '@/Components/BackLink.vue';
import {onMounted} from "vue";
import {Inertia} from '@inertiajs/inertia';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps(['location']);

onMounted(() => {
    const map = L.map('map').setView([props.location.latitude, props.location.longitude], 17);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const marker = L.marker([props.location.latitude, props.location.longitude]).addTo(map);

    marker.bindPopup(`<b>${props.location.name}</b>`);
})

const destroy = (id) => {
    if (confirm('Apakah anda yakin ingin menghapus lokasi ini?')) {
        return Inertia.delete(route('locations.destroy', id));
    }
}

const edit = (id) => {
    return Inertia.get(route('locations.edit', id));
}
</script>

<template>
    <Head title="Detail lokasi"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <BackLink :href="route('locations.index')"/>

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Detail lokasi
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-start md:items-center flex-col md:flex-row">
                            <div>
                                <span class="text-gray-500 text-sm">Nama</span>
                                <div class="text-gray-700 font-semibold">{{ location.name }}</div>
                            </div>

                            <div>
                                <span class="text-gray-500 text-sm">Latitude</span>
                                <div class="text-gray-700 font-semibold">{{ location.latitude }}</div>
                            </div>

                            <div>
                                <span class="text-gray-500 text-sm">Longitude</span>
                                <div class="text-gray-700 font-semibold">{{ location.longitude }}</div>
                            </div>

                            <div>
                                <span class="text-gray-500 text-sm">Status</span>
                                <div class="flex items-center capitalize">
                                    <div class="h-2.5 w-2.5 rounded-full mr-2"
                                         :class="{'bg-green-400': location.status == 'active', 'bg-red-500': location.status == 'inactive'}"></div>
                                    {{ location.status }}
                                </div>
                            </div>
                        </div>

                        <div id="map" class="w-full h-[400px] rounded mt-4"></div>

                        <div v-if="$page.props.permissions.manage" class="mt-4 flex justify-between md:justify-end md:space-x-8 items-center">
                            <PrimaryButton @click="edit(location.id)" class="flex justify-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                    <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                </svg>
                                <span>Edit Lokasi</span>
                            </PrimaryButton>

                            <button @click="destroy(location.id)" type="button" v-if="location.status !== 'active'"
                                    class="flex justify-center space-x-2 uppercase tracking-widest text-sm px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-300 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Hapus lokasi</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
