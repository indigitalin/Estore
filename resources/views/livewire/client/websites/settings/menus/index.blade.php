<div class="">
    <div>
        <div class="flex items-center">
            <div class="flex items-center">
                <x-secondary-button class="mb-4 me-2 bg-primary text-white">
                    <box-icon name='menu' color="white"></box-icon> {{ __('Navigation menu') }}
                </x-secondary-button>
                <x-secondary-button class="mb-4 me-2 bg-white">
                    <box-icon name='image-alt'></box-icon> {{ __('Banners') }}
                </x-secondary-button>
                <x-secondary-button class="mb-4 me-2 bg-white">
                    <box-icon name='bookmark'></box-icon> {{ __('Pages') }}
                </x-secondary-button>
                <x-secondary-button class="mb-4 me-2 bg-white">
                    <box-icon name='package'></box-icon> {{ __('Shipping') }}
                </x-secondary-button>
            </div>

        </div>
    </div>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            {{ $website->name }} settings
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium" href="index.html">Dashboard /</a>
                </li>
                <li class="font-medium">Websites /</li>
                <li class="font-medium text-primary">Settings</li>
            </ol>
        </nav>
    </div>
    <div class="">
        <p>Manage menus, view edit and delete menus</p>
    </div>
    <div class="flex">
        <a class="ms-auto" href="{{ route('client.websites.settings.menus.create', $this->website) }}" wire:navigate>
            <x-primary-button class="mb-4 ms-auto">
                {{ __('Create new menu') }}
            </x-primary-button>
        </a>
    </div>
    <div class="rounded-sm shadow-default border border-stroke bg-white">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Menu
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Last updated
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menus as $menu)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                {{ $menu->title }}
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                {{ $menu->updated_at->diffForHumans() }}
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark text-end">
                                <div class="flex items-center">
                                    <x-action-button x-data="{ tooltip: 'Edit menu' }" x-tooltip="tooltip" role="button"
                                        class="ms-auto me-2" wire:navigate
                                        href="{{ route('client.websites.settings.menus.edit', ['website' => $website, 'menu' => $menu]) }}">
                                        <box-icon size="20px" color="#888" name='edit'></box-icon>
                                    </x-action-button>

                                    <x-action-button x-data="{ tooltip: 'Delete menu' }" x-tooltip="tooltip" role="button"
                                        @click="confirmAction({{ $menu->id }}, 'destroy', 'Are you sure want to delete?')">
                                        <box-icon size="20px" color="#888" name='trash'></box-icon>
                                    </x-action-button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100"
                                class="border-b text-center border-[#eee] px-4 py-4 dark:border-strokedark">
                                No records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $menus->links('vendor.pagination.default') }}
    </div>
</div>
