<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * DatabaseSeeder – Seeder utama yang menjalankan semua seeder sekaligus
 *
 * Cara menjalankan semua seeder:
 *   php spark db:seed DatabaseSeeder
 *
 * Cara menjalankan seeder individual:
 *   php spark db:seed MenuSeeder
 *   php spark db:seed UserSeeder
 *   php spark db:seed SettingsSeeder
 */
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        echo "🚀 Memulai proses seeding database Burjo Ku...\n";
        echo str_repeat('-', 50) . "\n";

        // ── 1. Seeder data menu makanan & minuman ──
        $this->call('MenuSeeder');

        // ── 2. Seeder akun admin ──
        $this->call('UserSeeder');

        // ── 3. Seeder pengaturan aplikasi ──
        $this->call('SettingsSeeder');

        echo str_repeat('-', 50) . "\n";
        echo "🎉 Semua seeder berhasil dijalankan!\n";
    }
}
