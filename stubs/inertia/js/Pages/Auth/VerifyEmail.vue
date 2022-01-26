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

<script>
import { defineComponent } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import AuthenticationLayout from '@/Layouts/AuthenticationLayout'
import Button from '@/Components/Button'

export default defineComponent({
    components: {
        Head,
        Button,
        Link,
        AuthenticationLayout,
    },

    props: {
        status: String
    },

    data() {
        return {
            form: this.$inertia.form()
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('verification.send'))
        },
    },

    computed: {
        verificationLinkSent() {
            return this.status === 'verification-link-sent';
        }
    }
})
</script>
