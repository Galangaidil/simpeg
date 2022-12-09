<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import {Inertia} from '@inertiajs/inertia'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {reactive, computed} from 'vue';
import TextInput from '@/Components/TextInput.vue';
import SuccessToast from '@/Components/SuccessToast.vue';
import dayjs from "dayjs";
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps(['attendances', 'filtered']);

const create = () => {
    return Inertia.get(route('attendances.create'));
}

const data = reactive({
    search: '',
    title: 'Presensi',
    start_date: null,
    end_date: null,
    filter: '',
    showModal: false
})

const show = (id) => {
    return Inertia.get(route('attendances.show', id));
}

const formatTime = (time) => {
    return dayjs(time).format('DD MMMM YYYY HH.mm');
}

const filteredItems = computed(() => {
    return props.attendances.filter(item => {
        return item.status.toLowerCase().indexOf(data.search.toLowerCase()) > -1 ||
            item.user.name.toLowerCase().indexOf(data.search.toLowerCase()) > -1;
    })
})

const searchByDate = () => {
    if (data.start_date != null && data.end_date != null) {
        const query = `?start=${data.start_date}&end=${data.end_date}`
        return Inertia.get(route('attendances.index') + query);
    }
}

function filterBy() {
    if (data.filter === 'let_me_choose') {
        return toggleModal();
    }
    return Inertia.get('?filter=' + data.filter);
}

function toggleModal() {
    return data.showModal = !data.showModal;
}

</script>

<template>
    <Head>
        <title>{{ data.title }}</title>
    </Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ data.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <div class="flex justify-between items-center">
                            <div class="flex space-x-4">
                                <TextInput type="text" v-model="data.search" class="placeholder:text-gray-400"
                                           :placeholder="'Cari ' + data.title"/>

                                <select v-model="data.filter" @change="filterBy"
                                        class="text-gray-500 rounded border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                                    <option disabled value="">Pilih tanggal</option>
                                    <option value="today">Hari ini</option>
                                    <option value="yesterday">Kemarin</option>
                                    <option value="this_week">Minggu ini</option>
                                    <option value="this_month">Bulan ini</option>
                                    <option value="let_me_choose">Pilih tanggal sendiri</option>
                                </select>
                            </div>

                            <PrimaryButton @click="create">
                                Tambah
                            </PrimaryButton>
                        </div>

                        <div class="mt-2 text-sm text-gray-600" v-if="filtered ? filtered : null">
                            Menampilkan data berdasarkan {{ filtered }}.
                        </div>

                        <div class="overflow-x-auto relative mt-6">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Pegawai
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        latitude
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Longitude
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Jarak
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Status
                                    </th>
                                    <th scope="col" class="py-3 px-6 sr-only">
                                        Aksi
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="bg-white border-b hover:bg-gray-100 cursor-pointer"
                                    v-for="attendance in filteredItems" :key="attendance.id"
                                    @click="show(attendance.id)">
                                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                        {{ formatTime(attendance.created_at) }}
                                    </th>
                                    <th class="py-4 px-6">
                                        {{ attendance.user.name }}
                                    </th>
                                    <td class="py-4 px-6">
                                        {{ attendance.latitude }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ attendance.longitude }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ attendance.distance }} meter
                                    </td>
                                    <td class="py-4 px-6 capitalize">
                                        <div class="flex items-center capitalize">
                                            <div class="h-2.5 w-2.5 rounded-full mr-2" :class="{
                                                'bg-gray-400' : attendance.status === 'izin',
                                                'bg-red-500': attendance.status === 'alpha',
                                                'bg-green-400': attendance.status === 'hadir',
                                            }"></div>
                                            {{ attendance.status }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 flex justify-end">
                                        <Link :href="route('attendances.show', attendance.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                 fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd"
                                                      d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </Link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div v-if="Object.keys(filteredItems).length === 0"
                             class="text-center text-gray-500 mt-4 text-sm">
                            {{ data.title }} tidak ditemukan.
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <SuccessToast v-if="$page.props.flash.message" :message="$page.props.flash.message"/>

        <div v-if="data.showModal"
             class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
            <div class="relative w-auto my-6 mx-auto max-w-3xl">
                <!--content-->
                <div
                    class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                    <!--header-->
                    <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
                        <h3 class="text-3xl font-semibold">
                            Pilih Tanggal
                        </h3>
                        <button
                            class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                            v-on:click="toggleModal()">
              <span class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                ×
              </span>
                        </button>
                    </div>
                    <!--body-->
                    <div class="relative p-6 flex-auto">
                        <p class="my-4 text-slate-500 text-lg leading-relaxed">
                            Fitur
                            <mark class="capitalize">pilih tanggal</mark>
                            berfungsi untuk menampilkan data berdasarkan rentang waktu yang anda inginkan.
                        </p>
                        <div>
                            <InputLabel for="start_date" value="Tanggal Awal"/>
                            <TextInput type="date" id="start_date" class="mt-1 block w-full" v-model="data.start_date"
                                       required/>
                        </div>

                        <div class="mt-4">
                            <InputLabel for="end_date" value="Tanggal Akhir"/>
                            <TextInput type="date" id="end_date" class="mt-1 block w-full" v-model="data.end_date"
                                       required/>
                        </div>
                    </div>
                    <!--footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
                        <button
                            class="text-red-500 bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-xs tracking-widest px-4 py-2 rounded outline-none focus:outline-none mr-3 mb-1 ease-linear transition-all duration-150"
                            type="button" v-on:click="toggleModal()">
                            Tutup
                        </button>
                        <PrimaryButton class="mb-1"
                                       @click="searchByDate"
                                       :class="{ 'opacity-25' : data.start_date === null, 'opacity-50' : data.end_date === null }"
                                       :disabled="data.end_date === null">
                            Pilih
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="data.showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>

    </AuthenticatedLayout>
</template>
