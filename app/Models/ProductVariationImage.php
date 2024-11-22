<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_image_id',
        'product_variation_id',
        'product_id',
    ];

    /**
     * The attributes that are lazy loaded.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'image_url',
    ];

    public function product_image()
    {
        return $this->belongsTo(ProductImage::class);
    }

    public function getImageUrlAttribute()
    {
        return file_url($this->image_path);
    }
}
