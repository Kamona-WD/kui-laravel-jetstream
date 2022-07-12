<template>
    <AuthenticationLayout title="Forgot Password">

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div class="grid gap-4">
                <div class="space-y-2">
                    <Label for="email" value="Email" />
                    <InputIconWrapper>
                        <template #icon>
                            <MailIcon aria-hidden="true" class="w-6 h-6" />
                        </template>
                        <Input with-icon id="email" type="email" class="block w-full" placeholder="Email" v-model="form.email" required autofocus />
                    </InputIconWrapper>
                </div>

                <div>
                    <Button class="w-full justify-center gap-2" :disabled="form.processing" v-slot="{ iconSizeClasses }">
                        <PaperAirplaneIcon aria-hidden="true" :class="iconSizeClasses" />
                        <span>Email Password Reset Link</span>
                    </Button>
                </div>
            </div>
        </form>
    </AuthenticationLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import AuthenticationLayout from '@/Layouts/AuthenticationLayout.vue'
import InputIconWrapper from '@/Components/InputIconWrapper.vue'
import Button from '@/Components/Button.vue'
import Input from '@/Components/Input.vue'
import Label from '@/Components/Label.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'
import { MailIcon, PaperAirplaneIcon } from '@heroicons/vue/outline'

defineProps({
    status: String
})

const form = useForm({
    email: ''
})

const submit = () => {
    form.post(route('password.email'))
}
</script>
