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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('products')->onDelete("cascade");
            $table->foreign('product_id')->references('id')->on('products')->onDelete("cascade");
            $table->string('uid', 16);
            $table->string('name', 150);
            $table->string('sku', 150)->nullable();
            $table->boolean('status')->default(0);
            $table->decimal('weight', 8, 2)->default(0)->nullable();
            $table->enum('weight_type', ['ml', 'gm', 'l', 'kg'])->default('gm')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->decimal('cost_per_item', 8, 2)->nullable();
            $table->decimal('compare_price', 8, 2)->nullable();
            $table->string('option_id', 150)->nullable();
            $table->string('option_key', 150)->nullable();
            $table->string('option_name', 150)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};
