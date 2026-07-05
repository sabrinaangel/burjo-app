<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Membuat tabel settings untuk konfigurasi aplikasi Burjo Ku
 * Menyimpan pasangan key-value untuk pengaturan dinamis
 */
class CreateSettingsTable extends Migration
{
    public function up()
    {
        // Definisi struktur tabel settings (key-value store)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            // Kunci pengaturan, harus unik
            'key' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            // Nilai pengaturan, bisa berisi teks panjang
            'value' => [
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

        // Atur unique key pada kolom key (mencegah duplikasi pengaturan)
        $this->forge->addUniqueKey('key');

        // Buat tabel
        $this->forge->createTable('settings');
    }

    public function down()
    {
        // Hapus tabel jika migrasi di-rollback
        $this->forge->dropTable('settings');
    }
}
