<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * SettingsSeeder – Mengisi tabel settings dengan konfigurasi default Burjo Ku
 *
 * Tabel settings menyimpan pasangan key-value untuk pengaturan dinamis
 * yang bisa diubah melalui panel admin tanpa perlu edit kode.
 */
class SettingsSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            // Pengaturan password WiFi warung
            [
                'key'        => 'wifi_password',
                'value'      => 'BurjoKu@2026',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Nama file gambar QRIS untuk pembayaran digital
            [
                'key'        => 'qris_image',
                'value'      => 'qris.png',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Masukkan semua pengaturan ke tabel settings
        $this->db->table('settings')->insertBatch($data);

        echo "✅ SettingsSeeder: " . count($data) . " pengaturan berhasil ditambahkan.\n";

        // Tampilkan ringkasan pengaturan yang ditambahkan
        foreach ($data as $setting) {
            echo "   🔧 {$setting['key']} = {$setting['value']}\n";
        }
    }
}
