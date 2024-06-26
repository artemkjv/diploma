<template>
    <Head title="Edit Event"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Event</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="relative p-4">
                        <form @submit.prevent="submit">
                            <div ref="canvas"></div>

                            <div class="mt-4">
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
                                <InputLabel for="description" value="Description" />

                                <Textarea
                                    id="description"
                                    class="mt-1 block w-full"
                                    v-model="form.description"
                                    placeholder="Description for event"
                                />

                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="image" value="Image" />

                                <file-input
                                    @file-uploaded="selectImage"
                                    id="image"
                                    class="mt-1 block w-full"
                                    v-model="form.image"
                                />

                                <InputError class="mt-2" :message="form.errors.image" />

                                <figure class="max-w-lg mt-2">
                                    <img class="h-auto rounded-lg max-w-[100px]" :src="`/storage/${event.image}`" alt="image description">
                                </figure>

                            </div>

                            <div class="mt-4">
                                <PrimaryButton class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Update
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import grapesjs from 'grapesjs';
import 'grapesjs/dist/css/grapes.min.css';
import {onMounted, ref} from "vue";
import plugin from 'grapesjs-preset-webpage';
import blocksPlugin from 'grapesjs-blocks-basic';
import formsPlugin from 'grapesjs-plugin-forms';
import tooltipPlugin from 'grapesjs-tooltip';
import Textarea from "@/Components/Textarea.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import FileInput from "@/Components/FileInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Head, useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";

const props = defineProps({
    event: {
        type: Object,
        required: true
    }
});

const form = useForm({
    name: props.event.name,
    description: props.event.description,
    image: null,
    content: props.event.content,
    styles: props.event.styles,
})

const selectImage = (image) => {
    form.image = image;
}

const submit = () => {
    form.content = editor.getHtml();
    form.styles = editor.getCss();
    form.post(route('events.update', {'id': props.event.id}));
}

const canvas = ref(null);
let editor;
onMounted(() => {
    editor = grapesjs.init({
        container: canvas.value,
        fromElement: true,
        storageManager: {
            type: 'remote',
            autoload: true,
            autosave: true,
            options: {
                remote: {
                    urlLoad: route('api.grapejs.load', {'id': props.event.page.uuid}),
                    urlStore: route('api.grapejs.store', {'id': props.event.page.uuid}),
                }
            }
        },
        canvas: {
            styles: [],
            scripts: [],
        },
        plugins: [plugin, blocksPlugin, formsPlugin, tooltipPlugin],
        pluginsOpts: {
            [plugin]: { /* options */ }
        },
    });
});
</script>
