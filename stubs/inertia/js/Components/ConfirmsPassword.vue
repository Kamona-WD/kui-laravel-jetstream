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

<script>
import { defineComponent } from 'vue'
import Button from '@/Components/Button'
import DialogModal from '@/Components/DialogModal'
import Input from '@/Components/Input'
import InputError from '@/Components/InputError'

export default defineComponent({
    emits: ['confirmed'],

    props: {
        title: {
            default: 'Confirm Password',
        },
        content: {
            default: 'For your security, please confirm your password to continue.',
        },
        button: {
            default: 'Confirm',
        }
    },

    components: {
        Button,
        DialogModal,
        Input,
        InputError,
    },

    data() {
        return {
            confirmingPassword: false,
            form: {
                password: '',
                error: '',
            },
        }
    },

    methods: {
        startConfirmingPassword() {
            axios.get(route('password.confirmation')).then(response => {
                if (response.data.confirmed) {
                    this.$emit('confirmed');
                } else {
                    this.confirmingPassword = true;

                    setTimeout(() => this.$refs.password.focus(), 250)
                }
            })
        },

        confirmPassword() {
            this.form.processing = true;

            axios.post(route('password.confirm'), {
                password: this.form.password,
            }).then(() => {
                this.form.processing = false;
                this.closeModal()
                this.$nextTick(() => this.$emit('confirmed'));
            }).catch(error => {
                this.form.processing = false;
                this.form.error = error.response.data.errors.password[0];
                this.$refs.password.focus()
            });
        },

        closeModal() {
            this.confirmingPassword = false
            this.form.password = '';
            this.form.error = '';
        },
    }
})
</script>
