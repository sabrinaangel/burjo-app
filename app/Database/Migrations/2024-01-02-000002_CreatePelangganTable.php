<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Membuat tabel pelanggan dengan dukungan soft delete
 */
class CreatePelangganTable extends Migration
{
    public function up()
    {
        // Definisi struktur tabel pelanggan
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // Kolom untuk soft delete – NULL berarti data aktif
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Atur primary key
        $this->forge->addKey('id', true);

        // Buat tabel
        $this->forge->createTable('pelanggan');
    }

    public function down()
    {
        // Hapus tabel jika migrasi di-rollback
        $this->forge->dropTable('pelanggan');
    }
}
