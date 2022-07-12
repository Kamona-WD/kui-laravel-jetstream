<template>
    <Head :title="title" />

    <div class="min-h-screen flex flex-col gap-8 p-4 sm:p-6 bg-gray-100 text-gray-900 dark:bg-dark-eval-0 dark:text-gray-100">
        <div class="flex-1 flex flex-col items-center justify-center gap-6">
            <div>
                <Link :href="'/'">
                    <ApplicationLogo aria-hidden="true" class="w-16 h-16" />
                    <span class="sr-only">Home page</span>
                </Link>
            </div>

            <div class="w-full sm:max-w-md p-4 sm:p-6 bg-white rounded-md shadow-md overflow-hidden dark:bg-dark-eval-1">
                <slot />
            </div>
        </div>
        <page-footer />

        <div class="fixed right-10 top-10">
            <Button
                iconOnly
                variant="secondary"
                type="button"
                @click="toggleDarkMode"
                v-slot="{ iconSizeClasses }"
                class="hidden md:inline-flex"
                srText="Toggle dark mode"
            >
                <MoonIcon
                    v-show="!isDark"
                    aria-hidden="true"
                    :class="iconSizeClasses"
                />
                <SunIcon
                    v-show="isDark"
                    aria-hidden="true"
                    :class="iconSizeClasses"
                />
            </Button>
        </div>
    </div>
</template>

<script setup>
import { Link, Head } from '@inertiajs/inertia-vue3'
import { MoonIcon, SunIcon } from '@heroicons/vue/outline'
import { toggleDarkMode, isDark } from '@/Composables'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import PageFooter from '@/Components/PageFooter.vue'
import Button from '@/Components/Button.vue'

defineProps({
    title: {
        type: String,
        default: 'Auth'
    }
})
</script>
