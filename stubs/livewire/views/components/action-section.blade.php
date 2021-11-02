<div class="grid gap-4 md:gap-6" {{ $attributes }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="p-4 bg-white shadow-md rounded-md sm:p-6 dark:bg-dark-eval-1">
            {{ $content }}
        </div>
    </div>
</div>
