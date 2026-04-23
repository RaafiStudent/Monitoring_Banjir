<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat Akun Admin Default
        User::create([
            'name' => 'Admin BPBD Tegal',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
        ]);
    }
}