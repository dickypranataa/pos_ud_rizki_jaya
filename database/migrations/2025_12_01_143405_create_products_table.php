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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Relasi ke kategori
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            $table->string('sku')->unique(); // Kode Barang
            $table->string('name');
            $table->integer('stock')->default(0);

            // Enum untuk satuan (Sesuai permintaan: pcs, dus, meter)
            $table->enum('unit', ['pcs', 'dus', 'meter'])->default('pcs');

            // 4 Jenis Harga
            $table->decimal('purchase_price', 15, 2)->default(0); // Modal
            $table->decimal('price_retail', 15, 2)->default(0);   // Eceran
            $table->decimal('price_semi_wholesale', 15, 2)->default(0); // Semi
            $table->decimal('price_wholesale', 15, 2)->default(0);      // Grosir

            $table->boolean('is_service')->default(false); // Jasa atau Barang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
