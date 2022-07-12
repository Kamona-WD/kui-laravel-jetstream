<template>
    <span>
        <span @click="startConfirmingPassword">
            <slot />
        </span>

        <DialogModal :show="confirmingPassword" @close="closeModal">
            <template #title>
                {{ title }}
            </template>

            <template #content>
                {{ content }}

                <div class="mt-4">
                    <Input type="password" class="mt-1 block w-3/4" placeholder="Password"
                                ref="password"
                                v-model="form.password"
                                @keyup.enter="confirmPassword" />

                    <InputError :message="form.error" class="mt-2" />
                </div>
            </template>

            <template #footer>
                <Button variant="info" @click="closeModal">
                    Cancel
                </Button>

                <Button class="ml-2" @click="confirmPassword" :disabled="form.processing">
                    {{ button }}
                </Button>
            </template>
        </DialogModal>
    </span>
</template>

<script setup>
import { ref, reactive, nextTick } from 'vue'
import Button from '@/Components/Button.vue'
import DialogModal from '@/Components/DialogModal.vue'
import Input from '@/Components/Input.vue'
import InputError from '@/Components/InputError.vue'

const emit = defineEmits(['confirmed'])

defineProps({
    title: {
        type: String,
        default: 'Confirm Password',
    },
    content: {
        type: String,
        default: 'For your security, please confirm your password to continue.',
    },
    button: {
        type: String,
        default: 'Confirm',
    },
})

const confirmingPassword = ref(false)

const form = reactive({
    password: '',
    error: '',
    processing: false,
})

const passwordInput = ref(null)

const startConfirmingPassword = () => {
    axios.get(route('password.confirmation')).then(response => {
        if (response.data.confirmed) {
            emit('confirmed')
        } else {
            confirmingPassword.value = true

            setTimeout(() => passwordInput.value.focus(), 250)
        }
    })
}

const confirmPassword = () => {
    form.processing = true

    axios.post(route('password.confirm'), {
        password: form.password,
    }).then(() => {
        form.processing = false

        closeModal()
        nextTick().then(() => emit('confirmed'))

    }).catch(error => {
        form.processing = false
        form.error = error.response.data.errors.password[0]
        passwordInput.value.focus()
    })
}

const closeModal = () => {
    confirmingPassword.value = false
    form.password = ''
    form.error = ''
}
</script>
