<template>
    <Modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="$emit('close')"
    >
        <div class="px-6 py-4">
            <div class="text-lg">
                <slot name="title"> </slot>
            </div>

            <div class="mt-4">
                <slot name="content"> </slot>
            </div>
        </div>

        <div class="px-6 py-4 text-right bg-gray-100 dark:bg-dark-eval-3">
            <slot name="footer"> </slot>
        </div>
    </Modal>
</template>

<script setup>
import Modal from '@/Components/Modal'

const props = defineProps({
    show: {
        default: false,
    },
    maxWidth: {
        default: '2xl',
    },
    closeable: {
        default: true,
    },
})
</script>
