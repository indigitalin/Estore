<div>
    <div class="flex items-center">
        <div class="flex items-center">
            <x-secondary-button wire:navigate href="{{ route('client.websites.settings.index', $this->website) }}"
                class="mb-4 me-2 {{ ($active = request()->route()->getName() == 'client.websites.settings.index') ? 'bg-primary text-white' : 'bg-white' }}">
                <box-icon name='home' color="{{ $active ? 'white' : 'black' }}"></box-icon> {{ __('Home') }}
            </x-secondary-button>
            <x-secondary-button wire:navigate href="{{ route('client.websites.settings.menus.index', $this->website) }}"
                class="mb-4 me-2 {{ ($active = request()->is('*/menus*')) ? 'bg-primary text-white' : 'bg-white' }}">
                <box-icon name='menu' color="{{ $active ? 'white' : 'black' }}"></box-icon> {{ __('Navigation menu') }}
            </x-secondary-button>
            <x-secondary-button wire:navigate
                href="{{ route('client.websites.settings.banners.index', $this->website) }}"
                class="mb-4 me-2 {{ ($active = request()->is('*/banners*')) ? 'bg-primary text-white' : 'bg-white' }}">
                <box-icon name='image-alt' color="{{ $active ? 'white' : 'black' }}"></box-icon> {{ __('Banners') }}
            </x-secondary-button>
            <x-secondary-button wire:navigate
                href="{{ $active = route('client.websites.settings.pages.index', $this->website) }}"
                class="mb-4 me-2 {{ ($active = request()->is('*/pages*')) && $active ? 'bg-primary text-white' : 'bg-white' }}">
                <box-icon name='bookmark' color="{{ $active ? 'white' : 'black' }}"></box-icon> {{ __('Pages') }}
            </x-secondary-button>
            <x-secondary-button
                class="mb-4 me-2 {{ ($active = request()->is('*/shippings*')) && $active ? 'bg-primary text-white' : 'bg-white' }}">
                <box-icon name='package' color="{{ $active ? 'white' : 'black' }}"></box-icon> {{ __('Shipping') }}
            </x-secondary-button>
        </div>
    </div>
</div>
