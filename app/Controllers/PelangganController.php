<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * PelangganController – Controller untuk mengelola CRUD data pelanggan Burjo Ku
 * Mendukung soft delete: trash, restore, dan force delete
 */
class PelangganController extends BaseController
{
    protected PelangganModel $pelangganModel;

    public function __construct()
    {
        $this->pelangganModel = new PelangganModel();
    }

    // ===================================================================
    // INDEX - Tampilkan semua pelanggan aktif (belum dihapus)
    // ===================================================================
    public function index(): string
    {
        // Ambil semua pelanggan aktif, diurutkan berdasarkan nama
        $pelanggan = $this->pelangganModel->orderBy('nama', 'ASC')->findAll();

        $data = [
            'title'     => 'Daftar Pelanggan - Burjo Ku',
            'pelanggan' => $pelanggan,
            'total'     => count($pelanggan),
            // Hitung data di sampah untuk ditampilkan di badge
            'totalSampah' => $this->pelangganModel->onlyDeleted()->countAllResults(),
        ];

        return view('pelanggan/index', $data);
    }

    // ===================================================================
    // CREATE (GET) - Form tambah pelanggan baru
    // ===================================================================
    public function create(): string
    {
        $data = [
            'title'      => 'Tambah Pelanggan - Burjo Ku',
            'validation' => \Config\Services::validation(),
        ];

        return view('pelanggan/create', $data);
    }

