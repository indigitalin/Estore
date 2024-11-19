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
                                                        x-bind:value="option_value.name" class="mt-1 block w-full pr-14"
                                                        type="text" />
                                                    <div x-show="option_value.name"
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
                                                <div x-show="option_value.name" x-text="option_value.name"
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
                                                    <input @change="updateVariation('status', $event.target.checked)"
                                                        :id="'variation_' + variation.id"
                                                        x-bind:checked="variation.status" type="checkbox"
                                                        :value="variation.key"
                                                        class="w-5 h-5 text-blue-600 cursor-pointer bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label class="cursor-pointer" :for="'variation_' + variation.id"
                                                        x-text="variation.name"></label>
                                                    {{-- <x-text-input
                                                        @change="updateVariation('variation_name', $event.target.value)"
                                                        autocomplete="off" placeholder="SKU"
                                                        x-bind:value="variation.variation_name" class="mt-1 block w-full !py-2"
                                                        type="text" /> --}}
                                                </div>
                                            </th>
                                            <td class="px-6 py-4">
                                                <div class="cursor-pointer">
                                                    <img class="w-10 h-10 rounded object-cover object-center"
                                                        src="{{ file_url('default.png') }}" alt="">
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <x-text-input @change="updateVariation('price', $event.target.value)"
                                                    autocomplete="off" placeholder="Price"
                                                    x-bind:value="variation.price" class="mt-1 block w-full !py-2"
                                                    type="number" min="0" />
                                            </td>
                                            <td class="px-6 py-4">
                                                <x-text-input @change="updateVariation('sku', $event.target.value)"
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
                options: @js($this->product_options),
                variations: [],
                weight_types: @js(config('constants.weights')),
                editingVariation: {},
                showEditingModal: false,
                stores: @js($stores),
                websites: @js($websites),
                init() {
                    this.setOptions()
                    this.setVariations()
                    this.loadVariations();
                },
                adOption() {
                    this.options.push({
                        id: Math.random().toString(36).substring(2, 12).toUpperCase(),
                        name: null,
                        editing: true,
                        option_values: [{
                            id: Math.random().toString(36).substring(2, 12).toUpperCase(),
                            name: null,
                        }]
                    });
                },
                removeOption(option) {
                    // Remove the option from the options list
                    this.options = this.options.filter(element => element.id !== option.id);

                    // Update variations to remove references to the deleted option
                    const remainingOptionIds = this.options.map(opt => opt.id);

                    this.variations = this.variations.map(variation => {
                        // Filter the option_ids and associated combination values to match remaining options
                        const updatedOptionIds = variation.option_ids.filter(optionId =>
                            remainingOptionIds.includes(optionId)
                        );

                        // Find the corresponding remaining values for the updated option_ids
                        const remainingCombination = updatedOptionIds.map(optionId => {
                            for (let opt of this.options) {
                                const match = opt.option_values.find(val => val.id === optionId);
                                if (match) {
                                    return match;
                                }
                            }
                            return null;
                        }).filter(item => item !== null);

                        const newKey = remainingCombination.map(item => item.name.toLowerCase()).join('-');
                        const newName = remainingCombination.map(item => item.name).join(' / ');

                        return {
                            ...variation,
                            key: newKey,
                            name: newName,
                            option_ids: updatedOptionIds,
                        };
                    });

                    // Reload the variations to ensure consistency
                    this.loadVariations();
                },
                removeOptionValue(option, option_value) {
                    option.option_values = option.option_values.filter(element => element.id !== option_value.id);
                    this.setOptions()
                },
                setOptionName(option, value) {
                    option.name = value && value.trim().length > 0 ? value : null;
                    this.setOptions()
                },
                setOptionValue(option, option_value, value) {
                    option_value.name = null;
                    if (value && value.trim().length > 0) {
                        option_value.name = value;
                        const lastvalue = option.option_values.at(-1);
                        if (lastvalue && lastvalue.name) {
                            option.option_values.push({
                                id: Math.random().toString(36).substring(2, 12).toUpperCase(),
                                name: null,
                            });
                        }
                    } else {
                        option.option_values = option.option_values.filter(
                            element => element.name || element.id == option_value.id
                        );
                    }
                    this.setOptions()
                },
                checkOptionErrors(option) {
                    //Check if name is empty
                    const optionValues = option.option_values.filter(value => value.name != null);
                    if (!option.name) {
                        return 'Please enter option name.';
                    } //Check if option values is empty
                    else if (!optionValues.length) {
                        return "Add atleast one option value.";
                    } //Check if option name is repeated
                    else if (this.options.some(element => element.name === option.name && element.id != option.id)) {
                        return "Option names can not be repeated.";
                    } //Check if option name is repeated
                    else if (this.options.some(element => element.name === option.name && element.id != option.id)) {
                        return "Option names can not be repeated.";
                    } //Check if option name is repeated 
                    else if (optionValues.some((element, index, array) =>
                            array.findIndex(e => e.name.toLowerCase() === element.name.toLowerCase()) !== index
                        )) {
                        return "Option values can not be repeated.";
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
                        // .filter(option => !option.editing)
                        .map(option => ({
                            ...option,
                            option_values: option.option_values.filter(value => value.name != null)
                        }));

                    const optionValuesArrays = options.map(option =>
                        option.option_values.map(value => ({
                            name: value.name,
                            id: value.id,
                            option_id: option.id // Include the option_id to uniquely identify the value
                        }))
                    );

                    if (!optionValuesArrays.length) {
                        this.variations = [];
                        return;
                    }

                    const combinations = this.cartesianProduct(optionValuesArrays);

                    // Helper function to find matching variation by `option_ids`
                    const findMatchingVariationByOptionIds = (combination) => {
                        return this.variations.find(existingVariation => {
                            const existingIds = existingVariation.option_ids || [];
                            const newIds = combination.map(item => item.id);
                            // Match by comparing option value IDs
                            return JSON.stringify(existingIds) === JSON.stringify(newIds.slice(0, existingIds
                                .length));
                        });
                    };

                    // Generate new variations, retaining data for matching combinations
                    this.variations = combinations.map(combination => {
                        const newKey = combination.map(item => item.name.toLowerCase()).join('-');
                        const newName = combination.map(item => item.name).join(' / ');
                        const newOptionIds = combination.map(item => item.id);

                        // Attempt to find a matching existing variation
                        const matchingVariation = findMatchingVariationByOptionIds(combination);
                        return matchingVariation ? {
                                ...matchingVariation,
                                name: newName,
                                key: newKey,
                                variation_name: matchingVariation.variation_name == matchingVariation.name ?
                                    newName : matchingVariation.variation_name,
                                option_ids: newOptionIds
                            } // Retain data
                            :
                            { // Create a new variation for unmatched combinations
                                id: Math.random().toString(36).substring(2, 12).toUpperCase(),
                                key: newKey,
                                name: newName,
                                variation_name: newName,
                                option_ids: newOptionIds, // Store option value IDs for matching
                                price: null,
                                sku: null,
                                stock: null,
                                image: null,
                                status: true,
                            };
                    });
                },
                cartesianProduct(arrays) {
                    return arrays.reduce((acc, curr) =>
                        acc.flatMap(d => curr.map(e => [...d, e])), [
                            []
                        ]);
                },
                editVariation(variation) {
                    this.editingVariation = variation;
                    this.showEditingModal = true;
                    this.processPrice(variation);
                },
                updateVariation(property, value) {
                    this.editingVariation[property] = value;
                    this.processPrice(this.editingVariation);
                    this.setVariations();
                },
                setVariations() {
                    console.log(this.variations);
                },
                processPrice(variation) {
                    variation.profit = (variation.cost_per_item && variation.price) ?
                        variation.price - variation.cost_per_item :
                        '--';

                    variation.margin = (variation.cost_per_item && variation.price > 0) ?
                        ((variation.price - variation.cost_per_item) / variation.price * 100).toFixed(2) + '%' :
                        '--';
                },
                setStock(store, value) {
                    const storeIndex = this.editingVariation.stores.findIndex(s => s.id === store.id);
                    if (storeIndex === -1) {
                        // Store not found, add new store with id and value
                        this.editingVariation.stores.push({
                            id: store.id,
                            stock: value
                        });
                    } else {
                        // Store found, update the value
                        this.editingVariation.stores[storeIndex].stock = value;
                    }
                },
                findStoreStock(variation, store) {
                    const storeIndex = variation.stores.findIndex(s => s.id === store.id);
                    if (storeIndex === -1) {
                        return null;
                    } else {
                        return variation.stores[storeIndex].stock;
                    }
                },
                setOptions() {
                    Livewire.dispatch('set-product-options', {
                        product_options: this.options
                    });
                }
            }
        }
    </script>
@endpush
