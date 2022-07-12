<template>
    <Head title="Terms of Service" />

    <div class="font-sans antialiased text-gray-900 dark:text-gray-200 dark:bg-dark-eval-0">
        <div class="pt-4 bg-gray-100">
            <div class="flex flex-col items-center min-h-screen pt-6 sm:pt-0">
                <Link :href="'/'">
                    <ApplicationLogo aria-hidden="true" class="w-16 h-16" />
                    <span class="sr-only">Home page</span>
                </Link>

                <div
                    v-html="terms"
                    class="w-full p-6 mt-6 overflow-hidden prose bg-white shadow-md  sm:max-w-2xl sm:rounded-lg dark:prose-invert dark:bg-dark-eval-1"
                ></div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'

defineProps(['terms'])
</script>
