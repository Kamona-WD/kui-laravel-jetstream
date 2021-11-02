<x-sidebar.overlay />

<aside class="fixed inset-y-0 z-20 flex flex-col py-4 space-y-6 bg-white shadow-lg dark:bg-dark-eval-1" 
        :class="{
            'translate-x-0 w-64': isSidebarOpen || isSidebarHovered,
            '-translate-x-full w-64 md:w-16 md:translate-x-0': !isSidebarOpen && !isSidebarHovered,
        }" 
        style="transition-property: width, transform; transition-duration: 150ms;"
        @mouseenter="handleSidebarHover(true)" @mouseleave="handleSidebarHover(false)"
>
    <x-sidebar.header />

    <x-sidebar.content />
    
    <x-sidebar.footer />
</aside>