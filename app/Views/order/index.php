<?php
/**
 * View: order/index.php
 * Halaman menu untuk pelanggan – tanpa login
 * Warm & Cozy design: hijau tua, krem, kuning emas
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Burjo Ku – Pesan menu burjo favoritmu langsung dari sini.">
    <title><?= esc($title ?? 'Menu Burjo Ku') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        :root {
            --bg-cream:#FFFDF7; --primary:#2D5A27; --primary-dark:#1e3d1a;
            --primary-light:#3a7232; --accent:#F2A135; --accent-dark:#d4882a;
            --text-main:#2C2C2C; --text-muted:#6c757d; --danger:#E74C3C;
            --shadow-sm:0 2px 8px rgba(45,90,39,.08);
            --shadow-md:0 4px 20px rgba(45,90,39,.12);
            --shadow-lg:0 8px 32px rgba(45,90,39,.16);
            --radius:16px; --trans:all .3s cubic-bezier(.25,.46,.45,.94);
        }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Poppins',sans-serif;background:var(--bg-cream);color:var(--text-main);min-height:100vh;display:flex;flex-direction:column}
        h1,h2,h3,h4,h5{font-family:'Playfair Display',serif}

        /* NAVBAR */
        .nav-burjo{background:linear-gradient(135deg,var(--primary),var(--primary-dark));padding:14px 0;box-shadow:0 4px 20px rgba(45,90,39,.25);position:sticky;top:0;z-index:1030}
        .brand-text{font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:800;color:#fff!important;text-decoration:none}
        .brand-text span{color:var(--accent)}
        .brand-tagline{font-size:.72rem;color:rgba(255,255,255,.65);display:block;margin-top:-4px}
        .btn-nav{font-size:.82rem;font-weight:600;padding:8px 16px;border-radius:10px;border:none;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:var(--trans)}
        .btn-nav-outline{background:rgba(255,255,255,.12);color:#fff!important;border:1.5px solid rgba(255,255,255,.35)}
        .btn-nav-outline:hover{background:rgba(255,255,255,.22);transform:translateY(-1px)}
        .btn-nav-accent{background:linear-gradient(135deg,var(--accent),var(--accent-dark));color:var(--text-main)!important;position:relative}
        .btn-nav-accent:hover{transform:translateY(-1px);box-shadow:var(--shadow-md)}
        .cart-badge{position:absolute;top:-6px;right:-6px;background:var(--danger);color:#fff;font-size:.65rem;font-weight:700;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid var(--primary-dark);animation:pulse 1.5s infinite}
        @keyframes pulse{0%,100%{transform:scale(1)}50%{transform:scale(1.15)}}

        /* HERO */
        .hero{background:linear-gradient(145deg,var(--primary),var(--primary-light),#4a8f42);padding:60px 0 50px;position:relative;overflow:hidden}
        .hero::before{content:'';position:absolute;top:-50%;right:-10%;width:400px;height:400px;background:rgba(242,161,53,.08);border-radius:50%}
        .hero-title{font-size:2.8rem;font-weight:800;color:#fff;line-height:1.2;margin-bottom:12px}
        .hero-title span{color:var(--accent)}
        .hero-sub{font-size:1rem;color:rgba(255,255,255,.8);max-width:420px}
        .hero-emoji{font-size:4rem;animation:float 3s ease-in-out infinite;display:block}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}

        /* FILTER */
        .filter-sec{background:#fff;padding:18px 0;border-bottom:1px solid rgba(45,90,39,.08);box-shadow:var(--shadow-sm);position:sticky;top:66px;z-index:100}
        .f-btn{border:2px solid #e0e0e0;background:#fff;color:var(--text-muted);font-size:.82rem;font-weight:600;padding:8px 22px;border-radius:25px;transition:var(--trans);text-decoration:none;display:inline-flex;align-items:center;gap:6px}
        .f-btn:hover{border-color:var(--primary);color:var(--primary);transform:translateY(-2px)}
        .f-btn.fa{background:var(--primary);border-color:var(--primary);color:#fff}
        .f-btn.fm{background:linear-gradient(135deg,#ff6b35,#f7931e);border-color:#ff6b35;color:#fff}
        .f-btn.fmi{background:linear-gradient(135deg,#1a73e8,#0d47a1);border-color:#1a73e8;color:#fff}

        /* CARDS */
        .menu-card{background:#fff;border:none;border-radius:var(--radius);box-shadow:var(--shadow-sm);transition:var(--trans);overflow:hidden;height:100%;display:flex;flex-direction:column}
        .menu-card:hover{transform:translateY(-6px);box-shadow:var(--shadow-lg)}
        .card-emoji{font-size:3.5rem;background:linear-gradient(135deg,#f8f8f2,#f0ede0);padding:24px;text-align:center;display:block;transition:var(--trans)}
        .menu-card:hover .card-emoji{transform:scale(1.08)}
        .card-body-inner{padding:18px;flex:1;display:flex;flex-direction:column}
        .badge-mk{background:linear-gradient(135deg,#ff6b35,#f7931e);color:#fff;font-size:.7rem;font-weight:600;padding:4px 12px;border-radius:20px;align-self:flex-start}
        .badge-mn{background:linear-gradient(135deg,#1a73e8,#0d47a1);color:#fff;font-size:.7rem;font-weight:600;padding:4px 12px;border-radius:20px;align-self:flex-start}
        .menu-nama{font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:700;margin:8px 0 2px}
        .menu-harga{font-size:1.15rem;font-weight:700;color:var(--primary)}
        .menu-desc{font-size:.8rem;color:var(--text-muted);line-height:1.5;flex:1;font-style:italic}
        .qty-wrap{display:flex;align-items:center;gap:8px;margin-top:14px}
        .qty-inp{width:60px;text-align:center;border:2px solid #e8e8e8;border-radius:10px;padding:7px 4px;font-family:'Poppins',sans-serif;font-size:.875rem;font-weight:600;background:#fafafa;transition:var(--trans)}
        .qty-inp:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(45,90,39,.1);outline:none}
        .btn-add{flex:1;background:linear-gradient(135deg,var(--primary),var(--primary-light));border:none;color:#fff;font-weight:600;font-size:.82rem;padding:8px 14px;border-radius:10px;transition:var(--trans);cursor:pointer;display:flex;align-items:center;justify-content:center;gap:5px}
        .btn-add:hover{background:linear-gradient(135deg,var(--primary-dark),var(--primary));transform:translateY(-2px);box-shadow:var(--shadow-md)}
        /* Textarea catatan per menu */
        .catatan-label{font-size:.75rem;font-weight:600;color:var(--text-muted);margin:10px 0 4px;display:block}
        .catatan-inp{width:100%;border:2px solid #e8e8e8;border-radius:10px;padding:7px 10px;font-family:'Poppins',sans-serif;font-size:.78rem;background:#fafafa;resize:none;transition:var(--trans);color:var(--text-main)}
        .catatan-inp:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(45,90,39,.1);outline:none;background:#fff}

        /* FLASH */
        .flash-ok{background:linear-gradient(135deg,#d4edda,#c3e6cb);border:1px solid #b8dabd;border-left:5px solid var(--primary);color:#155724;border-radius:12px;font-size:.875rem;font-weight:500;padding:14px 18px}
        .flash-err{background:linear-gradient(135deg,#fde8e8,#fcc9c9);border:1px solid #f5b7b7;border-left:5px solid var(--danger);color:#721c24;border-radius:12px;font-size:.875rem;font-weight:500;padding:14px 18px}

        /* EMPTY STATE */
        .empty{text-align:center;padding:80px 20px}
        .empty-icon{font-size:5rem;display:block;margin-bottom:16px}

        /* FOOTER */
        .footer-burjo{background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;padding:28px 0;margin-top:auto}

        @media(max-width:768px){.hero-title{font-size:2rem}}
        @media(max-width:576px){.hero-title{font-size:1.6rem}}
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="nav-burjo">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <a href="<?= base_url('/order') ?>" class="brand-text">
                <span style="margin-right:6px">🍜</span>Burjo <span>Ku</span>
                <span class="brand-tagline">Warung Makan Favorit Sejak 1998</span>
            </a>
            <div class="d-flex gap-2 flex-wrap">
                <a href="<?= base_url('/order/pdf') ?>" class="btn-nav btn-nav-outline" id="btn-pdf-menu">
                    <i class="bi bi-file-earmark-pdf-fill"></i> Download Menu PDF
                </a>
                <a href="<?= base_url('/cart') ?>" class="btn-nav btn-nav-accent" id="btn-cart">
                    <i class="bi bi-cart3"></i> Keranjang
                    <?php if (($cartCount ?? 0) > 0): ?>
                        <span class="cart-badge"><?= $cartCount ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="hero-title">Pesan Menu Burjo <span>Favoritmu</span></h1>
                <p class="hero-sub">Pilih menu lezat, masukkan ke keranjang, dan dapatkan struk pesananmu dalam hitungan detik!</p>
            </div>
            <div class="col-md-4 text-center d-none d-md-block">
                <span class="hero-emoji">🍽️</span>
            </div>
        </div>
    </div>
</section>

<!-- FILTER KATEGORI -->
<section class="filter-sec">
    <div class="container">
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <span style="font-size:.82rem;font-weight:600;color:var(--text-muted);margin-right:4px">Filter:</span>
            <a href="<?= base_url('/order') ?>" class="f-btn <?= ($kategori==='Semua')?'fa':'' ?>" id="f-semua">
                <i class="bi bi-grid-3x3-gap-fill"></i> Semua
            </a>
            <a href="<?= base_url('/order?kategori=Makanan') ?>" class="f-btn <?= ($kategori==='Makanan')?'fm':'' ?>" id="f-makanan">
                <i class="bi bi-egg-fried"></i> Makanan
            </a>
            <a href="<?= base_url('/order?kategori=Minuman') ?>" class="f-btn <?= ($kategori==='Minuman')?'fmi':'' ?>" id="f-minuman">
                <i class="bi bi-cup-straw"></i> Minuman
            </a>
            <?php if (($cartCount ?? 0) > 0): ?>
            <span class="ms-auto" style="font-size:.82rem;color:var(--primary);font-weight:600">
                <i class="bi bi-cart-check-fill me-1"></i><?= $cartCount ?> item di keranjang
            </span>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- MAIN -->
<main style="padding:32px 0 60px">
    <div class="container">

        <!-- Flash messages -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-ok d-flex align-items-center gap-2 mb-4" id="flash-ok" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span><?= session()->getFlashdata('success') ?></span>
            <button type="button" class="btn-close ms-auto" onclick="this.parentElement.style.display='none'"></button>
        </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
        <div class="flash-err d-flex align-items-center gap-2 mb-4" id="flash-err" role="alert">
            <i class="bi bi-x-circle-fill fs-5"></i>
            <span><?= session()->getFlashdata('error') ?></span>
            <button type="button" class="btn-close ms-auto" onclick="this.parentElement.style.display='none'"></button>
        </div>
        <?php endif; ?>

        <?php if (empty($menu)): ?>
        <div class="empty">
            <span class="empty-icon">🍽️</span>
            <h3 style="margin-bottom:8px">Belum Ada Menu</h3>
            <p style="color:var(--text-muted);font-size:.9rem">Menu untuk kategori ini belum tersedia.</p>
            <a href="<?= base_url('/order') ?>" class="btn-nav btn-nav-outline mt-3"
               style="display:inline-flex;background:var(--primary);border-color:var(--primary);margin-top:16px">
                <i class="bi bi-arrow-left"></i> Lihat Semua Menu
            </a>
        </div>
        <?php else: ?>
        <div class="row g-4" id="menu-grid">
            <?php foreach ($menu as $item): ?>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="menu-card">
                    <?php
                        // Cek apakah menu punya foto yang sudah diupload
                        $adaFoto = !empty($item['gambar']) &&
                                   file_exists(FCPATH . 'uploads/menu/' . $item['gambar']);
                    ?>

                    <?php if ($adaFoto): ?>
                    <!-- Tampilkan foto asli menu -->
                    <img src="<?= base_url('uploads/menu/' . $item['gambar']) ?>"
                         alt="<?= esc($item['nama_menu']) ?>"
                         style="width:100%; height:160px; object-fit:cover; display:block;
                                border-radius:var(--radius) var(--radius) 0 0;">
                    <?php else: ?>
                    <!-- Fallback emoji jika tidak ada foto -->
                    <span class="card-emoji"><?= ($item['kategori']==='Makanan') ? '🍛' : '🥤' ?></span>
                    <?php endif; ?>
                    <div class="card-body-inner">
                        <span class="<?= ($item['kategori']==='Makanan') ? 'badge-mk' : 'badge-mn' ?>">
                            <?= ($item['kategori']==='Makanan') ? '🍛 ' : '🥤 ' ?><?= esc($item['kategori']) ?>
                        </span>
                        <p class="menu-nama"><?= esc($item['nama_menu']) ?></p>
                        <p class="menu-harga">Rp <?= number_format($item['harga'],0,',','.') ?></p>
                        <p class="menu-desc">
                            <?= !empty($item['deskripsi']) ? esc($item['deskripsi']) : 'Menu lezat khas Burjo Ku.' ?>
                        </p>
                        <!-- Form tambah ke keranjang -->
                        <form action="<?= base_url('/cart/insert') ?>" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="menu_id" value="<?= $item['id'] ?>">
                            <div class="qty-wrap">
                                <input type="number" name="qty" value="1" min="1" max="99"
                                       class="qty-inp" id="qty-<?= $item['id'] ?>"
                                       aria-label="Jumlah <?= esc($item['nama_menu']) ?>">
                                <button type="submit" class="btn-add" id="btn-add-<?= $item['id'] ?>">
                                    <i class="bi bi-cart-plus-fill"></i> Tambah ke Keranjang
                                </button>
                            </div>
                            <!-- Textarea catatan opsional per item -->
                            <label class="catatan-label" for="catatan-<?= $item['id'] ?>">
                                📝 Catatan <span style="font-weight:400">(opsional)</span>
                            </label>
                            <textarea name="catatan" id="catatan-<?= $item['id'] ?>"
                                      class="catatan-inp" rows="2"
                                      placeholder="Contoh: pedas, es dikit, tambah topping..."></textarea>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</main>

<!-- FOOTER -->
<footer class="footer-burjo">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span style="font-size:1.4rem">🍜</span>
                    <span style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700">
                        Burjo <span style="color:var(--accent)">Ku</span>
                    </span>
                </div>
                <p style="color:rgba(255,255,255,.65);font-size:.8rem;margin:0">
                    © <?= date('Y') ?> Burjo Ku – Warung Makan Favorit Sejak 1998
                </p>
                <a href="/login" style="color:rgba(255,255,255,0.2); font-size:0.7rem; text-decoration:none;">
                    Admin
                </a>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <p style="color:rgba(255,255,255,.55);font-size:.78rem;margin:0">
                    <i class="bi bi-wifi me-1"></i> Nikmati WiFi gratis saat makan di tempat
                </p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Auto-hide flash setelah 5 detik
    setTimeout(() => {
        ['flash-ok','flash-err'].forEach(id => {
            const el = document.getElementById(id);
            if (el) { el.style.transition='opacity .5s'; el.style.opacity='0'; setTimeout(()=>el.remove(),500); }
        });
    }, 5000);

    // Feedback tombol saat form disubmit
    document.querySelectorAll('.btn-add').forEach(btn => {
        btn.closest('form').addEventListener('submit', () => {
            btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menambahkan...';
            btn.style.opacity = '.75';
            btn.disabled = true;
        });
    });
</script>
</body>
</html>
