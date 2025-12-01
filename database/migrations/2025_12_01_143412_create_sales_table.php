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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // INV-20241001-001

            // Relasi ke User (Kasir)
            $table->foreignId('user_id')->constrained('users');

            // Relasi ke Tipe Harga (Pilihan tombol kasir)
            $table->foreignId('customer_type_id')->constrained('customer_types');

            // Nama pembeli BOLEH KOSONG (Nullable) sesuai alur cepat
            $table->string('customer_name')->nullable();

            $table->decimal('total_amount', 15, 2);
            $table->string('payment_method')->default('Tunai');
            $table->decimal('paid_amount', 15, 2);   // Uang dibayar
            $table->decimal('change_amount', 15, 2); // Kembalian
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
