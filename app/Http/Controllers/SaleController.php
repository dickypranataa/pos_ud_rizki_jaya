<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function print($id)
    {
        // 1. Ambil data transaksi
        $sale = Sale::with(['items.product', 'user', 'customerType'])->findOrFail($id);

        // 2. Hitung estimasi tinggi kertas agar pas (Dinamis)
        // - Base height: Tinggi Header + Footer + Meta data (kira-kira 200 point)
        // - Item height: Tinggi per baris barang (kira-kira 35 point per barang)
        // - Buffer: Tambahan sedikit agar tidak terpotong (50 point)

        $jumlahBarang = $sale->items->count();
        $tinggiPerBarang = 35; // Estimasi tinggi 1 baris barang
        $tinggiDasar = 220;    // Estimasi tinggi Header + Footer + Total

        $totalTinggi = $tinggiDasar + ($jumlahBarang * $tinggiPerBarang);

        // 3. Set ukuran kertas (Lebar 220, Tinggi Sesuai Hitungan)
        $customPaper = array(0, 0, 220, $totalTinggi);

        // 4. Generate PDF
        $pdf = Pdf::loadView('pdf.struk', compact('sale'))
            ->setPaper($customPaper, 'portrait');

        return $pdf->stream('struk-' . $sale->invoice_number . '.pdf');
    }
}
