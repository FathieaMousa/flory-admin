<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::table('addresses', function (Blueprint $table) {
        if (!Schema::hasColumn('addresses', 'name')) {
            $table->string('name')->nullable();
        }
        if (!Schema::hasColumn('addresses', 'phone')) {
            $table->string('phone')->nullable();
        }
        if (!Schema::hasColumn('addresses', 'street')) {
            $table->string('street')->nullable();
        }
        if (!Schema::hasColumn('addresses', 'state')) {
            $table->string('state')->nullable();
        }
        if (!Schema::hasColumn('addresses', 'postal_code')) {
            $table->string('postal_code')->nullable();
        }
        if (!Schema::hasColumn('addresses', 'country')) {
            $table->string('country')->nullable();
        }
        if (!Schema::hasColumn('addresses', 'selected')) {
            $table->boolean('selected')->default(false);
        }
    });
}




    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn(['name', 'phone', 'street', 'state', 'postal_code', 'country', 'selected']);
        });
    }
};
