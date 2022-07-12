<template>
    <div class="grid gap-4 md:gap-6">
        <SectionTitle>
            <template #title><slot name="title"></slot></template>
            <template #description><slot name="description"></slot></template>
        </SectionTitle>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <form @submit.prevent="$emit('submitted')">
                <div class="px-4 py-5 bg-white shadow-md sm:p-6 dark:bg-dark-eval-1"
                    :class="hasActions ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'">
                    <div class="grid grid-cols-6 gap-6">
                        <slot name="form"></slot>
                    </div>
                </div>

                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md dark:bg-dark-eval-2" v-if="hasActions">
                    <slot name="actions"></slot>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useSlots, computed } from 'vue'
import SectionTitle from '@/Components/SectionTitle.vue'

const emits = defineEmits(['submitted'])

const slots = useSlots()

const hasActions = computed(() => {
        return !!slots.actions
})
</script>
