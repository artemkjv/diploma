<script setup>
defineProps(['modelValue']);
defineEmits(['update:modelValue']);

</script>

<template>
    <textarea id="description" rows="4"
              :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
              class="block p-2.5 w-full bg-transparent rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
              placeholder="Enter description"></textarea>
</template>
