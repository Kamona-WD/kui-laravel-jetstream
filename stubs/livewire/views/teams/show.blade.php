<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Team Settings') }}
        </h2>
    </x-slot>

    <div class="grid gap-10">
        @livewire('teams.update-team-name-form', ['team' => $team])

        @livewire('teams.team-member-manager', ['team' => $team])

        @if (Gate::check('delete', $team) && ! $team->personal_team)
            @livewire('teams.delete-team-form', ['team' => $team])
        @endif
    </div>
</x-app-layout>
