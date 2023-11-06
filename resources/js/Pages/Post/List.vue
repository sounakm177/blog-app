<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue'
import moment from 'moment';

const props = defineProps({
    posts:Array,
    users:Array,
    author_name:String
})
const author = ref('all');

onMounted(()=>{
    author.value = props.author_name;
});

const sortByAuthor = () => {
    author.value == 'All' ? router.get('/post') : router.get('/post?author_id='+author.value);
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flezx-row gap-4 w-full">
                <div class="rounded-xl h-full w-1/2">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">All Posts</h2>
                </div>
                <div class="rounded-xl h-full w-1/2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sort By Author Name</label>
                    <select v-model="author" @change="sortByAuthor($event)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option>All</option>
                        <option v-for="user in props.users" :key="user.id" :value="user.id">{{ user.name }}</option>
                    </select>
                </div>
            </div>
            
        </template>
        <div class="p-12 grid grid-cols-4 gap-4" v-if="props.posts.data.length > 0">
            <div v-for="post in props.posts.data" :key="post.id" class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <Link :href="route('post.show',post.id)">
                    <img class="rounded-t-lg object-fill h-48 w-96" :src="post.image" alt="" />
                </Link>
                <div class="p-5">
                    <Link :href="route('post.show',post.id)">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ post.title }} <span class="bg-gray-100 text-gray-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ moment(post.created_at).format('MMMM Do YYYY') }}</span></h5>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Author Name : <b>{{ post.user.name }}</b></p>
                    </Link>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ post.text.substring(0, 100) }} </p>
                    <Link :href="route('post.show',post.id)" method="get" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Read more
                        <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </Link>
                </div>
            </div>
        </div>

        <Pagination v-if="props.posts.data.length > 0" :pagination="props.posts.links" />

    </AuthenticatedLayout>
</template>
