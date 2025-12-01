<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;

    // 1. SOLUSI UTAMA: Definisikan nama tabel secara manual
    protected $table = 'stock_history';

    // 2. Mass Assignment (Agar bisa di-create lewat Controller)
    protected $fillable = [
        'product_id',
        'user_id',
        'quantity_change',
        'restock_date',
        'type',
        'notes'
    ];

    // 3. Relasi (Opsional tapi Bagus)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
