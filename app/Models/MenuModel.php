<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * MenuModel - Model untuk mengelola data menu Burjo (makanan & minuman)
 */
class MenuModel extends Model
{
    // Nama tabel di database
    protected $table = 'menu';

    // Primary key tabel
    protected $primaryKey = 'id';

    // Tipe kembalian data (object atau array)
    protected $returnType = 'array';

    // Aktifkan soft delete – hapus data akan ditandai deleted_at, bukan dihapus permanen
    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';

    // Kolom yang boleh diisi (mass assignment)
    protected $allowedFields = [
        'nama_menu',
        'kategori',
        'harga',
        'deskripsi',
        'gambar',     // nama file foto menu
        'deleted_at', // diperlukan untuk operasi restore
    ];

    // Aktifkan timestamps otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ===== ATURAN VALIDASI =====
    protected $validationRules = [
        'nama_menu' => 'required|min_length[2]|max_length[100]',
        'kategori'  => 'required|in_list[Makanan,Minuman]',
        'harga'     => 'required|numeric|greater_than[0]',
        'deskripsi' => 'permit_empty|max_length[500]',
    ];

    // Pesan error validasi dalam Bahasa Indonesia
    protected $validationMessages = [
        'nama_menu' => [
            'required'   => 'Nama menu wajib diisi.',
            'min_length' => 'Nama menu minimal 2 karakter.',
            'max_length' => 'Nama menu maksimal 100 karakter.',
        ],
        'kategori' => [
            'required' => 'Kategori wajib dipilih.',
            'in_list'  => 'Kategori harus berupa Makanan atau Minuman.',
        ],
        'harga' => [
            'required'     => 'Harga wajib diisi.',
            'numeric'      => 'Harga harus berupa angka.',
            'greater_than' => 'Harga harus lebih dari 0.',
        ],
        'deskripsi' => [
            'max_length' => 'Deskripsi maksimal 500 karakter.',
        ],
    ];

    // Hentikan validasi pada error pertama
    protected $skipValidation = false;

    /**
     * Ambil semua menu berdasarkan filter kategori
     *
     * @param string|null $kategori Filter kategori (Makanan/Minuman/null untuk semua)
     * @return array
     */
    public function getMenuByKategori(?string $kategori = null): array
    {
        if ($kategori && in_array($kategori, ['Makanan', 'Minuman'])) {
            return $this->where('kategori', $kategori)
                        ->orderBy('nama_menu', 'ASC')
                        ->findAll();
        }

        return $this->orderBy('nama_menu', 'ASC')->findAll();
    }

    /**
     * Pulihkan data menu yang sudah di-soft delete
     * (set deleted_at = NULL agar muncul kembali di daftar aktif)
     *
     * @param int $id ID menu yang akan dipulihkan
     * @return bool
     */
    public function restore(int $id): bool
    {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $id)
                        ->update([$this->deletedField => null]);
    }
}
