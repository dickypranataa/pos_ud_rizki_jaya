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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();

            // Relasi ke Nota (Jika nota dihapus, item ikut terhapus)
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');

            // Relasi ke Produk
            $table->foreignId('product_id')->constrained('products');

            $table->integer('quantity');

            // Harga 'snapshot' saat transaksi terjadi
            $table->decimal('price_at_sale', 15, 2);
            $table->decimal('subtotal', 15, 2);

            // Tidak perlu timestamps() di sini
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
