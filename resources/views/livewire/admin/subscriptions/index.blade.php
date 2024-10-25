<div class="">
    @php
        $pageTitle = 'Subscription Plans';
        $navigationLinks = [['text' => 'Dashboard', 'link' => route('admin.index')], ['text' => 'Subscription Plans', 'link' => '']];
        $pageDescription = 'Manage your subscrptions plans easily. Search, view, and edit the information.';
        $rightSideBtnText = 'Create new Plan';
        $rightSideBtnRoute = route('admin.subscriptions.create');
    @endphp

    <x-admin-breadcrumb :pageTitle=$pageTitle :navigationLinks=$navigationLinks :pageDescription=$pageDescription
        :rightSideBtnText=$rightSideBtnText :rightSideBtnRoute=$rightSideBtnRoute />

    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[220px] px-4 py-4 font-medium text-black dark:text-white xl:pl-11">
                            Name
                        </th>
                        <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                            Validity
                        </th>
                        <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                            Amount
                        </th>
                        <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                            Last Modified at
                        </th>
                        <th class="min-w-[120px] px-4 py-4 font-medium text-black dark:text-white">
                            Status
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">

                        </th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($plans as $plan)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-5 pl-5 dark:border-strokedark">
                                <div class="flex items-center gap-3">
                                    <p class="hidden font-medium text-black dark:text-white sm:block capitalize">
                                        {{ $plan->name }}
                                    </p>
                                </div>
                            </td>

                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <div class="flex items-center gap-3">
                                    <p class="hidden font-medium text-black dark:text-white sm:block capitalize">
                                        {{ $plan->validity }}
                                    </p>
                                </div>
                            </td>

                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <div class="flex items-center gap-3">
                                    <p class="hidden font-medium text-black dark:text-white sm:block capitalize">
                                        {{ $plan->amount }}
                                    </p>
                                </div>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <div class="flex items-center gap-3">
                                    <p class="hidden font-medium text-black dark:text-white sm:block capitalize">
                                        {{ $plan->last_modified }}
                                    </p>
                                </div>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p role="button"
                                    @click="actionConfirmed({{ $plan->id }}, 'status')"
                                    class="inline-flex rounded-full {{ $plan->status == 1 ? 'bg-success' : 'bg-danger' }}  bg-opacity-10 px-3 py-1 text-sm font-medium {{ $plan->status == 1 ? 'text-success' : 'text-danger' }} ">
                                    {{ $plan->status_label }}
                                </p>

                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-end">
                                <div class="flex items-center">
                                    <x-action-button x-data="{ tooltip: 'View details' }" x-tooltip="tooltip" class="ms-auto me-2"
                                        role="button" wire:navigate href="{{ route('admin.subscriptions.show', $plan) }}">
                                        <box-icon size="20px" color="#888" name='show'></box-icon>
                                    </x-action-button>
                                    <x-action-button x-data="{ tooltip: 'Edit plan' }" x-tooltip="tooltip" role="button" class="me-2"
                                        wire:navigate href="{{ route('admin.subscriptions.edit', $plan) }}">
                                        <box-icon size="20px" color="#888" name='edit'></box-icon>
                                    </x-action-button>

                                    <x-action-button x-data="{ tooltip: 'Delete plan' }" x-tooltip="tooltip" role="button"
                                        @click="confirmAction({{ $plan->id }}, 'destroy', 'Are you sure want to delete?')">
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
        {{ $plans->links('vendor.pagination.default') }}
    </div>
</div>
