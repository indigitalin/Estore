<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <h2 class="text-xl text-gray-800 dark:text-gray-200 leading-tight mb-5">
        {{ __('Dashboard') }}
    </h2>
    <div class="bg-white dark:bg-gray-800 overflow-hidden border">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            {{ __("You're logged in!") }}
        </div>
    </div>
    @if ($this->firstLogin)
        <div x-data="{ firstLogin: @js($firstLogin) }" x-init="if (firstLogin) { $dispatch('openModal', { component: 'client.get-started' }) }"></div>
    @endif
</div>
