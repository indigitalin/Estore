<div x-data="vendorComponent()" @click.away="show = false" class="relative">
    <x-text-input @change="setProductVendor()" x-model="name" autocomplete="off" @click="show = !show"
        placeholder="Product vendor" wire:model="form.product_vendor" id="vendor" class="mt-1 block w-full"
        type="text" />
    <div x-show="show" style="display:none"
        class="z-[100] absolute rounded border border-stroke text-black bg-white focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary mt-1 block w-full">
        <label class="block">
            <div @click="show = false; name=null; setProductVendor()"
                class="p-2 px-4 flex items-center gap-3 cursor-pointer hover:bg-gray-100">
                <div class="">
                    <p class="font-medium sm:block capitalize">
                        No vendor
                    </p>
                </div>
            </div>
        </label>
        <template x-for="vendor in vendors">
            <label class="block">
                <div class="w-full flex items-center gap-3 cursor-pointer hover:bg-gray-100">
                    <div @click="show = false; name=vendor.name; setProductVendor()" class="w-full p-2 px-4">
                        <p class="font-medium sm:block capitalize" x-text="vendor.name"></p>
                    </div>
                    <div @click="confirmAction(vendor.id, 'destroy-product-vendor', 'Are you sure want to delete this product vendor?')"
                        class="p-2 px-4">
                        <box-icon name="x-circle" color="#888" class="cursor-pointer"></box-icon>
                    </div>
                </div>
            </label>
        </template>
    </div>
</div>
@push('scripts')
    <script>
        function vendorComponent() {
            return {
                show: false,
                name: @entangle('form.product_vendor'),
                vendors: @js($product_vendors),
                init() {
                    window.addEventListener('productVendorDeleted', (event) => {
                        this.vendors = event.detail[0].product_vendors;
                    });
                },
                setProductVendor() {
                    Livewire.dispatch('set-product-vendor', {
                        product_vendor: this.name
                    });
                }
            }
        }
    </script>
@endpush
