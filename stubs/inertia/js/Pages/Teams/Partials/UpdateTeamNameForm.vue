<template>
    <FormSection @submitted="updateTeamName">
        <template #title>
            Team Name
        </template>

        <template #description>
            The team's name and owner information.
        </template>

        <template #form>
            <!-- Team Owner Information -->
            <div class="col-span-6">
                <Label value="Team Owner" />

                <div class="flex items-center mt-2">
                    <img class="w-12 h-12 rounded-full object-cover" :src="team.owner.profile_photo_url" :alt="team.owner.name">

                    <div class="ml-4 leading-tight">
                        <div>{{ team.owner.name }}</div>
                        <div class="text-gray-700 text-sm dark:text-gray-400">{{ team.owner.email }}</div>
                    </div>
                </div>
            </div>

            <!-- Team Name -->
            <div class="col-span-6 sm:col-span-4">
                <Label for="name" value="Team Name" />

                <Input id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            :disabled="! permissions.canUpdateTeam" />

                <InputError :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #actions v-if="permissions.canUpdateTeam">
            <Button :disabled="form.processing">
                Save
            </Button>
        </template>
    </FormSection>
</template>

<script>
import { defineComponent } from 'vue'
import Button from '@/Components/Button'
import FormSection from '@/Components/FormSection'
import Input from '@/Components/Input'
import InputError from '@/Components/InputError'
import Label from '@/Components/Label'
import { successToast } from '@/Toast'

export default defineComponent({
    components: {
        Button,
        FormSection,
        Input,
        InputError,
        Label,
    },

    props: ['team', 'permissions'],

    data() {
        return {
            form: this.$inertia.form({
                name: this.team.name,
            })
        }
    },

    methods: {
        updateTeamName() {
            this.form.put(route('teams.update', this.team), {
                errorBag: 'updateTeamName',
                preserveScroll: true,
                onSuccess: () => {
                    successToast({
                        text: 'Team\'s name updated successfully! :)'
                    })
                }
            });
        },
    },
})
</script>
