<?php include APPPATH . 'Views/templates/header.php'; ?>

<!-- PAGE HEADER -->
<section style="background: linear-gradient(135deg, var(--bg-cream) 0%, #fff9ec 100%); padding: 40px 0 32px; border-bottom: 1px solid rgba(45,90,39,0.08);">
    <div class="container">
        <div class="d-flex align-items-center gap-3 mb-2">
            <a href="<?= base_url('/pelanggan') ?>" style="color: var(--text-muted); text-decoration:none; font-size:0.85rem;">
                <i class="bi bi-people-fill me-1"></i>Pelanggan
            </a>
            <i class="bi bi-chevron-right" style="color:#ccc; font-size:0.75rem;"></i>
            <span style="color: var(--accent); font-size:0.85rem; font-weight:600;">Tambah Baru</span>
        </div>
        <h1 style="font-family:'Playfair Display',serif; font-size: clamp(1.6rem,3.5vw,2.2rem); font-weight:800; color:var(--primary); margin:0;">
            Tambah <span style="color: var(--accent);">Pelanggan</span>
        </h1>
    </div>
</section>

<!-- FORM -->
<section style="padding: 40px 0 60px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card-burjo" style="padding: 36px 40px;">

                    <!-- Form Header -->
                    <div style="text-align:center; margin-bottom:28px;">
                        <div style="font-size: 3rem; margin-bottom: 10px;">👤</div>
                        <h4 style="font-family:'Playfair Display',serif; color:var(--primary); font-size:1.3rem; margin-bottom:4px;">Data Pelanggan Baru</h4>
                        <p style="color: var(--text-muted); font-size:0.85rem; margin:0;">Isi semua informasi pelanggan di bawah ini</p>
                    </div>

                    <form action="<?= base_url('/pelanggan/store') ?>" method="POST" novalidate>
                        <?= csrf_field() ?>

                        <!-- Nama -->
                        <div class="mb-4">
                            <label for="nama" class="form-label-burjo">
                                Nama Pelanggan <span style="color:var(--danger);">*</span>
                            </label>
                            <input type="text"
                                   id="nama"
                                   name="nama"
                                   class="form-control-burjo w-100 <?= (isset($validation) && $validation->hasError('nama')) ? 'is-invalid' : '' ?>"
                                   placeholder="Contoh: Budi Santoso"
                                   value="<?= old('nama') ?>"
                                   autocomplete="off">
                            <?php if (isset($validation) && $validation->hasError('nama')): ?>
                                <div class="invalid-feedback d-block mt-1">
                                    <i class="bi bi-exclamation-circle me-1"></i><?= $validation->getError('nama') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- No. HP -->
                        <div class="mb-4">
                            <label for="no_hp" class="form-label-burjo">
                                Nomor HP <span style="color:var(--danger);">*</span>
                            </label>
                            <div style="position:relative;">
                                <span style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.9rem;">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <input type="text"
                                       id="no_hp"
                                       name="no_hp"
                                       class="form-control-burjo w-100 <?= (isset($validation) && $validation->hasError('no_hp')) ? 'is-invalid' : '' ?>"
                                       placeholder="Contoh: 08123456789"
                                       value="<?= old('no_hp') ?>"
                                       style="padding-left: 38px;">
                            </div>
                            <?php if (isset($validation) && $validation->hasError('no_hp')): ?>
                                <div class="invalid-feedback d-block mt-1">
                                    <i class="bi bi-exclamation-circle me-1"></i><?= $validation->getError('no_hp') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-5">
                            <label for="alamat" class="form-label-burjo">
                                Alamat <span style="color: var(--text-muted); font-weight:400;">(opsional)</span>
                            </label>
                            <textarea id="alamat"
                                      name="alamat"
                                      class="form-control-burjo w-100 <?= (isset($validation) && $validation->hasError('alamat')) ? 'is-invalid' : '' ?>"
                                      rows="3"
                                      placeholder="Contoh: Jl. Merdeka No. 10, Yogyakarta"
                                      style="resize:vertical;"><?= old('alamat') ?></textarea>
                            <?php if (isset($validation) && $validation->hasError('alamat')): ?>
                                <div class="invalid-feedback d-block mt-1">
                                    <i class="bi bi-exclamation-circle me-1"></i><?= $validation->getError('alamat') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="<?= base_url('/pelanggan') ?>" class="btn-burjo-outline text-decoration-none d-inline-flex align-items-center gap-2">
                                <i class="bi bi-x-lg"></i> Batal
                            </a>
                            <button type="submit" class="btn-burjo-primary d-inline-flex align-items-center gap-2">
                                <i class="bi bi-person-check-fill"></i> Simpan Pelanggan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<?php include APPPATH . 'Views/templates/footer.php'; ?>
