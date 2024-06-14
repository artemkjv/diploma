<script setup>

import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Textarea from "@/Components/Textarea.vue";

const props = defineProps({
    sponsor: {
        type: Object,
        required: true
    }
})

const form = useForm({
    name: props.sponsor.name,
    contact_info: props.sponsor.contact_info,
    terms_of_cooperation: props.sponsor.terms_of_cooperation,
})

const submit = () => {
    form.post(route('sponsors.update', {'id': props.sponsor.id}));
}

</script>

<template>
    <Head title="Edit Sponsor"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Sponsor</h2>
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
                                <InputLabel for="contact-info" value="Contact Info" />

                                <TextInput
                                    id="contact-info"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.contact_info"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.contact_info" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="terms-of-cooperation" value="Terms Of Cooperation" />

                                <Textarea
                                    id="terms-of-cooperation"
                                    class="mt-1 block w-full"
                                    v-model="form.terms_of_cooperation"
                                    placeholder=""
                                />

                                <InputError class="mt-2" :message="form.errors.terms_of_cooperation" />
                            </div>

                            <div class="mt-4">
                                <PrimaryButton class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Submit
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
