<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { notify } from "notiwind"

const props = defineProps({
    post:Array,
});

const form = useForm({
    id: props.post.id,
    title: props.post.title,
    text: props.post.text,
    image: ''
});

const updatePost = () => {
    form.post(route('post.update'), {
        preserveScroll: true,
        onSuccess: () =>{
            notify({
                group: "foo",
                title: "Success",
                text: "Post has been updated successfully"
            }, 4000);
            form.reset()
        },
        onError: () => {
            if (form.errors.title) {
                titleInput.value.focus();
            }
            if (form.errors.text) {
                textInput.value.focus();
            }
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
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Post</h2>
                </div>
                <div class="rounded-xl h-full w-1/2 text-right">
                    <Link :href="route('post.show',props.post.id)" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Back</Link>
                </div>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Post</h2>
                    </header>
                    
                    <form @submit.prevent="updatePost" class="mt-6 space-y-6">
                        <div>
                            <InputLabel for="title" value="Title" />

                            <TextInput
                                id="title"
                                ref="titleInput"
                                v-model="form.title"
                                type="text"
                                class="mt-1 block w-full"
                            />

                            <InputError :message="form.errors.title" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="text" value="Text" />
                            <TextArea
                                id="text"
                                ref="textInput"
                                v-model="form.text"
                                type="text"
                                class="mt-1 block w-full"
                            />

                            <InputError :message="form.errors.text" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="image" value="Image" />
                            <TextInput
                                id="image"
                                ref="imageInput"
                                type="file"
                                class="mt-1 block w-full"
                                @input="form.image = $event.target.files[0]"
                            />
                            <InputError :message="form.errors.image" class="mt-2" />
                        </div>

                        
                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                            </Transition>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
