<div class="">
    @php
        $pageTitle = 'Plan details for "' . $plan->name . '"';
        $navigationLinks = [
            ['text' => 'Dashboard', 'link' => route('admin.index')],
            ['text' => 'Plans', 'link' => route('admin.subscriptions.index')],
            ['text' => 'Plans Details', 'link' => ''],
        ];
        $pageDescription = '';
        $rightSideBtnText = '';
        $rightSideBtnRoute = '';
    @endphp
    <x-admin-breadcrumb :pageTitle=$pageTitle :navigationLinks=$navigationLinks :pageDescription=$pageDescription
        :rightSideBtnText=$rightSideBtnText :rightSideBtnRoute=$rightSideBtnRoute />
    <div
        class="overflow-hidden rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="px-4 pb-6  lg:pb-8 xl:pb-11.5">

            <div class="px-6 py-4">
                <table>
                    <tr>
                        <div class="mt-3">
                            <td>
                                Plan Name
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <span class="font-bold">{{ $plan->name }}</span>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="mt-3">
                            <td>
                                Description
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <span class="font-bold">{!! $plan->description !!}</span>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="mt-3">
                            <td>
                                Amount
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <span class="font-bold">{!! $plan->amount !!}</span>
                            </td>
                        </div>
                    </tr>
                    <tr class="mt-3">
                        <div class="mt-3">
                            <td>
                                Validity
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <span class="font-bold">{!! $plan->validity !!}</span>
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="mt-3">
                            <td>
                                Status
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <span class="font-bold">{!! $plan->status_label !!}</span>
                            </td>
                        </div>
                    </tr>
                </table>
                <div class="py-3">
                    <label class="mb-2 font-bold ">Selected Modules</label>
                    <div class=" gap-3 flex flex-wrap -mx-2  mt-4">
                        @foreach ($plan->plan_modules ?? [] as $item)
                            <span
                                class="flex items-center gap-1 inline-block bg-gray-200 rounded-full py-1 pe-5 ps-3 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                <box-icon name='badge-check' color="green"></box-icon>
                                <span>{{ $item->module_details->name }}</span>
                            </span>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
