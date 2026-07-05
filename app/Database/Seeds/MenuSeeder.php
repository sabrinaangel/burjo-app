<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * MenuSeeder – Mengisi tabel menu dengan data warung burjo (15 makanan + 15 minuman)
 */
class MenuSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            // ── MAKANAN ──
            [
                'nama_menu'  => 'Nasi Goreng Spesial',
                'kategori'   => 'Makanan',
                'harga'      => 12000,
                'deskripsi'  => 'Nasi goreng dengan telur, ayam suwir, dan bumbu rempah pilihan. Disajikan dengan kerupuk dan acar.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Ayam Geprek Sambal Bawang',
                'kategori'   => 'Makanan',
                'harga'      => 13000,
                'deskripsi'  => 'Ayam goreng tepung renyah digeprek dengan sambal bawang pedas. Disajikan dengan nasi hangat.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Nasi Telur Ceplok',
                'kategori'   => 'Makanan',
                'harga'      => 8000,
                'deskripsi'  => 'Nasi putih dengan telur ceplok setengah matang, sambal kecap, dan kerupuk.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Indomie Goreng Spesial',
                'kategori'   => 'Makanan',
                'harga'      => 9000,
                'deskripsi'  => 'Indomie goreng dengan telur, sawi, dan tomat. Bisa request level pedas.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Indomie Rebus Kuah',
                'kategori'   => 'Makanan',
                'harga'      => 9000,
                'deskripsi'  => 'Indomie rebus kuah gurih dengan telur dan sayuran segar. Cocok untuk malam dingin.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Bubur Ayam Spesial',
                'kategori'   => 'Makanan',
                'harga'      => 11000,
                'deskripsi'  => 'Bubur ayam lembut dengan suwiran ayam, cakwe, kacang, dan kerupuk emping.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Mie Goreng Jawa',
                'kategori'   => 'Makanan',
                'harga'      => 10000,
                'deskripsi'  => 'Mie goreng khas Jawa dengan bumbu kecap manis, telur, dan tauge segar.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Tempe Orek Pedas',
                'kategori'   => 'Makanan',
                'harga'      => 6000,
                'deskripsi'  => 'Tempe goreng orek dengan bumbu pedas manis khas burjo. Cocok sebagai lauk tambahan.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Tempe Mendoan',
                'kategori'   => 'Makanan',
                'harga'      => 5000,
                'deskripsi'  => 'Tempe tipis digoreng tepung setengah matang, gurih dan lembut. Disajikan dengan cabai rawit.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Nasi Ayam Kecap',
                'kategori'   => 'Makanan',
                'harga'      => 13000,
                'deskripsi'  => 'Nasi putih dengan ayam goreng saus kecap manis. Disajikan dengan lalapan dan sambal.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Roti Bakar Coklat Keju',
                'kategori'   => 'Makanan',
                'harga'      => 10000,
                'deskripsi'  => 'Roti tawar dibakar dengan isian coklat meses dan keju leleh. Manis dan mengenyangkan.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Roti Bakar Srikaya',
                'kategori'   => 'Makanan',
                'harga'      => 8000,
                'deskripsi'  => 'Roti tawar dibakar dengan selai srikaya hijau khas. Harum dan legit.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Pisang Goreng Crispy',
                'kategori'   => 'Makanan',
                'harga'      => 7000,
                'deskripsi'  => 'Pisang kepok goreng tepung renyah dengan taburan gula halus dan susu kental manis.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Nasi Pecel Burjo',
                'kategori'   => 'Makanan',
                'harga'      => 11000,
                'deskripsi'  => 'Nasi dengan sayuran rebus disiram bumbu kacang khas, dilengkapi rempeyek dan kerupuk.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Mie Rebus Telur',
                'kategori'   => 'Makanan',
                'harga'      => 9000,
                'deskripsi'  => 'Mie kuning rebus dengan kuah gurih, telur rebus, dan pelengkap sayuran segar.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            // ── MINUMAN ──
            [
                'nama_menu'  => 'Es Teh Manis',
                'kategori'   => 'Minuman',
                'harga'      => 4000,
                'deskripsi'  => 'Teh manis dingin segar, cocok menemani makan siang dan malam.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Teh Hangat',
                'kategori'   => 'Minuman',
                'harga'      => 3000,
                'deskripsi'  => 'Teh tubruk hangat klasik khas warung, pas untuk menemani obrolan santai.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Es Jeruk Peras',
                'kategori'   => 'Minuman',
                'harga'      => 6000,
                'deskripsi'  => 'Jeruk segar diperas langsung, ditambah es batu dan sedikit gula. Menyegarkan!',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Kopi Hitam Tubruk',
                'kategori'   => 'Minuman',
                'harga'      => 5000,
                'deskripsi'  => 'Kopi hitam khas warung dengan ampas, pahit dan nikmat. Bikin melek seketika.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Kopi Susu Hangat',
                'kategori'   => 'Minuman',
                'harga'      => 7000,
                'deskripsi'  => 'Kopi hitam dicampur susu kental manis hangat. Creamy dan menghangatkan.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Es Kopi Susu',
                'kategori'   => 'Minuman',
                'harga'      => 8000,
                'deskripsi'  => 'Kopi hitam pekat dicampur susu kental manis dan es batu. Segar dan bikin semangat.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Susu Coklat Hangat',
                'kategori'   => 'Minuman',
                'harga'      => 7000,
                'deskripsi'  => 'Susu coklat hangat yang creamy dan manis. Favorit semua kalangan.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Es Susu Coklat',
                'kategori'   => 'Minuman',
                'harga'      => 7000,
                'deskripsi'  => 'Susu coklat dingin dengan es batu, segar dan menyenangkan untuk segala suasana.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Wedang Jahe',
                'kategori'   => 'Minuman',
                'harga'      => 6000,
                'deskripsi'  => 'Minuman jahe hangat dengan campuran gula merah dan serai. Menghangatkan badan.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Es Teh Tarik',
                'kategori'   => 'Minuman',
                'harga'      => 7000,
                'deskripsi'  => 'Teh susu khas dengan busa lembut di atasnya, disajikan dingin.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Air Mineral Botol',
                'kategori'   => 'Minuman',
                'harga'      => 3000,
                'deskripsi'  => 'Air mineral kemasan botol 600ml, dingin dan menyegarkan.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Es Dawet',
                'kategori'   => 'Minuman',
                'harga'      => 8000,
                'deskripsi'  => 'Minuman tradisional dengan cendol hijau, santan, dan gula merah cair. Segar dan legit.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Jus Alpukat',
                'kategori'   => 'Minuman',
                'harga'      => 10000,
                'deskripsi'  => 'Jus alpukat segar dengan campuran susu coklat dan es batu. Kental dan mengenyangkan.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Es Campur',
                'kategori'   => 'Minuman',
                'harga'      => 9000,
                'deskripsi'  => 'Minuman segar berisi cincau, kolang-kaling, nata de coco, dan sirup merah.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'nama_menu'  => 'Bajigur',
                'kategori'   => 'Minuman',
                'harga'      => 6000,
                'deskripsi'  => 'Minuman tradisional Sunda dari santan, gula merah, dan jahe. Hangat dan unik.',
                'gambar'     => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
        ];

        // Insert dengan cek duplikat berdasarkan nama_menu
        $inserted = 0;
        $skipped  = 0;

        foreach ($data as $item) {
            $existing = $this->db->table('menu')
                                 ->where('nama_menu', $item['nama_menu'])
                                 ->get()
                                 ->getRow();

            if (!$existing) {
                $this->db->table('menu')->insert($item);
                $inserted++;
            } else {
                $skipped++;
            }
        }

        echo "✅ MenuSeeder: {$inserted} data berhasil diinsert, {$skipped} data dilewati (sudah ada).\n";
    }
}
