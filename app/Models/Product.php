<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara massal (create/update)
    protected $fillable = [
        'category_id', //kategori produk
        'sku', // id barang
        'name', // nama barang
        'stock', //stok barang
        'unit', // satuan (pcs, dus, meter)
        'purchase_price', // modal
        'price_retail', // harga eceran
        'price_semi_wholesale', // harga semi grosir
        'price_wholesale', // harga grosir
        'is_service' // jasa atau barang
    ];

    // Relasi: Satu Produk milik Satu Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
