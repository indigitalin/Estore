<div class="">
    @php
        $pageTitle = 'Error Logs';
        $navigationLinks = [['text' => 'Dashboard', 'link' => route('admin.index')], ['text' => 'Error Logs', 'link' => '']];
        $pageDescription = '';
        $rightSideBtnText = '';
        $rightSideBtnRoute = '';
    @endphp

    <x-admin-breadcrumb :pageTitle=$pageTitle :navigationLinks=$navigationLinks :pageDescription=$pageDescription
        :rightSideBtnText=$rightSideBtnText :rightSideBtnRoute=$rightSideBtnRoute />
    <div class="flex">
            <x-danger-button @click="confirmAction('all', 'destroy_all', 'Are you sure want to delete all files?')" class="mb-4 ms-auto">
                Delete all logs
            </x-danger-button>
    </div>
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Error
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Time
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">

                        </th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($filelists as $item)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-5 pl-5 dark:border-strokedark">
                                <div class="flex items-center gap-3">
                                    <p class="hidden font-medium text-black dark:text-white sm:block capitalize">
                                      
                                       {{ str_replace('.html','',str_replace('_','-',$item)) }}
                                    </p>
                                </div>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 pl-5 dark:border-strokedark">
                                <div class="flex items-center gap-3">
                                    <p class="hidden font-medium text-black dark:text-white sm:block capitalize">
                                      
                                       {{ str_replace('.html','',str_replace('_','-',$item)) }}
                                    </p>
                                </div>
                            </td>

                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-end">
                                <div class="flex items-center">
                                    <x-action-button x-data="{ tooltip: 'View details' }" x-tooltip="tooltip" class="ms-auto me-2"
                                        role="button" wire:navigate href="{{ route('admin.logs.show', $item) }}">
                                        <box-icon size="20px" color="#888" name='show'></box-icon>
                                    </x-action-button>
                                 
                                    <x-action-button x-data="{ tooltip: 'Delete log' }" x-tooltip="tooltip" role="button"
                                        @click="confirmAction('{{ str_replace('.html','',$item) }}', 'destroy', 'Are you sure want to delete?')">
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
        {{ $filelists->links('vendor.pagination.default') }}
    </div>
</div>
