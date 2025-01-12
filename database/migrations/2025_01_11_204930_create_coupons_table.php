<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Coupon code
            $table->decimal('discount_value', 8, 2)->nullable(); // Discount amount
            $table->enum('discount_type', ['fixed', 'percentage'])->default('fixed'); // Discount type
            $table->decimal('minimum_order_amount', 10, 2)->nullable(); // Minimum order amount
            $table->integer('usage_limit')->nullable(); // Usage limit per coupon
            $table->integer('used')->default(0); // Times the coupon has been used
            $table->boolean('is_active')->default(true); // Active or not
            $table->dateTime('expires_at')->nullable(); // Expiration date
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
