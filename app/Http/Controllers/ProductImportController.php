<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductImportController extends Controller
{
    public function import(Request $request)
    {
        


        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $path = $request->file('file')->getRealPath();
        $file = fopen($path, 'r');

        // Auto detect delimiter
        $firstLine = fgets($file);
        rewind($file);

        $delimiter = ',';
        if (str_contains($firstLine, ';')) {
            $delimiter = ';';
        } elseif (str_contains($firstLine, "\t")) {
            $delimiter = "\t";
        }

        $header = fgetcsv($file, 0, $delimiter);

        while (($row = fgetcsv($file, 0, $delimiter)) !== false) {

            if (count($row) !== count($header)) {
                continue;
            }

            $data = array_combine($header, $row);

            if (
                empty($data['Kode']) ||
                empty($data['Deskripsi'])
            ) {
                continue;
            }

            $priceRetail = $this->toNumber($data['Total Jual'] ?? 0);
            $categoryId  = $this->detectCategoryId($data['Deskripsi']);

            Product::updateOrCreate(
                ['sku' => trim($data['Kode'])],
                [
                    'category_id' => $categoryId,
                    'name' => trim($data['Deskripsi']),
                    'stock' => 0,
                    'unit' => 'pcs',
                    'purchase_price' => 0,
                    'price_retail' => $priceRetail,
                    'price_semi_wholesale' => $priceRetail,
                    'price_wholesale' => $priceRetail,
                    'is_service' => 0,
                ]
            );
        }

        fclose($file);

        return back()->with('success', 'Import produk berhasil dan kategori otomatis terdeteksi');
    }

    /**
     * Deteksi kategori dari nama produk
     */
    private function detectCategoryId(string $name): int
    {
        $name = strtoupper($name);

        $rules = [
            1 => ['POMPA', 'JET', 'SUBMERSIBLE', 'CELUP', 'HCL'],
            2 => ['PIPA', 'ELBOW', 'TEE', 'SOCKET', 'FITTING', 'KNEE'],
            3 => ['SEAL', 'IMPELLER', 'BEARING', 'ORING', 'DIFUSER'],
            4 => ['TOREN', 'TANGKI', 'TABUNG'],
            5 => ['KRAN', 'SHOWER', 'SANITASI', 'STOP KRAN'],
            7 => ['KUNCI', 'GERGAJI', 'PALU', 'OBENG', 'TANG'],
            8 => ['KABEL', 'CAPASITOR', 'DINAMO', 'KIPAS'],
            9 => ['LEM', 'KLEM', 'LAKBAN', 'SEALTIP'],
        ];

        foreach ($rules as $categoryId => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($name, $keyword)) {
                    return $categoryId;
                }
            }
        }

        return 10; // Lainnya
    }

    /**
     * Ubah angka "1.250.000" → 1250000
     */
    private function toNumber($value): float
    {
        return (float) str_replace(
            ['.', ',', ' '],
            ['', '.', ''],
            preg_replace('/[^0-9.,]/', '', $value)
        );
    }
}
