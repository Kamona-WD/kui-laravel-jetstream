<template>
    <div class="grid gap-4 md:gap-6">
        <SectionTitle>
            <template #title><slot name="title"></slot></template>
            <template #description><slot name="description"></slot></template>
        </SectionTitle>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="p-4 bg-white shadow-md rounded-md sm:p-6 dark:bg-dark-eval-1">
                <slot name="content"></slot>
            </div>
        </div>
    </div>
</template>

<script setup>
import SectionTitle from '@/Components/SectionTitle.vue'
</script>
