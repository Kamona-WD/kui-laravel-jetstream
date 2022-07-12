<template>
    <AppLayout title="Profile">
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800  dark:text-gray-200"
            >
                Profile Settings
            </h2>
        </template>

        <div class="grid gap-10">
            <div
                v-if="$page.props.jetstream.canUpdateProfileInformation"
            >
                <UpdateProfileInformationForm
                    :user="$page.props.user"
                />
            </div>

            <div v-if="$page.props.jetstream.canUpdatePassword">
                <UpdatePasswordForm />
            </div>

            <div
                v-if="$page.props.jetstream.canManageTwoFactorAuthentication"
            >
                <TwoFactorAuthenticationForm :requires-confirmation="confirmsTwoFactorAuthentication" />
            </div>

            <div>
                <LogoutOtherBrowserSessionsForm :sessions="sessions" />
            </div>

            <div
                v-if="$page.props.jetstream.hasAccountDeletionFeatures"
            >
                <DeleteUserForm />
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue'
import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue'
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue'
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue'
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue'

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
})
</script>
