<template>
    <FormSection @submitted="updateProfileInformation">
        <template #title>
            Profile Information
        </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div v-if="$page.props.jetstream.managesProfilePhotos" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input 
                    ref="photoInput"
                    type="file" 
                    class="hidden"
                    @change="updatePhotoPreview">

                <Label for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div v-show="!photoPreview" class="mt-2">
                    <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div v-show="photoPreview" class="mt-2">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          :style="'background-image: url(\'' + photoPreview + '\')'">
                    </span>
                </div>

                <Button 
                    variant="info" 
                    size="sm" 
                    class="mt-2 mr-2" 
                    type="button" 
                    @click.prevent="selectNewPhoto"
                >
                    Select A New Photo
                </Button>

                <Button 
                    variant="info" 
                    size="sm" 
                    type="button" 
                    class="mt-2" 
                    @click.prevent="deletePhoto" 
                    v-if="user.profile_photo_path"
                >
                    Remove Photo
                </Button>

                <InputError :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <Label for="name" value="Name" />

                <Input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />

                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <Label for="email" value="Email" />

                <Input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />

                <InputError :message="form.errors.email" class="mt-2" />
                
                <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
                    <p class="text-sm mt-2">
                        Your email address is unverified.

                        <Link
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class="underline text-blue-500 hover:text-blue-700"
                            @click.prevent="sendEmailVerification"
                        >
                            Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        A new verification link has been sent to your email address.
                    </div>
                </div>
            </div>
        </template>

        <template #actions>
            <Button :disabled="form.processing">
                Save
            </Button>
        </template>
    </FormSection>
</template>

<script setup>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { Link, useForm } from '@inertiajs/inertia-vue3'
import Button from '@/Components/Button.vue'
import FormSection from '@/Components/FormSection.vue'
import Input from '@/Components/Input.vue'
import InputError from '@/Components/InputError.vue'
import Label from '@/Components/Label.vue'
import { successToast } from '@/Toast'

const props = defineProps({
    user: Object,
})

const form = useForm({
    _method: 'PUT',
    name: props.user.name,
    email: props.user.email,
    photo: null,
})

const verificationLinkSent = ref(null)
const photoPreview = ref(null)
const photoInput = ref(null)

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0]
    }

    form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => {
            clearPhotoFileInput()
            successToast({
                title: 'Success',
                text: 'Your profile updated.'
            })
        },
    })
}

const sendEmailVerification = () => {
    verificationLinkSent.value = true
}

const selectNewPhoto = () => {
    photoInput.value.click()
}

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0]

    if (!photo) return

    const reader = new FileReader()

    reader.onload = (e) => {
        photoPreview.value = e.target.result
    }

    reader.readAsDataURL(photo)
}

const deletePhoto = () => {
    Inertia.delete(route('current-user-photo.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null
            clearPhotoFileInput()
            successToast({
                title: 'Success',
                text: 'Your avatar deleted.'
            })
        },
    })
}

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null
    }
}
</script>
