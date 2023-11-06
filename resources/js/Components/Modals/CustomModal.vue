<script setup>

import { computed, watchEffect } from 'vue';

import { router } from '@inertiajs/vue3';

const props = defineProps({
    size: {
        type: String,
        default: '2xl',
    },
    position: {
      type: String,
      default: "center"
    },
    modalType:{
        type: String,
        default: ""
    },
    modalName:{
        type: String,
        default: ""
    }
});

const emit = defineEmits(['close']);

watchEffect(
    () => props.size,
    () => props.position,
    () => props.modalType
);

const close = (e) => {
    emit('close');
};

const sizeClass = computed(() => {
    return {
        xs: "max-w-xs",
        sm: "max-w-sm",
        md: "max-w-md",
        lg: "max-w-lg",
        xl: "max-w-xl",
        "2xl": "max-w-2xl",
        "3xl": "max-w-3xl",
        "4xl": "max-w-4xl",
        "5xl": "max-w-5xl",
        "6xl": "max-w-6xl",
        "7xl": "max-w-7xl"
    }[props.size];
});
const positionClass = computed(() => {
    return {
        "top-left": modalType.value+" justify-start items-start",
        "top-center": modalType.value+" justify-center items-start",
        "top-right": modalType.value+" justify-end items-start",
        "center-left": modalType.value+" justify-start items-center",
        "center": modalType.value+" justify-center items-center",
        "center-edit": modalType.value+" justify-center items-start pt-[60px]",
        "center-right": modalType.value+" justify-end items-center",
        "bottom-left": modalType.value+" justify-start items-end",
        "bottom-center": modalType.value+" justify-center items-end",
        "bottom-right": modalType.value+" justify-end items-end"
    }[props.position];
});
const modalType = computed(() => {
    return {
        "notepad": "z-[999]",
        "":"z-[9999]"
    }[props.modalType];
});
</script>

<template>
    <div class="bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0" :class="modalType"></div>
    <div tabindex="-1" class="overlay-modal overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 w-full md:inset-0 h-modal md:h-full flex" :class="positionClass">
        <div class="fixed w-full h-full top-0 left-0 right-0 bottom-0" @click="close"></div> 
        <div class="relative p-4 w-full h-full md:h-auto" :class="sizeClass">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-4 rounded-t flex justify-between items-center">
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" @click="close">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-6 pt-0">
                    <slot name="body" />
                </div>
            </div>
        </div>
    </div>
</template>