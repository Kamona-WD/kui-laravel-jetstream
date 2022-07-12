<template>
    <AppLayout title="API Tokens">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
                API Tokens
            </h2>
        </template>

        <ApiTokenManager :tokens="tokens"
                            :available-permissions="availablePermissions"
                            :default-permissions="defaultPermissions" />
    </AppLayout>
</template>

<script setup>
import ApiTokenManager from '@/Pages/API/Partials/ApiTokenManager.vue'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps([
    'tokens',
    'availablePermissions',
    'defaultPermissions',
])
</script>
