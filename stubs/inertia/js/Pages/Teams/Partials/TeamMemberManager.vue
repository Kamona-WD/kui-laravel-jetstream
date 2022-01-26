<template>
    <div>
        <div v-if="userPermissions.canAddTeamMembers">
            <!-- Add Team Member -->
            <FormSection @submitted="addTeamMember">
                <template #title>
                    Add Team Member
                </template>

                <template #description>
                    Add a new team member to your team, allowing them to collaborate with you.
                </template>

                <template #form>
                    <div class="col-span-6">
                        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                            Please provide the email address of the person you would like to add to this team.
                        </div>
                    </div>

                    <!-- Member Email -->
                    <div class="col-span-6 sm:col-span-4">
                        <Label for="email" value="Email" />
                        <Input id="email" type="email" class="mt-1 block w-full" v-model="addTeamMemberForm.email" />
                        <InputError :message="addTeamMemberForm.errors.email" class="mt-2" />
                    </div>

                    <!-- Role -->
                    <div class="col-span-6 lg:col-span-4" v-if="availableRoles.length > 0">
                        <Label for="roles" value="Role" />
                        <InputError :message="addTeamMemberForm.errors.role" class="mt-2" />

                        <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer dark:border-gray-700">
                            <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:ring focus:ring-purple-500"
                                            :class="{'border-t border-gray-200 rounded-t-none dark:border-gray-700': i > 0, 'rounded-b-none': i != Object.keys(availableRoles).length - 1}"
                                            @click="addTeamMemberForm.role = role.key"
                                            v-for="(role, i) in availableRoles"
                                            :key="role.key">
                                <div :class="{'opacity-70': addTeamMemberForm.role && addTeamMemberForm.role != role.key}">
                                    <!-- Role Name -->
                                    <div class="flex items-center">
                                        <div class="text-sm text-gray-600 dark:text-gray-400" :class="{'font-semibold': addTeamMemberForm.role == role.key}">
                                            {{ role.name }}
                                        </div>

                                        <svg v-if="addTeamMemberForm.role == role.key" class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>

                                    <!-- Role Description -->
                                    <div class="mt-2 text-xs text-gray-600 text-left dark:text-gray-400">
                                        {{ role.description }}
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </template>

                <template #actions>
                    <Button :disabled="addTeamMemberForm.processing">
                        Add
                    </Button>
                </template>
            </FormSection>
        </div>

        <div v-if="team.team_invitations.length > 0 && userPermissions.canAddTeamMembers">
            <SectionBorder />

            <!-- Team Member Invitations -->
            <ActionSection class="mt-10 sm:mt-0">
                <template #title>
                    Pending Team Invitations
                </template>

                <template #description>
                    These people have been invited to your team and have been sent an invitation email. They may join the team by accepting the email invitation.
                </template>

                <!-- Pending Team Member Invitation List -->
                <template #content>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between" v-for="invitation in team.team_invitations" :key="invitation.id">
                            <div class="text-gray-600 dark:text-gray-400">{{ invitation.email }}</div>

                            <div class="flex items-center">
                                <!-- Cancel Team Invitation -->
                                <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                                    @click="cancelTeamInvitation(invitation)"
                                                    v-if="userPermissions.canRemoveTeamMembers">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </ActionSection>
        </div>

        <div v-if="team.users.length > 0">
            <SectionBorder />

            <!-- Manage Team Members -->
            <ActionSection class="mt-10 sm:mt-0">
                <template #title>
                    Team Members
                </template>

                <template #description>
                    All of the people that are part of this team.
                </template>

                <!-- Team Member List -->
                <template #content>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between" v-for="user in team.users" :key="user.id">
                            <div class="flex items-center">
                                <img class="w-8 h-8 rounded-full" :src="user.profile_photo_url" :alt="user.name">
                                <div class="ml-4">{{ user.name }}</div>
                            </div>

                            <div class="flex items-center">
                                <!-- Manage Team Member Role -->
                                <button class="ml-2 text-sm text-gray-400 underline"
                                        @click="manageRole(user)"
                                        v-if="userPermissions.canAddTeamMembers && availableRoles.length">
                                    {{ displayableRole(user.membership.role) }}
                                </button>

                                <div class="ml-2 text-sm text-gray-400" v-else-if="availableRoles.length">
                                    {{ displayableRole(user.membership.role) }}
                                </div>

                                <!-- Leave Team -->
                                <button class="cursor-pointer ml-6 text-sm text-red-500"
                                                    @click="confirmLeavingTeam"
                                                    v-if="$page.props.user.id === user.id">
                                    Leave
                                </button>

                                <!-- Remove Team Member -->
                                <button class="cursor-pointer ml-6 text-sm text-red-500"
                                                    @click="confirmTeamMemberRemoval(user)"
                                                    v-if="userPermissions.canRemoveTeamMembers">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </ActionSection>
        </div>

        <!-- Role Management Modal -->
        <DialogModal :show="currentlyManagingRole" @close="currentlyManagingRole = false">
            <template #title>
                Manage Role
            </template>

            <template #content>
                <div v-if="managingRoleFor">
                    <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer dark:border-gray-600">
                        <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-purple-500 focus:ring focus:ring-purple-500"
                                        :class="{'border-t border-gray-200 rounded-t-none dark:border-gray-600': i > 0, 'rounded-b-none': i !== Object.keys(availableRoles).length - 1}"
                                        @click="updateRoleForm.role = role.key"
                                        v-for="(role, i) in availableRoles"
                                        :key="role.key">
                            <div :class="{'opacity-70': updateRoleForm.role && updateRoleForm.role !== role.key}">
                                <!-- Role Name -->
                                <div class="flex items-center">
                                    <div class="text-sm text-gray-600 dark:text-gray-400" :class="{'font-semibold': updateRoleForm.role === role.key}">
                                        {{ role.name }}
                                    </div>

                                    <svg v-if="updateRoleForm.role === role.key" class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>

                                <!-- Role Description -->
                                <div class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                                    {{ role.description }}
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </template>

            <template #footer>
                <Button variant="info" @click="currentlyManagingRole = false">
                    Cancel
                </Button>

                <Button class="ml-2" @click="updateRole" :disabled="updateRoleForm.processing">
                    Save
                </Button>
            </template>
        </DialogModal>

        <!-- Leave Team Confirmation Modal -->
        <ConfirmationModal :show="confirmingLeavingTeam" @close="confirmingLeavingTeam = false">
            <template #title>
                Leave Team
            </template>

            <template #content>
                Are you sure you would like to leave this team?
            </template>

            <template #footer>
                <Button variant="info" @click="confirmingLeavingTeam = false">
                    Cancel
                </Button>

                <Button variant="danger" class="ml-2" @click="leaveTeam" :disabled="leaveTeamForm.processing">
                    Leave
                </Button>
            </template>
        </ConfirmationModal>

        <!-- Remove Team Member Confirmation Modal -->
        <ConfirmationModal :show="teamMemberBeingRemoved" @close="teamMemberBeingRemoved = null">
            <template #title>
                Remove Team Member
            </template>

            <template #content>
                Are you sure you would like to remove this person from the team?
            </template>

            <template #footer>
                <Button variant="info" @click="teamMemberBeingRemoved = null">
                    Cancel
                </Button>

                <Button variant="danger" class="ml-2" @click="removeTeamMember" :disabled="removeTeamMemberForm.processing">
                    Remove
                </Button>
            </template>
        </ConfirmationModal>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import ActionSection from '@/Components/ActionSection'
