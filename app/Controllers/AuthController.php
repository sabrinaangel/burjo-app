<?php

namespace App\Controllers;

use App\Models\UserModel;

/**
 * AuthController – Mengelola autentikasi admin (login & logout)
 *
 * Alur login:
 * 1. Admin buka /login → tampil form
 * 2. Submit form → attemptLogin() verifikasi email + password
 * 3. Jika valid → simpan ke session → redirect /menu
 * 4. Jika gagal → flash error → kembali ke /login
 */
class AuthController extends BaseController
{
    // ===================================================================
    // LOGIN (GET) - Tampilkan halaman form login
    // ===================================================================
    public function login()
    {
        // Jika sudah login, langsung redirect ke menu (tidak perlu login ulang)
        if (session()->get('user_id')) {
            return redirect()->to('/menu');
        }

        return view('auth/login', [
            'title' => 'Login Admin - Burjo Ku',
        ]);
    }

    // ===================================================================
    // ATTEMPT LOGIN (POST) - Proses verifikasi email & password
    // ===================================================================
    public function attemptLogin()
    {
        // Ambil input dari form
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validasi input dasar (tidak boleh kosong)
        if (empty($email) || empty($password)) {
            session()->setFlashdata('error', 'Email dan password wajib diisi.');
            return redirect()->to('/login');
        }

        // Cari user di database berdasarkan email
        $userModel = new UserModel();
        $user      = $userModel->where('email', $email)->first();

        // Jika user tidak ditemukan
        if (!$user) {
            session()->setFlashdata('error', 'Email atau password salah. Silakan coba lagi.');
            return redirect()->to('/login');
        }

        // Verifikasi password menggunakan password_verify() (bcrypt)
        if (!password_verify($password, $user['password'])) {
            session()->setFlashdata('error', 'Email atau password salah. Silakan coba lagi.');
            return redirect()->to('/login');
        }

        // Login berhasil – simpan data user ke session CI4
        session()->set([
            'user_id'   => $user['id'],
            'user_name' => $user['name'],
            'user_email'=> $user['email'],
            'user_role' => $user['role'],
            'isLoggedIn'=> true,
        ]);

        // Flash message selamat datang
        session()->setFlashdata('success', 'Selamat datang kembali, <strong>' . esc($user['name']) . '</strong>! 👋');

        // Redirect ke halaman utama admin
        return redirect()->to('/menu');
    }

    // ===================================================================
    // LOGOUT (GET) - Hapus session & redirect ke login
    // ===================================================================
    public function logout()
    {
        // Ambil nama user sebelum session dihapus untuk flash message
        $userName = session()->get('user_name') ?? 'Admin';

        // Hapus semua data session
        session()->destroy();

        // Flash message perpisahan (disimpan di session baru)
        session()->setFlashdata('success', 'Sampai jumpa, <strong>' . esc($userName) . '</strong>! Anda berhasil logout. 👋');

        return redirect()->to('/login');
    }
}
