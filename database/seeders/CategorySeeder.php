<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Data Kategori yang relevan dengan Toko Pompa Air
        $categories = [
            [
                'name' => 'Pompa Air',
                'description' => 'Segala jenis mesin pompa (Jet pump, Sumur dangkal, Celup/Submersible).',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Pipa & Fitting',
                'description' => 'Pipa PVC, sambungan (knee, tee), dan lem pipa.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Suku Cadang',
                'description' => 'Sparepart mesin (Seal, Bearing, Impeller, Tusen klep).',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Aksesoris Toren',
                'description' => 'Radar otomatis, Pelampung bola, Filter air.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Kran & Sanitasi',
                'description' => 'Berbagai jenis kran air dan perlengkapan kamar mandi.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Jasa & Layanan',
                'description' => 'Biaya servis, pemasangan, atau gulung dinamo (Non-fisik).',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Masukkan data ke tabel
        DB::table('categories')->insert($categories);
    }
}
