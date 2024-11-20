<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('store_product_variations', function (Blueprint $table) {
            $table->bigInteger('store_id')->unsigned();
            $table->bigInteger('product_variation_id')->unsigned();
            $table->integer('quantity')->nullable();
            $table->foreign('store_id')->references('id')->on('stores')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['store_id', 'product_variation_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_product_variations');
    }
};
