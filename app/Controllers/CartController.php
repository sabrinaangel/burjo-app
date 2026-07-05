<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\PelangganModel;
use App\Models\SettingsModel;

/**
 * CartController - Mengelola keranjang belanja pelanggan
 *
 * Alur:
 * 1. Pelanggan buka /order → lihat menu
 * 2. Klik "Tambah ke Keranjang" → insert() ke session cart
 * 3. Buka /cart → lihat isi keranjang, update qty, remove item
 * 4. Checkout → isi nama, pilih metode bayar → dapat struk PDF
 */
class CartController extends BaseController
{
    protected $menuModel;
    protected $pelangganModel;
    protected $settingsModel;

    public function __construct()
    {
        $this->menuModel      = new MenuModel();
        $this->pelangganModel = new PelangganModel();
        $this->settingsModel  = new SettingsModel();
    }

    // ==============================================================
    // HALAMAN ORDER - Tampilkan menu untuk pelanggan (tanpa login)
    // ==============================================================
    public function order()
    {
        // Ambil semua menu aktif
        $kategori = $this->request->getGet('kategori');

        if ($kategori && in_array($kategori, ['Makanan', 'Minuman'])) {
            $menu = $this->menuModel->where('kategori', $kategori)->findAll();
        } else {
            $menu = $this->menuModel->findAll();
            $kategori = 'Semua';
        }

        // Hitung total item di cart untuk badge navbar
        $cart      = session()->get('cart') ?? [];
        $cartCount = array_sum(array_column($cart, 'qty'));

        return view('order/index', [
            'title'     => 'Menu Burjo Ku',
            'menu'      => $menu,
            'kategori'  => $kategori,
            'cartCount' => $cartCount,
        ]);
    }

    // ==============================================================
    // INSERT - Tambahkan item ke keranjang
    // ==============================================================
    public function insert()
    {
        $menuId  = $this->request->getPost('menu_id');
        $qty     = (int) $this->request->getPost('qty') ?: 1;
        // Ambil catatan dari form, default string kosong jika tidak diisi
        $catatan = trim($this->request->getPost('catatan') ?? '');

        // Cari data menu di database
        $menu = $this->menuModel->find($menuId);
        if (!$menu) {
            return redirect()->to('/order')->with('error', 'Menu tidak ditemukan.');
        }

        // Ambil cart dari session
        $cart = session()->get('cart') ?? [];

        // Jika item sudah ada di cart, tambah qty dan update catatan jika ada catatan baru
        if (isset($cart[$menuId])) {
            $cart[$menuId]['qty'] += $qty;
            // Update catatan hanya jika ada catatan baru yang diisi
            if ($catatan !== '') {
                $cart[$menuId]['catatan'] = $catatan;
            }
        } else {
            // Jika belum ada, tambahkan sebagai item baru beserta catatan
            $cart[$menuId] = [
                'menu_id'   => $menu['id'],
                'nama_menu' => $menu['nama_menu'],
                'harga'     => $menu['harga'],
                'kategori'  => $menu['kategori'],
                'qty'       => $qty,
                'catatan'   => $catatan,
            ];
        }

        // Simpan kembali ke session
        session()->set('cart', $cart);

        return redirect()->to('/order')->with('success', '"' . $menu['nama_menu'] . '" berhasil ditambahkan ke keranjang!');
    }

    // ==============================================================
    // CART INDEX - Tampilkan isi keranjang
    // ==============================================================
    public function cart()
    {
        $cart      = session()->get('cart') ?? [];
        $cartCount = array_sum(array_column($cart, 'qty'));

        return view('cart/index', [
            'title'     => 'Keranjang Belanja',
            'cart'      => $cart,
            'total'     => $this->total(),
            'cartCount' => $cartCount,
        ]);
    }

