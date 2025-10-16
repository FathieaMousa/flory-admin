<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('address_id')->nullable();

            // حالات: Pending, Processing, Out for Delivery, Delivered
$table->enum('status', ['Pending', 'Processing', 'Delivered', 'Cancelled'])->default('Pending');

            $table->boolean('is_payment')->default(false)->nullable();
            $table->string('payment_method')->nullable();

            $table->decimal('sub_total', 10, 2)->nullable();
            $table->decimal('coupon_value', 10, 2)->nullable();
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->decimal('total', 10, 2)->nullable();

            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->foreign('address_id')->references('id')->on('addresses')->nullOnDelete();
            $table->index(['customer_id', 'status']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
