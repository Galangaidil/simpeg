<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import {reactive, onMounted} from 'vue';
import BackLink from '@/Components/BackLink.vue';
import SuccessToast from '@/Components/SuccessToast.vue';

const loading = reactive({
    OnLoading: false,
    showToast: false,
    showAlert: true
});

const form = useForm({
    name: null,
    latitude: null,
    longitude: null
})

onMounted(() => {

    // Set map of indonesia
    const map = L.map('map').setView([-5.44102230371796, 118.81480144101882], 4);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const popup = L.popup();

    // Set coords on click
    function onMapClick(e){
        form.latitude = e.latlng.lat;
        form.longitude = e.latlng.lng;

        popup.setLatLng(e.latlng)
            .setContent(`
                    <b>Informasi koordinat</b>
                    <br>
                    Latitude: ${e.latlng.lat}
                    <br>
                    Longitude: ${e.latlng.lng}
                `)
            .openOn(map)
    }

    map.on('click', onMapClick);

    document.querySelector('#find-me').addEventListener('click', geoFindMe);

    function geoFindMe()
    {
        function success(position)
        {
            form.latitude = position.coords.latitude;
            form.longitude = position.coords.longitude;

            loading.OnLoading = false;
            loading.showToast = true;
            loading.showAlert = false

            map.flyTo([position.coords.latitude, position.coords.longitude], 19);
            L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        }

        function error()
        {
            alert('Mohon maaf, kami tidak dapat menemukan koordinat Anda.');
        }

        if (navigator.geolocation){
            navigator.geolocation.getCurrentPosition(success, error);
            loading.OnLoading = true;
        } else {
            alert('Mohon maaf, sepertinya browser Anda tidak support fitur Geolocation.');
            loading.OnLoading = false;
        }
    }
})
</script>

<template>
    <Head title="Tambah Lokasi"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <BackLink :href="route('locations.index')" />

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Lokasi</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex space-x-4 flex-col md:flex-row">
                            <div class="w-full md:w-1/3 px-4 py-2">
                                <h2 class="text-2xl font-bold">Tambah lokasi</h2>

                                <div v-if="loading.showAlert" class="flex p-4 my-2 bg-green-100 rounded-lg" role="alert">
                                    <div class="ml-3 text-sm font-medium text-green-700">
                                        Tekan tombol <strong class="uppercase tracking-tight">Temukan koordinat</strong> untuk mengisi latitude dan longitude secara otomatis.
                                    </div>
                                    <button @click="loading.showAlert = false" type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8" data-dismiss-target="#alert-3" aria-label="Close">
                                        <span class="sr-only">Close</span>
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </div>

                                <div class="flex justify-center my-4">
                                    <PrimaryButton id="find-me" class="flex items-center">
                                        <span v-if="loading.OnLoading">
                                            <svg class="inline mr-2 w-4 h-4 text-gray-400 animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#FFFFFF"/>
                                            </svg>
                                        </span>
                                        <span v-if="loading.OnLoading">Mencari koordinat</span>
                                        <span v-else>Temukan koordinat</span>
                                    </PrimaryButton>
                                </div>

                                <form @submit.prevent="form.post(route('locations.store'))">
                                    <div>
                                        <InputLabel for="name" value="Nama tempat"/>
                                        <TextInput id="name" type="text" class="mt-1 block w-full"
                                                   v-model="form.name"></TextInput>
                                        <InputError class="mt-2" :message="form.errors.name"/>
                                    </div>

                                    <div class="mt-4">
                                        <InputLabel for="latitude" value="Latitude"/>
                                        <TextInput id="latitude" type="text" class="mt-1 block w-full"
                                                   v-model="form.latitude"></TextInput>
                                        <InputError class="mt-2" :message="form.errors.latitude"/>
                                    </div>

                                    <div class="mt-4">
                                        <InputLabel for="longitude" value="Longitude"/>
                                        <TextInput id="longitude" type="text" class="mt-1 block w-full"
                                                   v-model="form.longitude"></TextInput>
                                        <InputError class="mt-2" :message="form.errors.longitude"/>
                                    </div>

                                    <div class="flex items-center justify-end mt-4">
                                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                                       :disabled="form.processing">
                                            Simpan
                                        </PrimaryButton>
                                    </div>
                                </form>
                            </div>

                            <div class="w-full md:w-2/3 px-4 py-2">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-2xl font-bold">Maps</h2>
                                </div>

                                <p class="mt-4">
                                    Pilih tempat melakukan presensi
                                </p>

                                <div id="map" class="h-[400px] rounded mt-2"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <SuccessToast v-if="loading.showToast" message="Berhasil mendapatkan latitude dan longitude." />
    </AuthenticatedLayout>
</template>
