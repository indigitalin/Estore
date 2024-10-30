<div class="">
    @php
        $pageTitle = "{$website->name} settings";
        $navigationLinks = [
            ['text' => 'Dashboard', 'link' => roleRoute('{role}.index')],
            ['text' => 'Websites', 'link' => roleRoute('{role}.websites.index')],
            ['text' => 'Settings', 'link' => ''],
        ];
        $pageDescription = '';
        $rightSideBtnText = '';
        $rightSideBtnRoute = '';
    @endphp
    <x-admin-breadcrumb :pageTitle=$pageTitle :navigationLinks=$navigationLinks :pageDescription=$pageDescription
        :rightSideBtnText=$rightSideBtnText :rightSideBtnRoute=$rightSideBtnRoute />
    <div>
        <div class="flex items-center">
            <x-secondary-button class="mb-4 me-2 bg-white">
                <box-icon name='menu' ></box-icon> {{ __('Navigation menu') }}
            </x-secondary-button>
            <x-secondary-button class="mb-4 me-2 bg-white">
                <box-icon name='image-alt' ></box-icon> {{ __('Banners') }}
            </x-secondary-button>
            <x-secondary-button class="mb-4 me-2 bg-white">
                <box-icon name='bookmark' ></box-icon> {{ __('Pages') }}
            </x-secondary-button>
            <x-secondary-button class="mb-4 me-2 bg-white">
                <box-icon name='package' ></box-icon> {{ __('Shipping') }}
            </x-secondary-button>
        </div>
    </div>
</div>
