<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Tambahkan kolom `gambar` ke tabel menu
 * Kolom menyimpan nama file foto menu (VARCHAR 255, nullable)
 */
class AddGambarToMenuTable extends Migration
{
    public function up(): void
    {
        // Tambahkan kolom gambar setelah kolom deskripsi
        $this->forge->addColumn('menu', [
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
                'after'      => 'deskripsi',
                'comment'    => 'Nama file foto menu di public/uploads/menu/',
            ],
        ]);
    }

    public function down(): void
    {
        // Hapus kolom gambar jika migration di-rollback
        $this->forge->dropColumn('menu', 'gambar');
    }
}
