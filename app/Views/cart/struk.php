<?php
/**
 * View: cart/struk.php
 * Halaman struk / bukti pesanan setelah checkout
 * Warm & Cozy design – tanpa admin header/footer
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Struk Pesanan – Burjo Ku') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root{--bg-cream:#FFFDF7;--primary:#2D5A27;--primary-dark:#1e3d1a;--primary-light:#3a7232;--accent:#F2A135;--accent-dark:#d4882a;--text-main:#2C2C2C;--text-muted:#6c757d;--danger:#E74C3C;--shadow-sm:0 2px 8px rgba(45,90,39,.08);--shadow-md:0 4px 20px rgba(45,90,39,.12);--shadow-lg:0 8px 32px rgba(45,90,39,.18);--radius:16px;--trans:all .3s cubic-bezier(.25,.46,.45,.94)}
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Poppins',sans-serif;background:var(--bg-cream);color:var(--text-main);min-height:100vh;display:flex;flex-direction:column}
        h1,h2,h3,h4,h5{font-family:'Playfair Display',serif}

        /* HERO SUKSES */
        .success-hero{background:linear-gradient(135deg,var(--primary),var(--primary-light));padding:48px 0 36px;text-align:center;position:relative;overflow:hidden}
        .success-hero::before{content:'';position:absolute;top:-40%;right:-5%;width:300px;height:300px;background:rgba(242,161,53,.1);border-radius:50%}
        .success-icon{font-size:4rem;animation:pop .6s cubic-bezier(.175,.885,.32,1.275);display:block;margin-bottom:16px}
        @keyframes pop{0%{transform:scale(0)}100%{transform:scale(1)}}
        .success-title{font-size:2rem;font-weight:800;color:#fff;margin-bottom:6px}
        .success-sub{font-size:.9rem;color:rgba(255,255,255,.8)}
        .no-pesanan-badge{background:rgba(242,161,53,.2);border:1.5px solid rgba(242,161,53,.5);color:var(--accent);font-size:.85rem;font-weight:700;padding:6px 18px;border-radius:25px;display:inline-block;margin-top:12px;font-family:'Poppins',sans-serif;letter-spacing:.5px}

        /* STRUK PAPER */
        .struk-paper{background:#fff;border-radius:var(--radius);box-shadow:var(--shadow-lg);max-width:560px;margin:0 auto;overflow:hidden}
        .struk-header{background:linear-gradient(135deg,var(--primary),var(--primary-dark));padding:24px;text-align:center;color:#fff}
        .struk-header h2{font-size:1.5rem;font-weight:800;margin-bottom:2px}
        .struk-header p{font-size:.8rem;color:rgba(255,255,255,.75);margin:0}
        .struk-body{padding:24px}
        .info-row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px dashed #ede8da;font-size:.85rem}
        .info-row:last-of-type{border-bottom:none}
        .info-label{color:var(--text-muted);font-weight:500}
        .info-val{font-weight:600;color:var(--text-main);text-align:right;max-width:60%}

        /* DIVIDER */
        .divider{border:none;border-top:2px dashed #ede8da;margin:16px 0}
        .divider-solid{border:none;border-top:2px solid var(--primary);margin:16px 0}

        /* ITEM LIST */
        .struk-item{display:flex;justify-content:space-between;align-items:flex-start;padding:8px 0;border-bottom:1px dashed #ede8da;font-size:.85rem}
        .struk-item:last-child{border-bottom:none}
        .struk-item-name{font-weight:600}
        .struk-item-meta{font-size:.78rem;color:var(--text-muted)}
        .struk-item-total{font-weight:700;color:var(--primary);white-space:nowrap;margin-left:10px}

        /* TOTAL */
        .total-row{display:flex;justify-content:space-between;align-items:center;padding:12px 0}
        .total-label{font-size:1rem;font-weight:700}
        .total-amount{font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:800;color:var(--primary)}

        /* WIFI BOX */
        .wifi-box{background:linear-gradient(135deg,rgba(45,90,39,.08),rgba(45,90,39,.04));border:2px solid rgba(45,90,39,.2);border-radius:12px;padding:18px 20px;margin-top:16px;text-align:center;position:relative;overflow:hidden}
        .wifi-box::before{content:'📶';position:absolute;top:8px;right:12px;font-size:1.4rem;opacity:.3}
        .wifi-label{font-size:.78rem;color:var(--text-muted);font-weight:500;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px}
        .wifi-pass{font-family:'Poppins',sans-serif;font-size:1.3rem;font-weight:800;color:var(--primary);letter-spacing:2px;word-break:break-all}
        .wifi-copy-btn{background:var(--primary);color:#fff;border:none;font-size:.75rem;font-weight:600;padding:5px 14px;border-radius:8px;cursor:pointer;margin-top:8px;transition:var(--trans)}
        .wifi-copy-btn:hover{background:var(--primary-dark);transform:translateY(-1px)}

        /* QRIS */
        .qris-box{background:linear-gradient(135deg,#f8f8f2,#f0ede0);border-radius:12px;padding:16px;text-align:center;border:1px dashed rgba(45,90,39,.2);margin-top:12px}
        .qris-box img{max-width:150px;border-radius:8px;box-shadow:var(--shadow-sm)}

        /* TOMBOL */
        .btn-pdf{background:linear-gradient(135deg,var(--primary),var(--primary-light));border:none;color:#fff;font-weight:700;font-size:.9rem;padding:13px 24px;border-radius:12px;cursor:pointer;transition:var(--trans);display:inline-flex;align-items:center;gap:8px;text-decoration:none}
        .btn-pdf:hover{transform:translateY(-2px);box-shadow:var(--shadow-md);color:#fff}
        .btn-pesan-lagi{background:linear-gradient(135deg,var(--accent),var(--accent-dark));border:none;color:var(--text-main);font-weight:700;font-size:.9rem;padding:13px 24px;border-radius:12px;cursor:pointer;transition:var(--trans);display:inline-flex;align-items:center;gap:8px;text-decoration:none}
        .btn-pesan-lagi:hover{transform:translateY(-2px);box-shadow:var(--shadow-md);color:var(--text-main)}

        /* FOOTER */
        .footer-burjo{background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;padding:24px 0;margin-top:auto}

        @media(max-width:576px){.success-title{font-size:1.5rem}.total-amount{font-size:1.3rem}}
        @media print{.no-print{display:none!important}.struk-paper{box-shadow:none}}
    </style>
</head>
<body>

<?php $o = $order; // shorthand ?>

<!-- HERO SUKSES -->
<section class="success-hero">
    <div class="container">
        <span class="success-icon">✅</span>
        <h1 class="success-title">Pesanan Berhasil!</h1>
        <p class="success-sub">Terima kasih, <strong><?= esc($o['nama']) ?></strong>. Pesananmu sedang diproses.</p>
        <span class="no-pesanan-badge">🧾 No. Pesanan: <?= esc($o['no_pesanan']) ?></span>
    </div>
</section>

<!-- MAIN -->
<main style="padding:36px 0 60px">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">

                <!-- STRUK PAPER -->
                <div class="struk-paper">
                    <!-- Header struk -->
                    <div class="struk-header">
                        <h2>🍜 Burjo Ku</h2>
                        <p>Warung Makan Favorit Sejak 1998</p>
                        <p style="margin-top:6px;font-size:.75rem;opacity:.7"><?= esc($o['waktu']) ?></p>
                    </div>

                    <div class="struk-body">
                        <!-- Info pesanan -->
                        <div class="info-row">
                            <span class="info-label"><i class="bi bi-hash me-1"></i>No. Pesanan</span>
                            <span class="info-val" style="color:var(--primary);font-weight:700"><?= esc($o['no_pesanan']) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="bi bi-person me-1"></i>Nama</span>
                            <span class="info-val"><?= esc($o['nama']) ?></span>
                        </div>
                        <?php if (!empty($o['no_hp']) && $o['no_hp'] !== '-'): ?>
                        <div class="info-row">
                            <span class="info-label"><i class="bi bi-phone me-1"></i>No HP</span>
                            <span class="info-val"><?= esc($o['no_hp']) ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="info-row">
                            <span class="info-label"><i class="bi bi-clock me-1"></i>Waktu</span>
                            <span class="info-val"><?= esc($o['waktu']) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="bi bi-credit-card me-1"></i>Metode Bayar</span>
                            <span class="info-val">
                                <?= ($o['metode_bayar']==='QRIS') ? '📱 QRIS' : '💵 Cash / Tunai' ?>
                            </span>
                        </div>

                        <hr class="divider">

                        <!-- Daftar item -->
                        <p style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:8px">Detail Pesanan</p>
                        <?php foreach ($o['cart'] as $item): ?>
                        <div class="struk-item">
                            <div>
                                <p class="struk-item-name"><?= esc($item['nama_menu']) ?></p>
                                <p class="struk-item-meta">
                                    <?= $item['qty'] ?> × Rp <?= number_format($item['harga'],0,',','.') ?>
                                </p>
                            </div>
                            <span class="struk-item-total">
                                Rp <?= number_format($item['harga']*$item['qty'],0,',','.') ?>
                            </span>
                        </div>
                        <?php endforeach; ?>

                        <hr class="divider-solid">

                        <!-- Total -->
                        <div class="total-row">
                            <span class="total-label">Total Pembayaran</span>
                            <span class="total-amount">Rp <?= number_format($o['total'],0,',','.') ?></span>
                        </div>

                        <!-- QRIS image jika metode QRIS -->
                        <?php if ($o['metode_bayar'] === 'QRIS'): ?>
                        <div class="qris-box">
                            <p style="font-size:.8rem;font-weight:700;color:var(--primary);margin-bottom:10px">
                                <i class="bi bi-qr-code me-1"></i> Scan untuk Melunasi Pembayaran
                            </p>
                            <?php
                                $qrisImg = $o['qris_image'] ?? '';
                                $qrisPath = FCPATH . 'uploads/qris/' . $qrisImg;
                            ?>
                            <?php if (!empty($qrisImg) && file_exists($qrisPath)): ?>
                                <img src="<?= base_url('uploads/qris/' . $qrisImg) ?>" alt="QRIS Burjo Ku">
                            <?php else: ?>
                                <div style="width:150px;height:150px;background:#e8e8e8;border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto">
                                    <i class="bi bi-qr-code" style="font-size:3rem;color:var(--text-muted)"></i>
                                </div>
                                <p style="font-size:.75rem;color:var(--text-muted);margin-top:8px">Gambar QRIS belum tersedia</p>
                            <?php endif; ?>
                            <p style="font-size:.75rem;color:var(--text-muted);margin-top:8px">Tunjukkan bukti transfer ke kasir</p>
                        </div>
                        <?php endif; ?>

                        <!-- WiFi Password Highlight -->
                        <?php if (!empty($o['wifi_password'])): ?>
                        <div class="wifi-box">
                            <p class="wifi-label"><i class="bi bi-wifi me-1"></i>Password WiFi Gratis</p>
                            <p class="wifi-pass" id="wifi-pass-text"><?= esc($o['wifi_password']) ?></p>
                            <button class="wifi-copy-btn" onclick="copyWifi()" id="wifi-copy-btn">
                                <i class="bi bi-clipboard me-1"></i> Salin Password
                            </button>
                        </div>
                        <?php endif; ?>

                        <!-- Pesan kecil -->
                        <p style="text-align:center;font-size:.78rem;color:var(--text-muted);margin-top:20px">
                            <i class="bi bi-heart-fill me-1" style="color:var(--accent)"></i>
                            Terima kasih sudah mampir! Selamat menikmati 😊
                        </p>
                    </div>
                </div>

                <!-- TOMBOL AKSI -->
                <div class="d-flex gap-3 justify-content-center mt-4 flex-wrap no-print">
                    <a href="<?= base_url('/struk/pdf') ?>" class="btn-pdf" id="btn-download-struk">
                        <i class="bi bi-file-earmark-pdf-fill"></i> Download Struk PDF
                    </a>
                    <a href="<?= base_url('/order') ?>" class="btn-pesan-lagi" id="btn-pesan-lagi">
                        <i class="bi bi-bag-plus-fill"></i> Pesan Lagi
                    </a>
                </div>

            </div>
        </div>
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
    // Salin password WiFi ke clipboard
    function copyWifi() {
        const txt = document.getElementById('wifi-pass-text')?.innerText;
        if (!txt) return;
        navigator.clipboard.writeText(txt).then(() => {
            const btn = document.getElementById('wifi-copy-btn');
            btn.innerHTML = '<i class="bi bi-clipboard-check me-1"></i> Tersalin!';
            btn.style.background = '#3a7232';
            setTimeout(() => {
                btn.innerHTML = '<i class="bi bi-clipboard me-1"></i> Salin Password';
                btn.style.background = '';
            }, 2500);
        });
    }

    // Animasi masuk
    document.addEventListener('DOMContentLoaded', () => {
        const paper = document.querySelector('.struk-paper');
        if (paper) {
            paper.style.opacity = '0';
            paper.style.transform = 'translateY(20px)';
            paper.style.transition = 'opacity .6s ease, transform .6s ease';
            setTimeout(() => {
                paper.style.opacity = '1';
                paper.style.transform = 'translateY(0)';
            }, 150);
        }
    });
</script>
</body>
</html>
