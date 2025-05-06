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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->float('price', 2);
            $table->foreignId('currency_id')->default(1);
            $table->string('option_value')->nullable();
            $table->float('discounted_price', 2)->nullable();
            $table->float('discount_amount', 2)->nullable();
            $table->decimal('cargo_price', 10, 2)->default(250);
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
                ->onDelete('cascade');

//            $table->foreign('option_value_id')
//                ->references('id')
//                ->on('option_values')
//                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
