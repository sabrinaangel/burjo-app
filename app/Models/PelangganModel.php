<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * PelangganModel – Model untuk mengelola data pelanggan warung Burjo Ku
 * Mendukung soft delete: data yang dihapus ditandai deleted_at, tidak hilang permanen
 */
class PelangganModel extends Model
{
    // Nama tabel di database
    protected $table      = 'pelanggan';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    // Aktifkan soft delete
    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';

    // Kolom yang boleh diisi (mass assignment)
    protected $allowedFields = [
        'nama',
        'no_hp',
        'alamat',
        'deleted_at', // diperlukan untuk operasi restore
    ];

    // Aktifkan timestamps otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ===== ATURAN VALIDASI =====
    protected $validationRules = [
        'nama'  => 'required|min_length[2]|max_length[100]',
        'no_hp' => 'required|min_length[7]|max_length[20]',
        'alamat'=> 'permit_empty|max_length[500]',
    ];

    // Pesan error validasi dalam Bahasa Indonesia
    protected $validationMessages = [
        'nama' => [
            'required'   => 'Nama pelanggan wajib diisi.',
            'min_length' => 'Nama pelanggan minimal 2 karakter.',
            'max_length' => 'Nama pelanggan maksimal 100 karakter.',
        ],
        'no_hp' => [
            'required'   => 'Nomor HP wajib diisi.',
            'min_length' => 'Nomor HP minimal 7 digit.',
            'max_length' => 'Nomor HP maksimal 20 karakter.',
        ],
        'alamat' => [
            'max_length' => 'Alamat maksimal 500 karakter.',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Pulihkan data pelanggan yang sudah di-soft delete
     *
     * @param int $id ID pelanggan yang akan dipulihkan
     * @return bool
     */
    public function restore(int $id): bool
    {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $id)
                        ->update([$this->deletedField => null]);
    }
}
