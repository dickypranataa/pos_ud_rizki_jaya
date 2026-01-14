<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\StockHistory;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function index(){
        // 1. Statistik Hari Ini
        $today = Carbon::today();

        $omzetHariIni = Sale::whereDate('created_at', $today)->sum('total_amount');
        $transaksiHariIni = Sale::whereDate('created_at', $today)->count();
        $totalProduk = Product::count();

        // 2. Peringatan Stok Menipis (Misal: kurang dari 5)
        $stokMenipis = Product::where('stock', '<=', 5)->get();

        // 3. 5 Transaksi Terakhir
        $transaksiTerbaru = Sale::with('user')->latest()->take(5)->get();

        return view('dashboard', compact(
            'omzetHariIni',
            'transaksiHariIni',
            'totalProduk',
            'stokMenipis',
            'transaksiTerbaru'
        ));
    }
}
