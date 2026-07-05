<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * AuthFilter – Filter autentikasi untuk melindungi halaman admin
 *
 * Filter ini memastikan hanya pengguna yang sudah login yang
 * bisa mengakses route yang dilindungi. Jika belum login,
 * pengguna akan diredirect ke halaman login.
 */
class AuthFilter implements FilterInterface
{
    /**
     * Dijalankan SEBELUM controller dieksekusi.
     * Cek apakah session user_id tersedia (sudah login).
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Ambil session library CI4
        $session = session();

        // Jika user_id tidak ada di session, berarti belum login
        if (!$session->get('user_id')) {
            // Simpan URL yang dituju agar bisa redirect setelah login (opsional)
            $session->setFlashdata('error', 'Anda harus login terlebih dahulu untuk mengakses halaman ini.');

            // Redirect ke halaman login
            return redirect()->to('/login');
        }

        // Jika sudah login, lanjutkan request ke controller
    }

    /**
     * Dijalankan SETELAH controller selesai dieksekusi.
     * Tidak diperlukan tindakan khusus setelah request.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah request
    }
}
