<div class="">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Clients
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium" href="index.html">Dashboard /</a>
                </li>
                <li class="font-medium text-primary">Clients</li>
            </ol>
        </nav>
    </div>
    <div class="">
        <p>Manage clients and companies. Create new client, and view client details.</p>
    </div>
    <div class="flex">
        <a class="ms-auto" href="{{ route('admin.clients.create') }}" wire:navigate>
            <x-primary-button class="mb-4 ms-auto">
                {{ __('Create new client') }}
            </x-primary-button>
        </a>
    </div>
    <div class="rounded-sm shadow-default border border-stroke bg-white">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Client
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Contact person
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Contact
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Created at
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Status
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 ">
                                        <img src="{{ $client->logo_url }}" class="rounded-full w-12 h-12 object-cover rounded-full"
                                            alt="Brand" />
                                    </div>
                                    <div class="">
                                        <p class="hidden font-medium text-black dark:text-white sm:block capitalize">
                                            {{ $client->business_name }}
                                        </p>
                                        <i
                                            class="text-black dark:text-white text-sm capitalize">{{ $client->industry }}</i>
                                    </div>

                                </div>
                            </td>

                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                <div>{{ $client->user->name }}</div>
                                <div>Administrator</div>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                <div class="flex flex-col">
                                    <a href="mailto:{{ $client->user->email }}"><i
                                            class="text-black dark:text-white">{{ $client->user->email }}</i></a>
                                    <a href="tel:{{ $client->user->phone }}"><i
                                            class="text-black dark:text-white">{{ $client->user->phoneNumber }}</i></a>
                                </div>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                {{ $client->created_at }}
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p role="button"
                                    @click="actionConfirmed({{ $client->id }}, 'status')"
                                    class="inline-flex rounded-full {{ $client->status == 1 ? 'bg-success' : 'bg-danger' }}  bg-opacity-10 px-3 py-1 text-sm font-medium {{ $client->status == 1 ? 'text-success' : 'text-danger' }} ">
                                    {{ $client->status_label }}
                                </p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark text-end">
                                <div class="flex items-center">
                                    <x-action-button x-data="{ tooltip: 'View details' }" x-tooltip="tooltip" class="ms-auto me-2"
                                        role="button" wire:navigate href="{{ route('admin.clients.show', $client) }}">
                                        <box-icon size="20px" color="#888" name='show'></box-icon>
                                    </x-action-button>
                                    <x-action-button x-data="{ tooltip: 'Edit client' }" x-tooltip="tooltip" role="button" class="me-2"
                                        wire:navigate href="{{ route('admin.clients.edit', $client) }}">
                                        <box-icon size="20px" color="#888" name='edit'></box-icon>
                                    </x-action-button>

                                    <x-action-button x-data="{ tooltip: 'Delete client' }" x-tooltip="tooltip" role="button"
                                        @click="confirmAction({{ $client->id }}, 'destroy', 'Are you sure want to delete?')">
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
        {{ $clients->links('vendor.pagination.default') }}
    </div>
    @include('livewire.confirm')
</div>
