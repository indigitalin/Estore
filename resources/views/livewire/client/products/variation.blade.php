<div class="rounded-sm border border-stroke shadow-default mt-7 bg-white dark:border-strokedark dark:bg-boxdark">
    <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
        <h3 class="font-medium text-black dark:text-white">
            Variations
        </h3>
    </div>
    <div x-data="variationComponent()" class="p-7 pt-0">
        <div class="flex flex-wrap -mx-2">
            <div class="w-full md:w-1/1 p-2">
                <div class="mt-2">
                    <x-toggle-switch @change="show = $event.target.checked" id="variation-toggle" :label="'This product has variations'"
                        :value="1" :checked="false" />
                </div>
                <div x-show="show" class="mt-2">
                    Variants here.
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function variationComponent() {
            return {
                show: false,
            }
        }
    </script>
@endpush