import Button from '@/Components/Button'
import ConfirmationModal from '@/Components/ConfirmationModal'
import DialogModal from '@/Components/DialogModal'
import FormSection from '@/Components/FormSection'
import Input from '@/Components/Input'
import InputError from '@/Components/InputError'
import Label from '@/Components/Label'
import SectionBorder from '@/Components/SectionBorder'
import { successToast } from '@/Toast'

export default defineComponent({
    components: {
        ActionSection,
        Button,
        ConfirmationModal,
        DialogModal,
        FormSection,
        Input,
        InputError,
        Label,
        SectionBorder,
    },

    props: [
        'team',
        'availableRoles',
        'userPermissions'
    ],

    data() {
        return {
            addTeamMemberForm: this.$inertia.form({
                email: '',
                role: null,
            }),

            updateRoleForm: this.$inertia.form({
                role: null,
            }),

            leaveTeamForm: this.$inertia.form(),
            removeTeamMemberForm: this.$inertia.form(),

            currentlyManagingRole: false,
            managingRoleFor: null,
            confirmingLeavingTeam: false,
            teamMemberBeingRemoved: null,
        }
    },

    methods: {
        addTeamMember() {
            this.addTeamMemberForm.post(route('team-members.store', this.team), {
                errorBag: 'addTeamMember',
                preserveScroll: true,
                onSuccess: () => {
                    this.addTeamMemberForm.reset()
                    successToast({
                        text: 'Member add successfully! :)'
                    })
                },
            });
        },

        cancelTeamInvitation(invitation) {
            this.$inertia.delete(route('team-invitations.destroy', invitation), {
                preserveScroll: true
            });
        },

        manageRole(teamMember) {
            this.managingRoleFor = teamMember
            this.updateRoleForm.role = teamMember.membership.role
            this.currentlyManagingRole = true
        },

        updateRole() {
            this.updateRoleForm.put(route('team-members.update', [this.team, this.managingRoleFor]), {
                preserveScroll: true,
                onSuccess: () => (this.currentlyManagingRole = false),
            })
        },

        confirmLeavingTeam() {
            this.confirmingLeavingTeam = true
        },

        leaveTeam() {
            this.leaveTeamForm.delete(route('team-members.destroy', [this.team, this.$page.props.user]))
        },

        confirmTeamMemberRemoval(teamMember) {
            this.teamMemberBeingRemoved = teamMember
        },

        removeTeamMember() {
            this.removeTeamMemberForm.delete(route('team-members.destroy', [this.team, this.teamMemberBeingRemoved]), {
                errorBag: 'removeTeamMember',
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => (this.teamMemberBeingRemoved = null),
            })
        },

        displayableRole(role) {
            return this.availableRoles.find(r => r.key === role).name
        },
    },
})
</script>
