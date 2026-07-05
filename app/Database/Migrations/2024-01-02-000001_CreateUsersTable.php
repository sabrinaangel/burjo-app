<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Membuat tabel users untuk autentikasi admin Burjo Ku
 */
class CreateUsersTable extends Migration
{
    public function up()
    {
        // Definisi struktur tabel users
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            // Hanya satu role yang tersedia: admin
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin'],
                'default'    => 'admin',
                'null'       => false,
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

        // Atur unique key untuk kolom email (mencegah duplikasi)
        $this->forge->addUniqueKey('email');

        // Buat tabel
        $this->forge->createTable('users');
    }

    public function down()
    {
        // Hapus tabel jika migrasi di-rollback
        $this->forge->dropTable('users');
    }
}
