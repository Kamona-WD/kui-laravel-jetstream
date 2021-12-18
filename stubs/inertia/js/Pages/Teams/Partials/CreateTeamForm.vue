<template>
    <FormSection @submitted="createTeam">
        <template #title>
            Team Details
        </template>

        <template #description>
            Create a new team to collaborate with others on projects.
        </template>

        <template #form>
            <div class="col-span-6">
                <Label value="Team Owner" />

                <div class="flex items-center mt-2">
                    <img class="object-cover w-12 h-12 rounded-full" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">

                    <div class="ml-4 leading-tight">
                        <div>{{ $page.props.user.name }}</div>
                        <div class="text-sm text-gray-700">{{ $page.props.user.email }}</div>
                    </div>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <Label for="name" value="Team Name" />
                <Input id="name" type="text" class="block w-full mt-1" v-model="form.name" autofocus />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <Button :disabled="form.processing">
                Create
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

    export default defineComponent({
        components: {
            Button,
            FormSection,
            Input,
            InputError,
            Label,
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                })
            }
        },

        methods: {
            createTeam() {
                this.form.post(route('teams.store'), {
                    errorBag: 'createTeam',
                    preserveScroll: true
                });
            },
        },
    })
</script>
