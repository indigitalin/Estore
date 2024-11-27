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
        Schema::create('product_variation_images', function (Blueprint $table) {
            $table->id();
            $table->enum('image_type', array('thumbnail', 'extra'))->default('extra');
            $table->bigInteger('product_image_id')->unsigned();
            $table->foreign('product_image_id')->references('id')->on('product_images')->onDelete("cascade");
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete("cascade");
            $table->bigInteger('product_variation_id')->unsigned()->nullable();
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variation_images');
    }
};
