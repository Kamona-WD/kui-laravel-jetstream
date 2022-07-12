<x-guest-layout>
    <div class="pt-4 bg-gray-100 dark:bg-dark-eval-0">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20" />
                </a>
            </div>

            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white dark:bg-dark-eval-1 shadow-md overflow-hidden sm:rounded-lg prose dark:prose-invert">
                {!! $terms !!}
            </div>
        </div>
    </div>
</x-guest-layout>
