<div class="">
    @php
        $pageTitle = $this->product ? 'Edit Product' : 'Create Product';
        $navigationLinks = [
            ['text' => 'Dashboard', 'link' => route('client.index')],
            ['text' => 'Products', 'link' => route('client.products.index')],
            ['text' => $pageTitle, 'link' => ''],
        ];
        $pageDescription = '';
        $rightSideBtnText = '';
        $rightSideBtnRoute = '';
    @endphp
    <x-admin-breadcrumb :pageTitle=$pageTitle :navigationLinks=$navigationLinks :pageDescription=$pageDescription
        :rightSideBtnText=$rightSideBtnText :rightSideBtnRoute=$rightSideBtnRoute />

    <div class="">
        <form wire:submit.prevent="save" x-data="producutComponent()">
            <div class="grid grid-cols-6 gap-8">
                <div class="col-span-6 xl:col-span-4">
                    <div
                        class="rounded-sm border border-stroke shadow-default mb-7 bg-white dark:border-strokedark dark:bg-boxdark">
                        <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                            <h3 class="font-medium text-black dark:text-white">
                                Product information
                            </h3>
                        </div>
                        <div class="p-7 pt-0">
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="name" :value="__('Name')" />
                                        <x-text-input placeholder="Name" wire:model="form.name" id="name"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="description" :value="__('Description')" />
                                        <x-textarea rows="5" placeholder="Description"
                                            wire:model="form.description" id="description" class="mt-1 block w-full"
                                            type="text" />
                                        <x-input-error :messages="$errors->get('form.description')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div
                        class="rounded-sm border border-stroke shadow-default mt-7 bg-white dark:border-strokedark dark:bg-boxdark">
                        <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                            <h3 class="font-medium text-black dark:text-white">
                                Pricing information
                            </h3>
                        </div>
                        <div class="p-7 pt-0">
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="price" :value="__('Price')" />
                                        <x-text-input @change="price=$event.target.value, processPrice()"
                                            placeholder="Price" wire:model="form.price" id="price" min="0"
                                            class="mt-1 block w-full" type="number" />
                                        <x-input-error :messages="$errors->get('form.price')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="compare_price" :value="__('Compare-at price')" />
                                        <x-text-input @change="compare_price=$event.target.value, processPrice()"
                                            min="0" placeholder="Compare-at price"
                                            wire:model="form.compare_price" id="compare_price" class="mt-1 block w-full"
                                            type="number" />
                                        <x-input-error :messages="$errors->get('form.compare_price')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-toggle-switch id="charge_tax-toggle" wire:model="form.charge_tax"
                                            :label="__('Charge tax on this product')" :value="1" :checked="$this->product && $this->product->charge_tax == '1'
                                                ? true
                                                : false" />
                                        <x-input-error :messages="$errors->get('form.charge_tax')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/3 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="cost_per_item" :value="__('Cost per item')" />
                                        <x-text-input min="0"
                                            @change="cost_per_item=$event.target.value,processPrice()"
                                            placeholder="Cost per item" wire:model="form.cost_per_item"
                                            id="cost_per_item" class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.cost_per_item')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/3 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="profit" :value="__('Profit')" />
                                        <x-text-input x-bind:value="profit" disabled placeholder="Profit"
                                            id="profit" class="mt-1 block w-full" type="text" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/3 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="margin" :value="__('Margin')" />
                                        <x-text-input x-bind:value="margin" disabled placeholder="Margin"
                                            id="margin" class="mt-1 block w-full" type="text" />
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <x-input-label :value="__('Status')" />
                                <x-toggle-switch :labelOn="'Active'" :labelOff="'Inactive'" id="status-toggle"
                                    wire:model="form.status" :label="__('Status')" :value="1" :checked="$this->product && $this->product->status == '1' ? true : false" />
                                <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
                            </div>
                            <div class="mt-5 flex">
                                <x-secondary-button wire:navigate href="{{ route('client.products.index') }}"
                                    class="ms-auto me-2">
                                    Cancel
                                </x-secondary-button>
                                <x-primary-button>
                                    @if ($this->product)
                                        Update product
                                    @else
                                        Create product
                                    @endif
                                </x-primary-button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-span-6 xl:col-span-2">
                    <div class="sticky top-[110px]">
                        <div
                            class="rounded-sm border border-stroke shadow-default  bg-white dark:border-strokedark dark:bg-boxdark">
                            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                                <h3 class="font-medium text-black dark:text-white">
                                    Product picture
                                </h3>
                            </div>
                            <div class="p-7 pt-0 mt-4">
                                <x-image-upload :default="$this->product->default_picture_url ?? file_url('/default.png')" :uploaded="$this->product->picture_url ?? file_url('/default.png')"
                                    :name="'form.picture'"></x-image-upload>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<x-form-error :error="$errors" />
@push('scripts')
    <script>
        function producutComponent() {
            return {
                profit: '--',
                margin: '--',
                cost_per_item: 0,
                price: 0,
                compare_price: 0,
                processPrice() {
                    this.profit = (this.cost_per_item && this.price) ?
                        this.price - this.cost_per_item :
                        '--';

                    this.margin = (this.cost_per_item && this.price > 0) ?
                        ((this.price - this.cost_per_item) / this.price * 100).toFixed(2) + '%' :
                        '--';
                }

            }
        }
    </script>
@endpush
