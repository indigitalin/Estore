<div class="">
    @php
        $pageTitle = $plan->name;
        $navigationLinks = [
            ['text' => 'Dashboard', 'link' => route('admin.index')],
            ['text' => 'Plans', 'link' => route('admin.subscriptions.index')],
            ['text' => 'Plans Details', 'link' => ''],
        ];
        $pageDescription = '';
        $rightSideBtnText = 'Back to List';
        $rightSideBtnRoute = route('admin.subscriptions.index');
    @endphp
    <x-admin-breadcrumb :pageTitle=$pageTitle :navigationLinks=$navigationLinks :pageDescription=$pageDescription
        :rightSideBtnText=$rightSideBtnText :rightSideBtnRoute=$rightSideBtnRoute />
    <div
        class="overflow-hidden rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="px-4 pb-6  lg:pb-8 xl:pb-11.5">

            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-3">Plan Name : {{ $plan->name }}</div>
                <p class="text-gray-700 text-base mb-3">
                    Description : {!! $plan->description !!}
                </p>
                <p class="text-gray-700 text-base mb-3">
                    Amount : {!! $plan->amount !!}
                </p>
                <p class="text-gray-700 text-base mb-3">
                    Validity : {!! $plan->validity !!}
                </p>
                <p class="text-gray-700 text-base mb-3">
                    Status : {!! $plan->status_label !!}
                </p>
            </div>
            <div class="px-6 pt-4 pb-2">
                <label class="mb-2">Selected Modules</label>
                @foreach($plan->plan_modules ?? [] as $item)
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                        {{ $item->name }}
                    </span>
                @endforeach
            </div>

        </div>
    </div>
</div>
