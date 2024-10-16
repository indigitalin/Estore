<div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
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
        <x-primary-button wire:click="$dispatch('openModal', { component: 'admin.roles.modal' })" class="mb-4 ms-auto">
            Create new role
        </x-primary-button>
    </div>
    <div class="rounded-sm border border-stroke bg-white">
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
                                <a wire:click="$dispatch('openModal', { component: 'admin.roles.permissions', arguments: { role: {{ $role }} }})"
                                    href="#" class="text-indigo-600"> {{ $role->permissions()->count() }}
                                    permissions</a>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                {{ $role->created_at->diffForHumans() }}
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark text-end">
                                <span role="button"
                                    wire:click="$dispatch('openModal', { component: 'admin.roles.modal', arguments: { role: {{ $role }} }})">
                                    <box-icon name='edit'></box-icon>
                                </span>
                                {{-- <span role="button"@click="if (confirm('Are you sure you want to delete this role?')) $wire.destroy({{ $role->id }})">
                                    <box-icon name='trash'></box-icon>
                                </span> --}}
                                <span role="button"
                                    wire:click="$dispatch('openModal', { component: 'admin.roles.deleteRole', arguments: { roleId: {{ $role->id }} }})">
                                    <box-icon name='trash'></box-icon>
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
</div>
