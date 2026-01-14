<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
     * Memetakan baris Excel ke Model Database
     */
    public function model(array $row)
    {
        // 1. Validasi: Lewati jika kode barang kosong
        if (!isset($row['kode'])) {
            return null;
        }

        // 2. Ambil data mentah dari Excel
        $skuRaw   = trim($row['kode']);
        $nameRaw  = trim($row['deskripsi']);
        $unitRaw  = isset($row['satuan']) ? strtoupper(trim($row['satuan'])) : 'PCS';

        $hargaBeliRaw = (float) $row['total_beli'];
        $hargaJualRaw = (float) $row['total_jual'];

        // 3. LOGIKA PEMBERSIHAN DATA (CLEANING)
        // Default: Gunakan harga asli
        $finalPurchasePrice = $hargaBeliRaw;
        $finalSellingPrice  = $hargaJualRaw;

        // Cek Anomali: Jika Harga Modal >= Harga Jual
        // Artinya data ini salah satuan (Roll vs Pcs) atau salah input
        if ($hargaBeliRaw >= $hargaJualRaw) {
            // SOLUSI: Anggap margin keuntungan standar adalah 20%
            // Rumus: Harga Modal = Harga Jual x 0.8
            $finalPurchasePrice = $hargaJualRaw * 0.8;

            // (Opsional) Tambahkan tanda di nama barang agar Admin tahu ini data hasil koreksi
            // $nameRaw = $nameRaw . ' *'; 
        }

        // 4. Masukkan ke Database 'products'
        // Cek apakah produk dengan SKU ini sudah ada? (Update or Create)
        $product = Product::firstOrNew(['sku' => $skuRaw]);

        $product->name = $nameRaw;
        $product->unit = $unitRaw;

        // Simpan harga yang sudah "dibersihkan"
        $product->purchase_price = $finalPurchasePrice;
        $product->price_retail = $finalSellingPrice;

        // Set harga grosir sama dulu (bisa diedit nanti)
        $product->price_wholesale = $finalSellingPrice;
        $product->price_semi_wholesale = $finalSellingPrice;

        // Jika stok belum ada, set 0. Jika sudah ada, jangan ditimpa jadi 0.
        if (!$product->exists) {
            $product->stock = 0;
        }

        $product->save();

        return $product;
    }
}
