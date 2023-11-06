<script setup>
import CustomModal from '@/Components/Modals/CustomModal.vue';
import {ref, onMounted} from 'vue';
import { usePage, useForm} from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';

const props = defineProps({
    post_id: Number,
    id: {
        type: Number,
        default: 0 
    },
    comment:  {
        type: String,
        default: '' 
    }
});

const form = useForm({
    id: props.id ?? '',
    post_id: props.post_id,
    comment: props.comment ?? '',
})

const emit = defineEmits(['closeModal', 'addComment', 'updateComment']);
const close = () => {
    emit('closeModal', true);
}

</script>

<template>
    <CustomModal @close=close>
        <template #body>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <header>
                            <h2 v-if="props.id != 0 " class="text-lg font-medium text-gray-900">Edit Comment</h2>
                            <h2 v-else class="text-lg font-medium text-gray-900">Add Comment</h2>
                        </header>
                        
                        <form @submit.prevent="props.id != 0 ? emit('updateComment', form) : emit('addComment', form)" class="mt-6 space-y-6">
                            <div>
                                <InputLabel for="text" value="Comment" />
                                <TextArea
                                    id="comment"
                                    ref="commentInput"
                                    v-model="form.comment"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.comment" class="mt-2" />
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
        </template>
    </CustomModal>
</template>