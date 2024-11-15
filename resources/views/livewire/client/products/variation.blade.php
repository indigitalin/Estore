<div x-data="{ showEditingModal: false }"
    class="rounded-sm border border-stroke shadow-default mt-7 bg-white dark:border-strokedark dark:bg-boxdark">
    <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
        <h3 class="font-medium text-black dark:text-white">
            Variations
        </h3>
    </div>
    <div x-data="variationComponent()" class="p-7 pt-0">
        <div class="flex flex-wrap -mx-2">
            <div class="w-full md:w-1/1 p-2">
                <div class="mt-2">
                    <x-toggle-switch @change="show = has_variations = $event.target.checked" id="variation-toggle"
                        :label="'This product has variations'" :value="1" :checked="false" />
                </div>
                <div x-show="show" class="mt-4">
                    <div>
                        <template x-for="option in options">
                            <div class="mt-2 py-2">
                                <div x-show="option.editing" class="">
                                    <div class="flex items-center gap-2 mb-4">
                                        <div class="w-1/2">
                                            <x-input-label :value="__('Option name')" />
                                            <x-text-input @change="setOptionName(option, $event.target.value)"
                                                x-bind:value="option.name" autocomplete="off"
                                                placeholder="Option name" class="mt-1 block w-full" type="text" />
                                        </div>
                                        <x-action-button class="ms-auto" @click="doneEditing(option)"
                                            x-data="{ tooltip: 'Done editing' }" x-tooltip="tooltip" role="button">
                                            <box-icon size="20px" color="#888" name='check'></box-icon>
                                        </x-action-button>
                                        <x-action-button @click="removeOption(option)" class=""
                                            x-data="{ tooltip: 'Delete option' }" x-tooltip="tooltip" role="button">
                                            <box-icon size="20px" color="#888" name='trash'></box-icon>
                                        </x-action-button>
                                    </div>
                                    <div class="mt-4">
                                        <x-input-label :value="__('Option values')" />
                                        <template x-for="option_value in option.option_values">
                                            <div class="flex w-full">
                                                <div class="w-1/2 relative">
                                                    <x-text-input class=""
                                                        @keyup="setOptionValue(option, option_value, $event.target.value)"
                                                        autocomplete="off" placeholder="Option value"
                                                        x-bind:value="option_value.value"
                                                        class="mt-1 block w-full pr-14" type="text" />
                                                    <div x-show="option_value.value"
                                                        class="absolute top-1/2 left-full transform -translate-x-1/2 -translate-y-1/2 pr-14">
                                                        <box-icon x-data="{ tooltip: 'Delete option value' }" x-tooltip="tooltip"
                                                            role="button"
                                                            @click="removeOptionValue(option, option_value)"
                                                            class="cursor-pointer mt-2" color="#888"
                                                            name='trash'></box-icon>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div x-show="!option.editing">
                                    <div class="flex items-center">
                                        <div class="text-xl font-semibold" x-text="option.name">Size</div>
                                        <x-action-button @click="option.editing = true" class="ms-auto"
                                            x-data="{ tooltip: 'Edit option' }" x-tooltip="tooltip" role="button">
                                            <box-icon size="20px" color="#888" name='edit'></box-icon>
                                        </x-action-button>
                                    </div>
                                    <div>
                                        <div class="flex items-center flex-wrap gap-1">
                                            <template x-for="option_value in option.option_values">
                                                <div x-show="option_value.value" x-text="option_value.value"
                                                    class="bg-indigo-200 p-2 py-1 rounded flex items-center gap-2">
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-2">
                            </div>
                        </template>
                    </div>
                    <div class="flex mt-2">
                        <x-action-button class="w-auto px-2 gap-1" @click="adOption()" x-data="{ tooltip: 'Add new option' }"
                            x-tooltip="tooltip" role="button">
                            <box-icon size="20px" color="#888" name='plus'></box-icon>
                            <span>Add an option</span>
                        </x-action-button>
                    </div>
                    <div class="mt-4" x-show="variations.length">
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Image
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Price
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            SKU
                                        </th>
                                        <th scope="col" class="px-6 py-3">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="variation in variations">
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="flex items-center gap-2">
                                                    <input
                                                        @change="variation.status = $event.target.checked; setVariation()"
                                                        :id="'variation_' + variation.id"
                                                        x-bind:checked="variation.status" type="checkbox"
                                                        :value="variation.key"
                                                        class="w-5 h-5 text-blue-600 cursor-pointer bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label class="cursor-pointer" :for="'variation_' + variation.id"
                                                        x-text="variation.name"></label>
                                                </div>
                                            </th>
                                            <td class="px-6 py-4">
                                                <div class="cursor-pointer">
                                                    <img class="w-10 h-10 rounded object-cover object-center"
                                                        src="{{ file_url('default.png') }}" alt="">
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <x-text-input
                                                    @change="variation.price = $event.target.value; setVariation()"
                                                    autocomplete="off" placeholder="Price"
                                                    x-bind:value="variation.price" class="mt-1 block w-full !py-2"
                                                    type="number" min="0" />
                                            </td>
                                            <td class="px-6 py-4">
                                                <x-text-input
                                                    @change="variation.sku = $event.target.value; setVariation()"
                                                    autocomplete="off" placeholder="SKU" x-bind:value="variation.sku"
                                                    class="mt-1 block w-full !py-2" type="text" />
                                            </td>
                                            <td class="px-6 py-4">
                                                <x-action-button @click="editVariation(variation)" class="ms-auto"
                                                    x-data="{ tooltip: 'Edit variation' }" x-tooltip="tooltip" role="button">
                                                    <box-icon size="20px" color="#888"
                                                        name='edit'></box-icon>
                                                </x-action-button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('livewire.client.products.variation-edit')
    </div>
