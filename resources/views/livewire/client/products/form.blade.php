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
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="category_id" :value="__('Category')" />
                                        <div wire:ignore x-data="categoryComponent()" @click.away="show = false" class="relative">
                                            <div @click="show = !show"
                                                class="flex items-center cursor-pointer rounded border border-stroke py-3 pl-3 pr-3 text-black bg-gray focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary mt-1 w-full">
                                                <div>
                                                    <div x-show="id">
                                                        <div class="flex items-center gap-3 cursor-pointer">
                                                            <div class="flex-shrink-0 ">
                                                                <img :src="image"
                                                                    class="w-8 h-8 object-cover rounded-full"
                                                                    alt="Brand" />
                                                            </div>
                                                            <div class="">
                                                                <p class="font-medium sm:block capitalize"
                                                                    x-text="title"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div x-show="!id">
                                                        Select an option
                                                    </div>
                                                </div>
                                                <div class="ms-auto"><box-icon name='chevron-down'
                                                        color="#888"></box-icon></div>
                                            </div>
                                            <div x-show="show" style="display:none"
                                                class="z-[100] absolute rounded border border-stroke text-black bg-white focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary mt-1 block w-full">
                                                <label for="category_id_0" class="block">
                                                    <div @click="show = false; id = null; title=null; image=null; setCategoryId()"
                                                        class="p-2 px-4 flex items-center gap-3 cursor-pointer">
                                                        <div class="">
                                                            <p class="font-medium sm:block capitalize">
                                                                No category
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <input x-show="false" type="radio" hidden value=""
                                                        name="category_id" id="category_id_0">
                                                </label>
                                                <template x-for="category in categories">
                                                    <div>
                                                        <template x-template-outlet="$refs.treeNodeTemplate"
                                                            x-data="{ category: category, parentCategory:null }">
                                                        </template>
                                                    </div>
                                                </template>
                                                <template x-ref="treeNodeTemplate">
                                                    <div x-init="if (category_id == category.id) selectedCategory = category; selectedCategoryParent:parent">
                                                        <label
                                                            :for="category.childs.length ? '' : 'category_id_' + category.id"
                                                            class="block"
                                                            :class="'category-item parent-' + category.parent_handle">
                                                            <div :class="category.childs.length ? 'hover:bg-gray-100' :
                                                                'hover:bg-gray-200'"
                                                                @click="categorySelected(category, true)"
                                                                class="flex items-center gap-3 cursor-pointer">
                                                                <label :for="'category_id_' + category.id"
                                                                    @click.stop="categorySelected(category)"
                                                                    class="block cursor-pointer">
                                                                    <div :class="category.childs.length ? 'hover:bg-gray-200' : ''"
                                                                        class="p-2 px-4 rounded gap-3 flex items-center">
                                                                        <div class="flex-shrink-0 ">
                                                                            <img :src="category.picture_url"
                                                                                class="w-10 h-10 object-cover rounded-full"
                                                                                alt="Brand" />
                                                                        </div>
                                                                        <div class="">
                                                                            <p x-text="category.name"
                                                                                class="font-medium sm:block capitalize">
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </label>

                                                                <div class="flex items-center ms-auto px-4"
                                                                    x-show="category.childs.length">
                                                                    <box-icon color="#888"
                                                                        name='chevron-right'></box-icon>
                                                                </div>
                                                            </div>
                                                            <input x-show="false" type="radio" hidden
                                                                :value="category.id" name="category_id"
                                                                wire:form="form.category_id"
                                                                :id="'category_id_' + category.id">
                                                        </label>
                                                        <div x-show="category.childs.length">
                                                            <div x-show="category.showChilds">
                                                                <label @click="hideChildCategories(category)"
                                                                    :class="'category-item parent-' + category.handle">
                                                                    <div
                                                                        class="p-2 px-4 flex items-center gap-3 cursor-pointer">
                                                                        <box-icon color="#888"
                                                                            name='left-arrow-alt'></box-icon>
                                                                        <div class=""
                                                                            x-text="category.parent_name">
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                                <template x-for="childNode in category.childs"
                                                                    :key="childNode.id">
                                                                    <div>
                                                                        <template
                                                                            x-template-outlet="$refs.treeNodeTemplate"
                                                                            x-data="{ category: childNode, parentCategory:category }">
                                                                        </template>
                                                                    </div>
                                                                </template>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                                <div x-init="if (selectedCategory) preloadCategory();"></div>
                                            </div>
                                        </div>
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
                        <div class="p-7 pt-0" x-init="processPrice()">
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="price" :value="__('Price')" />
                                        <x-text-input @change="price=$event.target.value, processPrice()"
                                            placeholder="Price" wire:model="form.price" id="price"
                                            min="0" class="mt-1 block w-full" type="number" />
                                        <x-input-error :messages="$errors->get('form.price')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="compare_price" :value="__('Compare-at price')" />
                                        <x-text-input @change="compare_price=$event.target.value, processPrice()"
                                            min="0" placeholder="Compare-at price"
                                            wire:model="form.compare_price" id="compare_price"
                                            class="mt-1 block w-full" type="number" />
                                        <x-input-error :messages="$errors->get('form.compare_price')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-toggle-switch @change="charge_tax = $event.target.checked"
                                            id="charge_tax-toggle" wire:model="form.charge_tax" :label="__('Charge tax on this product')"
                                            :value="1" :checked="$this->product && $this->product->charge_tax == '1'
                                                ? true
                                                : false" />
                                        <x-input-error :messages="$errors->get('form.charge_tax')" class="mt-2" />
                                    </div>
                                </div>
                                <div x-show="charge_tax" class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-toggle-switch @change="custom_tax = $event.target.checked"
                                            id="custom_tax-toggle" wire:model="form.custom_tax" :label="__('Charge custom tax')"
                                            :value="1" :checked="$this->product && $this->product->custom_tax == '1'
                                                ? true
                                                : false" />
                                        <x-input-error :messages="$errors->get('form.custom_tax')" class="mt-2" />
                                    </div>
                                </div>
                                <div x-show="custom_tax && charge_tax" class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="tax_rate" :value="__('Custom tax rate')" />
                                        <x-text-input min="0" placeholder="Custom tax rate"
                                            wire:model="form.tax_rate" id="tax_rate" class="mt-1 block w-full"
                                            type="number" />
                                        <x-input-error :messages="$errors->get('form.tax_rate')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-0"></div>
                                <div class="w-full md:w-1/3 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="cost_per_item" :value="__('Cost per item')" />
                                        <x-text-input min="0"
                                            @change="cost_per_item=$event.target.value,processPrice()"
                                            placeholder="Cost per item" wire:model="form.cost_per_item"
                                            id="cost_per_item" class="mt-1 block w-full" type="number" />
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
                                            <x-input-label for="sku" :value="__('SKU')" />
                                            <x-text-input min="0" placeholder="SKU" wire:model="form.sku"
                                                id="sku" class="mt-1 block w-full" type="text" />
                                            <x-input-error :messages="$errors->get('form.sku')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-toggle-switch @change="track_quantity = $event.target.checked"
                                            id="track_quantity-toggle" wire:model="form.track_quantity"
                                            :label="__('Track quantity')" :value="1" :checked="$this->product && $this->product->track_quantity == '1'
                                                ? true
                                                : false" />
                                        <x-input-error :messages="$errors->get('form.track_quantity')" class="mt-2" />
                                    </div>
                                </div>
                                <div x-show="track_quantity" class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-toggle-switch id="sell_without_stock-toggle"
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
                                            id="physical-toggle" wire:model="form.physical" :label="__('This is a physical product')"
                                            :value="1" :checked="$this->product && $this->product->physical == '1' ? true : false" />
                                        <x-input-error :messages="$errors->get('form.physical')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-0"></div>
                                <div x-show="physical" class="w-full md:w-1/3 p-2">
                                    <div class="mt-2">
                                        <div class="mt-2">
                                            <x-input-label for="weight" :value="__('Weight')" />
                                            <x-text-input min="0" placeholder="Weight"
                                                wire:model="form.weight" id="weight" class="mt-1 block w-full"
                                                type="number" />
                                            <x-input-error :messages="$errors->get('form.weight')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                                <div x-show="physical" class="w-full md:w-1/3 p-2">
                                    <div class="mt-2">
                                        <div class="mt-2">
                                            <x-input-label for="weight_type" :value="__('Weight type')" />
                                            <x-select min="0" :selected="$this->form->weight_type" :options="config('constants.weights')"
                                                placeholder="Weight type" wire:model="form.weight_type"
                                                id="weight_type" class="mt-1 block w-full" type="text" />
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
                                            <x-input-label class="mb-0" for="stores" :value="__('Stores')" />
                                        </div>
                                        @if ($stores->count())
                                            <div x-show="track_quantity" class="w-1/4 p-2">
                                                <x-input-label class="mb-0" for="stores" :value="__('Stock')" />
                                            </div>
                                        @endif
                                    </div>
                                    @forelse ($stores as $store)
                                        <div class="flex flex-wrap items-center -mx-2 border-bottom mb-2">
                                            <div class="w-3/4 p-2">
                                                <x-toggle-switch id="stores-toggle_{{ $store->id }}"
                                                    wire:model="form.stores" :label="__($store->name . ', ' . $store->city)" :value="$store->id"
                                                    :checked="false" />
                                            </div>
                                            <div x-show="track_quantity" class="w-1/4 p-2">
                                                <x-text-input wire:model="form.stocks.{{ $store->id }}"
                                                    min="0" placeholder="Stock"
                                                    id="stocks_{{ $store->id }}" class="mt-1 block w-full"
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
                                            <x-input-label class="mb-0" for="websites" :value="__('Websites')" />
                                        </div>
                                    </div>
                                    @forelse ($websites as $website)
                                        <div class="flex flex-wrap items-center -mx-2 border-bottom mb-2">
                                            <div class="w-3/4 p-2">
                                                <x-toggle-switch id="websites-toggle_{{ $website->id }}"
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
                                        <x-input-label for="seo_title" :value="__('Seo title')" />
                                        <x-text-input placeholder="Seo title" wire:model="form.seo_title"
                                            id="seo_title" class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.seo_title')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="seo_description" :value="__('Seo description')" />
                                        <x-textarea rows="2" placeholder="Seo description"
                                            wire:model="form.seo_description" id="seo_description"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.seo_description')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="seo_keywords" :value="__('Seo keywords')" />
                                        <x-textarea rows="2" placeholder="Seo keywords"
                                            wire:model="form.seo_keywords" id="seo_keywords"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.seo_keywords')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <x-input-label :value="__('Status')" />
                                <x-toggle-switch :labelOn="'Active'" :labelOff="'Inactive'" id="status-toggle"
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

        function categoryComponent() {
            return {
                categories: @js($categories),
                category_id: {{ $this->form->category_id ?? 0 }},
                selectedCategory: null,
                selectedCategoryParent:null,
                show: false,
                id: 0,
                image: null,
                title: null,
                categorySelected(category, subCategorySelection = false) {
                    if (subCategorySelection && category.childs.length) {
                        this.showChildCategories(category);
                    } else {
                        this.show = false;
                        this.id = category.id;
                        this.title = category.name;
                        this.image = category.picture_url;
                    }
                    this.setCategoryId();
                },
                showChildCategories(category) {
                    document.querySelectorAll("label.category-item").forEach(el => {
                        el.style.display = "none";
                    });

                    document.querySelectorAll("label.category-item.parent-" + category.handle).forEach(el => {
                        el.style.display = "block";
                    });
                    category.showChilds = true;
                },
                hideChildCategories(category) {
                    document.querySelectorAll("label.category-item.parent-" + category.parent_handle).forEach(el => {
                        el.style.display = "block";
                    });
                    category.showChilds = false;
                },
                preloadCategory() {
                    this.categorySelected(this.selectedCategory);
                    console.log(this.selectedCategoryParent);
                },
                setCategoryId() {
                    Livewire.dispatch('set-category', {
                        category: this.id
                    });
                }
            }
        }
    </script>
@endpush
