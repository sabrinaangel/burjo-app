<?php
// Sertakan template header
include APPPATH . 'Views/templates/header.php';
?>

<!-- ================================================================
     HERO SECTION
================================================================ -->
<section style="background: linear-gradient(135deg, var(--bg-cream) 0%, #fff9ec 100%); padding: 52px 0 40px; border-bottom: 1px solid rgba(45,90,39,0.08);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <p style="color: var(--accent); font-size: 0.82rem; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 8px;">
                    🍽️ Warung Burjo Nusantara
                </p>
                <h1 style="font-family:'Playfair Display',serif; font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 800; color: var(--primary); line-height: 1.2; margin-bottom: 14px;">
                    Kelola Menu <span style="color: var(--accent);">Burjo</span> Anda
                </h1>
                <p style="color: var(--text-muted); font-size: 0.95rem; max-width: 500px; line-height: 1.7; margin-bottom: 24px;">
                    Tambah, edit, dan kelola seluruh menu makanan & minuman warung burjo Anda dengan mudah dan cepat.
                </p>
                <a href="<?= base_url('/menu/create') ?>" class="btn-burjo-primary text-decoration-none d-inline-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle-fill"></i>
                    Tambah Menu Baru
                </a>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <div style="font-size: 6rem; line-height: 1.2; filter: drop-shadow(0 8px 16px rgba(0,0,0,0.1));">
                    🍜🥤🍳☕🥘🍵
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================================================================
     STATISTIK SINGKAT
================================================================ -->
<section style="padding: 24px 0; background: var(--primary); color: #fff;">
    <div class="container">
        <div class="row text-center g-3">
            <div class="col-4">
                <div style="font-family:'Playfair Display',serif; font-size: 1.8rem; font-weight: 800; color: var(--accent);">
                    <?= $jumlahMakanan + $jumlahMinuman ?>
                </div>
                <div style="font-size: 0.78rem; color: rgba(255,255,255,0.7); font-weight: 500;">Total Menu</div>
            </div>
            <div class="col-4" style="border-left: 1px solid rgba(255,255,255,0.15); border-right: 1px solid rgba(255,255,255,0.15);">
                <div style="font-family:'Playfair Display',serif; font-size: 1.8rem; font-weight: 800; color: #ff9a6c;">
                    <?= $jumlahMakanan ?>
                </div>
                <div style="font-size: 0.78rem; color: rgba(255,255,255,0.7); font-weight: 500;">🍛 Makanan</div>
            </div>
            <div class="col-4">
                <div style="font-family:'Playfair Display',serif; font-size: 1.8rem; font-weight: 800; color: #7eb8f7;">
                    <?= $jumlahMinuman ?>
                </div>
                <div style="font-size: 0.78rem; color: rgba(255,255,255,0.7); font-weight: 500;">🥤 Minuman</div>
            </div>
        </div>
    </div>
</section>

<!-- ================================================================
     KONTEN UTAMA: FILTER + GRID MENU
