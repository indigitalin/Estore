<div class="">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Roles and responsibilities
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium" href="index.html">Dashboard /</a>
                </li>
                <li class="font-medium text-primary">Roles</li>
            </ol>
        </nav>
    </div>
    <div class="">
        <p>Manage staff roles and permissions. Create new roles, assign permissions, and view role details.</p>
    </div>
    <div class="flex">
        <a class="ms-auto" href="{{ route('admin.roles.create') }}" wire:navigate>
            <x-primary-button class="mb-4 ms-auto">
                {{ __('Create new role') }}
            </x-primary-button>
        </a>
    </div>
    <div class="rounded-sm shadow-default border border-stroke bg-white">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            ID
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Name
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Permissions
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Users
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Last updated
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                {{ $role->id }}
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                {{ $role->name }}
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                <a x-data="{ tooltip: '{{ $role->permissions()->pluck('name')->implode(', ') }}' }" x-tooltip="tooltip" href="#" class="text-indigo-600">
                                    {{ $role->permissions()->count() }}
                                    permissions</a>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                {{ $role->users()->count() }} users
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                {{ $role->created_at->diffForHumans() }}
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                <a x-data="{ tooltip: 'Edit role' }" x-tooltip="tooltip" role="button"
                                href="{{ route('admin.roles.edit', ['role' => $role]) }}" wire:navigate>
                                    <box-icon color="#888" name='edit'></box-icon>
                                </a>
                                <span x-data="{ tooltip: 'Delete role' }" x-tooltip="tooltip" role="button"
                                    @click="confirmAction({{ $role->id }}, 'destroy', 'Are you sure want to delete?')">
                                    <box-icon color="#888" name='trash'></box-icon>
                                </span>
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
    @include('livewire.confirm')
</div>
