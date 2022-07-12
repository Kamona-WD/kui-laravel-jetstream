<template>
    <AppLayout title="Create Team">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
                Create Team
            </h2>
        </template>

        <CreateTeamForm />
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import CreateTeamForm from '@/Pages/Teams/Partials/CreateTeamForm.vue'
</script>
