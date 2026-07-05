<?php

namespace App\Controllers;

use App\Models\SettingsModel;

/**
 * SettingsController – Mengelola pengaturan aplikasi
 * (password WiFi & gambar QRIS)
 */
class SettingsController extends BaseController
{
    protected $settingsModel;

    public function __construct()
    {
        $this->settingsModel = new SettingsModel();
    }

    // ==============================================================
    // INDEX – Tampilkan halaman pengaturan
    // ==============================================================
    public function index()
    {
        // Ambil semua setting saat ini
        $settings = [
            'wifi_password' => $this->settingsModel->getSetting('wifi_password') ?? '',
            'qris_image'    => $this->settingsModel->getSetting('qris_image')    ?? '',
        ];

        return view('settings/index', [
            'title'    => 'Pengaturan – Burjo Ku',
            'settings' => $settings,
        ]);
    }

    // ==============================================================
    // UPDATE – Simpan setting ke database
    // ==============================================================
    public function update()
    {
        $type = $this->request->getPost('type');

        // ---- Update Password WiFi ----
        if ($type === 'wifi') {
            $wifiPassword = $this->request->getPost('wifi_password');

            // Validasi: tidak boleh kosong
            if (empty(trim($wifiPassword))) {
                return redirect()->to('/settings')
                                 ->with('error', 'Password WiFi tidak boleh kosong.');
            }

            $this->settingsModel->setSetting('wifi_password', $wifiPassword);
            return redirect()->to('/settings')
                             ->with('success', 'Password WiFi berhasil diperbarui.');
        }

        // ---- Update Gambar QRIS ----
        if ($type === 'qris') {
            $file = $this->request->getFile('qris_image');

            // Validasi file
            if (!$file || !$file->isValid() || $file->hasMoved()) {
                return redirect()->to('/settings')
                                 ->with('error', 'File gambar tidak valid atau tidak ditemukan.');
            }

            // Validasi tipe file: hanya JPG dan PNG
            $allowedMime = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!in_array($file->getMimeType(), $allowedMime)) {
                return redirect()->to('/settings')
                                 ->with('error', 'Format file harus JPG atau PNG.');
            }

            // Validasi ukuran: maks 2MB
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->to('/settings')
                                 ->with('error', 'Ukuran file maksimal 2MB.');
            }

            // Buat folder upload jika belum ada
            $uploadPath = FCPATH . 'uploads/qris/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Hapus file lama jika ada
            $oldFile = $this->settingsModel->getSetting('qris_image');
            if ($oldFile && file_exists($uploadPath . $oldFile)) {
                unlink($uploadPath . $oldFile);
            }

            // Pindahkan file baru ke folder upload
            $newName = 'qris_' . time() . '.' . $file->getExtension();
            $file->move($uploadPath, $newName);

            // Simpan nama file ke database
            $this->settingsModel->setSetting('qris_image', $newName);

            return redirect()->to('/settings')
                             ->with('success', 'Gambar QRIS berhasil diperbarui.');
        }

        // Jika type tidak dikenal
        return redirect()->to('/settings')
                         ->with('error', 'Permintaan tidak valid.');
    }
}
