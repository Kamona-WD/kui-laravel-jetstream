<template>
    <Head title="Reset Password" />

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div class="grid gap-4">
                <div class="space-y-2">
                    <jet-label for="email" value="Email" />
                    <jet-input-icon-wrapper>
                        <template #icon>
                            <mail-icon aria-hidden="true" class="w-6 h-6" />
                        </template>
                        <jet-input with-icon id="email" type="email" class="block w-full" placeholder="Email" v-model="form.email" required autofocus />
                    </jet-input-icon-wrapper>
                </div>

                <div class="space-y-2">
                    <jet-label for="password" value="Password" />
                    <jet-input-icon-wrapper>
                        <template #icon>
                            <lock-closed-icon aria-hidden="true" class="w-6 h-6" />
                        </template>
                        <jet-input with-icon id="password" type="password" class="block w-full" placeholder="Password" v-model="form.password" required autocomplete="new-password" />
                    </jet-input-icon-wrapper>
                </div>

                <div class="space-y-2">
                    <jet-label for="password_confirmation" value="Confirm Password" />
                    <jet-input-icon-wrapper>
                        <template #icon>
                            <lock-closed-icon aria-hidden="true" class="w-6 h-6" />
                        </template>
                        <jet-input with-icon id="password_confirmation" type="password" class="block w-full" placeholder="Confirm Password" v-model="form.password_confirmation" required autocomplete="new-password" />
                    </jet-input-icon-wrapper>
                </div>

                <div>
                    <jet-button class="w-full justify-center" :disabled="form.processing">
                        Reset Password
                    </jet-button>
                </div>
            </div>
        </form>
</template>

<script>
    import { defineComponent } from 'vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import AuthenticationLayout from '@/Layouts/AuthenticationLayout.vue'
    import JetInputIconWrapper from '@/Components/InputIconWrapper.vue'
    import JetButton from '@/Components/Button.vue'
    import JetInput from '@/Components/Input.vue'
    import JetLabel from '@/Components/Label.vue'
    import JetValidationErrors from '@/Components/ValidationErrors.vue'
    import { MailIcon, LockClosedIcon } from '@heroicons/vue/outline';

    export default defineComponent({
        layout: AuthenticationLayout,
        components: {
            Head,
            JetInputIconWrapper,
            JetButton,
            JetInput,
            JetLabel,
            JetValidationErrors,
            MailIcon, 
            LockClosedIcon
        },

        props: {
            email: String,
            token: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    token: this.token,
                    email: this.email,
                    password: '',
                    password_confirmation: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.update'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    })
</script>
