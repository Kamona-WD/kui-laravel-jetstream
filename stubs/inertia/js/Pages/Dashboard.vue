<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight">
                    Dashboard
                </h2>

                <Button external variant="black" target="_blank" class="items-center gap-2 max-w-xs" v-slot="{ iconSizeClasses }" href="https://github.com/kamona-wd/kui-laravel-jetstream">
                    <GithubIcon aria-hidden="true" :class="iconSizeClasses" />
                    <span>Star on Github</span>
                </Button>
            </div>
        </template>

        <div class="p-6 flex flex-col gap-6 overflow-hidden bg-white rounded-md shadow-md lg:flex-row md:justify-between dark:bg-dark-eval-1">
            <div>You're logged in!</div>

            <div>
                <a 
                    href="https://jetstream.laravel.com/2.x/introduction.html"
                    class="text-blue-600 hover:underline"
                    target="_blank"
                >
                    Jetstream Documentation
                </a>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import Button from "@/Components/Button.vue"
import { GithubIcon } from "@/Components/Icons/Brands"
</script>
