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

const props = defineProps(['offwork'])

const form = useForm({
    start_date: props.offwork.start_date,
    finish_date: props.offwork.finish_date,
    reason: props.offwork.reason,
    document_url: props.offwork.document_url
})

const data = reactive({photoContainer: form.document_url})
</script>

<template>
    <Head title="Formulir Edit Permohonan Pengajuan Cuti"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <BackLink :href="route('offworks.show', props.offwork.id)" />

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Formulir edit permohonan pengajuan cuti</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="w-full md:max-w-md md:mx-auto px-4 py-2">
                            <div class="text-base text-gray-500 mb-2">
                                <span class="text-red-500">*</span> <span>Wajib diisi</span>
                            </div>

                            <form @submit.prevent="form.put(route('offworks.update', props.offwork.id))">

                                <div>
                                    <InputLabel for="start_date" value="Tanggal mulai" :required-data="true"/>
                                    <TextInput id="start_date" type="date" class="mt-1 block w-full" v-model="form.start_date" />
                                    <InputError class="mt-2" :message="form.errors.start_date"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="finish_date" value="Tanggal selesai" :required-data="true"/>
                                    <TextInput id="finish_date" type="date" class="mt-1 block w-full" v-model="form.finish_date" />
                                    <InputError class="mt-2" :message="form.errors.finish_date"/>
                                </div>


                                <div class="mt-4">
                                    <InputLabel for="reason" value="Alasan" :required-data="true"/>
                                    <TextareaInput class="mt-1 block w-full" v-model="form.reason" placeholder="Saya sakit gigi, kata Dokter harus istirahat dulu." />
                                    <InputError class="mt-2" :message="form.errors.reason"/>
                                </div>

                                <div class="mt-4">
                                    <img :src="data.photoContainer" class="rounded-lg">
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
