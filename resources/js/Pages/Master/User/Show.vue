<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import BackLink from '@/Components/BackLink.vue';
import {Inertia} from '@inertiajs/inertia'
import { reactive } from 'vue';

const props = defineProps(['user']);

const edit = (id) => {
    return Inertia.get(route('users.edit', id));
}

const destroy = (id) => {
  if (confirm('Anda yakin ingin menghapus pegawai ini?')){
      return Inertia.delete(route('users.destroy', id));
  }
}

const data = reactive({
    title: 'Detail Pegawai'
})

</script>

<template>
    <Head :title="data.title"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <BackLink :href="route('users.index')" />

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ data.title }}</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="w-full px-4 py-2">
                            <div class="flex justify-center lg:justify-between items-center border-b lg:border-none">
                                <h2 class="text-2xl font-bold mb-4 lg:mb-0">{{ data.title }}</h2>

                                <div class="hidden lg:flex items-center space-x-8">
                                    <PrimaryButton @click="edit(props.user.id)" class="flex justify-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                            <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                        </svg>
                                        <span>Edit</span>
                                    </PrimaryButton>

                                    <button @click="destroy(props.user.id)" type="button"
                                            class="flex justify-center space-x-2 uppercase tracking-widest text-sm px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 focus:outline-none focus:ring focus:ring-red-300 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="text-gray-500 text-sm">Nama</div>
                                <div class="text-gray-900 font-semibold">{{ props.user.name }}</div>
                            </div>
                            <div class="mt-4">
                                <div class="text-gray-500 text-sm">NIP</div>
                                <div class="text-gray-900 font-semibold">{{ props.user.nip }}</div>
                            </div>
                            <div class="mt-4">
                                <div class="text-gray-500 text-sm">Email</div>
                                <div class="text-gray-900 font-semibold select-all">{{ props.user.email }}</div>
                            </div>
                            <div class="mt-4">
                                <div class="text-gray-500 text-sm">Nomor HP</div>
                                <div class="text-gray-900 font-semibold">{{ props.user.phone_number }}</div>
                            </div>
                            <div class="mt-4">
                                <div class="text-gray-500 text-sm">Alamat</div>
                                <div class="text-gray-900 font-semibold">{{ props.user.address }}</div>
                            </div>
                            <div class="mt-4">
                                <div class="text-gray-500 text-sm">Tempat tanggal lahir</div>
                                <div class="text-gray-900 font-semibold">{{ props.user.birthplace }}. {{ props.user.birthdate }}</div>
                            </div>

                            <div class="flex justify-between items-center space-x-4 lg:hidden mt-6">
                                <PrimaryButton @click="edit(props.user.id)" class="flex justify-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                        <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                    </svg>
                                    <span>Edit</span>
                                </PrimaryButton>

                                <button @click="destroy(props.user.id)" type="button"
                                        class="flex justify-center space-x-2 uppercase tracking-widest text-sm px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 focus:outline-none focus:ring focus:ring-red-300 text-white">
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
        </div>
    </AuthenticatedLayout>
</template>
