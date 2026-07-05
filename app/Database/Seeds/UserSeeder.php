<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * UserSeeder – Membuat akun admin default untuk aplikasi Burjo Ku
 *
 * Password di-hash menggunakan fungsi password_hash() bawaan PHP
 * dengan algoritma PASSWORD_DEFAULT (bcrypt).
 * Login: admin@burjoku.com / admin123
 */
class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            [
                'name'       => 'Admin Burjo',
                'email'      => 'admin@burjoku.com',
                // Hash password menggunakan bcrypt (PASSWORD_DEFAULT)
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Gunakan insertBatch agar mudah ditambah akun lain di masa depan
        $this->db->table('users')->insertBatch($data);

        echo "✅ UserSeeder: " . count($data) . " akun admin berhasil ditambahkan.\n";
        echo "   📧 Email   : admin@burjoku.com\n";
        echo "   🔑 Password: admin123\n";
    }
}
