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
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label :value="__('Name')" />
                                        <x-text-input placeholder="Name" wire:model="form.name"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label :value="__('Description')" />
                                        <x-textarea rows="5" placeholder="Description"
                                            wire:model="form.description" class="mt-1 block w-full"
                                            type="text" />
                                        <x-input-error :messages="$errors->get('form.description')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label :value="__('Category')" />
                                        @include('livewire.client.products.category')
                                        <div class="text-sm">Determines tax rates and adds metafields to improve
                                            search,
                                            filters, and cross-channel sales</div>
                                        <x-input-error :messages="$errors->get('form.category_id')" class="mt-2" />
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
                                        <x-input-label :value="__('Price')" />
                                        <x-text-input @change="price=$event.target.value, processPrice()"
                                            placeholder="Price" wire:model="form.price" min="0"
                                            class="mt-1 block w-full" type="number" />
                                        <x-input-error :messages="$errors->get('form.price')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label :value="__('Compare-at price')" />
                                        <x-text-input @change="compare_price=$event.target.value, processPrice()"
                                            min="0" placeholder="Compare-at price"
                                            wire:model="form.compare_price" class="mt-1 block w-full"
                                            type="number" />
                                        <x-input-error :messages="$errors->get('form.compare_price')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-toggle-switch @change="charge_tax = $event.target.checked"
                                            id="charge_tax" wire:model="form.charge_tax" :label="__('Charge tax on this product')"
                                            :value="1" :checked="$this->product && $this->product->charge_tax == '1'
                                                ? true
                                                : false" />
                                        <x-input-error :messages="$errors->get('form.charge_tax')" class="mt-2" />
                                    </div>
                                </div>
                                <div x-show="charge_tax" class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-toggle-switch @change="custom_tax = $event.target.checked"
                                            id="custom_tax" wire:model="form.custom_tax" :label="__('Charge custom tax')"
                                            :value="1" :checked="$this->product && $this->product->custom_tax == '1'
                                                ? true
                                                : false" />
                                        <x-input-error :messages="$errors->get('form.custom_tax')" class="mt-2" />
                                    </div>
                                </div>
                                <div x-show="custom_tax && charge_tax" class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label :value="__('Custom tax rate')" />
                                        <x-text-input min="0" placeholder="Custom tax rate"
                                            wire:model="form.tax_rate" class="mt-1 block w-full"
                                            type="number" />
                                        <x-input-error :messages="$errors->get('form.tax_rate')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-0"></div>
                                <div class="w-full md:w-1/3 p-2">
                                    <div class="mt-2">
                                        <x-input-label :value="__('Cost per item')" />
                                        <x-text-input min="0"
                                            @change="cost_per_item=$event.target.value,processPrice()"
                                            placeholder="Cost per item" wire:model="form.cost_per_item"
                                             class="mt-1 block w-full" type="number" />
                                        <x-input-error :messages="$errors->get('form.cost_per_item')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/3 p-2">
                                    <div class="mt-2">
                                        <x-input-label :value="__('Profit')" />
                                        <x-text-input x-bind:value="profit" disabled placeholder="Profit"
                                            id="profit" class="mt-1 block w-full" type="text" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/3 p-2">
                                    <div class="mt-2">
                                        <x-input-label :value="__('Margin')" />
                                        <x-text-input x-bind:value="margin" disabled placeholder="Margin" class="mt-1 block w-full" type="text" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div
                        class="rounded-sm border border-stroke shadow-default mt-7 bg-white dark:border-strokedark dark:bg-boxdark">
                        <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                            <h3 class="font-medium text-black dark:text-white">
                                Inventory
                            </h3>
                        </div>
                        <div class="p-7 pt-0">
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <div class="mt-2">
                                            <x-input-label :value="__('SKU')" />
                                            <x-text-input min="0" placeholder="SKU" wire:model="form.sku" class="mt-1 block w-full" type="text" />
                                            <x-input-error :messages="$errors->get('form.sku')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-toggle-switch @change="track_quantity = $event.target.checked"
                                            id="track_quantity" wire:model="form.track_quantity"
                                            :label="__('Track quantity')" :value="1" :checked="$this->product && $this->product->track_quantity == '1'
                                                ? true
                                                : false" />
                                        <x-input-error :messages="$errors->get('form.track_quantity')" class="mt-2" />
                                    </div>
                                </div>
                                <div x-show="track_quantity" class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-toggle-switch id="sell_without_stock"
                                            wire:model="form.sell_without_stock" :label="__('Continue selling when out of stock')" :value="1"
                                            :checked="$this->product && $this->product->sell_without_stock == '1'
                                                ? true
                                                : false" />
                                        <x-input-error :messages="$errors->get('form.sell_without_stock')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-toggle-switch @change="physical = $event.target.checked"
                                            id="physical" wire:model="form.physical" :label="__('This is a physical product')"
                                            :value="1" :checked="$this->product && $this->product->physical == '1' ? true : false" />
                                        <x-input-error :messages="$errors->get('form.physical')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-0"></div>
                                <div x-show="physical" class="w-full md:w-1/3 p-2">
                                    <div class="mt-2">
                                        <div class="mt-2">
                                            <x-input-label :value="__('Weight')" />
                                            <x-text-input min="0" placeholder="Weight"
                                                wire:model="form.weight" class="mt-1 block w-full"
                                                type="number" />
                                            <x-input-error :messages="$errors->get('form.weight')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                                <div x-show="physical" class="w-full md:w-1/3 p-2">
                                    <div class="mt-2">
                                        <div class="mt-2">
                                            <x-input-label :value="__('Weight type')" />
                                            <x-select min="0" :selected="$this->form->weight_type" :options="config('constants.weights')"
                                                placeholder="Weight type" wire:model="form.weight_type" class="mt-1 block w-full" type="text" />
                                            <x-input-error :messages="$errors->get('form.weight_type')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div
                        class="rounded-sm border border-stroke shadow-default mt-7 bg-white dark:border-strokedark dark:bg-boxdark">
                        <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                            <h3 class="font-medium text-black dark:text-white">
                                Stores
                            </h3>
                        </div>
                        <div class="p-7 pt-0">
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="flex flex-wrap -mx-2">
                                        <div class="w-3/4 p-2">
                                            <x-input-label class="mb-0" :value="__('Stores')" />
                                        </div>
                                        @if ($stores->count())
                                            <div x-show="track_quantity && !has_variations" class="w-1/4 p-2">
                                                <x-input-label class="mb-0" :value="__('Stock')" />
                                            </div>
                                        @endif
                                    </div>
                                    @forelse ($stores as $store)
                                        <div class="flex flex-wrap items-center -mx-2 border-bottom mb-2">
                                            <div class="w-3/4 p-2">
                                                <x-toggle-switch  @change="$event.target.checked ? selectedStores.push({{ $store->id }}) : selectedStores.splice(selectedStores.indexOf({{ $store->id }}), 1)" id="stores_{{ $store->id }}"
                                                    wire:model="form.stores" :label="__($store->name . ', ' . $store->city)" :value="$store->id"
                                                    :checked="false" />
                                            </div>
                                            <div x-show="track_quantity && !has_variations" class="w-1/4 p-2">
                                                <x-text-input wire:model="form.stocks.{{ $store->id }}"
                                                    min="0" placeholder="Stock" class="mt-1 block w-full !py-2"
                                                    type="number" />
                                            </div>
                                        </div>
                                    @empty
                                        <div
                                            class="flex w-full border-l-6 border-warning bg-warning bg-opacity-[15%] px-4 py-5 dark:bg-[#1B1B24] dark:bg-opacity-30">
                                            <div class="w-full">
                                                You dont have any stores created, please create one.
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="rounded-sm border border-stroke shadow-default mt-7 bg-white dark:border-strokedark dark:bg-boxdark">
                        <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                            <h3 class="font-medium text-black dark:text-white">
                                Websites
                            </h3>
                        </div>
                        <div class="p-7 pt-0">
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="flex flex-wrap -mx-2">
                                        <div class="w-3/4 p-2">
                                            <x-input-label class="mb-0" :value="__('Websites')" />
                                        </div>
                                    </div>
                                    @forelse ($websites as $website)
                                        <div class="flex flex-wrap items-center -mx-2 border-bottom mb-2">
                                            <div class="w-3/4 p-2">
                                                <x-toggle-switch id="websites_{{ $website->id }}"
                                                    wire:model="form.websites" :label="__($website->name)" :value="$website->id"
                                                    :checked="false" />
                                            </div>
                                        </div>
                                    @empty
                                        <div
                                            class="flex w-full border-l-6 border-warning bg-warning bg-opacity-[15%] px-4 py-5 dark:bg-[#1B1B24] dark:bg-opacity-30">
                                            <div class="w-full">
                                                You dont have any websites created, please create one.
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('livewire.client.products.variation')
                    <div
                        class="rounded-sm border border-stroke shadow-default mt-7 bg-white dark:border-strokedark dark:bg-boxdark">
                        <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                            <h3 class="font-medium text-black dark:text-white">
                                Seo settings
                            </h3>
                        </div>
                        <div class="p-7 pt-0">
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label :value="__('Seo title')" />
                                        <x-text-input placeholder="Seo title" wire:model="form.seo_title" class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.seo_title')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label :value="__('Seo description')" />
                                        <x-textarea rows="2" placeholder="Seo description"
                                            wire:model="form.seo_description"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.seo_description')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label :value="__('Seo keywords')" />
                                        <x-textarea rows="2" placeholder="Seo keywords"
                                            wire:model="form.seo_keywords"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.seo_keywords')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <x-input-label :value="__('Status')" />
                                <x-toggle-switch :labelOn="'Active'" :labelOff="'Inactive'" id="status"
                                    wire:model="form.status" :label="__('Status')" :value="1"
                                    :checked="$this->product && $this->product->status == '1' ? true : false" />
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
                        <div
                            class="rounded-sm border border-stroke shadow-default mt-7 bg-white dark:border-strokedark dark:bg-boxdark">
                            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                                <h3 class="font-medium text-black dark:text-white">
                                    Additional information
                                </h3>
                            </div>
                            <div class="p-7 pt-0 mt-4">
                                <div class="mt-2 py-2">
                                    <x-input-label :value="__('Type')" />
                                    @include('livewire.client.products.type')
                                    <x-input-error :messages="$errors->get('form.type')" class="mt-2" />
                                </div>
                                <div class="mt-2 py-2">
                                    <x-input-label :value="__('Collections')" />
                                    @include('livewire.client.products.collection')
                                    <x-input-error :messages="$errors->get('form.collections')" class="mt-2" />
                                </div>
                                <div class="mt-2 py-2">
                                    <x-input-label :value="__('Vendor')" />
                                    @include('livewire.client.products.vendor')
                                    <x-input-error :messages="$errors->get('form.vendor')" class="mt-2" />
                                </div>
                                <div class="mt-2 py-2">
                                    <x-input-label :value="__('Tags')" />
                                    @include('livewire.client.products.tags')
                                    <x-input-error :messages="$errors->get('form.tags')" class="mt-2" />
                                </div>
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
                cost_per_item: {{ $this->form->cost_per_item ?? 0 }},
                price: {{ $this->form->price ?? 0 }},
                compare_price: {{ $this->form->compare_price ?? 0 }},
                charge_tax: {{ $this->form->charge_tax == '1' ? 1 : 0 }},
                tax_rate: {{ $this->form->tax_rate ?? 0 }},
                custom_tax: {{ $this->form->custom_tax == '1' ? 1 : 0 }},
                physical: {{ $this->form->physical == '1' ? 1 : 0 }},
                track_quantity: {{ $this->form->track_quantity == '1' ? 1 : 0 }},
                selectedStores: @js($this->form->stores),
                has_variations:@entangle('form.has_variations'),
                init(){
                    this.processPrice();
                },
                processPrice() {
                    this.profit = (this.cost_per_item && this.price) ?
                        this.price - this.cost_per_item :
                        '--';

                    this.margin = (this.cost_per_item && this.price > 0) ?
                        ((this.price - this.cost_per_item) / this.price * 100).toFixed(2) + '%' :
                        '--';
                },
            }
        }
    </script>
@endpush
