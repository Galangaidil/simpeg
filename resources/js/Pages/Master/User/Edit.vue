<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import BackLink from '@/Components/BackLink.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import { reactive } from 'vue';

const props = defineProps(['user'])

const form = useForm({
    nip: props.user.nip,
    name: props.user.name,
    email: props.user.email,
    password: null,
    password_confirmation: null,
    birthdate: props.user.birthdate,
    birthplace: props.user.birthplace,
    phone_number: props.user.phone_number,
    address: props.user.address
})

const data = reactive({
    title: "Edit Pegawai"
})
</script>

<template>
    <Head :title="data.title"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <BackLink :href="route('users.show', props.user.id)" />

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ data.title }}</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="w-full md:max-w-md md:mx-auto px-4 py-2">
                            <h2 class="text-2xl font-bold mb-4">{{ data.title }}</h2>

                            <div class="text-base text-gray-500 mb-2">
                                <span class="text-red-500">*</span> <span>Wajib diisi</span>
                            </div>

                            <form @submit.prevent="form.put(route('users.update', props.user.id))">
                                <div class="text-base text-gray-700 mb-2 font-bold">
                                    Informasi pribadi
                                </div>

                                <div>
                                    <InputLabel for="name" value="Nama" :required-data="true"/>
                                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" />
                                    <InputError class="mt-2" :message="form.errors.name"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="nip" value="NIP" :required-data="true"/>
                                    <TextInput id="nip" type="text" class="mt-1 block w-full" v-model="form.nip" />
                                    <InputError class="mt-2" :message="form.errors.nip"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="birthdate" value="Tanggal lahir"/>
                                    <TextInput id="birthdate" type="date" class="mt-1 block w-full" v-model="form.birthdate" />
                                    <InputError class="mt-2" :message="form.errors.birthdate"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="birthplace" value="Tempat lahir"/>
                                    <TextInput id="birthplace" type="text" class="mt-1 block w-full" v-model="form.birthplace" />
                                    <InputError class="mt-2" :message="form.errors.birthplace"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="phone_number" value="Nomor HP"/>
                                    <TextInput id="phone_number" type="text" class="mt-1 block w-full" v-model="form.phone_number" />
                                    <InputError class="mt-2" :message="form.errors.phone_number"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="address" value="Alamat"/>
                                    <TextareaInput class="mt-1 block w-full" v-model="form.address" />
                                    <InputError class="mt-2" :message="form.errors.address"/>
                                </div>

                                <div class="text-base text-gray-700 my-4 font-bold">
                                    Informasi login
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="email" value="Email" :required-data="true"/>
                                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                                    <InputError class="mt-2" :message="form.errors.email"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="password" value="Password" :required-data="true"/>
                                    <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" />
                                    <InputError class="mt-2" :message="form.errors.password"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="password_confirmation" value="Konfirmasi password" :required-data="true"/>
                                    <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" />
                                    <InputError class="mt-2" :message="form.errors.password_confirmation"/>
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Simpan
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
