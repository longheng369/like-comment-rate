<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
           // Temporarily remove foreign key constraints if they are somehow involved
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);

            // Drop the unique index
            $table->dropUnique(['product_id', 'user_id']);

            // Recreate foreign keys
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->unique(['product_id', 'user_id']);
        });
    }
};
