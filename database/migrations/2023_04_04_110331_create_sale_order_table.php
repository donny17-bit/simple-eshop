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
        Schema::create('sale_order', function (Blueprint $table) {
            $table->foreignId('id_product')->constrained('product', 'id');
            $table->foreignId('id_customer')->constrained('users', 'id');
            $table->integer('invoice_number');
            $table->integer('quatity');
            $table->integer('unit_price');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_order');
    }
};
