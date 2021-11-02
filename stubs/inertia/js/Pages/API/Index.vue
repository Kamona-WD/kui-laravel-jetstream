<template>
    <AppLayout title="API Tokens">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
                API Tokens
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <ApiTokenManager :tokens="tokens"
                                 :available-permissions="availablePermissions"
                                 :default-permissions="defaultPermissions" />
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
    import { defineProps } from 'vue'
    import ApiTokenManager from '@/Pages/API/Partials/ApiTokenManager.vue'
    import AppLayout from '@/Layouts/AppLayout.vue'

    const props = defineProps([
            'tokens',
            'availablePermissions',
            'defaultPermissions',
    ])
</script>
