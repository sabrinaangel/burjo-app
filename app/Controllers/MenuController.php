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

        // Hitung jumlah item di sampah (soft deleted)
        $trashCount = $this->menuModel->onlyDeleted()->countAllResults();

        // Kirim data ke view
        $data = [
            'title'         => 'Daftar Menu - Burjo Ku',
            'menu'          => $menu,
            'activeFilter'  => $kategori ?? 'Semua',
            'jumlahMakanan' => $jumlahMakanan,
            'jumlahMinuman' => $jumlahMinuman,
            'totalMenu'     => count($menu),
            'trashCount'    => $trashCount,
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

        // Validasi tambahan untuk file gambar (opsional)
        $rules['gambar'] = 'permit_empty|uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]';
        $messages['gambar'] = [
            'max_size'  => 'Ukuran foto maksimal 2MB.',
            'is_image'  => 'File harus berupa gambar.',
            'mime_in'   => 'Format foto harus JPG, PNG, atau WebP.',
        ];

        // Jika validasi gagal, kembalikan ke form dengan error
        if (!$this->validate($rules, $messages)) {
            return view('menu/create', [
                'title'      => 'Tambah Menu - Burjo Ku',
                'validation' => $this->validator,
            ]);
        }

        // Proses upload gambar jika ada file yang diunggah
        $namaFile = null;
        $fileFoto = $this->request->getFile('gambar');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            // Buat folder upload jika belum ada
            $folderUpload = FCPATH . 'uploads/menu/';
            if (!is_dir($folderUpload)) {
                mkdir($folderUpload, 0755, true);
            }
            // Beri nama unik agar tidak bertabrakan
            $namaFile = 'menu_' . time() . '_' . uniqid() . '.' . $fileFoto->getExtension();
            $fileFoto->move($folderUpload, $namaFile);
        }

        // Simpan data ke database
        $this->menuModel->save([
            'nama_menu' => $this->request->getPost('nama_menu'),
            'kategori'  => $this->request->getPost('kategori'),
            'harga'     => (int) $this->request->getPost('harga'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar'    => $namaFile, // null jika tidak ada foto
        ]);

        // Set flash message sukses
        session()->setFlashdata('success', 'Menu <strong>' . esc($this->request->getPost('nama_menu')) . '</strong> berhasil ditambahkan!');

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

        // Validasi tambahan untuk file gambar (opsional saat update)
        $rules['gambar'] = 'permit_empty|uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]';
        $messages['gambar'] = [
            'max_size' => 'Ukuran foto maksimal 2MB.',
            'is_image' => 'File harus berupa gambar.',
            'mime_in'  => 'Format foto harus JPG, PNG, atau WebP.',
        ];

        // Jika validasi gagal, kembalikan ke form edit dengan error
        if (!$this->validate($rules, $messages)) {
            return view('menu/edit', [
                'title'      => 'Edit Menu - Burjo Ku',
                'menu'       => $menu,
                'validation' => $this->validator,
            ]);
        }

        // Proses upload gambar baru jika ada file yang diunggah
        $namaFileBaru = $menu['gambar']; // default: pakai gambar lama
        $fileFoto     = $this->request->getFile('gambar');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            // Hapus gambar lama dari server jika ada
            if (!empty($menu['gambar'])) {
                $pathLama = FCPATH . 'uploads/menu/' . $menu['gambar'];
                if (file_exists($pathLama)) {
                    unlink($pathLama);
                }
            }
            // Buat folder upload jika belum ada
            $folderUpload = FCPATH . 'uploads/menu/';
            if (!is_dir($folderUpload)) {
                mkdir($folderUpload, 0755, true);
            }
            // Simpan file baru dengan nama unik
            $namaFileBaru = 'menu_' . time() . '_' . uniqid() . '.' . $fileFoto->getExtension();
            $fileFoto->move($folderUpload, $namaFileBaru);
        }

        // Update data di database
        $this->menuModel->update($id, [
            'nama_menu' => $this->request->getPost('nama_menu'),
            'kategori'  => $this->request->getPost('kategori'),
            'harga'     => (int) $this->request->getPost('harga'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar'    => $namaFileBaru,
        ]);

        // Set flash message sukses
        session()->setFlashdata('success', 'Menu <strong>' . esc($this->request->getPost('nama_menu')) . '</strong> berhasil diperbarui!');

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

        // Set flash message sukses (soft delete)
        session()->setFlashdata('success', 'Menu <strong>' . esc($namaMenu) . '</strong> dipindahkan ke sampah. <a href="' . base_url('/menu/trash') . '">Lihat Sampah</a>');

        return redirect()->to('/menu');
    }

    // ===================================================================
    // TRASH (GET) - Tampilkan menu yang sudah di-soft delete
    // ===================================================================
    public function trash(): string
    {
        // Ambil hanya data yang sudah di-soft delete, diurutkan terbaru
        $menu = $this->menuModel->onlyDeleted()
                                ->orderBy('deleted_at', 'DESC')
                                ->findAll();

        $data = [
            'title' => 'Sampah Menu - Burjo Ku',
            'menu'  => $menu,
        ];

        return view('menu/trash', $data);
    }

    // ===================================================================
    // RESTORE (POST) - Pulihkan menu dari sampah kembali ke aktif
    // ===================================================================
    public function restore(int $id)
    {
        // Cari data termasuk yang sudah di-soft delete
        $menu = $this->menuModel->withDeleted()->find($id);

        // Pastikan data ada dan memang sudah dihapus (deleted_at tidak null)
        if (!$menu || empty($menu['deleted_at'])) {
            session()->setFlashdata('error', 'Data tidak ditemukan di sampah.');
            return redirect()->to('/menu/trash');
        }

        // Pulihkan data (set deleted_at = NULL)
        $this->menuModel->restore($id);

        session()->setFlashdata('success', 'Menu <strong>' . esc($menu['nama_menu']) . '</strong> berhasil dipulihkan! ♻️');

        return redirect()->to('/menu/trash');
    }

    // ===================================================================
    // FORCE DELETE (POST) - Hapus menu secara permanen dari sampah
    // ===================================================================
    public function forceDelete(int $id)
    {
        // Cari data termasuk yang sudah di-soft delete
        $menu = $this->menuModel->withDeleted()->find($id);

        if (!$menu) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to('/menu/trash');
        }

        $namaMenu = $menu['nama_menu'];

        // Hapus permanen dari database (parameter ke-2 true = force/hard delete)
        $this->menuModel->delete($id, true);

        session()->setFlashdata('success', 'Menu <strong>' . esc($namaMenu) . '</strong> dihapus permanen! 🗑️');

        return redirect()->to('/menu/trash');
    }
}
