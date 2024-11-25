<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uid,
            'name' => $this->option_name,
            'variation_name' => $this->name,
            'status' => $this->status == '1',
            'key' => $this->option_key,
            'option_ids' => explode("-", $this->option_id),
            'price' => $this->price,
            'sku' => $this->sku,
            'compare_price' => $this->compare_price,
            'cost_per_item' => $this->cost_per_item,
            'weight' => $this->weight,
            'weight_type' => $this->weight_type,
            'thumbnail' => $this->thumbnail_image_url,
            'images' => $this->images->map(function ($image) {
                return [
                    'id' => $image->product_image_id,
                    'type' => $image->image_type,
                    'image_url' => $image->product_image->image_url,
                ];
            })->toArray(),
            'stores' => $this->stores->map(function ($store) {
                return [
                    'id' => $store->id, // Assuming 'store_id' is a property of the store object
                    'stock' => $store->pivot->quantity, // Assuming 'quantity' is a property of the store object
                ];
            })->toArray(),
        ];
    }
}
