<template>
    <Head title="Edit News"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit News</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="relative p-4">
                        <form @submit.prevent="submit">
                            <div ref="canvas"></div>

                            <div class="mt-4">
                                <InputLabel for="title" value="Title" />

                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="category" value="News Category" />
                                <RichSelect
                                    key-name="name"
                                    id="category"
                                    class="mt-1 block w-full"
                                    :value-prop="news.category"
                                    :data="newsCategories"
                                    @chosen="handleChosenCategory"
                                    placeholder="Search for category..."
                                />

                                <InputError class="mt-2" :message="form.errors.news_category_id" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="image" value="Image" />

                                <file-input
                                    @file-uploaded="selectImage"
                                    id="image"
                                    class="mt-1 block w-full"
                                    v-model="form.image"
                                />

                                <figure class="max-w-lg mt-2">
                                    <img class="h-auto rounded-lg max-w-[100px]" :src="`/storage/${news.image}`" alt="image description">
                                </figure>

                                <InputError class="mt-2" :message="form.errors.image" />
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
import RichSelect from "@/Components/RichSelect.vue";

const props = defineProps({
    news: {
        type: Object,
        required: true
    },
    newsCategories: {
        type: Array,
        required: true
    },
});

const form = useForm({
    title: props.news.title,
    image: null,
    news_category_id: props.news.news_category_id,
    content: props.news.content,
    styles: props.news.styles,
})

const selectImage = (image) => {
    form.image = image;
}

const handleChosenCategory = (category) => {
    form.news_category_id = category?.id
}

const submit = () => {
    form.content = editor.getHtml();
    form.styles = editor.getCss();
    form.post(route('news.update', {'id': props.news.id}));
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
                    urlLoad: route('api.grapejs.load', {'id': props.news.page.uuid}),
                    urlStore: route('api.grapejs.store', {'id': props.news.page.uuid}),
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
