<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import BackLink from '@/Components/BackLink.vue';
import {onMounted} from "vue";
import { Inertia } from '@inertiajs/inertia'

const props = defineProps(['location']);

onMounted(() => {
    const map = L.map('map').setView([props.location.latitude, props.location.longitude], 13);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const marker = L.marker([props.location.latitude, props.location.longitude]).addTo(map);

    marker.bindPopup(`<b>${props.location.name}</b>`);
})

const destroy = (id) => {
  if (confirm('Apakah anda yakin ingin menghapus lokasi ini?')){
      return Inertia.delete(route('locations.destroy', id));
  }
}
</script>

<template>
    <Head title="Detail lokasi" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <BackLink :href="route('locations.index')" />

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
                                <span class="text-gray-500 text-sm">Latitude</span>
                                <div class="text-gray-700 font-semibold">{{ location.longitude }}</div>
                            </div>

                            <div>
                                <span class="text-gray-500 text-sm">Status</span>
                                <div class="flex items-center capitalize">
                                    <div class="h-2.5 w-2.5 rounded-full mr-2" :class="{'bg-green-400': location.status == 'active', 'bg-red-500': location.status == 'inactive'}"></div> {{ location.status }}
                                </div>
                            </div>
                        </div>

                        <div id="map" class="w-full h-[400px] rounded mt-4"></div>

                        <div class="mt-4 flex justify-between md:justify-end md:space-x-8 items-center">
                            <div>edit</div>
                            <button @click="destroy(location.id)" type="button" class="px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-300 text-white">
                                Hapus lokasi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
