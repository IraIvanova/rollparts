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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('token')->nullable();
            $table->string('payment_type')->default('online');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->text('callback')->nullable();
            $table->string('status')->default('pending');
            $table->string('transaction_timestamp')->nullable();
            $table->string('confirmation_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
