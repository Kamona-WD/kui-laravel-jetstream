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

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout'
import Welcome from '@/Components/Welcome'
import Button from "@/Components/Button";
import { GithubIcon } from "@/Components/Icons/Brands";
</script>
