<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { reactive, computed } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import SuccessToast from '@/Components/SuccessToast.vue';

const props = defineProps(['offworks']);

const create = () => {
    return Inertia.get(route('offworks.create'));
}

const data = reactive({
    search: ''
})

const show = (id) => {
    return Inertia.get(route('offworks.show', id));
}

const filteredItems = computed(() => {
    return props.offworks.filter(item => {
        return item.reason.toLowerCase().indexOf(data.search.toLowerCase()) > -1 ||
        item.user.name.toLowerCase().indexOf(data.search.toLowerCase()) > -1 ||
        item.status.toLowerCase().indexOf(data.search.toLowerCase()) > -1;
    })
})

function limit (string = '', limit = 0)
{
    return string.substring(0, limit);
}
</script>

<template>
    <Head title="Cuti" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cuti
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <div class="flex justify-between items-center">
                            <TextInput type="text" v-model="data.search" class="placeholder:text-gray-400" placeholder="Cari"/>

                            <PrimaryButton @click="create" v-if="$page.props.auth.user.role_id === 2">
                                Tambah
                            </PrimaryButton>
                        </div>

                        <div class="overflow-x-auto relative mt-6">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">
                                        Pegawai
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Alasan
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        tanggal mulai
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        tanggal selesai
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
                                <tr class="bg-white border-b hover:bg-gray-100 cursor-pointer" v-for="offwork in filteredItems" :key="offwork.id" @click="show(offwork.id)">
                                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                        {{ offwork.user.name }}
                                    </th>
                                    <td class="py-4 px-6">
                                        {{ limit(offwork.reason, 30) }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ offwork.start_date }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ offwork.finish_date }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center capitalize">
                                            <div class="h-2.5 w-2.5 rounded-full mr-2" :class="{
                                                'bg-gray-400  animate-pulse' : offwork.status === 'menunggu',
                                                'bg-orange-500  animate-pulse' : offwork.status === 'diproses',
                                                'bg-red-500': offwork.status === 'ditolak',
                                                'bg-green-400': offwork.status === 'disetujui',
                                            }"></div>
                                            {{ offwork.status }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 flex justify-end">
                                        <Link :href="route('offworks.show', offwork.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                            </svg>
                                        </Link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div v-if="Object.keys(filteredItems).length === 0" class="text-center text-gray-500 mt-4 text-sm">
                            Cuti tidak ditemukan.
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <SuccessToast v-if="$page.props.flash.message" :message="$page.props.flash.message"/>

    </AuthenticatedLayout>
</template>
