<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Akun ADMIN (Penjual)
        User::create([
            'name' => 'Admin Catering',
            'email' => 'admin@gmail.com',
            'role' => 'admin', // Role khusus admin
            'password' => Hash::make('12345678'), // Password admin
            'alamat' => 'Kantor Pusat Catering',
            'telp' => '081234567890',
        ]);

        // 2. Membuat Akun User Biasa (Contoh Pembeli)
        User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'role' => 'user', // Role user biasa
            'password' => Hash::make('12345678'),
            'alamat' => 'Jl. Mawar No 10',
            'telp' => '08987654321',
        ]);
    }
}