<?php include APPPATH . 'Views/templates/header.php'; ?>

<!-- ================================================================
     HALAMAN CREATE – FORM TAMBAH MENU BARU
================================================================ -->
<section style="padding: 48px 0 80px; background: var(--bg-cream); min-height: calc(100vh - 160px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xl-6">

                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb" style="font-size: 0.82rem; background: transparent; padding: 0;">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('/menu') ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">
                                <i class="bi bi-grid-3x3-gap-fill me-1"></i>Daftar Menu
                            </a>
                        </li>
                        <li class="breadcrumb-item active" style="color: var(--text-muted);">Tambah Menu</li>
                    </ol>
                </nav>

                <!-- Header Card -->
                <div class="page-header-card mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div style="font-size: 2.5rem;">🍽️</div>
                        <div>
                            <h4 class="mb-1">Tambah Menu Baru</h4>
                            <p>Isi formulir di bawah untuk menambahkan menu baru ke daftar warung burjo Anda.</p>
                        </div>
                    </div>
                </div>

                <!-- FORM CARD -->
                <div class="card-burjo p-4">
                    <form action="<?= base_url('/menu/store') ?>" method="POST" novalidate id="form-tambah-menu">
                        <?= csrf_field() ?>

                        <!-- ── NAMA MENU ── -->
                        <div class="mb-4">
                            <label for="nama_menu" class="form-label-burjo">
                                <i class="bi bi-tag-fill me-1" style="color: var(--accent);"></i>
                                Nama Menu <span style="color: var(--danger);">*</span>
                            </label>
                            <input
                                type="text"
                                id="nama_menu"
                                name="nama_menu"
                                class="form-control-burjo w-100 <?= ($validation->hasError('nama_menu')) ? 'is-invalid' : '' ?>"
                                placeholder="Contoh: Nasi Goreng Spesial, Es Teh Manis..."
                                value="<?= old('nama_menu') ?>"
                                maxlength="100"
                                autocomplete="off"
                            >
                            <?php if ($validation->hasError('nama_menu')): ?>
                                <div class="invalid-feedback d-block mt-1">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $validation->getError('nama_menu') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- ── KATEGORI ── -->
                        <div class="mb-4">
                            <label for="kategori" class="form-label-burjo">
                                <i class="bi bi-collection-fill me-1" style="color: var(--accent);"></i>
                                Kategori <span style="color: var(--danger);">*</span>
                            </label>
                            <select
                                id="kategori"
                                name="kategori"
                                class="form-select-burjo w-100 <?= ($validation->hasError('kategori')) ? 'is-invalid' : '' ?>"
                            >
                                <option value="" disabled <?= old('kategori') ? '' : 'selected' ?>>
                                    — Pilih Kategori —
                                </option>
                                <option value="Makanan" <?= old('kategori') === 'Makanan' ? 'selected' : '' ?>>
                                    🍛 Makanan
                                </option>
                                <option value="Minuman" <?= old('kategori') === 'Minuman' ? 'selected' : '' ?>>
                                    🥤 Minuman
                                </option>
                            </select>
                            <?php if ($validation->hasError('kategori')): ?>
                                <div class="invalid-feedback d-block mt-1">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $validation->getError('kategori') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- ── HARGA ── -->
                        <div class="mb-4">
                            <label for="harga" class="form-label-burjo">
                                <i class="bi bi-currency-dollar me-1" style="color: var(--accent);"></i>
                                Harga (Rp) <span style="color: var(--danger);">*</span>
                            </label>
                            <div style="position: relative;">
                                <span style="
                                    position: absolute;
                                    left: 14px;
                                    top: 50%;
                                    transform: translateY(-50%);
                                    color: var(--text-muted);
                                    font-weight: 600;
                                    font-size: 0.85rem;
                                ">Rp</span>
                                <input
                                    type="number"
                                    id="harga"
                                    name="harga"
                                    class="form-control-burjo w-100 <?= ($validation->hasError('harga')) ? 'is-invalid' : '' ?>"
                                    placeholder="0"
                                    value="<?= old('harga') ?>"
                                    min="1"
                                    style="padding-left: 44px;"
                                >
                            </div>
                            <?php if ($validation->hasError('harga')): ?>
                                <div class="invalid-feedback d-block mt-1">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $validation->getError('harga') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- ── DESKRIPSI ── -->
                        <div class="mb-5">
                            <label for="deskripsi" class="form-label-burjo">
                                <i class="bi bi-card-text me-1" style="color: var(--accent);"></i>
                                Deskripsi
                                <span style="color: var(--text-muted); font-weight: 400; font-size: 0.8rem;">(opsional)</span>
                            </label>
                            <textarea
                                id="deskripsi"
                                name="deskripsi"
                                class="form-control-burjo w-100 <?= ($validation->hasError('deskripsi')) ? 'is-invalid' : '' ?>"
                                rows="3"
                                placeholder="Ceritakan bahan, rasa, atau keistimewaan menu ini..."
                                maxlength="500"
                                style="resize: vertical;"
                            ><?= old('deskripsi') ?></textarea>
                            <?php if ($validation->hasError('deskripsi')): ?>
                                <div class="invalid-feedback d-block mt-1">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $validation->getError('deskripsi') ?>
                                </div>
                            <?php endif; ?>
                            <div style="text-align: right; font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">
                                Maks. 500 karakter
                            </div>
                        </div>

                        <!-- TOMBOL AKSI -->
                        <div class="d-flex gap-3">
                            <a href="<?= base_url('/menu') ?>"
                               class="btn-burjo-outline text-decoration-none d-inline-flex align-items-center gap-2"
                               style="flex: 1; justify-content: center; padding: 12px;">
                                <i class="bi bi-arrow-left"></i> Batal
                            </a>
                            <button type="submit"
                                    class="btn-burjo-primary d-inline-flex align-items-center gap-2"
                                    style="flex: 2; justify-content: center; padding: 12px; cursor: pointer;">
                                <i class="bi bi-floppy-fill"></i> Simpan Menu
                            </button>
                        </div>

                    </form>
                </div>
                <!-- / FORM CARD -->

            </div>
        </div>
    </div>
</section>

<?php include APPPATH . 'Views/templates/footer.php'; ?>
