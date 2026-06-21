<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Membuat tabel menu untuk menyimpan data makanan dan minuman Burjo
 */
class CreateMenuTable extends Migration
{
    public function up()
    {
        // Definisi struktur tabel menu
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_menu' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'kategori' => [
                'type'       => 'ENUM',
                'constraint' => ['Makanan', 'Minuman'],
                'null'       => false,
            ],
            'harga' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
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
        $this->forge->createTable('menu');
    }

    public function down()
    {
        // Hapus tabel jika migrasi di-rollback
        $this->forge->dropTable('menu');
    }
}