</div>
@push('scripts')
    <script>
        function variationComponent() {
            return {
                show: true,
                options: [],
                variations: [],
                weight_types: @js(config('constants.weights')),
                editingVariation: {},
                showEditingModal: false,
                stores: @js($stores),
                websites: @js($websites),
                init() {
                    this.options.push({
                        id: Math.floor(100000 + Math.random() * 900000),
                        name: 'Size',
                        editing: false,
                        option_values: [{
                            id: Math.floor(100000 + Math.random() * 900000),
                            value: 'Small',
                        }, {
                            id: Math.floor(100000 + Math.random() * 900000),
                            value: 'Large',
                        }, {
                            id: Math.floor(100000 + Math.random() * 900000),
                            value: null,
                        }]
                    }, {
                        id: Math.floor(100000 + Math.random() * 900000),
                        name: 'Color',
                        editing: false,
                        option_values: [{
                            id: Math.floor(100000 + Math.random() * 900000),
                            value: 'White',
                        }, {
                            id: Math.floor(100000 + Math.random() * 900000),
                            value: 'Black',
                        }, {
                            id: Math.floor(100000 + Math.random() * 900000),
                            value: null,
                        }]
                    });
                    this.loadVariations();
                },
                adOption() {
                    this.options.push({
                        id: Math.floor(100000 + Math.random() * 900000),
                        name: null,
                        editing: true,
                        option_values: [{
                            id: Math.floor(100000 + Math.random() * 900000),
                            value: null,
                        }]
                    });
                },
                removeOption(option) {
                    this.options = this.options.filter(element => element.id !== option.id);
                    this.loadVariations();
                },
                removeOptionValue(option, option_value) {
                    option.option_values = option.option_values.filter(element => element.id !== option_value.id);
                },
                setOptionName(option, value) {
                    option.name = value && value.trim().length > 0 ? value : null;
                },
                setOptionValue(option, option_value, value) {
                    option_value.value = null;
                    if (value && value.trim().length > 0) {
                        option_value.value = value;
                        const lastvalue = option.option_values.at(-1);
                        if (lastvalue && lastvalue.value) {
                            option.option_values.push({
                                id: Math.floor(100000 + Math.random() * 900000),
                                value: null,
                            });
                        }
                    } else {
                        option.option_values = option.option_values.filter(
                            element => element.value || element.id == option_value.id
                        );
                    }
                },
                checkOptionErrors(option) {
                    //Check if name is empty
                    const optionValues = option.option_values.filter(value => value.value != null);
                    if (!option.name) {
                        return 'Please enter option name.';
                    } //Check if option name is repeated
                    else if (this.options.some(element => element.name === option.name && element.id != option.id)) {
                        return "Option names can not be repeated.";
                    } //Check if option name is repeated 
                    else if (optionValues.some((element, index, array) =>
                            array.findIndex(e => e.value.toLowerCase() === element.value.toLowerCase()) !== index
                        )) {
                        return "Option values can not be repeated."
                        ''
                    } else {
                        return false;
                    }
                },
                doneEditing(option) {
                    const error = this.checkOptionErrors(option);
                    if (error) {
                        Toaster.warning(error)
                    } else {
                        option.editing = false;
                        this.loadVariations();
                    }
                },
                loadVariations() {
                    const options = this.options
                        .filter(option => !option.editing)
                        .map(option => ({
                            ...option,
                            option_values: option.option_values.filter(value => value.value != null)
                        }));

                    // Map option values to arrays of objects with both 'value' and 'id'
                    const optionValuesArrays = options.map(option => option.option_values.map(value => ({
                        value: value.value,
                        id: value.id,
                        option_id: option.id
                    })));

                    // Generate the Cartesian product with both value and id
                    const combinations = this.cartesianProduct(optionValuesArrays);

                    const result = combinations.map(combination => {
                        // Generate the combination key by joining the values of the selected options
                        const combinationKey = combination.map(item => item.value).join('-').toLowerCase();

                        return {
                            id: Math.floor(100000 + Math.random() * 900000),
                            key: combinationKey, // Key as combination of values
                            name: combination.map(item => item.value).join(' / '), // Name as combination of values
                            price: null,
                            compare_price: null,
                            cost_per_item: null,
                            stores: [],
                            sku: null,
                            stock: null,
                            image: null,
                            status: true,
                            option_id: combination.map(item => item.id).join('-').toLowerCase(),
                            option_ids: combination.map(item => item.id), // Array of option_ids for the combination
                        };
                    });
                    //this.variations = result;
                    variations = this.variations;
                    this.variations = [];
                    // Loop through each combination in result and check if it exists in this.variations
                    result.forEach(newVariation => {
                        // Check if there's already a variation with the same option_ids
                        const existingVariation = variations.find(existing =>
                            existing.option_id === newVariation.option_id
                        );

                        if (existingVariation) {
                            // If a variation with the same option_ids exists, update only name and key
                            existingVariation.name = newVariation.name;
                            existingVariation.key = newVariation.key;
                            this.variations.push(existingVariation);
                        } else {
                            // If no match is found, push the entire new variation
                            this.variations.push(newVariation);
                        }
                    });
                },

                cartesianProduct(arrays) {
                    return arrays.reduce((acc, curr) =>
                        acc.flatMap(d => curr.map(e => [...d, e])), [
                            []
                        ]);
                },
                setVariation() {
                    //
                },
                editVariation(variation) {
                    this.editingVariation = variation;
                    this.showEditingModal = true;
                    this.processPrice(variation);
                },
                processPrice(variation) {
                    variation.profit = (variation.cost_per_item && variation.price) ?
                        variation.price - variation.cost_per_item :
                        '--';

                    variation.margin = (variation.cost_per_item && variation.price > 0) ?
                        ((variation.price - variation.cost_per_item) / variation.price * 100).toFixed(2) + '%' :
                        '--';
                },
                setStock(variation, store, value) {
                    const storeIndex = variation.stores.findIndex(s => s.id === store.id);
                    if (storeIndex === -1) {
                        // Store not found, add new store with id and value
                        variation.stores.push({
                            id: store.id,
                            stock: value
                        });
                    } else {
                        // Store found, update the value
                        variation.stores[storeIndex].stock = value;
                    }
                },
                findStoreStock(variation, store) {
                    const storeIndex = variation.stores.findIndex(s => s.id === store.id);
                    if (storeIndex === -1) {
                        return null;
                    } else {
                        return variation.stores[storeIndex].stock;
                    }
                }
            }
        }
    </script>
@endpush
