<div class="">
    @php
        $pageTitle = 'Backups';
        $navigationLinks = [['text' => 'Dashboard', 'link' => route('admin.index')], ['text' => 'Backups', 'link' => '']];
        $pageDescription = '';
        $rightSideBtnText = '';
        $rightSideBtnRoute = '';
    @endphp

    <x-admin-breadcrumb :pageTitle=$pageTitle :navigationLinks=$navigationLinks :pageDescription=$pageDescription
        :rightSideBtnText=$rightSideBtnText :rightSideBtnRoute=$rightSideBtnRoute />
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[220px] px-4 py-4 font-medium text-black dark:text-white xl:pl-11">
                            Backup
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Type
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">

                        </th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($backups as $backup)
                    <tr>
                        <td class="border-b border-[#eee] px-4 py-5 pl-5 dark:border-strokedark">
                            <div class="flex items-center gap-3">
                                <p class="hidden font-medium text-black dark:text-white sm:block capitalize">
                                  {{ basename($backup) }}
                                </p>
                            </div>
                        </td>
                        <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                            {{ str_contains(dirname($backup), 'images') ? 'Image' : 'Database' }}
                        </td>
                        <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-end">
                            <div class="flex items-center">
                                <x-action-button @click="confirmAction('{{ $backup }}', 'restore', 'Are you sure want to restore {{ $backup }}?')" x-data="{ tooltip: 'Restore' }" x-tooltip="tooltip" class="ms-auto me-2"
                                    role="button">
                                    <box-icon size="20px" color="#888" name='rotate-right'></box-icon>
                                </x-action-button>

                                <x-action-button @click="actionConfirmed('{{ $backup }}', 'download')" x-data="{ tooltip: 'Download' }" x-tooltip="tooltip" class=""
                                    role="button">
                                    <box-icon size="20px" color="#888" name='download'></box-icon>
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
        
    </div>
</div>
