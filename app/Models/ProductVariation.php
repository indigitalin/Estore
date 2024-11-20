<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariation extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'product_id',
        'uid',
        'name',
        'sku',
        'status',
        'weight',
        'weight_type',
        'price',
        'cost_per_item',
        'compare_price',
        'option_id',
        'option_key',
        'option_name',
    ];

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_product_variations', 'product_variation_id', 'store_id')->store()->using(StoreProductVariation::class)->withPivot('quantity');
    }
}
