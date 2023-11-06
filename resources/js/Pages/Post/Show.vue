<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import CommentModal from '@/Components/Modals/CommentModal.vue';
import { onMounted, ref } from 'vue'
import moment from 'moment';
import { notify } from "notiwind"

const user = usePage().props.auth.user;
const isOpenCommentModel = ref(false);
const isEditCommentModel = ref(false);
const commentId = ref('');
const commentText = ref('');

const props = defineProps({
    post:Array,
})

const addComment = (form) => {
    form.post(route('post.comment.store'), {
        preserveScroll: true,
        onSuccess: () => {
            isOpenCommentModel.value = false;
            notify({
                group: "foo",
                title: "Success",
                text: "A comment has been added successfully"
            }, 4000);
        },
    });
};

const editCommentModalOpen = (comment) => {
    commentId.value = comment.id;
    commentText.value = comment.comment;
    isEditCommentModel.value = true;
}

const updateComment = (form) => {
    form.post(route('post.comment.update'), {
        preserveScroll: true,
        onSuccess: () => {
            isEditCommentModel.value = false;
            notify({
                group: "foo",
                title: "Success",
                text: "A comment has been updated successfully"
            }, 4000);
        },
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flezx-row gap-4 w-full">
                <div class="rounded-xl h-full w-1/2">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Post Details</h2>
                </div>
                <div class="rounded-xl h-full w-1/2 text-right">
                    <Link :href="route('post.list')" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Back</Link>
                </div>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <img class="object-fill h-48 w-98" :src="props.post.image" alt="">
                    <div class="flex flex-col justify-between p-4 leading-normal">
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Date : <b>{{ moment(post.created_at).format('MMMM Do YYYY') }}</b></p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"> The author of the post is <b>{{ props.post.user.name.toUpperCase() }}</b></p>

                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ props.post.title }}</h5>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ props.post.text }}</p>
                    </div>
                    <Link v-if="user.id == props.post.created_by" :href="route('post.edit',props.post.id)" method="get" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Edit</Link>
                    <button v-else type="button" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Edit</button>
                    <Link v-if="user.id == props.post.created_by && props.post.deleted_at == null " :href="route('post.delete',props.post.id)" method="delete" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Archive</Link>
                    <Link v-if="user.id == props.post.created_by && props.post.deleted_at != null" :href="route('post.restore',props.post.id)" method="get" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Restore</Link>
                    <button type="button" @click="isOpenCommentModel=!isOpenCommentModel" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Add Comment</button>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Comment [{{props.post.comments.length}}]</h5>
                    <div v-if="props.post.comments.length > 0">
                        <div v-for="comment in props.post.comments" :key="comment.id" class="flex flex-col justify-between p-4 leading-normal">
                            <h6 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ comment.user.name.toUpperCase() }} 
                                <span v-if="user.id == comment.user.id" @click="editCommentModalOpen(comment)"  class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">Edit</span>
                            </h6>
                            <p class="text-right">Time: {{ moment(comment.created_at).format('MMMM Do YYYY, h:mm:ss a') }}</p>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ comment.comment }}</p>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>

            <CommentModal 
                v-if="isOpenCommentModel" 
                @closeModal="isOpenCommentModel=!isOpenCommentModel"
                @addComment=addComment
                :post_id="props.post.id"
            />

            <CommentModal 
                v-if="isEditCommentModel" 
                @closeModal="isEditCommentModel=!isEditCommentModel"
                @updateComment=updateComment
                :post_id="props.post.id"
                :id="commentId"
                :comment = "commentText"
            />

            
        </div>
    </AuthenticatedLayout>
</template>
