<script setup>

import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import RichSelect from "@/Components/RichSelect.vue";
import Textarea from "@/Components/Textarea.vue";
import LitepieDatepicker from 'litepie-datepicker-tw3';
import FileInput from "@/Components/FileInput.vue";

const props = defineProps({
    statuses: {
        type: Array,
        required: true
    }
});

const form = useForm({
    name: '',
    project_status_id: null,
    description: '',
    date: [],
    files: [],
})

const formatter = {
    date: 'YYYY-MM-DD',
    month: 'MM'
}

const submit = () => {
    form.post(route('projects.store'));
}

const handleChosenStatus = (status) => {
    form.project_status_id = status?.id
}

const removeFile = (index) => {
    form.files.splice(index, 1)
}

const addFile = (file) => {
    form.files.push(file)
}

</script>

<template>
    <Head title="Projects"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Project</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="relative p-4">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="name" value="Name" />

                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="status" value="Status" />

                                <RichSelect
                                    key-name="name"
                                    id="status"
                                    class="mt-1 block w-full"
                                    :data="statuses"
                                    @chosen="handleChosenStatus"
                                    placeholder="Search for status..."
                                />

                                <InputError class="mt-2" :message="form.errors.project_status_id" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="description" value="Description" />

                                <Textarea
                                    id="description"
                                    class="mt-1 block w-full"
                                    v-model="form.description"
                                    placeholder="Description for project"
                                />

                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="date" value="Start Date - End Date" />

                                <litepie-datepicker id="date" class="mt-1" :formatter="formatter" v-model="form.date"></litepie-datepicker>

                                <InputError class="mt-2" :message="form.errors.date" />
                            </div>

                            <div class="mt-4">
                                <file-input title="Add file" @file-uploaded="addFile" />
                            </div>

                            <div class="mt-2" v-if="form.files.length > 0">
                                <ul>
                                    <li v-for="(file, index) in form.files" :key="index" class="flex items-center justify-between mt-2">
                                        <span>{{ file.name }}</span>
                                        <button @click="removeFile(index)" type="button" class="text-red-500 hover:text-red-700">Remove</button>
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-4">
                                <PrimaryButton class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Create
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
