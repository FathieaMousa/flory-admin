<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // كود الخصم (مثلاً FLORY10)
            $table->enum('type', ['percentage', 'fixed'])->default('percentage'); // نسبة أو قيمة ثابتة
            $table->decimal('value', 8, 2); // قيمة الخصم (مثلاً 10 = 10%)
            $table->decimal('min_order_value', 10, 2)->nullable(); // حد أدنى للطلب
            $table->integer('max_uses')->nullable(); // عدد مرات الاستخدام المسموح
            $table->integer('used_count')->default(0); // عدد مرات الاستخدام الحالية
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('coupons');
    }
};
