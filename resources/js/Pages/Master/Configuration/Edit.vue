<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import BackLink from '@/Components/BackLink.vue';

const props = defineProps(['configuration', 'locations'])

const form = useForm({
    salary: props.configuration.salary,
    workday: props.configuration.workday,
    location: props.configuration.location,
    accepted_distance: props.configuration.accepted_distance,
    start: props.configuration.start,
    end: props.configuration.end,
})
</script>

<template>
    <Head title="Edit Pengaturan"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <BackLink :href="route('configurations.index')" />

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Pengaturan</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="w-full md:max-w-md md:mx-auto px-4 py-2">
                            <h2 class="text-2xl font-bold mb-4">Edit Pengaturan</h2>

                            <div class="text-base text-gray-500 mb-2">
                                <span class="text-red-500">*</span> <span>Wajib diisi</span>
                            </div>

                            <form @submit.prevent="form.put(route('configurations.update', configuration.id))">

                                <div>
                                    <InputLabel for="salary" value="Gaji per bulan" :required-data="true"/>
                                    <TextInput id="salary" type="number" class="mt-1 block w-full" v-model="form.salary" />
                                    <InputError class="mt-2" :message="form.errors.salary"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="workday" value="Jumlah hari kerja" :required-data="true"/>
                                    <TextInput id="workday" type="number" class="mt-1 block w-full" v-model="form.workday" />
                                    <InputError class="mt-2" :message="form.errors.workday"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="location" value="Lokasi presensi" :required-data="true"/>
                                    <select v-model="form.location" id="location" class="mt-1 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option v-for="location in locations" :value="location.id">
                                            {{ location.name }}
                                        </option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.location"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="birthplace" value="Radius presensi" :required-data="true"/>
                                    <TextInput id="birthplace" type="number" class="mt-1 block w-full" v-model="form.accepted_distance" />
                                    <InputError class="mt-2" :message="form.errors.accepted_distance"/>
                                </div>

                                <div class="grid grid-cols-2 gap-10 mt-4">
                                    <div>
                                        <InputLabel for="start" value="Jam masuk" :required-data="true"/>
                                        <TextInput id="start" type="time" class="mt-1 block w-full" v-model="form.start" min="00:00" max="23.59"/>
                                        <InputError class="mt-2" :message="form.errors.start"/>
                                    </div>

                                    <div>
                                        <InputLabel for="end" value="Jam keluar" :required-data="true"/>
                                        <TextInput id="end" type="time" class="mt-1 block w-full" v-model="form.end" min="00:00" max="23.59"/>
                                        <InputError class="mt-2" :message="form.errors.end"/>
                                    </div>
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Update
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