================================================================ -->
<section style="padding: 40px 0 60px;">
    <div class="container">

        <!-- Baris: Judul + Tombol Tambah + Filter -->
        <div class="row align-items-center mb-4 g-3">
            <div class="col-sm-auto">
                <h2 style="font-family:'Playfair Display',serif; font-size:1.5rem; color:var(--primary); margin:0;">
                    <?php if ($activeFilter === 'Semua'): ?>
                        Semua Menu
                    <?php elseif ($activeFilter === 'Makanan'): ?>
                        🍛 Menu Makanan
                    <?php else: ?>
                        🥤 Menu Minuman
                    <?php endif; ?>
                    <span style="font-size:1rem; color:var(--text-muted); font-family:'Poppins',sans-serif;">(<?= $totalMenu ?>)</span>
                </h2>
            </div>
            <div class="col-sm ms-auto">
                <div class="d-flex flex-wrap gap-2 justify-content-sm-end">
                    <!-- Filter Buttons -->
                    <a href="<?= base_url('/menu') ?>"
                       class="filter-btn <?= $activeFilter === 'Semua' ? 'active' : '' ?>">
                        <i class="bi bi-grid-3x3-gap"></i> Semua
                    </a>
                    <a href="<?= base_url('/menu?kategori=Makanan') ?>"
                       class="filter-btn <?= $activeFilter === 'Makanan' ? 'active-makanan' : '' ?>">
                        🍛 Makanan
                    </a>
                    <a href="<?= base_url('/menu?kategori=Minuman') ?>"
                       class="filter-btn <?= $activeFilter === 'Minuman' ? 'active-minuman' : '' ?>">
                        🥤 Minuman
                    </a>

                    <!-- Tombol Sampah Menu -->
                    <a href="<?= base_url('/menu/trash') ?>"
                       class="text-decoration-none d-inline-flex align-items-center gap-1"
                       style="
                           padding: 8px 14px;
                           border-radius: 10px;
                           border: 1.5px solid #e05555;
                           color: #e05555;
                           font-size: 0.85rem;
                           font-weight: 600;
                           background: transparent;
                           transition: all 0.2s ease;
                       "
                       onmouseover="this.style.background='#e05555';this.style.color='#fff';"
                       onmouseout="this.style.background='transparent';this.style.color='#e05555';">
                        <i class="bi bi-trash3"></i>
                        Sampah
                        <?php if ($trashCount > 0): ?>
                            <span style="
                                background: #e05555;
                                color: #fff;
                                border-radius: 999px;
                                padding: 1px 7px;
                                font-size: 0.75rem;
                                font-weight: 700;
                                line-height: 1.4;
                                transition: background 0.2s ease;
                            "><?= $trashCount ?></span>
                        <?php endif; ?>
                    </a>

                    <!-- Tombol Tambah Menu -->
                    <a href="<?= base_url('/menu/create') ?>" class="btn-burjo-primary text-decoration-none d-inline-flex align-items-center gap-2">
                        <i class="bi bi-plus-lg"></i> Tambah
                    </a>
                </div>
            </div>
        </div>

        <!-- GRID CARD MENU -->
        <?php if (empty($menu)): ?>
            <!-- Empty State -->
            <div class="empty-state card-burjo py-5">
                <span class="empty-state-icon">
                    <?= $activeFilter === 'Makanan' ? '🍛' : ($activeFilter === 'Minuman' ? '🥤' : '🍽️') ?>
                </span>
                <h4 style="color:var(--text-muted); font-family:'Poppins',sans-serif; font-size:1.1rem;">
                    Belum ada menu
                    <?= $activeFilter !== 'Semua' ? $activeFilter : '' ?>
                </h4>
                <p style="color:#aaa; font-size:0.875rem; margin-bottom:20px;">
                    Mulai tambahkan menu pertama Anda sekarang!
                </p>
                <a href="<?= base_url('/menu/create') ?>" class="btn-burjo-primary text-decoration-none d-inline-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle-fill"></i> Tambah Menu Pertama
                </a>
            </div>

        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($menu as $item): ?>
                    <div class="col">
                        <div class="card-burjo h-100" style="border-radius:16px; overflow:hidden;">
                            <!-- Card Header: Gambar / Emoji & Kategori -->
                            <div style="
                                background: <?= $item['kategori'] === 'Makanan'
                                    ? 'linear-gradient(135deg, #fff5ee, #ffe8d6)'
                                    : 'linear-gradient(135deg, #eff8ff, #daeeff)' ?>;
                                padding: 0;
                                text-align: center;
                                border-bottom: 1px solid rgba(0,0,0,0.05);
                                position: relative;
                                overflow: hidden;
                            ">
                                <?php
                                    // Cek apakah menu punya foto yang sudah diupload
                                    $adaFoto = !empty($item['gambar']) &&
                                               file_exists(FCPATH . 'uploads/menu/' . $item['gambar']);
                                ?>

                                <?php if ($adaFoto): ?>
                                <!-- Tampilkan foto asli menu -->
                                <img src="<?= base_url('uploads/menu/' . $item['gambar']) ?>"
                                     alt="<?= esc($item['nama_menu']) ?>"
                                     style="width:100%; height:160px; object-fit:cover; display:block;">
                                <?php else: ?>
                                <!-- Fallback: tampilkan emoji jika tidak ada foto -->
                                <div style="padding:24px 20px 16px;">
                                    <div style="font-size: 3rem; margin-bottom: 8px;">
                                        <?= $item['kategori'] === 'Makanan' ? '🍛' : '🥤' ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- Badge kategori (selalu tampil) -->
                                <div style="padding: <?= $adaFoto ? '8px 12px' : '0 12px 12px' ?>;">
                                    <span class="badge-<?= strtolower($item['kategori']) ?>">
                                        <?= $item['kategori'] === 'Makanan' ? '🍽️' : '🥤' ?>
                                        <?= esc($item['kategori']) ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div style="padding: 20px;">
                                <h5 style="
                                    font-family:'Playfair Display',serif;
                                    font-size: 1.1rem;
                                    font-weight: 700;
                                    color: var(--text-main);
                                    margin-bottom: 6px;
                                    line-height: 1.3;
                                ">
                                    <?= esc($item['nama_menu']) ?>
                                </h5>

                                <p class="harga-tag mb-2">
                                    Rp <?= number_format($item['harga'], 0, ',', '.') ?>
                                </p>

                                <?php if (!empty($item['deskripsi'])): ?>
                                    <p style="
                                        color: var(--text-muted);
                                        font-size: 0.82rem;
                                        line-height: 1.6;
                                        margin-bottom: 16px;
                                        display: -webkit-box;
                                        -webkit-line-clamp: 2;
                                        -webkit-box-orient: vertical;
                                        overflow: hidden;
                                    ">
                                        <?= esc($item['deskripsi']) ?>
                                    </p>
                                <?php else: ?>
                                    <p style="color:#ccc; font-size:0.8rem; margin-bottom:16px; font-style:italic;">
                                        Belum ada deskripsi
                                    </p>
                                <?php endif; ?>

                                <!-- Divider -->
                                <hr style="border-color: rgba(0,0,0,0.07); margin: 12px 0;">

                                <!-- Tombol Aksi -->
                                <div class="d-flex gap-2">
                                    <a href="<?= base_url('/menu/edit/' . $item['id']) ?>"
                                       class="btn-burjo-accent text-decoration-none d-inline-flex align-items-center gap-1 flex-fill justify-content-center"
                                       style="padding: 9px 14px; border-radius: 10px;">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>

                                    <!-- Form Hapus (hidden, disubmit via SweetAlert) -->
                                    <form id="form-hapus-<?= $item['id'] ?>"
                                          action="<?= base_url('/menu/delete/' . $item['id']) ?>"
                                          method="POST"
                                          style="flex: 1;">
                                        <?= csrf_field() ?>
                                        <button type="button"
                                                class="btn-burjo-danger w-100 d-inline-flex align-items-center justify-content-center gap-1"
                                                onclick="konfirmasiHapus('form-hapus-<?= $item['id'] ?>', '<?= esc($item['nama_menu'], 'js') ?>')"
                                                style="padding: 9px 14px; border-radius: 10px; cursor: pointer; width: 100%;">
                                            <i class="bi bi-trash3"></i> Hapus
                                        </button>
                                    </form>
                                </div>

                                <!-- Tanggal Ditambahkan -->
                                <p style="color:#bbb; font-size:0.72rem; text-align:center; margin-top:10px; margin-bottom:0;">
                                    <i class="bi bi-clock me-1"></i>
                                    <?= date('d M Y', strtotime($item['created_at'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php include APPPATH . 'Views/templates/footer.php'; ?>
