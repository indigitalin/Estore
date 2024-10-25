<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    

</head>

<body x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark text-bodydark bg-boxdark-2': darkMode === true }">
    <div class="flex h-screen overflow-hidden">
        @superAdmin
        <livewire:layout.admin.sidebar/>
        @endif
        @clientAdmin
        <livewire:layout.client.sidebar/>
        @endif
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
            @superAdmin
            <livewire:layout.admin.topbar/>
            @endif
            @clientAdmin
            <livewire:layout.client.topbar/>
            @endif
            <main>
                <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    <x-toaster-hub class="text-md" />
    @livewire('wire-elements-modal')
    @include('livewire.confirm')
    @stack('scripts')
</body>
</html>
