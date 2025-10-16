<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('new_price', 10, 2)->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_new')->default(false);
            $table->string('sell_number')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
            $table->string('image')->nullable(); // الصورة الرئيسية
            $table->timestamps();
            $table->index(['category_id', 'is_available', 'is_new']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('products');
    }
};
