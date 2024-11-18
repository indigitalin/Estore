<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use \App\Helper\Upload;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'category_id',
        'name',
        'handle',
        'sku',
        'description',
        'status',
        'track_quantity',
        'sell_without_stock',
        'physical',
        'weight',
        'weight_type',
        'price',
        'cost_per_item',
        'compare_price',
        'charge_tax',
        'custom_tax',
        'tax_rate',
        'client_id',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'product_type_id',
        'product_vendor_id',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getStatusLabelAttribute()
    {
        return $this->status == "1" ? 'Active' : 'Inactive';
    }

    public function getPictureAttribute($picture)
    {
        return $picture ?: 'default.png';
    }

    public function getPictureUrlAttribute($picture)
    {
        if ($this->picture == 'default.png') {
            return $this->default_picture_url;
        }
        return file_url($this->picture);
    }

    public function getDefaultPictureUrlAttribute()
    {
        return ('https://ui-avatars.com/api//?background=5c60f5&color=fff&name=' . $this->name);
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_products', 'product_id', 'store_id')->store()->using(StoreProduct::class)->withPivot('quantity');
    }

    public function websites()
    {
        return $this->belongsToMany(Website::class, 'store_products', 'product_id', 'store_id')->website()->using(StoreProduct::class)->withPivot('quantity');
    }

    public function collections(){
        return $this->belongsToMany(Collection::class, 'collection_products', 'product_id', 'collection_id')->using(CollectionProduct::class);
    }

    public function product_type(){
        return $this->belongsTo(ProductType::class);
    }

    public function getProductTypeNameAttribute(){
        return $this->product_type->name ?? null;
    }

    public function product_vendor(){
        return $this->belongsTo(ProductVendor::class);
    }

    public function getProductVendorNameAttribute(){
        return $this->product_vendor->name ?? null;
    }

    public function product_tags(){
        return $this->hasMany(ProductTag::class);
    }

    public function product_options(){
        return $this->hasMany(ProductOption::class);
    }
}
