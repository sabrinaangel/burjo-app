<?php

namespace App\Controllers;

use App\Models\MenuModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * MenuController - Controller utama untuk mengelola CRUD data menu Burjo
 */
class MenuController extends BaseController
{
    // Properti model
    protected MenuModel $menuModel;

    /**
     * Konstruktor - inisialisasi model
     */
    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }

    // ===================================================================
    // INDEX - Tampilkan semua menu dengan filter kategori
    // ===================================================================
    public function index(): string
    {
        // Ambil filter kategori dari query string (jika ada)
        $kategori = $this->request->getGet('kategori');

        // Validasi nilai filter agar aman
        if ($kategori && !in_array($kategori, ['Makanan', 'Minuman'])) {
            $kategori = null;
        }

        // Ambil data menu sesuai filter
        $menu = $this->menuModel->getMenuByKategori($kategori);

        // Hitung jumlah per kategori untuk badge info
        $jumlahMakanan = $this->menuModel->where('kategori', 'Makanan')->countAllResults();
        $jumlahMinuman = $this->menuModel->where('kategori', 'Minuman')->countAllResults();

        // Kirim data ke view
        $data = [
            'title'         => 'Daftar Menu - Burjo Ku',
            'menu'          => $menu,
            'activeFilter'  => $kategori ?? 'Semua',
            'jumlahMakanan' => $jumlahMakanan,
            'jumlahMinuman' => $jumlahMinuman,
            'totalMenu'     => count($menu),
        ];

        return view('menu/index', $data);
    }

    // ===================================================================
    // CREATE (GET) - Tampilkan form tambah menu baru
    // ===================================================================
    public function create(): string
    {
        $data = [
            'title'      => 'Tambah Menu - Burjo Ku',
            'validation' => \Config\Services::validation(),
        ];

        return view('menu/create', $data);
    }

    // ===================================================================
    // STORE (POST) - Proses simpan data menu baru
    // ===================================================================
    public function store()
    {
        // Aturan validasi form
        $rules = [
            'nama_menu' => 'required|min_length[2]|max_length[100]',
            'kategori'  => 'required|in_list[Makanan,Minuman]',
            'harga'     => 'required|numeric|greater_than[0]',
            'deskripsi' => 'permit_empty|max_length[500]',
        ];

        // Pesan error validasi Bahasa Indonesia
        $messages = [
            'nama_menu' => [
                'required'   => 'Nama menu wajib diisi.',
                'min_length' => 'Nama menu minimal 2 karakter.',
                'max_length' => 'Nama menu maksimal 100 karakter.',
            ],
            'kategori' => [
                'required' => 'Kategori wajib dipilih.',
                'in_list'  => 'Pilih kategori yang valid (Makanan atau Minuman).',
            ],
            'harga' => [
                'required'     => 'Harga wajib diisi.',
                'numeric'      => 'Harga harus berupa angka.',
                'greater_than' => 'Harga harus lebih dari Rp 0.',
            ],
        ];

        // Jika validasi gagal, kembalikan ke form dengan error
        if (!$this->validate($rules, $messages)) {
            return view('menu/create', [
                'title'      => 'Tambah Menu - Burjo Ku',
                'validation' => $this->validator,
            ]);
        }

        // Simpan data ke database
        $this->menuModel->save([
            'nama_menu' => $this->request->getPost('nama_menu'),
            'kategori'  => $this->request->getPost('kategori'),
            'harga'     => (int) $this->request->getPost('harga'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ]);

        // Set flash message sukses
        session()->setFlashdata('success', 'Menu <strong>' . esc($this->request->getPost('nama_menu')) . '</strong> berhasil ditambahkan! 🎉');

        return redirect()->to('/menu');
    }

    // ===================================================================
    // EDIT (GET) - Tampilkan form edit menu
    // ===================================================================
    public function edit(int $id): string
    {
        // Cari data menu berdasarkan ID
        $menu = $this->menuModel->find($id);

        // Jika tidak ditemukan, lempar 404
        if (!$menu) {
            throw new PageNotFoundException("Menu dengan ID $id tidak ditemukan.");
        }

        $data = [
            'title'      => 'Edit Menu - Burjo Ku',
            'menu'       => $menu,
            'validation' => \Config\Services::validation(),
        ];

        return view('menu/edit', $data);
    }

    // ===================================================================
    // UPDATE (POST) - Proses update data menu
    // ===================================================================
    public function update(int $id)
    {
        // Pastikan data yang akan diedit ada
        $menu = $this->menuModel->find($id);

        if (!$menu) {
            throw new PageNotFoundException("Menu dengan ID $id tidak ditemukan.");
        }

        // Aturan validasi form
        $rules = [
            'nama_menu' => 'required|min_length[2]|max_length[100]',
            'kategori'  => 'required|in_list[Makanan,Minuman]',
            'harga'     => 'required|numeric|greater_than[0]',
            'deskripsi' => 'permit_empty|max_length[500]',
        ];

        $messages = [
            'nama_menu' => [
                'required'   => 'Nama menu wajib diisi.',
                'min_length' => 'Nama menu minimal 2 karakter.',
                'max_length' => 'Nama menu maksimal 100 karakter.',
            ],
            'kategori' => [
                'required' => 'Kategori wajib dipilih.',
                'in_list'  => 'Pilih kategori yang valid (Makanan atau Minuman).',
            ],
            'harga' => [
                'required'     => 'Harga wajib diisi.',
                'numeric'      => 'Harga harus berupa angka.',
                'greater_than' => 'Harga harus lebih dari Rp 0.',
            ],
        ];

        // Jika validasi gagal, kembalikan ke form edit dengan error
        if (!$this->validate($rules, $messages)) {
            return view('menu/edit', [
                'title'      => 'Edit Menu - Burjo Ku',
                'menu'       => $menu,
                'validation' => $this->validator,
            ]);
        }

        // Update data di database
        $this->menuModel->update($id, [
            'nama_menu' => $this->request->getPost('nama_menu'),
            'kategori'  => $this->request->getPost('kategori'),
            'harga'     => (int) $this->request->getPost('harga'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ]);

        // Set flash message sukses
        session()->setFlashdata('success', 'Menu <strong>' . esc($this->request->getPost('nama_menu')) . '</strong> berhasil diperbarui! ✏️');

        return redirect()->to('/menu');
    }

    // ===================================================================
    // DELETE (POST) - Proses hapus data menu
    // ===================================================================
    public function delete(int $id)
    {
        // Cari data menu berdasarkan ID
        $menu = $this->menuModel->find($id);

        if (!$menu) {
            // Jika tidak ada, redirect dengan pesan error
            session()->setFlashdata('error', 'Menu tidak ditemukan atau sudah dihapus.');
            return redirect()->to('/menu');
        }

        // Simpan nama menu untuk flash message
        $namaMenu = $menu['nama_menu'];

        // Hapus data dari database
        $this->menuModel->delete($id);

        // Set flash message sukses
        session()->setFlashdata('success', 'Menu <strong>' . esc($namaMenu) . '</strong> berhasil dihapus! 🗑️');

        return redirect()->to('/menu');
    }
}
