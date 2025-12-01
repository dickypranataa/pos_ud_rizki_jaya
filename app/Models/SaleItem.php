<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        // item pada struk penjualan
        'sale_id',
        'product_id',
        'quantity',
        'price_at_sale',
        'subtotal'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
