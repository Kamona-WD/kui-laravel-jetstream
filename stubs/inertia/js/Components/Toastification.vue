<template>
    <div class="p-6 bg-white rounded-md shadow-lg dark:bg-dark-eval-3">
        <div class="flex items-start gap-4">
            <span :class="['inline-flex p-1 rounded-full', bgVariantClass]">
                <component
                    :is="icon"
                    aria-hidden="true"
                    class="w-6 h-6 text-white"
                />
            </span>
            <div class="space-y-2">
                <div :class="textVariantClass">{{ title }}</div>
                <p class="text-gray-600 dark:text-gray-400">{{ text }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue'
import { CheckIcon, XIcon } from '@heroicons/vue/outline'

const props = defineProps({
    variant: {
        type: String,
        default: 'primary',
    },
    title: {
        type: String,
        default: 'Notification',
    },
    text: {
        type: String,
        default: null,
    },
    hideClose: {
        type: Boolean,
        default: false,
    },
})

const { variant, title, text, hideClose } = props

const bgVariantClass = [
    {
        'bg-purple-400': variant == 'primary',
        'bg-green-400': variant == 'success',
        'bg-yellow-400': variant == 'warning',
        'bg-red-400': variant == 'error',
        'bg-cyan-400': variant == 'info',
    },
]
const textVariantClass = [
    {
        'text-purple-500': variant == 'primary',
        'text-green-500': variant == 'success',
        'text-yellow-500': variant == 'warning',
        'text-red-500': variant == 'error',
        'text-cyan-500': variant == 'info',
    },
]

let icon

switch (variant) {
    case 'primary':
        icon = CheckIcon
        break
    case 'success':
        icon = CheckIcon
        break
    case 'warning':
        icon = CheckIcon
        break
    case 'error':
        icon = XIcon
        break
    case 'info':
        icon = CheckIcon
        break
    default:
        icon = CheckIcon
}
</script>

<style></style>
