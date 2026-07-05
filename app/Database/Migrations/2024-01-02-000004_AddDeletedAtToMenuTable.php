<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Menambahkan kolom deleted_at ke tabel menu yang sudah ada
 * untuk mendukung fitur soft delete di masa depan.
 *
 * CATATAN: Migration ini TIDAK mengubah migration lama (CreateMenuTable).
 * Pendekatan ALTER TABLE digunakan agar data yang sudah ada tetap aman.
 */
class AddDeletedAtToMenuTable extends Migration
{
    public function up()
    {
        // Tambahkan kolom deleted_at setelah kolom deskripsi
        // NULL berarti data aktif, terisi berarti data sudah dihapus (soft delete)
        $this->forge->addColumn('menu', [
            'deleted_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
                'after'   => 'deskripsi',
            ],
        ]);
    }

    public function down()
    {
        // Hapus kolom deleted_at jika migrasi di-rollback
        $this->forge->dropColumn('menu', 'deleted_at');
    }
}
