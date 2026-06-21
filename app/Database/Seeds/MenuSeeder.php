<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * MenuSeeder – Mengisi tabel menu dengan data contoh warung burjo
 */
class MenuSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // Data contoh menu makanan & minuman khas burjo
        $data = [
            // ── MAKANAN ──
            [
                'nama_menu'  => 'Nasi Goreng Spesial',
                'kategori'   => 'Makanan',
                'harga'      => 12000,
                'deskripsi'  => 'Nasi goreng dengan telur, ayam, dan bumbu rahasia khas burjo. Cocok untuk sarapan atau makan malam.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_menu'  => 'Mie Goreng Jawa',
                'kategori'   => 'Makanan',
                'harga'      => 10000,
                'deskripsi'  => 'Mie goreng dengan bumbu kecap manis khas Jawa, disajikan dengan kerupuk dan acar.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_menu'  => 'Indomie Rebus Telur',
                'kategori'   => 'Makanan',
                'harga'      => 8000,
                'deskripsi'  => 'Indomie rebus kuah gurih dengan tambahan telur setengah matang dan daun bawang.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_menu'  => 'Nasi Telur Ceplok',
                'kategori'   => 'Makanan',
                'harga'      => 9000,
                'deskripsi'  => 'Nasi putih hangat dengan telur ceplok mata sapi dan sambal terasi pedas.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_menu'  => 'Bubur Ayam Spesial',
                'kategori'   => 'Makanan',
                'harga'      => 11000,
                'deskripsi'  => 'Bubur ayam lembut dengan suwiran ayam, cakwe, kacang, dan kerupuk emping.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_menu'  => 'Roti Bakar Coklat',
                'kategori'   => 'Makanan',
                'harga'      => 7000,
                'deskripsi'  => 'Roti tawar bakar dengan selai coklat keju. Snack favorit pelanggan burjo.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // ── MINUMAN ──
            [
                'nama_menu'  => 'Es Teh Manis',
                'kategori'   => 'Minuman',
                'harga'      => 4000,
                'deskripsi'  => 'Teh manis dingin menyegarkan, pilihan minuman paling populer di warung burjo.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_menu'  => 'Kopi Hitam Tubruk',
                'kategori'   => 'Minuman',
                'harga'      => 5000,
                'deskripsi'  => 'Kopi hitam robusta asli, diseduh langsung tanpa filter. Cocok untuk begadang.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_menu'  => 'Susu Coklat Hangat',
                'kategori'   => 'Minuman',
                'harga'      => 7000,
                'deskripsi'  => 'Susu UHT full cream dengan milo coklat, disajikan hangat. Favorit pelanggan pagi hari.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_menu'  => 'Es Jeruk Peras',
                'kategori'   => 'Minuman',
                'harga'      => 6000,
                'deskripsi'  => 'Jeruk segar diperas langsung, ditambah es batu dan sedikit gula. Segar alami!',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_menu'  => 'Teh Tarik',
                'kategori'   => 'Minuman',
                'harga'      => 8000,
                'deskripsi'  => 'Teh dengan susu kental manis, ditarik berkali-kali hingga berbuih. Khas melayu.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_menu'  => 'Air Mineral Botol',
                'kategori'   => 'Minuman',
                'harga'      => 3000,
                'deskripsi'  => 'Air mineral kemasan botol 600ml, dingin dan segar.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Masukkan semua data ke tabel menu
        $this->db->table('menu')->insertBatch($data);

        echo "✅ MenuSeeder: " . count($data) . " data menu berhasil ditambahkan.\n";
    }
}
