<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { reactive, computed } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import SuccessToast from '@/Components/SuccessToast.vue';

const props = defineProps(['locations', 'permissions']);

const create = () => {
  return Inertia.get(route('locations.create'));
}

const data = reactive({
    search: ''
})

const show = (id) => {
    return Inertia.get(route('locations.show', id));
}

const filteredItems = computed(() => {
    return props.locations.filter(item => {
        return item.name.toLowerCase().indexOf(data.search.toLowerCase()) > -1;
    })
})
</script>

<template>
    <Head title="Pengaturan Lokasi" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lokasi
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <div class="flex justify-between items-center">
                            <TextInput type="text" v-model="data.search" class="placeholder:text-gray-400" placeholder="Cari lokasi"/>

                            <PrimaryButton v-if="permissions.manage" @click="create">
                                Tambah
                            </PrimaryButton>
                        </div>

                        <div class="overflow-x-auto relative mt-6">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">
                                        Nama
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Latitude
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Longitude
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Status
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Aksi
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="bg-white border-b hover:bg-gray-100 cursor-pointer" v-for="location in filteredItems" :key="location.id" @click="show(location.id)">
                                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                        {{ location.name }}
                                    </th>
                                    <td class="py-4 px-6">
                                        {{ location.latitude }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ location.longitude }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center capitalize">
                                            <div class="h-2.5 w-2.5 rounded-full mr-2" :class="{'bg-green-400': location.status == 'active', 'bg-red-500': location.status == 'inactive'}"></div> {{ location.status }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <Link :href="route('locations.show', location.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                            </svg>
                                        </Link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div v-if="Object.keys(filteredItems).length == 0" class="text-center text-gray-500 mt-4 text-sm">
                            Lokasi tidak ditemukan. <span v-if="permissions.manage" class="text-blue-500 cursor-pointer" @click="create">Tambah lokasi</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <SuccessToast v-if="$page.props.flash.message" :message="$page.props.flash.message"/>

    </AuthenticatedLayout>
</template>
