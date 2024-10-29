<div class="">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Websites
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium" href="index.html">Dashboard /</a>
                </li>
                <li class="font-medium text-primary">Websites</li>
            </ol>
        </nav>
    </div>
    <div class="">
        <p>Manage websites, view edit and delete websites</p>
    </div>
    <div class="flex">
        <a class="ms-auto" href="{{ route('client.websites.create') }}" wire:navigate>
            <x-primary-button class="mb-4 ms-auto">
                {{ __('Create new website') }}
            </x-primary-button>
        </a>
    </div>
    <div class="rounded-sm shadow-default border border-stroke bg-white">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Website
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Link
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
                    @forelse ($websites as $website)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 ">
                                        <img src="{{ $website->logo_url }}"
                                            class="rounded-full w-12 h-12 object-cover rounded-full" alt="Brand" />
                                    </div>
                                    <div class="">
                                        <p class="hidden font-medium text-black dark:text-white sm:block capitalize">
                                            {{ $website->name }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                <a class="text-indigo-600" target="_blank" href="{{ $website->website }}"><div>
                                    <span>{{ strlen($website->website) > 20 ? '...' . substr($website->website, -20) : $website->website }}</span>
                                </div>
                                </a>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                <div class="flex flex-col">
                                    <a href="mailto:{{ $website->email }}"><i
                                            class="text-black dark:text-white">{{ $website->email }}</i></a>
                                    <a href="tel:{{ $website->phone }}"><i
                                            class="text-black dark:text-white">{{ $website->phone }}</i></a>
                                </div>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p role="button" @click="actionConfirmed({{ $website->id }}, 'status')"
                                    class="inline-flex rounded-full {{ $website->status == 1 ? 'bg-success' : 'bg-danger' }}  bg-opacity-10 px-3 py-1 text-sm font-medium {{ $website->status == 1 ? 'text-success' : 'text-danger' }} ">
                                    {{ $website->status_label }}
                                </p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                {{ $website->created_at->diffForHumans() }}
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark text-end">
                                <div class="flex items-center">
                                    <a target="_blank" class="ms-auto" href="{{ $website->website }}">
                                        <x-action-button x-data="{ tooltip: 'View website' }" x-tooltip="tooltip" role="button"
                                        class="ms-auto me-2">
                                        <box-icon size="20px" color="#888" name='show'></box-icon>
                                    </x-action-button>
                                    </a>
                                    <x-action-button x-data="{ tooltip: 'Edit website' }" x-tooltip="tooltip" role="button"
                                        class="me-2" wire:navigate
                                        href="{{ route('client.websites.edit', $website) }}">
                                        <box-icon size="20px" color="#888" name='edit'></box-icon>
                                    </x-action-button>

                                    <x-action-button x-data="{ tooltip: 'Delete website' }" x-tooltip="tooltip" role="button"
                                        @click="confirmAction({{ $website->id }}, 'destroy', 'Are you sure want to delete?')">
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
        {{ $websites->links('vendor.pagination.default') }}
    </div>
</div>
