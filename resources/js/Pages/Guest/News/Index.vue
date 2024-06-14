<template>
    <div class="container mx-auto p-4">
        <div v-if="loading" class="text-center">
            <p>Loading...</p>
        </div>
        <div v-else-if="error" class="text-center text-red-500">
            <p>{{ error }}</p>
        </div>
        <div v-else>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div
                    v-for="item in news"
                    :key="item.id"
                    class="bg-white p-4 rounded shadow hover:shadow-lg transition"
                >
                    <Link :href="`/guest/news/${item.id}`" class="no-underline">
                        <h2 class="text-xl font-bold mb-2">{{ item.title }}</h2>
                    </Link>
                    <p class="text-gray-500 mb-1">Category: {{ item.category.name }}</p>
                    <p class="text-gray-500 mb-1">Author: {{ item.user.name }}</p>
                    <img :src="getImageUrl(item.image)" alt="News Image" style="max-width: 150px;" class="w-full h-auto object-cover rounded mt-2">
                </div>
            </div>
            <div class="mt-4 flex justify-center items-center space-x-2">
                <button
                    @click="fetchNews(currentPage - 1)"
                    :disabled="currentPage <= 1"
                    style="width: 100px;"
                    class="bg-blue-500 text-white px-4 py-2 rounded disabled:opacity-50"
                >
                    Previous
                </button>
                <span class="text-gray-500">Page {{ currentPage }} of {{ totalPages }}</span>
                <button
                    @click="fetchNews(currentPage + 1)"
                    :disabled="currentPage >= totalPages"
                    style="width: 100px;"
                    class="bg-blue-500 text-white px-4 py-2 rounded disabled:opacity-50"
                >
                    Next
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, onMounted} from 'vue';
import {Link} from '@inertiajs/vue3';
import axios from 'axios';

const news = ref([]);
const loading = ref(true);
const error = ref(null);
const currentPage = ref(1);
const totalPages = ref(1);

const fetchNews = async (page = 1) => {
    if (page < 1 || page > totalPages.value) return;

    loading.value = true;
    error.value = null;

    try {
        const response = await axios.get(`http://localhost/api/news?page=${page}`);
        news.value = response.data.data;
        currentPage.value = response.data.current_page;
        totalPages.value = response.data.last_page;
    } catch (err) {
        error.value = 'Failed to load news';
    } finally {
        loading.value = false;
    }
};

const getImageUrl = (imagePath) => {
    return `http://localhost/storage/${imagePath}`;
};

onMounted(() => {
    fetchNews();
});
</script>