    // ==============================================================
    // UPDATE - Ubah quantity item di keranjang
    // ==============================================================
    public function update()
    {
        $menuId = $this->request->getPost('menu_id');
        $qty    = (int) $this->request->getPost('qty');

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$menuId])) {
            if ($qty <= 0) {
                // Jika qty 0 atau negatif, hapus item
                unset($cart[$menuId]);
                session()->set('cart', $cart);
                return redirect()->to('/cart')->with('success', 'Item dihapus dari keranjang.');
            }
            $cart[$menuId]['qty'] = $qty;
            session()->set('cart', $cart);
        }

        return redirect()->to('/cart')->with('success', 'Jumlah pesanan berhasil diperbarui.');
    }

    // ==============================================================
    // TOTAL - Hitung total harga keranjang
    // ==============================================================
    public function total()
    {
        $cart  = session()->get('cart') ?? [];
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        return $total;
    }

    // ==============================================================
    // REMOVE - Hapus satu item dari keranjang
    // ==============================================================
    public function remove()
    {
        $menuId = $this->request->getPost('menu_id');
        $cart   = session()->get('cart') ?? [];

        if (isset($cart[$menuId])) {
            $namaMenu = $cart[$menuId]['nama_menu'];
            unset($cart[$menuId]);
            session()->set('cart', $cart);
            return redirect()->to('/cart')->with('success', '"' . $namaMenu . '" dihapus dari keranjang.');
        }

        return redirect()->to('/cart')->with('error', 'Item tidak ditemukan di keranjang.');
    }

    // ==============================================================
    // DESTROY - Kosongkan seluruh keranjang
    // ==============================================================
    public function destroy()
    {
        session()->remove('cart');
        return redirect()->to('/cart')->with('success', 'Keranjang berhasil dikosongkan.');
    }

    // ==============================================================
    // CHECKOUT - Tampilkan halaman checkout
    // ==============================================================
    public function checkout()
    {
        $cart = session()->get('cart') ?? [];

        // Jika cart kosong, redirect ke halaman order
        if (empty($cart)) {
            return redirect()->to('/order')->with('error', 'Keranjang belanja masih kosong!');
        }

        // Ambil setting QRIS dari database
        $qrisImage    = $this->settingsModel->getSetting('qris_image') ?? 'qris.png';
        $wifiPassword = $this->settingsModel->getSetting('wifi_password') ?? 'BurjoKu@2026';
        $cartCount    = array_sum(array_column($cart, 'qty'));

        return view('cart/checkout', [
            'title'        => 'Checkout Pesanan',
            'cart'         => $cart,
            'total'        => $this->total(),
            'qrisImage'    => $qrisImage,
            'wifiPassword' => $wifiPassword,
            'cartCount'    => $cartCount,
        ]);
    }

    // ==============================================================
    // PROCESS CHECKOUT - Proses data checkout & simpan pelanggan
    // ==============================================================
    public function processCheckout()
    {
        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/order')->with('error', 'Keranjang belanja masih kosong!');
        }

        // Ambil data dari form
        $nama    = $this->request->getPost('nama');
        $noHp    = $this->request->getPost('no_hp');
        $metode  = $this->request->getPost('metode_bayar');

        // Validasi input
        if (empty($nama) || empty($metode)) {
            return redirect()->to('/checkout')->with('error', 'Nama dan metode pembayaran wajib diisi.');
        }

        // Simpan data pelanggan ke database
        $pelangganId = null;
        try {
            $pelangganId = $this->pelangganModel->insert([
                'nama'  => $nama,
                'no_hp' => $noHp ?? '-',
                'alamat' => '-',
            ]);
        } catch (\Exception $e) {
            // Jika gagal simpan pelanggan, tetap lanjut proses
        }

        // Ambil setting untuk struk
        $wifiPassword = $this->settingsModel->getSetting('wifi_password') ?? 'BurjoKu@2026';
        $qrisImage    = $this->settingsModel->getSetting('qris_image') ?? 'qris.png';

        // Simpan data pesanan ke session untuk ditampilkan di struk
        session()->set('last_order', [
            'nama'         => $nama,
            'no_hp'        => $noHp ?? '-',
            'metode_bayar' => $metode,
            'cart'         => $cart,
            'total'        => $this->total(),
            'waktu'        => date('d F Y, H:i') . ' WIB',
            'no_pesanan'   => 'BK-' . strtoupper(substr(uniqid(), -6)),
            'wifi_password'=> $wifiPassword,
            'qris_image'   => $qrisImage,
        ]);

        // Kosongkan cart setelah checkout
        session()->remove('cart');

        return redirect()->to('/struk');
    }

    // ==============================================================
    // STRUK - Tampilkan halaman struk setelah checkout
    // ==============================================================
    public function struk()
    {
        $order = session()->get('last_order');

        // Jika tidak ada data order, redirect ke halaman utama
        if (!$order) {
            return redirect()->to('/order')->with('error', 'Tidak ada data pesanan.');
        }

        return view('cart/struk', [
            'title' => 'Struk Pesanan - Burjo Ku',
            'order' => $order,
        ]);
    }

    // ==============================================================
    // DOWNLOAD MENU PDF – Generate PDF daftar menu per kategori
    // ==============================================================
    public function downloadMenuPdf()
    {
        // Ambil semua menu aktif dari database
        $menuMakanan = $this->menuModel->where('kategori', 'Makanan')->findAll();
        $menuMinuman = $this->menuModel->where('kategori', 'Minuman')->findAll();

        // Ambil setting nama warung dari settings
        $wifiPassword = $this->settingsModel->getSetting('wifi_password') ?? 'BurjoKu@2026';

        // Bangun konten HTML untuk PDF
        $html  = '<!DOCTYPE html>';
        $html .= '<html><head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<style>';
        $html .= 'body{font-family:Arial,sans-serif;color:#2C2C2C;background:#FFFDF7;margin:0;padding:20px}';
        $html .= '.header{text-align:center;padding:20px 0;border-bottom:3px solid #2D5A27;margin-bottom:24px}';
        $html .= '.header h1{font-size:28px;color:#2D5A27;margin:0 0 4px}';
        $html .= '.header p{font-size:12px;color:#6c757d;margin:0}';
        $html .= '.section-title{background:#2D5A27;color:#fff;padding:10px 16px;font-size:14px;font-weight:bold;border-radius:6px;margin:20px 0 12px}';
        $html .= 'table{width:100%;border-collapse:collapse;margin-bottom:16px}';
        $html .= 'th{background:#f0ede0;color:#2D5A27;padding:10px 12px;text-align:left;font-size:12px;border-bottom:2px solid #2D5A27}';
        $html .= 'td{padding:9px 12px;font-size:11px;border-bottom:1px solid #e8e8e8;vertical-align:top}';
        $html .= 'tr:nth-child(even) td{background:#fafaf7}';
        $html .= '.harga{font-weight:bold;color:#2D5A27;white-space:nowrap}';
        $html .= '.footer{text-align:center;margin-top:28px;padding-top:16px;border-top:2px dashed #2D5A27;font-size:11px;color:#6c757d}';
        $html .= '.badge-mk{background:#ff6b35;color:#fff;padding:2px 8px;border-radius:10px;font-size:10px}';
        $html .= '.badge-mn{background:#1a73e8;color:#fff;padding:2px 8px;border-radius:10px;font-size:10px}';
        $html .= '</style></head><body>';

        // Header PDF
        $html .= '<div class="header">';
        $html .= '<h1>&#x1F35C; Burjo Ku</h1>';
        $html .= '<p>Warung Makan Favorit Sejak 1998</p>';
        $html .= '<p>Daftar Menu – Per ' . date('d F Y') . '</p>';
        $html .= '</div>';

        // Section MAKANAN
        if (!empty($menuMakanan)) {
            $html .= '<div class="section-title">&#x1F35B; Makanan</div>';
            $html .= '<table><thead><tr>';
            $html .= '<th>#</th><th>Nama Menu</th><th>Deskripsi</th><th>Harga</th>';
            $html .= '</tr></thead><tbody>';
            foreach ($menuMakanan as $i => $m) {
                $html .= '<tr>';
                $html .= '<td>' . ($i + 1) . '</td>';
                $html .= '<td><strong>' . htmlspecialchars($m['nama_menu']) . '</strong></td>';
                $html .= '<td>' . (empty($m['deskripsi']) ? '-' : htmlspecialchars($m['deskripsi'])) . '</td>';
                $html .= '<td class="harga">Rp ' . number_format($m['harga'], 0, ',', '.') . '</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody></table>';
        }

        // Section MINUMAN
        if (!empty($menuMinuman)) {
            $html .= '<div class="section-title">&#x1F964; Minuman</div>';
            $html .= '<table><thead><tr>';
            $html .= '<th>#</th><th>Nama Menu</th><th>Deskripsi</th><th>Harga</th>';
            $html .= '</tr></thead><tbody>';
            foreach ($menuMinuman as $i => $m) {
                $html .= '<tr>';
                $html .= '<td>' . ($i + 1) . '</td>';
                $html .= '<td><strong>' . htmlspecialchars($m['nama_menu']) . '</strong></td>';
                $html .= '<td>' . (empty($m['deskripsi']) ? '-' : htmlspecialchars($m['deskripsi'])) . '</td>';
                $html .= '<td class="harga">Rp ' . number_format($m['harga'], 0, ',', '.') . '</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody></table>';
        }

        // Footer PDF
        $html .= '<div class="footer">';
        $html .= '<p>Scan QR untuk pesan langsung di website kami</p>';
        $html .= '<p style="margin-top:6px">&#x1F4F6; WiFi Gratis: <strong>' . htmlspecialchars($wifiPassword) . '</strong></p>';
        $html .= '</div>';
        $html .= '</body></html>';

        // Generate PDF dengan Dompdf
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Kirim sebagai file download
        $dompdf->stream('daftar-menu-burjoku.pdf', ['Attachment' => true]);
        exit;
    }

    // ==============================================================
    // DOWNLOAD STRUK PDF – Generate PDF struk dari last_order session
    // Ukuran kertas: 80mm x 200mm (seperti struk kasir thermal)
    // ==============================================================
    public function downloadStrukPdf()
    {
        $order = session()->get('last_order');

        // Jika tidak ada data pesanan di session, redirect
        if (!$order) {
            return redirect()->to('/order')->with('error', 'Tidak ada data pesanan untuk diunduh.');
        }

        // ── CSS compact untuk struk kasir thermal 80mm ─────────────
        // Lebar efektif ~72mm setelah margin 4mm kiri-kanan
        // Font dasar 11px, baris rapat agar semua muat dalam 1 halaman
        $css  = 'body{font-family:Arial,sans-serif;font-size:11px;color:#1a1a1a;';
        $css .= 'margin:0;padding:4mm 4mm 6mm 4mm;background:#fff;line-height:1.4}';
        $css .= '.hdr{text-align:center;padding-bottom:5px;';
        $css .= 'border-bottom:2px solid #2D5A27;margin-bottom:6px}';
        $css .= '.hdr-nama{font-size:15px;font-weight:bold;color:#2D5A27;margin:0}';
        $css .= '.hdr-sub{font-size:9px;color:#555;margin:1px 0}';
        $css .= '.info-blok{margin-bottom:5px;border-bottom:1px dashed #ccc;padding-bottom:4px}';
        $css .= '.row{display:flex;justify-content:space-between;padding:1px 0;font-size:11px}';
        $css .= '.lbl{color:#555}';
        $css .= '.val{font-weight:bold;text-align:right;max-width:55%}';
        $css .= '.sek{font-size:9px;text-transform:uppercase;letter-spacing:.4px;';
        $css .= 'color:#777;margin:5px 0 3px;font-weight:bold}';
        $css .= 'table{width:100%;border-collapse:collapse;margin-bottom:4px}';
        $css .= 'td{padding:2px 0;font-size:11px;vertical-align:top;border-bottom:1px dashed #e0e0e0}';
        $css .= 'td:last-child{text-align:right;white-space:nowrap;font-weight:bold;color:#2D5A27}';
        $css .= '.item-meta{font-size:9px;color:#777}';
        $css .= '.total-blok{border-top:2px solid #2D5A27;margin-top:4px;';
        $css .= 'padding-top:4px;display:flex;justify-content:space-between;align-items:baseline}';
        $css .= '.total-lbl{font-size:12px;font-weight:bold}';
        $css .= '.total-val{font-size:14px;font-weight:bold;color:#2D5A27}';
        $css .= '.wifi{background:#f0ede0;border:1.5px solid #2D5A27;';
        $css .= 'border-radius:5px;padding:5px 6px;text-align:center;margin-top:7px}';
        $css .= '.wifi-lbl{font-size:8px;text-transform:uppercase;letter-spacing:.5px;color:#777;margin:0}';
        $css .= '.wifi-pass{font-size:13px;font-weight:bold;color:#2D5A27;letter-spacing:2px;margin:2px 0 0}';
        $css .= '.ftr{text-align:center;margin-top:8px;border-top:1px dashed #ccc;';
        $css .= 'padding-top:5px;font-size:9px;color:#777}';

        // ── Bangun HTML struk ────────────────────────────────────────
        $html  = '<!DOCTYPE html><html><head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<style>' . $css . '</style>';
        $html .= '</head><body>';

        // Header warung
        $html .= '<div class="hdr">';
        $html .= '<p class="hdr-nama">BURJO KU</p>';
        $html .= '<p class="hdr-sub">Warung Makan Favorit Sejak 1998</p>';
        $html .= '<p class="hdr-sub">STRUK PESANAN</p>';
        $html .= '</div>';

        // Info pesanan
        $html .= '<div class="info-blok">';
        $html .= '<div class="row"><span class="lbl">No. Pesanan:</span><span class="val">' . htmlspecialchars($order['no_pesanan']) . '</span></div>';
        $html .= '<div class="row"><span class="lbl">Nama:</span><span class="val">' . htmlspecialchars($order['nama']) . '</span></div>';
        if (!empty($order['no_hp']) && $order['no_hp'] !== '-') {
            $html .= '<div class="row"><span class="lbl">No HP:</span><span class="val">' . htmlspecialchars($order['no_hp']) . '</span></div>';
        }
        $html .= '<div class="row"><span class="lbl">Waktu:</span><span class="val">' . htmlspecialchars($order['waktu']) . '</span></div>';
        $html .= '<div class="row"><span class="lbl">Metode Bayar:</span><span class="val">' . htmlspecialchars($order['metode_bayar']) . '</span></div>';
        $html .= '</div>';

        // Daftar item pesanan
        $html .= '<p class="sek">Detail Pesanan</p>';
        $html .= '<table><tbody>';
        foreach ($order['cart'] as $item) {
            $subtotal = $item['harga'] * $item['qty'];
            $html .= '<tr>';
            $html .= '<td><strong>' . htmlspecialchars($item['nama_menu']) . '</strong>';
            // Tampilkan catatan di bawah nama menu jika ada
            if (!empty($item['catatan'])) {
                $html .= '<br><span style="font-size:8px;color:#888;font-style:italic">&#9998; ' . htmlspecialchars($item['catatan']) . '</span>';
            }
            $html .= '<br><span class="item-meta">' . $item['qty'] . ' x Rp ' . number_format($item['harga'], 0, ',', '.') . '</span></td>';
            $html .= '<td>Rp ' . number_format($subtotal, 0, ',', '.') . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';

        // Total pembayaran
        $html .= '<div class="total-blok">';
        $html .= '<span class="total-lbl">TOTAL</span>';
        $html .= '<span class="total-val">Rp ' . number_format($order['total'], 0, ',', '.') . '</span>';
        $html .= '</div>';

        // Kotak password WiFi (highlight menarik)
        if (!empty($order['wifi_password'])) {
            $html .= '<div class="wifi">';
            $html .= '<p class="wifi-lbl">&#x1F4F6; Password WiFi Gratis</p>';
            $html .= '<p class="wifi-pass">' . htmlspecialchars($order['wifi_password']) . '</p>';
            $html .= '</div>';
        }

        // Footer struk
        $html .= '<div class="ftr">';
        $html .= '<p>Terima kasih! Selamat menikmati!</p>';
        $html .= '<p>Burjo Ku &copy; ' . date('Y') . '</p>';
        $html .= '</div>';

        $html .= '</body></html>';

        // ── Generate PDF dengan Dompdf ──────────────────────────────
        // Ukuran custom 80mm x 200mm dikonversi ke satuan point
        // Konversi: 1mm = 2.83465 pt
        // 80mm  = 226.77 pt  |  200mm = 566.93 pt
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', false);  // nonaktifkan remote resource
        $options->set('defaultFont', 'Arial');    // font default

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');

        // Set kertas custom: [lebar, tinggi] dalam satuan point
        $dompdf->setPaper([0, 0, 226.77, 566.93]);
        $dompdf->render();

        // Nama file download berdasarkan no pesanan
        $filename = 'struk-' . strtolower(str_replace('/', '-', $order['no_pesanan'])) . '.pdf';
        $dompdf->stream($filename, ['Attachment' => true]);
        exit;
    }
}