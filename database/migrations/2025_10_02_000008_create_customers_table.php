<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            // 🔹 بيانات أساسية
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable()->unique();

            // 🔹 تسجيل الدخول (في حال ربط التطبيق)
            $table->string('password')->nullable();

            // 🔹 FCM للتنبيهات
            $table->string('fcm_token')->nullable();

            // 🔹 حالة الحساب
            $table->boolean('is_active')->default(true);

            // 🔹 صورة بروفايل اختيارية
            $table->string('avatar')->nullable();

            // 🔹 آخر تسجيل دخول (مفيد للإشعارات)
            $table->timestamp('last_login_at')->nullable();

            // 🔹 معلومات الموقع التقريبية (لتتبع الطلب)
            $table->string('city')->nullable();
            $table->string('region')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('customers');
    }
};
