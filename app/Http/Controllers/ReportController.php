<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\StockHistory;
use Carbon\Carbon;

class ReportController extends Controller
{
    //
    public function index(Request $request){
        //1. input memilih tanggal mulai dan tanggal akhir
        $startDate = $request->input('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));

        //ambil data penjualan dari database berdasarkan tanggal
        $sales = Sale::with('user')
        ->whereDate('created_at', '>=', $startDate)
        ->whereDate('created_at', '<=', $endDate)
        ->get();

        //hitung total omzet dari data penjualan
        $totalOmzet = $sales->sum('total_amount');

        return view('reports.sales.index', compact('sales', 'totalOmzet', 'startDate', 'endDate'));

    }

    public function StockReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));

        // UBAH NAMA VARIABEL DI SINI JADI $histories (Supaya cocok dengan View)
        $histories = StockHistory::with('product', 'user')
            ->whereDate('restock_date', '>=', $startDate)
            ->whereDate('restock_date', '<=', $endDate)
            ->latest() // Tambahan: Biar urut dari yang terbaru
            ->get();

        // Compact juga harus 'histories'
        return view('reports.stock.index', compact('histories', 'startDate', 'endDate'));
    }
}

