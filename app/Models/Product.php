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
        'tax_rate',
        'client_id',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];

    public function parent(){
        return $this->belongsTo(self::class);
    }

    public function category(){
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

    public function getDefaultPictureUrlAttribute(){
        return ('https://ui-avatars.com/api//?background=5c60f5&color=fff&name=' . $this->name);
    }
}
