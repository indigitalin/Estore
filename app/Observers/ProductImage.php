<?php

namespace App\Observers;

use App\Models\ProductImage as ProductImageModel;

class ProductImage
{
    /**
     * Handle the ProductImage "created" event.
     */
    public function created(ProductImageModel $productImage): void
    {
        //
    }

    /**
     * Handle the ProductImage "updated" event.
     */
    public function updated(ProductImageModel $productImage): void
    {
        //
    }

    /**
     * Handle the ProductImage "deleted" event.
     */
    public function deleted(ProductImageModel $productImage): void
    {
        //
    }

    /**
     * Handle the ProductImage "restored" event.
     */
    public function restored(ProductImageModel $productImage): void
    {
        //
    }

    /**
     * Handle the ProductImage "force deleted" event.
     */
    public function forceDeleted(ProductImageModel $productImage): void
    {
        
    }
}
