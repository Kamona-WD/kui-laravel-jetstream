<template>
    <ActionSection>
        <template #title>
            Delete Team
        </template>

        <template #description>
            Permanently delete this team.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.
            </div>

            <div class="mt-5">
                <Button variant="danger" @click="confirmTeamDeletion">
                    Delete Team
                </Button>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <ConfirmationModal :show="confirmingTeamDeletion" @close="confirmingTeamDeletion = false">
                <template #title>
                    Delete Team
                </template>

                <template #content>
                    Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.
                </template>

                <template #footer>
                    <Button variant="info" @click="confirmingTeamDeletion = false">
                        Cancel
                    </Button>

                    <Button variant="danger" class="ml-2" @click="deleteTeam" :disabled="form.processing">
                        Delete Team
                    </Button>
                </template>
            </ConfirmationModal>
        </template>
    </ActionSection>
</template>

<script>
    import { defineComponent } from 'vue'
    import ActionSection from '@/Components/ActionSection.vue'
    import ConfirmationModal from '@/Components/ConfirmationModal.vue'
    import Button from '@/Components/Button.vue'

    export default defineComponent({
        props: ['team'],

        components: {
            ActionSection,
            ConfirmationModal,
            Button,
        },

        data() {
            return {
                confirmingTeamDeletion: false,
                deleting: false,

                form: this.$inertia.form()
            }
        },

        methods: {
            confirmTeamDeletion() {
                this.confirmingTeamDeletion = true
            },

            deleteTeam() {
                this.form.delete(route('teams.destroy', this.team), {
                    errorBag: 'deleteTeam'
                });
            },
        },
    })
</script>
