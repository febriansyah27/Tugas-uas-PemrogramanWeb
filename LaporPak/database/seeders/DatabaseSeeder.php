<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // Buat akun PETUGAS untuk testing
        // =============================================
        User::create([
            'name'     => 'Petugas Admin',
            'email'    => 'petugas@LaporPak.id',
            'password' => Hash::make('12345678'),
            'role'     => 'petugas',
        ]);

        // =============================================
        // Buat akun WARGA untuk testing
        // =============================================
        User::create([
            'name'     => 'Budi Warga',
            'email'    => 'warga@LaporPak.id',
            'password' => Hash::make('12345678'),
            'role'     => 'warga',
        ]);

        $this->command->info('✅ Seeder selesai!');
        $this->command->info('📌 Login Petugas: petugas@LaporPak.id / 12345678');
        $this->command->info('📌 Login Warga:   warga@LaporPak.id / 12345678');
    }
}
