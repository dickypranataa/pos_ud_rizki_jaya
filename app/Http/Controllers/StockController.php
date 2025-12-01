<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    //
    public function create(Product $product)
    {
        return view('stocks.create', compact('product'));
    }

    public function store(Request $request, Product $product){
        $request->validate([
            'quantity_change' => 'required|integer|min:1',
            'restock_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $product) {
            // Update stok produk
            $product->increment('stock', $request->quantity_change);

            //catat riwayat di table stock_history
            StockHistory::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'quantity_change' => $request->quantity_change,
                'restock_date' => $request->restock_date,
                'type' => 'Restok',
                'notes' => $request->notes,
            ]);
        });
        return redirect()->route('products.index')
            ->with('success', 'Stok produk berhasil diperbarui dan riwayat disimpan.');
    }
}
