<div class="">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Stores
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium" href="index.html">Dashboard /</a>
                </li>
                <li class="font-medium text-primary">Stores</li>
            </ol>
        </nav>
    </div>
    <div class="">
        <p>Manage stores, view edit and delete stores</p>
    </div>
    <div class="flex">
        <a class="ms-auto" href="{{ route('client.stores.create') }}" wire:navigate>
            <x-primary-button class="mb-4 ms-auto">
                {{ __('Create new store') }}
            </x-primary-button>
        </a>
    </div>
    <div class="rounded-sm shadow-default border border-stroke bg-white">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Store
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Address
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Contact
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Status
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Last updated
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stores as $store)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 ">
                                        <img src="{{ $store->logo_url }}"
                                            class="rounded-full w-12 h-12 object-cover rounded-full" alt="Brand" />
                                    </div>
                                    <div class="">
                                        <p class="hidden font-medium text-black dark:text-white sm:block capitalize">
                                            {{ $store->name }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                <div>
                                    <div>{{ $store->address }}</div>
                                    <div>{{ $store->city }}</div>
                                </div>
                            </td>

                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                <div class="flex flex-col">
                                    <a href="mailto:{{ $store->email }}"><i
                                            class="text-black dark:text-white">{{ $store->email }}</i></a>
                                    <a href="tel:{{ $store->phone }}"><i
                                            class="text-black dark:text-white">{{ $store->phone }}</i></a>
                                </div>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p role="button" @click="actionConfirmed({{ $store->id }}, 'status')"
                                    class="inline-flex rounded-full {{ $store->status == 1 ? 'bg-success' : 'bg-danger' }}  bg-opacity-10 px-3 py-1 text-sm font-medium {{ $store->status == 1 ? 'text-success' : 'text-danger' }} ">
                                    {{ $store->status_label }}
                                </p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                {{ $store->created_at->diffForHumans() }}
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark text-end">
                                <div class="flex items-center">
                                    <x-action-button x-data="{ tooltip: 'Edit store' }" x-tooltip="tooltip" role="button"
                                        class="ms-auto me-2" wire:navigate
                                        href="{{ route('client.stores.edit', $store) }}">
                                        <box-icon size="20px" color="#888" name='edit'></box-icon>
                                    </x-action-button>

                                    <x-action-button x-data="{ tooltip: 'Delete store' }" x-tooltip="tooltip" role="button"
                                        @click="confirmAction({{ $store->id }}, 'destroy', 'Are you sure want to delete?')">
                                        <box-icon size="20px" color="#888" name='trash'></box-icon>
                                    </x-action-button>
                                </div>
                            </td>
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
        {{ $stores->links('vendor.pagination.default') }}
    </div>
</div>
