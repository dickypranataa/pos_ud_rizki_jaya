<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara massal (create/update)
    protected $fillable = [
        'category_id',
        'sku',
        'name',
        'stock',
        'unit',
        'purchase_price',
        'price_retail',
        'price_semi_wholesale',
        'price_wholesale',
        'is_service',
    ];


    // Relasi: Satu Produk milik Satu Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
