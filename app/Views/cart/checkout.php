<?php
/**
 * View: cart/checkout.php
 * Halaman checkout – isi nama, pilih metode bayar
 * Warm & Cozy design – tanpa admin header/footer
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Checkout – Burjo Ku') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root{--bg-cream:#FFFDF7;--primary:#2D5A27;--primary-dark:#1e3d1a;--primary-light:#3a7232;--accent:#F2A135;--accent-dark:#d4882a;--text-main:#2C2C2C;--text-muted:#6c757d;--danger:#E74C3C;--shadow-sm:0 2px 8px rgba(45,90,39,.08);--shadow-md:0 4px 20px rgba(45,90,39,.12);--shadow-lg:0 8px 32px rgba(45,90,39,.16);--radius:16px;--trans:all .3s cubic-bezier(.25,.46,.45,.94)}
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Poppins',sans-serif;background:var(--bg-cream);color:var(--text-main);min-height:100vh;display:flex;flex-direction:column}
        h1,h2,h3,h4,h5{font-family:'Playfair Display',serif}

        /* NAVBAR */
        .nav-burjo{background:linear-gradient(135deg,var(--primary),var(--primary-dark));padding:14px 0;box-shadow:0 4px 20px rgba(45,90,39,.25);position:sticky;top:0;z-index:1030}
        .brand-text{font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:800;color:#fff!important;text-decoration:none}
        .brand-text span{color:var(--accent)}
        .btn-nav{font-size:.82rem;font-weight:600;padding:8px 16px;border-radius:10px;border:none;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:var(--trans)}
        .btn-back{background:rgba(255,255,255,.15);color:#fff!important;border:1.5px solid rgba(255,255,255,.3)}
        .btn-back:hover{background:rgba(255,255,255,.25);transform:translateY(-1px)}

        /* CARD */
        .card-burjo{background:#fff;border-radius:var(--radius);box-shadow:var(--shadow-sm);padding:28px;margin-bottom:20px}

        /* FORM */
        .form-label-b{font-weight:600;font-size:.875rem;color:var(--text-main);margin-bottom:6px}
        .form-ctrl{border:2px solid #e8e8e8;border-radius:10px;padding:10px 14px;font-family:'Poppins',sans-serif;font-size:.875rem;background:#fafafa;transition:var(--trans);width:100%}
        .form-ctrl:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(45,90,39,.1);outline:none;background:#fff}
        .form-ctrl.is-invalid{border-color:var(--danger)}

        /* METODE BAYAR */
        .metode-card{border:2px solid #e8e8e8;border-radius:12px;padding:16px;cursor:pointer;transition:var(--trans);background:#fff}
        .metode-card:hover{border-color:var(--primary);transform:translateY(-2px);box-shadow:var(--shadow-sm)}
        .metode-card input[type=radio]{display:none}
        .metode-card.selected{border-color:var(--primary);background:linear-gradient(135deg,rgba(45,90,39,.05),rgba(45,90,39,.02));box-shadow:0 0 0 3px rgba(45,90,39,.1)}
        .metode-icon{font-size:2rem;margin-bottom:6px;display:block}
        .metode-label{font-weight:700;font-size:.9rem;color:var(--text-main)}
        .metode-desc{font-size:.75rem;color:var(--text-muted)}

        /* QRIS IMAGE */
        .qris-box{background:linear-gradient(135deg,#f8f8f2,#f0ede0);border-radius:12px;padding:20px;text-align:center;border:2px dashed rgba(45,90,39,.2)}
        .qris-box img{max-width:180px;border-radius:8px;box-shadow:var(--shadow-sm)}

        /* SUMMARY */
        .summary-item{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f5f5f5;font-size:.85rem}
        .total-big{font-size:1.5rem;font-weight:800;color:var(--primary);font-family:'Playfair Display',serif}

        /* BUTTONS */
        .btn-confirm{width:100%;background:linear-gradient(135deg,var(--accent),var(--accent-dark));border:none;color:var(--text-main);font-weight:700;font-size:1rem;padding:15px;border-radius:12px;cursor:pointer;transition:var(--trans);display:flex;align-items:center;justify-content:center;gap:8px}
        .btn-confirm:hover{transform:translateY(-2px);box-shadow:var(--shadow-md)}
        .btn-cancel{width:100%;background:transparent;border:2px solid #e8e8e8;color:var(--text-muted);font-weight:600;font-size:.875rem;padding:12px;border-radius:12px;cursor:pointer;transition:var(--trans);text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;margin-top:10px}
        .btn-cancel:hover{border-color:var(--primary);color:var(--primary);transform:translateY(-1px)}

        /* FLASH */
        .flash-err{background:linear-gradient(135deg,#fde8e8,#fcc9c9);border-left:5px solid var(--danger);color:#721c24;border-radius:12px;font-size:.875rem;font-weight:500;padding:14px 18px;margin-bottom:16px}

        /* FOOTER */
        .footer-burjo{background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;padding:24px 0;margin-top:auto}
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="nav-burjo">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a href="<?= base_url('/order') ?>" class="brand-text">
                <span style="margin-right:6px">🍜</span>Burjo <span>Ku</span>
            </a>
            <a href="<?= base_url('/cart') ?>" class="btn-nav btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Keranjang
            </a>
        </div>
    </div>
</nav>

<!-- MAIN -->
<main style="padding:36px 0 60px">
    <div class="container">
        <div class="text-center mb-4">
            <h1 style="font-size:2rem;font-weight:800">
                <i class="bi bi-bag-check-fill me-2" style="color:var(--accent)"></i>
                Checkout Pesanan
            </h1>
            <p style="color:var(--text-muted);font-size:.9rem">Lengkapi data di bawah untuk mengkonfirmasi pesananmu</p>
        </div>

        <!-- Flash error -->
        <?php if (session()->getFlashdata('error')): ?>
        <div class="flash-err d-flex align-items-center gap-2">
            <i class="bi bi-x-circle-fill fs-5"></i>
            <span><?= session()->getFlashdata('error') ?></span>
        </div>
        <?php endif; ?>

        <form action="<?= base_url('/checkout/process') ?>" method="POST" id="form-checkout">
            <?= csrf_field() ?>
            <div class="row g-4">

                <!-- KIRI: FORM -->
                <div class="col-lg-7">

                    <!-- Data diri -->
                    <div class="card-burjo">
                        <h5 style="margin-bottom:20px">
                            <i class="bi bi-person-circle me-2" style="color:var(--accent)"></i>
                            Data Pemesan
                        </h5>
                        <div class="mb-3">
                            <label class="form-label-b" for="nama">Nama Lengkap <span style="color:var(--danger)">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-ctrl"
                                   placeholder="Contoh: Budi Santoso"
                                   value="<?= old('nama') ?>" required>
                        </div>
                        <div>
                            <label class="form-label-b" for="no_hp">Nomor HP <span style="color:var(--text-muted);font-weight:400">(opsional)</span></label>
                            <input type="tel" name="no_hp" id="no_hp" class="form-ctrl"
                                   placeholder="Contoh: 08123456789"
                                   value="<?= old('no_hp') ?>">
                        </div>
                    </div>

                    <!-- Metode bayar -->
                    <div class="card-burjo">
                        <h5 style="margin-bottom:20px">
                            <i class="bi bi-credit-card-fill me-2" style="color:var(--accent)"></i>
                            Metode Pembayaran
                        </h5>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="metode-card w-100 text-center" id="label-cash" for="metode-cash">
                                    <input type="radio" name="metode_bayar" id="metode-cash" value="Cash"
                                           <?= (old('metode_bayar')==='Cash')?'checked':'' ?>>
                                    <span class="metode-icon">💵</span>
                                    <p class="metode-label">Cash / Tunai</p>
                                    <p class="metode-desc">Bayar langsung di kasir</p>
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="metode-card w-100 text-center" id="label-qris" for="metode-qris">
                                    <input type="radio" name="metode_bayar" id="metode-qris" value="QRIS"
                                           <?= (old('metode_bayar')==='QRIS')?'checked':'' ?>>
                                    <span class="metode-icon">📱</span>
                                    <p class="metode-label">QRIS</p>
                                    <p class="metode-desc">Scan QR code untuk bayar</p>
                                </label>
                            </div>
                        </div>

                        <!-- Preview QRIS (tampil jika pilih QRIS) -->
                        <div id="qris-preview" style="margin-top:20px;display:none">
                            <div class="qris-box">
                                <p style="font-size:.85rem;font-weight:600;color:var(--primary);margin-bottom:12px">
                                    <i class="bi bi-qr-code me-1"></i> Scan QR Code Ini
                                </p>
                                <?php if (!empty($qrisImage) && file_exists(FCPATH . 'uploads/qris/' . $qrisImage)): ?>
                                    <img src="<?= base_url('uploads/qris/' . $qrisImage) ?>"
                                         alt="QRIS Burjo Ku" id="img-qris">
                                <?php else: ?>
                                    <div style="width:180px;height:180px;background:#e8e8e8;border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto;font-size:.8rem;color:var(--text-muted)">
                                        <i class="bi bi-qr-code" style="font-size:3rem"></i>
                                    </div>
                                    <p style="font-size:.75rem;color:var(--text-muted);margin-top:8px">QRIS belum di-upload admin</p>
                                <?php endif; ?>
                                <p style="font-size:.78rem;color:var(--text-muted);margin-top:10px">
                                    Tunjukkan bukti transfer ke kasir
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KANAN: RINGKASAN + TOMBOL -->
                <div class="col-lg-5">
                    <div class="card-burjo" style="position:sticky;top:90px">
                        <h5 style="margin-bottom:16px;padding-bottom:12px;border-bottom:2px solid #f0ede0">
                            <i class="bi bi-receipt me-2" style="color:var(--accent)"></i>
                            Ringkasan Pesanan
                        </h5>

                        <!-- Daftar item -->
                        <?php foreach ($cart as $item): ?>
                        <div class="summary-item" style="flex-direction:column;align-items:stretch">
                            <div style="display:flex;justify-content:space-between;align-items:flex-start">
                                <span>
                                    <?= esc($item['nama_menu']) ?>
                                    <span style="color:var(--text-muted);font-size:.78rem"> ×<?= $item['qty'] ?></span>
                                </span>
                                <span style="font-weight:600;white-space:nowrap;margin-left:8px">
                                    Rp <?= number_format($item['harga']*$item['qty'],0,',','.') ?>
                                </span>
                            </div>
                            <?php if (!empty($item['catatan'])): ?>
                            <!-- Tampilkan catatan per item jika ada -->
                            <span style="font-size:.75rem;color:var(--text-muted);margin-top:2px">
                                ✏️ <?= esc($item['catatan']) ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>

                        <!-- Total -->
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3" style="border-top:2px solid var(--primary)">
                            <span style="font-weight:700;font-size:.95rem">Total Pembayaran</span>
                            <span class="total-big">Rp <?= number_format($total,0,',','.') ?></span>
                        </div>

                        <!-- Tombol -->
                        <button type="submit" class="btn-confirm mt-4" id="btn-pesan">
                            <i class="bi bi-check2-circle"></i> Konfirmasi Pesanan
                        </button>
                        <a href="<?= base_url('/cart') ?>" class="btn-cancel">
                            <i class="bi bi-arrow-left"></i> Kembali ke Keranjang
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>
</main>

<!-- FOOTER -->
<footer class="footer-burjo">
    <div class="container text-center">
        <span style="font-size:.85rem;color:rgba(255,255,255,.65)">
            🍜 Burjo Ku – © <?= date('Y') ?>
        </span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle tampilan QRIS dan highlight kartu metode bayar
    const radios = document.querySelectorAll('input[name="metode_bayar"]');
    const qrisDiv = document.getElementById('qris-preview');
    const labelCash = document.getElementById('label-cash');
    const labelQris = document.getElementById('label-qris');

    function updateMetode() {
        const val = document.querySelector('input[name="metode_bayar"]:checked')?.value;
        qrisDiv.style.display = (val === 'QRIS') ? 'block' : 'none';
        labelCash.classList.toggle('selected', val === 'Cash');
        labelQris.classList.toggle('selected', val === 'QRIS');
    }

    radios.forEach(r => r.addEventListener('change', updateMetode));

    // Inisialisasi saat halaman load (jika ada old value)
    updateMetode();

    // Feedback submit
    document.getElementById('form-checkout').addEventListener('submit', function() {
        const btn = document.getElementById('btn-pesan');
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';
        btn.disabled = true;
    });

    // Tambahkan event click ke label kartu agar radio ter-trigger
    document.querySelectorAll('.metode-card').forEach(card => {
        card.addEventListener('click', () => {
            const radio = card.querySelector('input[type=radio]');
            if (radio) { radio.checked = true; updateMetode(); }
        });
    });
</script>
</body>
</html>
