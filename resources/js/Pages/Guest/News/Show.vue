<template>
    <div class="container mx-auto p-4">
        <div v-if="loading" class="text-center">
            <p>Loading...</p>
        </div>
        <div v-else-if="error" class="text-center text-red-500">
            <p>{{ error }}</p>
        </div>
        <div v-else class="bg-white p-4 rounded shadow">
            <h2 class="text-2xl font-bold mb-4">{{ newsItem.title }}</h2>
            <img :src="getImageUrl(newsItem.image)" alt="News Image" style="max-width: 150px;" class="w-full h-auto object-cover rounded mb-4">
            <div v-html="newsItem.content"></div>
            <p class="text-gray-500 mt-4">Category: {{ newsItem.category.name }}</p>
            <p class="text-gray-500">Author: {{ newsItem.user.name }}</p>
        </div>

    </div>

</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const newsItem = ref(null);
const loading = ref(true);
const error = ref(null);

const props = defineProps({
    id: {
        required: true
    }
})

const fetchNewsItem = async (id) => {
    loading.value = true;
    error.value = null;

    try {
        const response = await axios.get(`http://localhost/api/news/${id}`);
        newsItem.value = response.data;
        injectStyles(response.data.styles);
    } catch (err) {
        error.value = 'Failed to load news item';
    } finally {
        loading.value = false;
    }
};

const injectStyles = (styles) => {
    const styleElement = document.createElement('style');
    styleElement.textContent = styles;
    document.head.appendChild(styleElement);
};

const getImageUrl = (imagePath) => {
    return `http://localhost/storage/${imagePath}`;
};

onMounted(() => {
    fetchNewsItem(props.id);
});
</script>

<style scoped>
</style>
