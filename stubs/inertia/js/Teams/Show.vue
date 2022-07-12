<template>
    <AppLayout title="Team Settings">
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800  dark:text-gray-200"
            >
                Team Settings
            </h2>
        </template>

        <div class="grid gap-10">
            <!-- Team Settings -->
            <div>
                <UpdateTeamNameForm :team="team" :permissions="permissions" />
            </div>

            <!-- Team Memeber Manager -->
            <div>
                <TeamMemberManager
                    :team="team"
                    :available-roles="availableRoles"
                    :user-permissions="permissions"
                />
            </div>

            <div
                    v-if="permissions.canDeleteTeam && !team.personal_team"
            >
                <DeleteTeamForm class="mt-10 sm:mt-0" :team="team" />
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import DeleteTeamForm from '@/Pages/Teams/Partials/DeleteTeamForm.vue'
import TeamMemberManager from '@/Pages/Teams/Partials/TeamMemberManager.vue'
import UpdateTeamNameForm from '@/Pages/Teams/Partials/UpdateTeamNameForm.vue'

defineProps(['team', 'availableRoles', 'permissions'])
</script>
