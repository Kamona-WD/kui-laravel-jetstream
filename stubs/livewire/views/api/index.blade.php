<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('API Tokens') }}
        </h2>
    </x-slot>

    @livewire('api.api-token-manager')
</x-app-layout>
