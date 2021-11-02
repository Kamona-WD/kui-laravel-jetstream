<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Profile Settings') }}
        </h2>
    </x-slot>

    <div>
        <div class="grid gap-6 lg:grid-cols-4" x-data="{ selectedTab: 'profileSetteings' }">
            <div class="flex flex-col items-start gap-2 lg:col-span-1">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    <button 
                        @click="selectedTab = 'profileSetteings'" 
                        class="block w-full max-w-xs text-left px-4 py-2 rounded-md text-gray-600 dark:text-gray-400 transition-colors hover:text-gray-900 dark:hover:text-gray-200" 
                        :class="{
                            'bg-purple-500 text-white hover:text-white dark:text-white dark:hover:text-white': selectedTab == 'profileSetteings',
                        }">
                        {{ __('Profile Settings') }}
                    </button>
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <button 
                        @click="selectedTab = 'updatePassword'" 
                        class="block w-full max-w-xs text-left px-4 py-2 rounded-md text-gray-600 dark:text-gray-400 transition-colors hover:text-gray-900 dark:hover:text-gray-200" 
                        :class="{
                            'bg-purple-500 text-white hover:text-white dark:text-white dark:hover:text-white': selectedTab == 'updatePassword',
                        }">
                        {{ __('Update Password') }}
                    </button>
                @endif

                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <button 
                        @click="selectedTab = 'twoFactorAuth'" 
                        class="block w-full max-w-xs text-left px-4 py-2 rounded-md text-gray-600 dark:text-gray-400 transition-colors hover:text-gray-900 dark:hover:text-gray-200" 
                        :class="{
                            'bg-purple-500 text-white hover:text-white dark:text-white dark:hover:text-white': selectedTab == 'twoFactorAuth',
                        }">
                        {{ __('Two Factor Authentication') }}
                    </button>
                @endif

                <button 
                    @click="selectedTab = 'browserSessions'" 
                    class="block w-full max-w-xs text-left px-4 py-2 rounded-md text-gray-600 dark:text-gray-400 transition-colors hover:text-gray-900 dark:hover:text-gray-200" 
                    :class="{
                        'bg-purple-500 text-white hover:text-white dark:text-white dark:hover:text-white': selectedTab == 'browserSessions',
                    }">
                    {{ __('Browser Sessions') }}
                </button>

                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <button 
                            @click="selectedTab = 'deleteProfiles'" 
                            class="block w-full max-w-xs text-left px-4 py-2 rounded-md text-gray-600 dark:text-gray-400 transition-colors hover:text-gray-900 dark:hover:text-gray-200" 
                            :class="{
                                'bg-purple-500 text-white hover:text-white dark:text-white dark:hover:text-white': selectedTab == 'deleteProfiles',
                            }">
                            {{ __('Delete Account') }}
                        </button>
                    @endif
            </div>
            
            <div class="lg:col-span-3">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    <div x-show="selectedTab == 'profileSetteings'">
                        @livewire('profile.update-profile-information-form')
                    </div>
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div x-show="selectedTab == 'updatePassword'" class="mt-10 sm:mt-0">
                        @livewire('profile.update-password-form')
                    </div>
                @endif

                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <div x-show="selectedTab == 'twoFactorAuth'">
                        @livewire('profile.two-factor-authentication-form')
                    </div>
                @endif

                <div x-show="selectedTab == 'browserSessions'">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>

                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <div x-show="selectedTab == 'deleteProfiles'">
                        @livewire('profile.delete-user-form')
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>