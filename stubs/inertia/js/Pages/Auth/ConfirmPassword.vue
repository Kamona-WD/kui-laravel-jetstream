<template>
    <AuthenticationLayout title="Secure Area">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            This is a secure area of the application. Please confirm your
            password before continuing.
        </div>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div class="grid gap-4">
                <div class="space-y-2">
                    <Label for="password" value="Password" />
                    <InputIconWrapper>
                        <template #icon>
                            <LockClosedIcon
                                aria-hidden="true"
                                class="w-6 h-6"
                            />
                        </template>
                        <Input
                            with-icon
                            id="password"
                            type="password"
                            class="block w-full mt-1"
                            placeholder="Password"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                            autofocus
                        />
                    </InputIconWrapper>
                </div>

                <div>
                    <Button
                        class="justify-center w-full"
                        :disabled="form.processing"
                    >
                        Confirm
                    </Button>
                </div>
            </div>
        </form>
    </AuthenticationLayout>
</template>

<script setup>
import AuthenticationLayout from '@/Layouts/AuthenticationLayout.vue'
import InputIconWrapper from '@/Components/InputIconWrapper.vue'
import Button from '@/Components/Button.vue'
import Input from '@/Components/Input.vue'
import Label from '@/Components/Label.vue'
import { LockClosedIcon } from '@heroicons/vue/outline'

const form = useForm({
    password: '',
})

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    })
}
</script>
