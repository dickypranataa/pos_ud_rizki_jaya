<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Admin
        $admin = User::create([
            'name' => 'Pemilik Toko',
            'username' => 'admin',
            'password' => Hash::make('password'), // Passwordnya: password
            'role' => 'admin',
        ]);
        $admin->assignRole('admin'); // Assign role Spatie

        // Buat Kasir
        $kasir = User::create([
            'name' => 'Kasir Satu',
            'username' => 'kasir',
            'password' => Hash::make('password'), // Passwordnya: password
            'role' => 'kasir',
        ]);
        $kasir->assignRole('kasir'); // Assign role Spatie
    }
}
