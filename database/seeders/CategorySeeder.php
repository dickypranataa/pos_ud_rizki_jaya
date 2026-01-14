<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Pompa Air',
            'Pipa & Fitting',
            'Suku Cadang',
            'Kran & Sanitasi',
            'Aksesoris Toren',
            'Alat & Perkakas',
            'Elektrikal',
            'Bahan Bangunan',
            'Jasa & Layanan',
            'Lainnya',
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat],
                ['description' => 'Kategori default sistem']
            );
        }
    }
}
