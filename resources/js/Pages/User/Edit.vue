<script setup>

import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    roles: {
        type: Array,
        required: true
    }
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role: props.user.role,
    password: '',
})

const submit = () => {
    form.put(route('users.update', {'id': props.user.id}));
}

</script>

<template>
    <Head title="Edit User"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit User</h2>
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
                                <InputLabel for="email" value="Email" />

                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="role" value="Role" />

                                <select id="role" v-model="form.role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Choose a role</option>
                                    <option v-for="role in roles" :value="role">{{ role }}</option>
                                </select>

                                <InputError class="mt-2" :message="form.errors.role" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="password" value="Password" />

                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password"
                                />

                                <InputError class="mt-2" :message="form.errors.password" />
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
