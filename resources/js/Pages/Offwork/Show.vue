<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import BackLink from '@/Components/BackLink.vue';
import {Inertia} from '@inertiajs/inertia';
import DangerButton from '@/Components/DangerButton.vue';
import dayjs from 'dayjs';
import localizedFormat from 'dayjs/plugin/localizedFormat';
import localeid from 'dayjs/locale/id';
import SuccessToast from '@/Components/SuccessToast.vue';

const props = defineProps(['offwork', 'options']);

const edit = (id) => {
    return Inertia.get(route('offworks.edit', id));
}

const destroy = (id) => {
  if (confirm('Anda yakin ingin menghapus pengajuan cuti ini?')){
      return Inertia.delete(route('offworks.destroy', id));
  }
}

const formatTime = (time) => {
    dayjs.extend(localizedFormat);
    dayjs.locale(localeid);
    return dayjs(time).format('LLLL');
}

const form = useForm({
    'status': props.offwork.status
})

const updateStatus = () => {
    return Inertia.put(route('offworks.updateStatus', props.offwork.id), form);
}

</script>

<template>
    <Head title="Detail Cuti"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <BackLink :href="route('offworks.index')" />

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Cuti</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="w-full px-4 py-2">
                            <div class="flex justify-center lg:justify-between items-center border-b lg:border-none">
                                <h2 class="text-2xl font-bold mb-4 lg:mb-0">Detail Cuti</h2>

                                <div class="hidden lg:flex items-center space-x-4">
                                    <select v-if="$page.props.permissions.manage" v-model="form.status" @change="updateStatus" class="text-gray-500 capitalize rounded border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                                        <option v-for="option in props.options" :value="option">{{ option }}</option>
                                    </select>

                                    <PrimaryButton v-if="props.offwork.status !== 'disetujui'" @click="edit(props.offwork.id)" class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                            <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                        </svg>
                                        <span>Edit</span>
                                    </PrimaryButton>

                                    <DangerButton v-if="props.offwork.status !== 'disetujui'" @click="destroy(props.offwork.id)" class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Hapus</span>
                                    </DangerButton>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="text-gray-500 text-sm">Diajukan oleh</div>
                                <div class="text-gray-900 font-semibold">
                                    {{ props.offwork.user.name }}
                                </div>
                                <div class="text-sm text-gray-700">
                                    {{ props.offwork.user.nip }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="text-gray-500 text-sm">Status</div>
                                <div class="flex items-center capitalize">
                                    <div class="h-2.5 w-2.5 rounded-full mr-2" :class="{
                                        'bg-gray-400  animate-pulse' : offwork.status == 'menunggu',
                                        'bg-orange-500  animate-pulse' : offwork.status == 'diproses',
                                        'bg-red-500': offwork.status == 'ditolak',
                                        'bg-green-400': offwork.status == 'disetujui',
                                    }"></div>
                                    {{ props.offwork.status }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="text-gray-500 text-sm">Tanggal Mulai Cuti</div>
                                <div class="text-gray-900 font-semibold">{{ props.offwork.start_date }}</div>
                            </div>

                            <div class="mt-4">
                                <div class="text-gray-500 text-sm">Tanggal Selesai Cuti</div>
                                <div class="text-gray-900 font-semibold">{{ props.offwork.finish_date }}</div>
                            </div>

                            <div class="mt-4">
                                <div class="text-gray-500 text-sm">Alasan</div>
                                <article class="prose lg:prose-xl">
                                    {{ props.offwork.reason }}
                                </article>
                            </div>

                            <div class="mt-4 max-w-lg">
                                <div class="text-gray-500 text-sm">Gambar</div>
                                <img :src="props.offwork.document" :alt="props.offwork.reason" class="rounded mt-1">
                            </div>

                            <div class="mt-4">
                                <div class="text-gray-500 text-sm">Tanggal dibuat</div>
                                <div class="text-gray-900 font-semibold">{{ formatTime(props.offwork.created_at) }}</div>
                            </div>

                            <div class="mt-4">
                                <div class="text-gray-500 text-sm">Tanggal diperbarui</div>
                                <div class="text-gray-900 font-semibold">{{ formatTime(props.offwork.updated_at) }}</div>
                            </div>

                            <div class="flex justify-between items-center lg:hidden mt-6">
                                <PrimaryButton v-if="props.offwork.status !== 'disetujui'" @click="edit(props.offwork.id)" class="flex justify-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                        <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                    </svg>
                                    <span>Edit</span>
                                </PrimaryButton>

                                <DangerButton v-if="props.offwork.status !== 'disetujui'" @click="destroy(props.offwork.id)" class="flex justify-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Hapus</span>
                                </DangerButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <SuccessToast v-if="$page.props.flash.message" :message="$page.props.flash.message"/>

    </AuthenticatedLayout>
</template>
