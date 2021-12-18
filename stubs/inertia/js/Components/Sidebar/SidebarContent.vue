<template>
    <PerfrectScrollbar
        tagname="nav"
        aria-label="main"
        class="relative flex flex-col flex-1 max-h-full gap-4 px-3"
    >
        <SidebarLink
            title="Dashboard"
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            <template #icon>
                <DashboardIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>
        </SidebarLink>

        <SidebarCollapsible title="Dropdown">
            <SidebarCollapsibleItem href="#" title="Link 1" :active="false" />
            <SidebarCollapsibleItem href="#" title="Link 2" :active="true" />
            <SidebarCollapsibleItem href="#" title="Link 3" :active="false" />
        </SidebarCollapsible>
    </PerfrectScrollbar>
</template>

<script setup>
import PerfrectScrollbar from '@/Components/PerfectScrollbar'
import SidebarLink from '@/Components/Sidebar/SidebarLink'
import { DashboardIcon } from '@/Components/Icons/outline'
import SidebarCollapsible from '@/Components/Sidebar/SidebarCollapsible'
import SidebarCollapsibleItem from '@/Components/Sidebar/SidebarCollapsibleItem'
</script>
