<?php
/**
 * View: cart/index.php
 * Halaman keranjang belanja pelanggan
 * Warm & Cozy design – tanpa admin header/footer
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Keranjang – Burjo Ku') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

        /* FLASH */
        .flash-ok{background:linear-gradient(135deg,#d4edda,#c3e6cb);border-left:5px solid var(--primary);color:#155724;border-radius:12px;font-size:.875rem;font-weight:500;padding:14px 18px}
        .flash-err{background:linear-gradient(135deg,#fde8e8,#fcc9c9);border-left:5px solid var(--danger);color:#721c24;border-radius:12px;font-size:.875rem;font-weight:500;padding:14px 18px}

        /* ITEM CARD */
        .item-card{background:#fff;border-radius:var(--radius);box-shadow:var(--shadow-sm);padding:18px;transition:var(--trans);margin-bottom:14px}
        .item-card:hover{box-shadow:var(--shadow-md);transform:translateY(-2px)}
        .item-emoji{font-size:2.5rem;background:linear-gradient(135deg,#f8f8f2,#f0ede0);width:60px;height:60px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .item-nama{font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;margin-bottom:4px}
        .item-harga{font-size:.85rem;color:var(--text-muted)}
        .badge-mk{background:linear-gradient(135deg,#ff6b35,#f7931e);color:#fff;font-size:.68rem;font-weight:600;padding:3px 10px;border-radius:20px}
        .badge-mn{background:linear-gradient(135deg,#1a73e8,#0d47a1);color:#fff;font-size:.68rem;font-weight:600;padding:3px 10px;border-radius:20px}
        .subtotal{font-size:1rem;font-weight:700;color:var(--primary)}

        /* QTY FORM */
        .qty-form{display:flex;align-items:center;gap:8px}
        .qty-inp{width:65px;text-align:center;border:2px solid #e8e8e8;border-radius:10px;padding:6px 4px;font-family:'Poppins',sans-serif;font-size:.875rem;font-weight:600;background:#fafafa;transition:var(--trans)}
        .qty-inp:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(45,90,39,.1);outline:none}
        .btn-update{background:linear-gradient(135deg,var(--primary),var(--primary-light));border:none;color:#fff;font-size:.78rem;font-weight:600;padding:7px 14px;border-radius:8px;cursor:pointer;transition:var(--trans)}
        .btn-update:hover{transform:translateY(-1px);box-shadow:var(--shadow-sm)}
        .btn-hapus{background:linear-gradient(135deg,var(--danger),#c0392b);border:none;color:#fff;font-size:.78rem;font-weight:600;padding:7px 14px;border-radius:8px;cursor:pointer;transition:var(--trans)}
        .btn-hapus:hover{transform:translateY(-1px);box-shadow:var(--shadow-sm)}

        /* SIDEBAR SUMMARY */
        .summary-card{background:#fff;border-radius:var(--radius);box-shadow:var(--shadow-sm);padding:24px;position:sticky;top:90px}
        .summary-title{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;margin-bottom:16px;padding-bottom:12px;border-bottom:2px solid #f0ede0}
        .summary-item{display:flex;justify-content:space-between;align-items:flex-start;font-size:.82rem;padding:6px 0;border-bottom:1px solid #f5f5f5}
        .summary-item:last-of-type{border-bottom:none}
        .total-big{font-size:1.4rem;font-weight:800;color:var(--primary);font-family:'Playfair Display',serif}
        .btn-checkout{width:100%;background:linear-gradient(135deg,var(--accent),var(--accent-dark));border:none;color:var(--text-main);font-weight:700;font-size:.95rem;padding:14px;border-radius:12px;cursor:pointer;transition:var(--trans);display:flex;align-items:center;justify-content:center;gap:8px;text-decoration:none}
        .btn-checkout:hover{transform:translateY(-2px);box-shadow:var(--shadow-md);color:var(--text-main)}
        .btn-kosongkan{background:transparent;border:2px solid var(--danger);color:var(--danger);font-size:.8rem;font-weight:600;padding:8px 16px;border-radius:10px;cursor:pointer;transition:var(--trans)}
        .btn-kosongkan:hover{background:var(--danger);color:#fff;transform:translateY(-1px)}

        /* EMPTY STATE */
        .empty{text-align:center;padding:80px 20px}
        .empty-icon{font-size:5rem;display:block;margin-bottom:16px;animation:float 3s ease-in-out infinite}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}

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
            <a href="<?= base_url('/order') ?>" class="btn-nav btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Menu
            </a>
        </div>
    </div>
</nav>

<!-- MAIN -->
<main style="padding:32px 0 60px">
    <div class="container">

        <!-- Flash messages -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-ok d-flex align-items-center gap-2 mb-3" id="flash-ok">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span><?= session()->getFlashdata('success') ?></span>
            <button type="button" class="btn-close ms-auto" onclick="this.parentElement.remove()"></button>
        </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
        <div class="flash-err d-flex align-items-center gap-2 mb-3" id="flash-err">
            <i class="bi bi-x-circle-fill fs-5"></i>
            <span><?= session()->getFlashdata('error') ?></span>
            <button type="button" class="btn-close ms-auto" onclick="this.parentElement.remove()"></button>
        </div>
        <?php endif; ?>

        <!-- Header halaman -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h1 style="font-size:1.8rem;font-weight:800">
                    <i class="bi bi-cart3 me-2" style="color:var(--accent)"></i>
                    Keranjang Belanja
                </h1>
                <p style="color:var(--text-muted);font-size:.85rem;margin:0">
                    <?= array_sum(array_column($cart,'qty')) ?> item dalam keranjang
                </p>
            </div>
            <?php if (!empty($cart)): ?>
            <form id="form-kosongkan" action="<?= base_url('/cart/destroy') ?>" method="POST">
                <?= csrf_field() ?>
                <button type="button" class="btn-kosongkan" onclick="konfirmasiKosongkan()" id="btn-kosongkan">
                    <i class="bi bi-trash3-fill me-1"></i> Kosongkan Keranjang
                </button>
            </form>
            <?php endif; ?>
        </div>

        <?php if (empty($cart)): ?>
        <!-- Empty state -->
        <div class="empty">
            <span class="empty-icon">🛒</span>
            <h3 style="margin-bottom:8px">Keranjang Masih Kosong</h3>
            <p style="color:var(--text-muted);font-size:.9rem;margin-bottom:20px">
                Yuk, tambahkan menu lezat ke keranjangmu!
            </p>
            <a href="<?= base_url('/order') ?>" class="btn-checkout" style="display:inline-flex;width:auto;padding:12px 28px">
                <i class="bi bi-bag-plus-fill"></i> Pilih Menu Sekarang
            </a>
        </div>

        <?php else: ?>
        <div class="row g-4">
            <!-- DAFTAR ITEM -->
            <div class="col-lg-8">
                <?php foreach ($cart as $menuId => $item): ?>
                <div class="item-card">
                    <div class="d-flex gap-3 align-items-start">
                        <!-- Emoji -->
                        <div class="item-emoji">
                            <?= ($item['kategori']==='Makanan') ? '🍛' : '🥤' ?>
                        </div>
                        <!-- Info -->
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                <div>
                                    <p class="item-nama"><?= esc($item['nama_menu']) ?></p>
                                    <span class="<?= ($item['kategori']==='Makanan')?'badge-mk':'badge-mn' ?>">
                                        <?= esc($item['kategori']) ?>
                                    </span>
                                    <?php if (!empty($item['catatan'])): ?>
                                    <!-- Tampilkan catatan jika ada -->
                                    <p style="font-size:.78rem;color:var(--text-muted);margin-top:5px;margin-bottom:0">
                                        ✏️ <?= esc($item['catatan']) ?>
                                    </p>
                                    <?php endif; ?>
                                    <p class="item-harga mt-1">
                                        Rp <?= number_format($item['harga'],0,',','.') ?> / porsi
                                    </p>
                                </div>
                                <div class="text-end">
                                    <p class="subtotal">Rp <?= number_format($item['harga']*$item['qty'],0,',','.') ?></p>
                                    <p style="font-size:.75rem;color:var(--text-muted)"><?= $item['qty'] ?> × Rp <?= number_format($item['harga'],0,',','.') ?></p>
                                </div>
                            </div>
                            <!-- Form update qty + hapus -->
                            <div class="d-flex gap-2 mt-3 flex-wrap">
                                <form action="<?= base_url('/cart/update') ?>" method="POST" class="qty-form">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="menu_id" value="<?= $menuId ?>">
                                    <input type="number" name="qty" value="<?= $item['qty'] ?>"
                                           min="1" max="99" class="qty-inp"
                                           id="qty-<?= $menuId ?>" aria-label="Jumlah">
                                    <button type="submit" class="btn-update" id="btn-update-<?= $menuId ?>">
                                        <i class="bi bi-arrow-repeat me-1"></i>Update
                                    </button>
                                </form>
                                <form action="<?= base_url('/cart/remove') ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="menu_id" value="<?= $menuId ?>">
                                    <button type="submit" class="btn-hapus" id="btn-hapus-<?= $menuId ?>"
                                            onclick="return confirm('Hapus <?= esc($item['nama_menu']) ?> dari keranjang?')">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <a href="<?= base_url('/order') ?>" style="font-size:.85rem;color:var(--primary);font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:4px">
                    <i class="bi bi-plus-circle-fill"></i> Tambah Menu Lagi
                </a>
            </div>

            <!-- SIDEBAR SUMMARY -->
            <div class="col-lg-4">
                <div class="summary-card">
                    <p class="summary-title">
                        <i class="bi bi-receipt me-2" style="color:var(--accent)"></i>
                        Ringkasan Pesanan
                    </p>

                    <!-- Daftar item -->
                    <?php foreach ($cart as $item): ?>
                    <div class="summary-item">
                        <span>
                            <?= esc($item['nama_menu']) ?>
                            <span style="color:var(--text-muted);font-size:.78rem"> ×<?= $item['qty'] ?></span>
                        </span>
                        <span style="font-weight:600;white-space:nowrap;margin-left:8px">
                            Rp <?= number_format($item['harga']*$item['qty'],0,',','.') ?>
                        </span>
                    </div>
                    <?php endforeach; ?>

                    <!-- Total -->
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3" style="border-top:2px solid var(--primary)">
                        <span style="font-weight:700;font-size:.95rem">Total</span>
                        <span class="total-big">Rp <?= number_format($total,0,',','.') ?></span>
                    </div>

                    <!-- Tombol checkout -->
                    <a href="<?= base_url('/checkout') ?>" class="btn-checkout mt-4" id="btn-checkout">
                        <i class="bi bi-bag-check-fill"></i> Lanjut Checkout
                    </a>

                    <a href="<?= base_url('/order') ?>" class="d-block text-center mt-3"
                       style="font-size:.82rem;color:var(--text-muted);text-decoration:none">
                        <i class="bi bi-arrow-left me-1"></i> Tambah Menu Lagi
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Konfirmasi kosongkan keranjang dengan SweetAlert2
    function konfirmasiKosongkan() {
        Swal.fire({
            title: 'Kosongkan Keranjang?',
            html: 'Semua item akan dihapus dari keranjang.<br><small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E74C3C',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-trash3-fill me-1"></i>Ya, Kosongkan!',
            cancelButtonText: '<i class="bi bi-x me-1"></i>Batal',
            customClass:{popup:'rounded-4',confirmButton:'rounded-3 px-4',cancelButton:'rounded-3 px-4'},
            reverseButtons: true
        }).then(r => { if (r.isConfirmed) document.getElementById('form-kosongkan').submit(); });
    }

    // Auto-hide flash setelah 5 detik
    setTimeout(() => {
        ['flash-ok','flash-err'].forEach(id => {
            const el = document.getElementById(id);
            if (el){el.style.transition='opacity .5s';el.style.opacity='0';setTimeout(()=>el.remove(),500);}
        });
    }, 5000);
</script>
</body>
</html>
