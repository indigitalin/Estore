<div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    x-show="showEditingModal" x-cloak class="fixed inset-0 flex items-center justify-center z-[9999]">

    <div class="bg-gray-500 opacity-75 absolute inset-0" @click="showEditingModal = false"></div>

    <div class="bg-white rounded-lg shadow-lg max-w-3xl w-full p-6 z-50">
        <div class="">
            <div class="text-lg font-semibold mb-5" x-text="editingVariation.name"></div>
            <div>
                <div class="text-base mb-3">Price</div>
                <hr>
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-1/2 p-2">
                        <div class="mt-2">
                            <x-input-label :value="__('Price')" />
                            <x-text-input
                                @change="editingVariation.price = $event.target.value; processPrice(editingVariation)"
                                x-bind:value="editingVariation.price" placeholder="Price" min="0"
                                class="mt-1 block w-full" type="number" />
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 p-2">
                        <div class="mt-2">
                            <x-input-label :value="__('Compare-at price')" />
                            <x-text-input min="0"
                                @change="editingVariation.compare_price = $event.target.value; processPrice(editingVariation)"
                                x-bind:value="editingVariation.compare_price" placeholder="Compare-at price"
                                class="mt-1 block w-full" type="number" />
                        </div>
                    </div>
                    <div class="w-full md:w-1/1 p-0"></div>
                    <div class="w-full md:w-1/3 p-2">
                        <div class="mt-2">
                            <x-input-label :value="__('Cost per item')" />
                            <x-text-input
                                @change="editingVariation.cost_per_item = $event.target.value; processPrice(editingVariation)"
                                x-bind:value="editingVariation.cost_per_item" min="0" placeholder="Cost per item"
                                class="mt-1 block w-full" type="number" />
                        </div>
                    </div>
                    <div class="w-full md:w-1/3 p-2">
                        <div class="mt-2">
                            <x-input-label :value="__('Profit')" />
                            <x-text-input x-bind:value="editingVariation.profit" disabled placeholder="Profit"
                                class="mt-1 block w-full" type="text" />
                        </div>
                    </div>
                    <div class="w-full md:w-1/3 p-2">
                        <div class="mt-2">
                            <x-input-label :value="__('Margin')" />
                            <x-text-input x-bind:value="editingVariation.margin" disabled placeholder="Margin"
                                class="mt-1 block w-full" type="text" />
                        </div>
                    </div>
                </div>
                <div class="text-base mb-3 mt-3">Inventory</div>
                <hr>
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-1/2 p-2">
                        <div class="mt-2">
                            <div class="mt-2">
                                <x-input-label :value="__('SKU')" />
                                <x-text-input x-bind:value="editingVariation.sku"
                                    @change="editingVariation.sku = $event.target.value" placeholder="SKU"
                                    class="mt-1 block w-full" type="text" />
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/1 p-0"></div>
                    <div x-show="physical" class="w-full md:w-1/3 p-2">
                        <div class="mt-2">
                            <div class="mt-2">
                                <x-input-label :value="__('Weight')" />
                                <x-text-input x-bind:value="editingVariation.weight"
                                    @change="editingVariation.weight = $event.target.value" min="0"
                                    placeholder="Weight" class="mt-1 block w-full" type="number" />
                            </div>
                        </div>
                    </div>
                    <div x-show="physical" class="w-full md:w-1/3 p-2">
                        <div class="mt-2">
                            <div class="mt-2">
                                <x-input-label :value="__('Weight type')" />
                                <select x-bind:value="editingVariation.weight_type"
                                    @change="editingVariation.weight_type = $event.target.value"
                                    class="relative z-20 w-full appearance-none rounded border border-stroke bg-gray py-3 pl-5 pr-12 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input mt-1 block w-full">
                                    <option selected value="">Select an option</option>
                                    <template x-for="weight_type in weight_types">
                                        <option :value="weight_type" x-text="weight_type"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div x-show="track_quantity && selectedStores.length" class="w-full md:w-1/1 p-2">
                        <div class="flex items-center">
                            <div class="">
                                <x-input-label :value="__('Store')" />
                            </div>
                            <div class="ms-auto">
                                <x-input-label :value="__('Stock')" />
                            </div>
                        </div>
                        <div class="mt-2">
                            <template x-for="store in stores">
                                <div x-show="selectedStores.includes(store.id)" class="flex items-center mb-3">
                                    <div>
                                        <span x-text="store.name" class="font-medium"></span>, <span x-text="store.city"></span>
                                    </div>
                                    <div class="ms-auto">
                                        <x-text-input x-bind:value="(editingVariation.stores.find(s => s.id === store.id) || {}).stock || null" @change="setStock(editingVariation, store, $event.target.value)"
                                            min="0" placeholder="Stock" class="mt-1 block w-full !py-2"
                                            type="number" />
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5 flex">
                <x-secondary-button type="button" @click="showEditingModal = false" class="ms-auto me-2">
                    Close
                </x-secondary-button>
            </div>
        </div>
    </div>
</div>
