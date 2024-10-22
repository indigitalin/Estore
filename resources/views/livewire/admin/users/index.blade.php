<div class="">
    @php
        $pageTitle          =   'Users';
        $navigationLinks    =   [
                                    ['text' => 'Dashboard', 'link' => route('admin.index')],
                                    ['text' => 'Users', 'link' => '']
                                ];
        $pageDescription    = "Showing {$users->count()} users of total {$users->total()}";
        $rightSideBtnText   = 'Create new user';
        $rightSideBtnRoute  = route('admin.users.create');
    @endphp

    <x-admin-breadcrumb 
        :pageTitle=$pageTitle
        :navigationLinks=$navigationLinks 
        :pageDescription=$pageDescription
        :rightSideBtnText=$rightSideBtnText 
        :rightSideBtnRoute=$rightSideBtnRoute
    />

    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[220px] px-4 py-4 font-medium text-black dark:text-white xl:pl-11">
                            User
                        </th>
                        <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                            Contact
                        </th>

                        <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                            Created at
                        </th>
                        <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                            Last login
                        </th>

                        <th class="min-w-[120px] px-4 py-4 font-medium text-black dark:text-white">
                            Status
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                           
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($users as $user)
     
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-5 pl-5 dark:border-strokedark">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 ">
                                        <img src="{{ $user->picture_url }}" class="rounded-full w-12 h-12 object-cover rounded-full" alt="Brand" />
                                    </div>
                                    <div class="">
                                        <p class="hidden font-medium text-black dark:text-white sm:block capitalize">
                                            {{ $user->name }}
                                        </p>
                                        <i class="text-black dark:text-white text-sm capitalize">{{ $user->role_name }}</i>
                                    </div>

                                </div>
                            </td>

                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <div class="flex flex-col">
                                    <a href="mailto:{{ $user->email }}"><i
                                            class="text-black dark:text-white">{{ $user->email }}</i></a>
                                    <a href="tel:{{ $user->phone }}"><i
                                            class="text-black dark:text-white">{{ $user->phoneNumber }}</i></a>
                                </div>
                            </td>

                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <i class="text-black dark:text-white">{{ $user->created_at }}</i>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <i class="text-black dark:text-white">{{ $user->last_login }}</i>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <x-toggle-button id="status-toggle_{{ $user->id }}" wire:model="form.status" :label="$user->status_label"
                                :value="1"  @click="actionConfirmed({{ $user->id }}, 'statusUpdate', 'Are you sure want to change?')" :checked="$user && $user->status == '1' ? true : false" />
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-end">
                                <div class="">
                                    
                                    <a x-data="{ tooltip: 'View details' }" x-tooltip="tooltip" class="ms-auto" role="button" wire:navigate href="{{ route('admin.users.show', $user) }}">
                                        <box-icon color="#888" name='show'></box-icon>
                                    </a>
                                    <a x-data="{ tooltip: 'Edit user' }" x-tooltip="tooltip" role="button" wire:navigate href="{{ route('admin.users.edit', $user) }}">
                                        <box-icon color="#888" name='edit'></box-icon>
                                    </a>

                                    <span x-data="{ tooltip: 'Delete user' }" x-tooltip="tooltip" role="button"
                                        @click="confirmAction({{ $user->id }}, 'destroy', 'Are you sure want to delete?')">
                                        <box-icon  color="#888" name='trash'></box-icon>
                                    </span>
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
        {{ $users->links('vendor.pagination.default') }}
    </div>
    @include('livewire.confirm')
</div>
