<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'name',         // Contoh: 'Ritel', 'Grosir'
        'description'   // Opsional
    ];

    /**
     * Relasi: Satu Tipe Harga bisa dipakai di banyak Transaksi Penjualan.
     * (One to Many)
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
