<?php
namespace App\Livewire\Client\Products;

use App\Livewire\Form;
use App\Models\Product;
use Livewire\Attributes\On;

class ProductForm extends Form
{
    public ?Product $product = null;
    public string|null $name = null;
    public string|null $handle = null;
    public string|null $status = null;
    public string|null $description = null;
    public array|null $stores = [];
    public array|null $stocks = [];
    public array|null $websites = [];
    public array|null $collections = [];

    public string|null $seo_title = null;
    public string|null $seo_keywords = null;
    public string|null $seo_description = null;
    public string|null $track_quantity = null;
    public string|null $physical = null;
    public string|null $weight = null;
    public string|null $weight_type = null;
    public string|null $sell_without_stock = null;
    public string|null $sku = null;
    public string|null $category_id = null;
    public float|null $price = null;
    public float|null $compare_price = null;
    public float|null $cost_per_item = null;
    public string|null $charge_tax = null;
    public string|null $custom_tax = null;
    public float|null $tax_rate = null;
    public string|null $product_type = null;
    public string|null $product_vendor = null;

    public int|null $product_type_id = null;
    public int|null $product_vendor_id = null;

    public function setProduct(?Product $product = null): void
    {
        $this->product = $product;

        // Use null coalescing operator to safely assign values
        $this->name = $product->name ?? null;
        $this->handle = $product->handle ?? null;
        $this->status = $product->status ?? null;
        $this->description = $product->description ?? null;
        $this->seo_title = $product->seo_title ?? null;
        $this->seo_description = $product->seo_description ?? null;
        $this->seo_keywords = $product->seo_keywords ?? null;
        $this->track_quantity = $product->track_quantity ?? '0';
        $this->physical = $product->physical ?? '0';
        $this->weight = $product->weight ?? null;
        $this->weight_type = $product->weight_type ?? null;
        $this->sell_without_stock = $product->sell_without_stock ?? '0';
        $this->sku = $product->sku ?? null;
        $this->category_id = $product->category_id ?? null;
        $this->price = $product->price ?? null;
        $this->compare_price = $product->compare_price ?? null;
        $this->cost_per_item = $product->cost_per_item ?? null;
        $this->charge_tax = $product->charge_tax ?? '0';
        $this->custom_tax = $product->custom_tax ?? '0';
        $this->tax_rate = $product->tax_rate ?? null;
        $this->websites = $product->websites->pluck('id')->toArray();
        $this->stores = $product->stores->pluck('id')->toArray();
        $this->stocks = $product->stores->pluck('pivot.quantity', 'id')->toArray();

        $this->collections = $product->collections->pluck('id')->toArray();

        $this->product_type = $product->product_type_name;
        $this->product_vendor = $product->product_vendor_name;
    }

    public function save()
    {

        $this->prepareValidation();
        $this->validate();
        try {
            if ($this->product) {
                // Create new product
                $this->product->update($this->only(['name', 'handle', 'status', 'description']));
            } else {
                // Update existing product
                $this->product = auth()->user()->client->products()->create(
                    $this->only(['name', 'handle', 'status', 'description'])
                );
            }
            $this->product->update($this->only([
                'seo_title',
                'seo_keywords',
                'seo_description',
                'track_quantity',
                'physical_product',
                'weight',
                'weight_type',
                'sell_without_stock',
                'sku',
                'category_id',
                'price',
                'compare_price',
                'cost_per_item',
                'charge_tax',
                'custom_tax',
                'tax_rate',
                'product_type_id',
                'product_vendor_id',
            ]));

            $this->product->stores()->sync([]);
            $this->product->websites()->sync([]);
            $this->product->collections()->sync([]);

            /**
             * Sync websites of the product
             */
            $this->product->websites()->sync($this->websites);

            /**
             * Sync stores of the product
             */

            foreach ($this->stores as $key => $store) {
                $this->product->stores()->attach($store, [
                    'quantity' => ($this->stocks[$store] ?? null),
                ]);
            }

            /**
             * Sync websites of the product
             */
            $this->product->collections()->sync($this->collections);
            return ([
                'status' => 'success',
                'message' => $this->product->wasRecentlyCreated ? 'Product created successfully.' : 'Product updated successfully.',
                'redirect' => route('client.products.index'),
            ]);

        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    /**
     * Before validation, prepare the values and do necessary changes
     */
    public function prepareValidation(): void
    {
        /**
         * Product type configuration
         */
        if ($this->product_type) {
            $product_type = auth()->user()->client->product_types()->firstOrCreate([
                'name' => $this->product_type,
            ], [
                'handle' => $this->product_type,
            ]);
            $this->product_type_id = $product_type->id;
        }

        /**
         * Product vendor configuration
         */
        if ($this->product_vendor) {
            $product_vendor = auth()->user()->client->product_vendors()->firstOrCreate([
                'name' => $this->product_vendor,
            ], [
                'handle' => $this->product_vendor,
            ]);
            $this->product_vendor_id = $product_vendor->id;
        }

        $this->handle = \Illuminate\Support\Str::slug($this->name);
        $this->status = isset($this->status) && $this->status ? '1' : '0';

        $this->track_quantity = isset($this->track_quantity) && $this->track_quantity ? '1' : '0';
        $this->physical_product = isset($this->physical_product) && $this->physical_product ? '1' : '0';
        $this->charge_tax = isset($this->charge_tax) && $this->charge_tax ? '1' : '0';
        $this->sell_without_stock = isset($this->sell_without_stock) && $this->sell_without_stock ? '1' : '0';
        $this->custom_tax = isset($this->custom_tax) && $this->custom_tax ? '1' : '0';
        $this->tax_rate = $this->custom_tax == '1' && $this->charge_tax == '1' ? $this->tax_rate : null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:128', function ($attribute, $value, $fail) {
                $exists = auth()->user()->client->products()->whereName($value)
                    ->whereNot('id', $this->product->id ?? null)
                    ->exists();

                if ($exists) {
                    $fail('The product already exists, please create different one.');
                }
            }],
            'product_type_id' => ['sometimes', 'nullable', 'exists:product_types,id'],
            'product_type' => ['sometimes', 'nullable', 'string'],
            'category_id' => ['sometimes', 'nullable', 'exists:categories,id'],
            'description' => ['string', 'sometimes', 'nullable'],
            'status' => ['nullable'],
        ];
    }
}
