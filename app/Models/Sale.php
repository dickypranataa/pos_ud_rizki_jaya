<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model // Perhatikan nama class singular (Sale) meski tabel plural (sales)
{
    use HasFactory;

    protected $fillable = [
        //struk penjualan
        'invoice_number', // nomor faktur
        'user_id', // id kasir
        'customer_name', // nama pelanggan
        'customer_type_id', // tipe pelanggan
        'total_amount', // total pembayaran
        'payment_method', // metode pembayaran
        'paid_amount', // jumlah yang dibayar
        'change_amount', // kembalian
        'notes' // catatan
    ];

    // Relasi ke Item Penjualan
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Relasi ke Kasir
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
