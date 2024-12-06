<div class="">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Products
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium" href="index.html">Dashboard /</a>
                </li>
                <li class="font-medium text-primary">Products</li>
            </ol>
        </nav>
    </div>
    <div class="">
        <p>Manage product, view edit and delete products</p>
    </div>
    <div class="flex">
        <a class="ms-auto" href="{{ route('client.products.create') }}" wire:navigate>
            <x-primary-button class="mb-4 ms-auto">
                {{ __('Create new product') }}
            </x-primary-button>
        </a>
    </div>
    <div class="rounded-sm shadow-default border border-stroke bg-white">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Name
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Price
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            SKU
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Category
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Status
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Last updated
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 ">
                                        <img src="{{ $product->thumbnail_image_url }}"
                                            class="w-12 h-12 object-cover rounded-full" alt="Brand" />
                                    </div>
                                    <div class="">
                                        <p
                                            class="hidden font-medium max-w-40 truncate text-black dark:text-white sm:block capitalize">
                                            {{ $product->name }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                $0
                            </td>

                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                {{ $product->sku ?? '...' }}
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                <div class="text-xs">{{ $product->category->parent_name ?? null }}</div>
                                {{ $product->category->name ?? '...' }}
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p role="button" @click="actionConfirmed({{ $product->id }}, 'status')"
                                    class="inline-flex rounded-full {{ $product->status == 1 ? 'bg-success' : 'bg-danger' }}  bg-opacity-10 px-3 py-1 text-sm font-medium {{ $product->status == 1 ? 'text-success' : 'text-danger' }} ">
                                    {{ $product->status_label }}
                                </p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark">
                                {{ $product->updated_at->diffForHumans() }}
                            </td>
                            <td class="border-b border-[#eee] px-4 py-4 dark:border-strokedark text-end">
                                <div class="flex items-center">
                                    <x-action-button x-data="{ tooltip: 'Edit product' }" x-tooltip="tooltip" role="button"
                                        class="ms-auto me-2" wire:navigate
                                        href="{{ route('client.products.edit', $product) }}">
                                        <box-icon size="20px" color="#888" name='edit'></box-icon>
                                    </x-action-button>

                                    <x-action-button x-data="{ tooltip: 'Delete product' }" x-tooltip="tooltip" role="button"
                                        @click="confirmAction({{ $product->id }}, 'destroy', 'Are you sure want to delete?')">
                                        <box-icon size="20px" color="#888" name='trash'></box-icon>
                                    </x-action-button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100"
                                class="border-b text-center border-[#eee] px-4 py-4 dark:border-strokedark">
                                No records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $products->links('vendor.pagination.default') }}
    </div>
</div>
