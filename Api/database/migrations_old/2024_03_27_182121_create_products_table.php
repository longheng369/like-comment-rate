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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('header');
            $table->string('title');
            $table->bigInteger('price');
            $table->text('details');
            $table->bigInteger('quantity');
            $table->string('scale');
            // $table->string('category_type');
            $table->unsignedBigInteger('category_id'); // Add a category_id column
            $table->foreign('category_id')->references('id')->on('categories');
            $table->dateTime('published_at');
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
