<template>
    <AppLayout title="Profile">
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800  dark:text-gray-200"
            >
                Profile Settings
            </h2>
        </template>

        <div>
            <TabGroup as="div" class="grid gap-6 lg:grid-cols-4">
                <TabList class="flex flex-col items-start gap-2 lg:col-span-1">
                    <TabButton
                        v-if="$page.props.jetstream.canUpdateProfileInformation"
                        title="Profile Information"
                    />

                    <TabButton
                        v-if="$page.props.jetstream.canUpdatePassword"
                        title="Update Password"
                    />

                    <TabButton
                        v-if="
                            $page.props.jetstream
                                .canManageTwoFactorAuthentication
                        "
                        title="Two Factor Authentication"
                    />

                    <TabButton title="Browser Sessions" />

                    <TabButton
                        v-if="$page.props.jetstream.hasAccountDeletionFeatures"
                        title="Delete Account"
                    />
                </TabList>

                <TabPanels class="lg:col-span-3">
                    <TabPanel
                        v-if="$page.props.jetstream.canUpdateProfileInformation"
                    >
                        <UpdateProfileInformationForm
                            :user="$page.props.user"
                        />
                    </TabPanel>

                    <TabPanel v-if="$page.props.jetstream.canUpdatePassword">
                        <UpdatePasswordForm />
                    </TabPanel>

                    <TabPanel
                        v-if="
                            $page.props.jetstream
                                .canManageTwoFactorAuthentication
                        "
                    >
                        <TwoFactorAuthenticationForm />
                    </TabPanel>

                    <TabPanel>
                        <LogoutOtherBrowserSessionsForm :sessions="sessions" />
                    </TabPanel>

                    <TabPanel
                        v-if="$page.props.jetstream.hasAccountDeletionFeatures"
                    >
                        <DeleteUserForm />
                    </TabPanel>
                </TabPanels>
            </TabGroup>
        </div>
    </AppLayout>
</template>

<script setup>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import TabButton from '@/Pages/Profile/Partials/TabButton.vue'
import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue'
import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue'
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue'
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue'
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue'

const props = defineProps({
    sessions: {
        type: Array,
    },
})
</script>
