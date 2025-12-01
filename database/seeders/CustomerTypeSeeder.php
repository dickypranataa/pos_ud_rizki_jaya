<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('customer_types')->insert([
            ['name' => 'Ritel', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Semi Grosir', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Grosir', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
