<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@simlab.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Akun Dosen
        User::updateOrCreate(
            ['email' => 'budi123@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('budi123'),
                'role' => 'dosen',
            ]
        );

        $this->command->info('✅ Akun Admin & Dosen berhasil dibuat/diupdate.');
    }
}