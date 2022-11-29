<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import {Inertia} from '@inertiajs/inertia'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {reactive, computed} from 'vue';
import TextInput from '@/Components/TextInput.vue';
import SuccessToast from '@/Components/SuccessToast.vue';
import dayjs from "dayjs";

const props = defineProps(['attendances']);

const create = () => {
    return Inertia.get(route('attendances.create'));
}

const data = reactive({
    search: '',
    title: 'Presensi',
    date: dayjs()
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
    return Inertia.get('?date=' + data.date);
}

</script>

<template>
    <Head :title="data.title"/>

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

                                <TextInput type="date" v-model="data.date" @change="searchByDate"/>
                            </div>

                            <PrimaryButton @click="create">
                                Tambah
                            </PrimaryButton>
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

                        <div v-if="Object.keys(filteredItems).length == 0"
                             class="text-center text-gray-500 mt-4 text-sm">
                            {{ data.title }} tidak ditemukan.
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <SuccessToast v-if="$page.props.flash.message" :message="$page.props.flash.message"/>

    </AuthenticatedLayout>
</template>
