<template>
    <AuthenticationLayout title="Two-factor Confirmation">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            <template v-if="!recovery">
                Please confirm access to your account by entering the authentication code provided by your authenticator application.
            </template>

            <template v-else>
                Please confirm access to your account by entering one of your emergency recovery codes.
            </template>
        </div>

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div v-if="!recovery">
                <Label for="code" value="Code" />
                <Input ref="codeInput" id="code" type="text" inputmode="numeric" class="mt-1 block w-full" v-model="form.code" autofocus autocomplete="one-time-code" />
            </div>

            <div v-else>
                <Label for="recovery_code" value="Recovery Code" />
                <Input ref="recoveryCodeInput" id="recovery_code" type="text" class="mt-1 block w-full" v-model="form.recovery_code" autocomplete="one-time-code" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="button" class="text-sm text-gray-600 dark:text-gray-400 dark:hover:text-gray-200 hover:text-gray-900 underline cursor-pointer" @click.prevent="toggleRecovery">
                    <template v-if="!recovery">
                        Use a recovery code
                    </template>

                    <template v-else>
                        Use an authentication code
                    </template>
                </button>

                <Button class="ml-4" :disabled="form.processing">
                    Log in
                </Button>
            </div>
        </form>
    </AuthenticationLayout>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import AuthenticationLayout from '@/Layouts/AuthenticationLayout.vue'
import Button from '@/Components/Button.vue'
import Input from '@/Components/Input.vue'
import Label from '@/Components/Label.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'

const recovery = ref(false)

const form = useForm({
    code: '',
    recovery_code: '',
})

const recoveryCodeInput = ref(null)
const codeInput = ref(null)

const toggleRecovery = async () => {
    recovery.value ^= true

    await nextTick()

    if (recovery.value) {
        recoveryCodeInput.value.focus()
        form.code = ''
    } else {
        codeInput.value.focus()
        form.recovery_code = ''
    }
}

const submit = () => {
    form.post(route('two-factor.login'))
}
</script>
