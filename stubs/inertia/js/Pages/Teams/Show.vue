<template>
    <AppLayout title="Team Settings">
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800  dark:text-gray-200"
            >
                Team Settings
            </h2>
        </template>

        <div>
            <TabGroup as="div" class="grid gap-6 lg:grid-cols-4">
                <TabList class="flex flex-col items-start gap-2 lg:col-span-1">
                    <!-- Team Settings -->
                    <TabButton title="Team Settings" />

                    <!-- Team Memeber Manager -->
                    <TabButton title="Team Memeber Manager" />

                    <!-- Delete Team -->
                    <TabButton 
                        v-if="permissions.canDeleteTeam && !team.personal_team" 
                        title="Delete Team" />
                </TabList>

                <TabPanels class="lg:col-span-3">
                    <!-- Team Settings -->
                    <TabPanel>
                        <UpdateTeamNameForm :team="team" :permissions="permissions" />
                    </TabPanel>

                    <!-- Team Memeber Manager -->
                    <TabPanel>
                        <TeamMemberManager
                            :team="team"
                            :available-roles="availableRoles"
                            :user-permissions="permissions"
                        />
                    </TabPanel>

                    <TabPanel
                         v-if="permissions.canDeleteTeam && !team.personal_team"
                    >
                        <DeleteTeamForm class="mt-10 sm:mt-0" :team="team" />
                    </TabPanel>
                </TabPanels>
            </TabGroup>

            <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8" v-if="false">
                <UpdateTeamNameForm :team="team" :permissions="permissions" />

                <TeamMemberManager
                    class="mt-10 sm:mt-0"
                    :team="team"
                    :available-roles="availableRoles"
                    :user-permissions="permissions"
                />

                <template
                    v-if="permissions.canDeleteTeam && !team.personal_team"
                >
                    <SectionBorder />

                    <DeleteTeamForm class="mt-10 sm:mt-0" :team="team" />
                </template>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { TabGroup, TabList, TabPanels, TabPanel } from '@headlessui/vue'
import AppLayout from '@/Layouts/AppLayout'
import DeleteTeamForm from '@/Pages/Teams/Partials/DeleteTeamForm'
import SectionBorder from '@/Components/SectionBorder'
import TeamMemberManager from '@/Pages/Teams/Partials/TeamMemberManager'
import UpdateTeamNameForm from '@/Pages/Teams/Partials/UpdateTeamNameForm'
import TabButton from '@/Pages/Teams/Partials/TabButton'

const props = defineProps(['team', 'availableRoles', 'permissions'])
</script>
