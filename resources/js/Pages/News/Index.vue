<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    news: {
        type: Object,
        required: true
    }
});

</script>

<template>
    <Head title="News"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">News</h2>
                <Link
                    :href="route('news.create')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Create News
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="relative overflow-x-auto">
                        <table v-if="news.data.length > 0" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    User
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(newsEl, index) in news.data" :key="index"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ newsEl.title }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ newsEl.user.name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ newsEl.category?.name }}
                                </td>
                                <td class="px-6 py-4">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <button class="w-8 h-8 relative focus:outline-none bg-teal-600 rounded">
                                                <div
                                                    class="block w-5 absolute left-[1.16rem] top-1/2   transform  -translate-x-1/2 -translate-y-1/2">
                                                    <span
                                                        class="block absolute h-0.5 w-4 text-white bg-current transform transition duration-500 ease-in-out  -translate-y-1.5"
                                                    ></span>
                                                    <span
                                                        class="block absolute  h-0.5 w-3 text-white bg-current   transform transition duration-500 ease-in-out"
                                                    ></span>
                                                    <span
                                                        class="block absolute  h-0.5 w-4 text-white bg-current transform  transition duration-500 ease-in-out translate-y-1.5"
                                                    ></span>
                                                </div>
                                            </button>
                                        </template>

                                        <template #content>
                                            <DropdownLink :href="route('news.edit', {'id': newsEl.id})">
                                                Edit
                                            </DropdownLink>
                                            <DropdownLink :href="route('news.destroy', {'id': newsEl.id})" method="delete" as="button">
                                                Delete
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                        <div v-else class="p-4 text-center text-gray-500 dark:text-gray-400">
                            No news found.
                        </div>
                    </div>
                </div>
                <Pagination :links="news.links" />

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
