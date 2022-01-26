<template>
    <Head :title="title" />

    <div class="min-h-screen pb-16 md:pb-0 bg-gray-100 text-gray-900 dark:bg-dark-eval-0 dark:text-gray-100">
        <Sidebar />

        <div
            style="transition-property: margin; transition-duration: 150ms"
            :class="[
                'min-h-screen flex flex-col',
                {
                    'lg:ml-64': sidebarState.isOpen,
                    'md:ml-16': !sidebarState.isOpen,
                },
            ]"
        >
            <Banner />

            <Navbar />

            <!-- Page Heading -->
            <header v-if="$slots.header">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6">
                <slot></slot>
            </main>

            <PageFooter />
        </div>
    </div>
</template>

<script setup>
import Banner from '@/Components/Banner'
import { Head } from '@inertiajs/inertia-vue3'
import Sidebar from '@/Components/Sidebar/Sidebar'
import Navbar from '@/Components/Navbar'
import PageFooter from '@/Components/PageFooter'
import { sidebarState } from '@/Composables'

const props = defineProps({
    title: String,
})
</script>
