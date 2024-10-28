<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->enum('type', ['store', 'website'])->default('store');
            $table->string('name', 150);
            $table->string('address', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postalcode', 7)->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('logo', 50)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            //$table->unsignedBigInteger('category_id')->nullable();
            $table->string('password')->nullable();
            $table->string('api_key')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            //$table->foreign('category_id')->references('id')->on('store_categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stores');
    }
}

