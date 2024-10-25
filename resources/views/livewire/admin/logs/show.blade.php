<div class="">
    @php
        $pageTitle = 'Error Log details for "' . $fileName . '"';
        $navigationLinks = [
            ['text' => 'Dashboard', 'link' => route('admin.index')],
            ['text' => 'Error Logs', 'link' => route('admin.logs.index')],
            ['text' => 'Error Log Details', 'link' => ''],
        ];
        $pageDescription = '';
        $rightSideBtnText = '';
        $rightSideBtnRoute = '';
    @endphp
    <x-admin-breadcrumb :pageTitle=$pageTitle :navigationLinks=$navigationLinks :pageDescription=$pageDescription
        :rightSideBtnText=$rightSideBtnText :rightSideBtnRoute=$rightSideBtnRoute />
    <div
        class="overflow-hidden rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="">

            <div class="">
                {!! $log !!}
            </div>
        </div>
    </div>
</div>
