<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    pagination:Array,
})
</script>

<template>
    <nav class="flex justify-center">
        <template v-for="link in props.pagination" :key="link.label">
            <Link 
                :href="link.url ?? ''" 
                v-html="link.label"
                class="m-2 flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 rounded-l hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
            />
        </template>
    </nav>
</template>