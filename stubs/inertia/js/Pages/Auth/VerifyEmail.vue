<template>
    <AuthenticationLayout title="Email Verification">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </div>

        <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent" >
            A new verification link has been sent to the email address you provided during registration.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <Button :disabled="form.processing">
                    Resend Verification Email
                </Button>

                <Link :href="route('logout')" method="post" as="button" class="text-sm text-blue-600 hover:underline dark:text-blue-400">Log Out</Link>
            </div>
        </form>
    </AuthenticationLayout>
</template>

<script setup> 
import { computed } from 'vue'
import { Link, useForm } from '@inertiajs/inertia-vue3'
import AuthenticationLayout from '@/Layouts/AuthenticationLayout.vue'
import Button from '@/Components/Button.vue'

const props = defineProps({
    status: String,
})

const form = useForm()

const submit = () => {
    form.post(route('verification.send'))
}

const verificationLinkSent = computed(() => props.status === 'verification-link-sent')
</script>