    // ===================================================================
    // STORE (POST) - Simpan data pelanggan baru
    // ===================================================================
    public function store()
    {
        // Aturan validasi form
        $rules = [
            'nama'  => 'required|min_length[2]|max_length[100]',
            'no_hp' => 'required|min_length[7]|max_length[20]',
            'alamat'=> 'permit_empty|max_length[500]',
        ];

        $messages = [
            'nama' => [
                'required'   => 'Nama pelanggan wajib diisi.',
                'min_length' => 'Nama minimal 2 karakter.',
                'max_length' => 'Nama maksimal 100 karakter.',
            ],
            'no_hp' => [
                'required'   => 'Nomor HP wajib diisi.',
                'min_length' => 'Nomor HP minimal 7 digit.',
                'max_length' => 'Nomor HP maksimal 20 karakter.',
            ],
        ];

        // Kembalikan ke form jika validasi gagal
        if (!$this->validate($rules, $messages)) {
            return view('pelanggan/create', [
                'title'      => 'Tambah Pelanggan - Burjo Ku',
                'validation' => $this->validator,
            ]);
        }

        // Simpan data baru ke database
        $this->pelangganModel->save([
            'nama'  => $this->request->getPost('nama'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat'=> $this->request->getPost('alamat'),
        ]);

        session()->setFlashdata('success', 'Pelanggan <strong>' . esc($this->request->getPost('nama')) . '</strong> berhasil ditambahkan! 🎉');

        return redirect()->to('/pelanggan');
    }

    // ===================================================================
    // EDIT (GET) - Form edit data pelanggan
    // ===================================================================
    public function edit(int $id): string
    {
        $pelanggan = $this->pelangganModel->find($id);

        if (!$pelanggan) {
            throw new PageNotFoundException("Pelanggan dengan ID $id tidak ditemukan.");
        }

        $data = [
            'title'      => 'Edit Pelanggan - Burjo Ku',
            'pelanggan'  => $pelanggan,
            'validation' => \Config\Services::validation(),
        ];

        return view('pelanggan/edit', $data);
    }

    // ===================================================================
    // UPDATE (POST) - Proses update data pelanggan
    // ===================================================================
    public function update(int $id)
    {
        $pelanggan = $this->pelangganModel->find($id);

        if (!$pelanggan) {
            throw new PageNotFoundException("Pelanggan dengan ID $id tidak ditemukan.");
        }

        $rules = [
            'nama'  => 'required|min_length[2]|max_length[100]',
            'no_hp' => 'required|min_length[7]|max_length[20]',
            'alamat'=> 'permit_empty|max_length[500]',
        ];

        $messages = [
            'nama' => [
                'required'   => 'Nama pelanggan wajib diisi.',
                'min_length' => 'Nama minimal 2 karakter.',
                'max_length' => 'Nama maksimal 100 karakter.',
            ],
            'no_hp' => [
                'required'   => 'Nomor HP wajib diisi.',
                'min_length' => 'Nomor HP minimal 7 digit.',
                'max_length' => 'Nomor HP maksimal 20 karakter.',
            ],
        ];

        // Kembalikan ke form edit jika validasi gagal
        if (!$this->validate($rules, $messages)) {
            return view('pelanggan/edit', [
                'title'      => 'Edit Pelanggan - Burjo Ku',
                'pelanggan'  => $pelanggan,
                'validation' => $this->validator,
            ]);
        }

        // Update data di database
        $this->pelangganModel->update($id, [
            'nama'  => $this->request->getPost('nama'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat'=> $this->request->getPost('alamat'),
        ]);

        session()->setFlashdata('success', 'Data pelanggan <strong>' . esc($this->request->getPost('nama')) . '</strong> berhasil diperbarui! ✏️');

        return redirect()->to('/pelanggan');
    }

    // ===================================================================
    // DELETE (GET) - Soft delete pelanggan (pindah ke sampah)
    // ===================================================================
    public function delete(int $id)
    {
        $pelanggan = $this->pelangganModel->find($id);

        if (!$pelanggan) {
            session()->setFlashdata('error', 'Pelanggan tidak ditemukan atau sudah dihapus.');
            return redirect()->to('/pelanggan');
        }

        $nama = $pelanggan['nama'];

        // Soft delete: mengisi kolom deleted_at, data tidak hilang permanen
        $this->pelangganModel->delete($id);

        session()->setFlashdata('success', 'Pelanggan <strong>' . esc($nama) . '</strong> dipindahkan ke sampah. <a href="' . base_url('/pelanggan/trash') . '">Lihat Sampah</a>');

        return redirect()->to('/pelanggan');
    }

    // ===================================================================
    // TRASH (GET) - Tampilkan pelanggan yang sudah di-soft delete
    // ===================================================================
    public function trash(): string
    {
        // Ambil hanya data yang sudah di-soft delete
        $pelanggan = $this->pelangganModel->onlyDeleted()
                                          ->orderBy('deleted_at', 'DESC')
                                          ->findAll();

        $data = [
            'title'     => 'Sampah Pelanggan - Burjo Ku',
            'pelanggan' => $pelanggan,
        ];

        return view('pelanggan/trash', $data);
    }

    // ===================================================================
    // RESTORE (GET) - Pulihkan pelanggan dari sampah ke daftar aktif
    // ===================================================================
    public function restore(int $id)
    {
        // Cari data termasuk yang sudah di-soft delete
        $pelanggan = $this->pelangganModel->withDeleted()->find($id);

        if (!$pelanggan || empty($pelanggan['deleted_at'])) {
            session()->setFlashdata('error', 'Data pelanggan tidak ditemukan di sampah.');
            return redirect()->to('/pelanggan/trash');
        }

        // Pulihkan data (set deleted_at = NULL)
        $this->pelangganModel->restore($id);

        session()->setFlashdata('success', 'Pelanggan <strong>' . esc($pelanggan['nama']) . '</strong> berhasil dipulihkan! ♻️');

        return redirect()->to('/pelanggan/trash');
    }

    // ===================================================================
    // FORCE DELETE (GET) - Hapus pelanggan secara permanen
    // ===================================================================
    public function forceDelete(int $id)
    {
        // Cari data termasuk yang sudah di-soft delete
        $pelanggan = $this->pelangganModel->withDeleted()->find($id);

        if (!$pelanggan) {
            session()->setFlashdata('error', 'Data pelanggan tidak ditemukan.');
            return redirect()->to('/pelanggan/trash');
        }

        $nama = $pelanggan['nama'];

        // Hapus permanen dari database (parameter ke-2 true = force/hard delete)
        $this->pelangganModel->delete($id, true);

        session()->setFlashdata('success', 'Pelanggan <strong>' . esc($nama) . '</strong> dihapus permanen! 🗑️');

        return redirect()->to('/pelanggan/trash');
    }
}
