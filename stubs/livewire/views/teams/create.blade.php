<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Create Team') }}
        </h2>
    </x-slot>

    @livewire('teams.create-team-form')
</x-app-layout>
