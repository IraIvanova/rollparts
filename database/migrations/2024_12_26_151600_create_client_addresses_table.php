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
        Schema::create('client_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to orders table
            $table->enum('type', ['billing', 'shipping']); // Address type
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('country')->nullable();
            $table->foreignId('province_id')->nullable();
            $table->foreignId('district_id')->nullable();
            $table->string('zip')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_addresses');
    }
};
