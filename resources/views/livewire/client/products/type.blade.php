<div wire:ignore x-data="typeComponent()" @click.away="show = false" class="relative">
    <x-text-input @change="setProductType()" x-model="name" autocomplete="off" @click="show = !show" placeholder="Product type" wire:model="form.product_type" id="type" class="mt-1 block w-full"
        type="text" />
    <div x-show="show" style="display:none"
        class="z-[100] absolute rounded border border-stroke text-black bg-white focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary mt-1 block w-full">
        <label class="block">
            <div @click="show = false; name=null; setProductType()" class="p-2 px-4 flex items-center gap-3 cursor-pointer hover:bg-gray-100">
                <div class="">
                    <p class="font-medium sm:block capitalize">
                        No type
                    </p>
                </div>
            </div>
        </label>
        <template x-for="type in types">
            <label class="block">
                <div @click="show = false; name=type.name; setProductType()" class="p-2 px-4 flex items-center gap-3 cursor-pointer hover:bg-gray-100">
                    <div class="">
                        <p class="font-medium sm:block capitalize" x-text="type.name"></p>
                    </div>
                </div>
            </label>
        </template>
    </div>
</div>
@push('scripts')
    <script>
        function typeComponent() {
            return {
                show: false,
                name: @entangle('form.product_type'),
                types: @js($productTypes),
                setProductType(){
                    Livewire.dispatch('set-product-type', {
                        product_type: this.name
                    });
                }
            }
        }
    </script>
@endpush
