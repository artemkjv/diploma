<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    clientRequests: {
        type: Object,
        required: true
    },
    statuses: {
        type: Array,
        required: true
    }
});

const updateStatus = (clientRequest, status) => {
    router.patch(route('client-requests.update-status', {'id': clientRequest.id}), {
        client_request_status_id: status.id
    })
}

</script>

<template>
    <Head title="Client Requests"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">ClientRequests</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="relative overflow-x-auto">
                        <table v-if="clientRequests.data.length > 0" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Theme
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(clientRequest, index) in clientRequests.data" :key="index"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ clientRequest.email }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ clientRequest.theme }}
                                </td>
                                <td class="px-6 py-4">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <span class="py-1 px-4 text-white rounded cursor-pointer"
                                              :class="`bg-${clientRequest.status?.color}-500`">
                                                {{ clientRequest.status?.name }}
                                            </span>
                                        </template>

                                        <template #content>
                                            <button
                                                v-for="status in statuses"
                                                @click.prevent="updateStatus(clientRequest, status)"
                                                class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
                                            >
                                                {{ status.name }}
                                            </button>
                                        </template>
                                    </Dropdown>
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
                                            <DropdownLink :href="route('client-requests.show', {'id': clientRequest.id})" as="button">
                                                View
                                            </DropdownLink>

                                            <DropdownLink :href="route('client-requests.destroy', {'id': clientRequest.id})" method="delete" as="button">
                                                Delete
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                        <div v-else class="p-4 text-center text-gray-500 dark:text-gray-400">
                            No client requests found.
                        </div>
                    </div>
                </div>
                <Pagination :links="clientRequests.links" />

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
