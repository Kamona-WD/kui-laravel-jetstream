<template>
    <div>
        <div class="grid gap-10">
            <!-- Generate API Token -->
            <FormSection @submitted="createApiToken">
                <template #title> Create API Token </template>

                <template #description>
                    API tokens allow third-party services to
                    authenticate with our application on your behalf.
                </template>

                <template #form>
                    <!-- Token Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <Label for="name" value="Name" />
                        <Input
                            id="name"
                            type="text"
                            class="block w-full mt-1"
                            v-model="createApiTokenForm.name"
                            autofocus
                        />
                        <InputError
                            :message="createApiTokenForm.errors.name"
                            class="mt-2"
                        />
                    </div>

                    <!-- Token Permissions -->
                    <div
                        v-if="availablePermissions.length > 0"
                        class="col-span-6"
                    >
                        <Label for="permissions" value="Permissions" />

                        <div
                            class="grid grid-cols-1 gap-4 mt-2  md:grid-cols-2"
                        >
                            <div
                                v-for="permission in availablePermissions"
                                :key="permission"
                            >
                                <label class="flex items-center">
                                    <Checkbox
                                        :value="permission"
                                        v-model:checked="createApiTokenForm.permissions"
                                    />
                                    <span
                                        class="ml-2 text-sm text-gray-600 dark:text-gray-400"
                                    >
                                        {{ permission }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </template>

                <template #actions>
                    <Button :disabled="createApiTokenForm.processing">
                        Create
                    </Button>
                </template>
            </FormSection>

            <!-- Manage API Tokens -->
            <div v-if="tokens.length > 0">
                <ActionSection>
                    <template #title> Manage API Tokens </template>

                    <template #description>
                        You may delete any of your existing tokens if they
                        are no longer needed.
                    </template>

                    <!-- API Token List -->
                    <template #content>
                        <div class="space-y-6">
                            <div
                                class="flex items-center justify-between"
                                v-for="token in tokens"
                                :key="token.id"
                            >
                                <div>
                                    {{ token.name }}
                                </div>

                                <div class="flex items-center">
                                    <div
                                        class="text-sm text-gray-400"
                                        v-if="token.last_used_ago"
                                    >
                                        Last used {{ token.last_used_ago }}
                                    </div>

                                    <button
                                        class="ml-6 text-sm text-gray-400 underline cursor-pointer "
                                        @click="manageApiTokenPermissions(token)"
                                        v-if="availablePermissions.length > 0"
                                    >
                                        Permissions
                                    </button>

                                    <button
                                        class="ml-6 text-sm text-red-500 cursor-pointer"
                                        @click="confirmApiTokenDeletion(token)"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </ActionSection>
            </div>
        </div>

        <!-- Token Value Modal -->
        <DialogModal :show="displayingToken" @close="displayingToken = false">
            <template #title> API Token </template>

            <template #content>
                <div>
                    Please copy your new API token. For your security, it won't
                    be shown again.
                </div>

                <div
                    class="px-4 py-2 mt-4 font-mono text-sm text-gray-500 bg-gray-100 rounded "
                    v-if="$page.props.jetstream.flash.token"
                >
                    {{ $page.props.jetstream.flash.token }}
                </div>
            </template>

            <template #footer>
                <Button variant="info" @click="displayingToken = false">
                    Close
                </Button>
            </template>
        </DialogModal>

        <!-- API Token Permissions Modal -->
        <DialogModal
            :show="managingPermissionsFor != null"
            @close="managingPermissionsFor = null"
        >
            <template #title> API Token Permissions </template>

            <template #content>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div
                        v-for="permission in availablePermissions"
                        :key="permission"
                    >
                        <label class="flex items-center">
                            <Checkbox
                                :value="permission"
                                v-model:checked="updateApiTokenForm.permissions"
                            />
                            <span class="ml-2 text-sm text-gray-600">
                                {{ permission }}
                            </span>
                        </label>
                    </div>
                </div>
            </template>

            <template #footer>
                <Button variant="info" @click="managingPermissionsFor = null">
                    Cancel
                </Button>

                <Button
                    class="ml-2"
                    @click="updateApiToken"
                    :disabled="updateApiTokenForm.processing"
                >
                    Save
                </Button>
            </template>
        </DialogModal>

        <!-- Delete Token Confirmation Modal -->
        <ConfirmationModal
            :show="apiTokenBeingDeleted != null"
            @close="apiTokenBeingDeleted = null"
        >
            <template #title> Delete API Token </template>

            <template #content>
                Are you sure you would like to delete this API token?
            </template>

            <template #footer>
                <Button variant="info" @click="apiTokenBeingDeleted = null">
                    Cancel
                </Button>

                <Button
                    variant="danger"
                    class="ml-2"
                    @click="deleteApiToken"
                    :disabled="deleteApiTokenForm.processing"
                >
                    Delete
                </Button>
            </template>
        </ConfirmationModal>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import ActionSection from '@/Components/ActionSection.vue'
import Button from '@/Components/Button.vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import DialogModal from '@/Components/DialogModal.vue'
import FormSection from '@/Components/FormSection.vue'
import Input from '@/Components/Input.vue'
import Checkbox from '@/Components/Checkbox.vue'
import InputError from '@/Components/InputError.vue'
import Label from '@/Components/Label.vue'
import { successToast } from '@/Toast'

const props = defineProps({
    tokens: Array,
    availablePermissions: Array,
    defaultPermissions: Array,
})

const createApiTokenForm = useForm({
    name: '',
    permissions: props.defaultPermissions,
})

const updateApiTokenForm = useForm({
    permissions: [],
})

const deleteApiTokenForm = useForm()

const displayingToken = ref(false)
const managingPermissionsFor = ref(null)
const apiTokenBeingDeleted = ref(null)

const createApiToken = () => {
    createApiTokenForm.post(route('api-tokens.store'), {
        preserveScroll: true,
        onSuccess: () => {
            displayingToken.value = true
            createApiTokenForm.reset()
            successToast({
                text: 'Api created.',
            })
        },
    })
}

const manageApiTokenPermissions = (token) => {
    updateApiTokenForm.permissions = token.abilities

    managingPermissionsFor.value = token
}

const updateApiToken = () => {
    updateApiTokenForm.put(
        route('api-tokens.update', managingPermissionsFor.value),
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                managingPermissionsFor.value = null
                successToast({
                    text: 'Api updated.',
                })
            },
        }
    )
}

const confirmApiTokenDeletion = (token) => {
    apiTokenBeingDeleted.value = token
}

const deleteApiToken = () => {
    deleteApiTokenForm.delete(
        route('api-tokens.destroy', apiTokenBeingDeleted.value),
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                apiTokenBeingDeleted.value = null
                successToast({
                    text: 'Api deleted.',
                })
            },
        }
    )
}
</script>
