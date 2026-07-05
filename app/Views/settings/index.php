<?php
/**
 * View: settings/index.php
 * Halaman pengaturan aplikasi: password WiFi & upload QRIS
 * Menggunakan header.php & footer.php admin
 */
?>
<?= view('templates/header', ['title' => 'Pengaturan – Burjo Ku']) ?>

<div class="container" style="padding: 32px 0 60px;">

    <!-- Page Header -->
    <div class="page-header-card mb-4">
        <div class="d-flex align-items-center gap-3">
            <span style="font-size:2rem">⚙️</span>
            <div>
                <h4><i class="bi bi-gear-fill me-2"></i>Pengaturan Aplikasi</h4>
                <p>Kelola password WiFi dan gambar QRIS untuk pelanggan.</p>
            </div>
        </div>
    </div>

    <!-- Flash messages -->
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert-burjo-success d-flex align-items-center gap-2 mb-4" id="flash-ok" role="alert">
        <i class="bi bi-check-circle-fill fs-5"></i>
        <span><?= session()->getFlashdata('success') ?></span>
        <button type="button" class="btn-close ms-auto" onclick="this.parentElement.remove()"></button>
    </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert-burjo-error d-flex align-items-center gap-2 mb-4" id="flash-err" role="alert">
        <i class="bi bi-x-circle-fill fs-5"></i>
        <span><?= session()->getFlashdata('error') ?></span>
        <button type="button" class="btn-close ms-auto" onclick="this.parentElement.remove()"></button>
    </div>
    <?php endif; ?>

    <div class="row g-4">

        <!-- ============================================================
             FORM PASSWORD WIFI
        ============================================================ -->
        <div class="col-md-6">
            <div class="card-burjo" style="padding:28px;height:100%">
                <h5 style="font-family:'Playfair Display',serif;margin-bottom:6px">
                    <i class="bi bi-wifi me-2" style="color:var(--accent)"></i>
                    Password WiFi
                </h5>
                <p style="font-size:.82rem;color:var(--text-muted);margin-bottom:24px">
                    Password ini akan ditampilkan di struk pelanggan setelah checkout.
                </p>

                <form action="<?= base_url('/settings/update') ?>" method="POST" id="form-wifi">
                    <?= csrf_field() ?>
                    <input type="hidden" name="type" value="wifi">

                    <!-- Password saat ini -->
                    <?php if (!empty($settings['wifi_password'])): ?>
                    <div style="background:linear-gradient(135deg,rgba(45,90,39,.06),rgba(45,90,39,.03));border:1.5px solid rgba(45,90,39,.15);border-radius:12px;padding:14px 18px;margin-bottom:20px">
                        <p style="font-size:.75rem;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:4px">Password Saat Ini</p>
                        <p style="font-weight:800;font-size:1.1rem;color:var(--primary);letter-spacing:2px;margin:0" id="current-wifi">
                            <?= esc($settings['wifi_password']) ?>
                        </p>
                    </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label-burjo" for="wifi_password">
                            Password WiFi Baru <span style="color:var(--danger)">*</span>
                        </label>
                        <div style="position:relative">
                            <input type="password" name="wifi_password" id="wifi_password"
                                   class="form-control-burjo w-100"
                                   placeholder="Masukkan password WiFi baru"
                                   value="" required
                                   style="padding-right:48px">
                            <button type="button" onclick="toggleWifi()"
                                    style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-muted);cursor:pointer;font-size:1.1rem"
                                    id="toggle-wifi-btn">
                                <i class="bi bi-eye" id="wifi-eye-icon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-burjo-primary w-100" id="btn-save-wifi">
                        <i class="bi bi-save-fill me-2"></i> Simpan Password WiFi
                    </button>
                </form>
            </div>
        </div>

        <!-- ============================================================
             FORM UPLOAD QRIS
        ============================================================ -->
        <div class="col-md-6">
            <div class="card-burjo" style="padding:28px;height:100%">
                <h5 style="font-family:'Playfair Display',serif;margin-bottom:6px">
                    <i class="bi bi-qr-code me-2" style="color:var(--accent)"></i>
                    Gambar QRIS
                </h5>
                <p style="font-size:.82rem;color:var(--text-muted);margin-bottom:20px">
                    Gambar QRIS ini akan ditampilkan saat pelanggan memilih metode bayar QRIS.
                </p>

                <!-- Preview gambar QRIS saat ini -->
                <?php
                    $qrisFile = $settings['qris_image'] ?? '';
                    $qrisPath = FCPATH . 'uploads/qris/' . $qrisFile;
                ?>
                <div style="text-align:center;margin-bottom:20px">
                    <?php if (!empty($qrisFile) && file_exists($qrisPath)): ?>
                        <div style="background:linear-gradient(135deg,#f8f8f2,#f0ede0);border-radius:12px;padding:16px;display:inline-block">
                            <img src="<?= base_url('uploads/qris/' . $qrisFile) ?>"
                                 alt="QRIS saat ini"
                                 style="max-width:160px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,.12)"
                                 id="qris-preview-img">
                        </div>
                        <p style="font-size:.75rem;color:var(--text-muted);margin-top:8px">
                            <i class="bi bi-check-circle-fill me-1" style="color:var(--primary)"></i>
                            Gambar QRIS aktif: <?= esc($qrisFile) ?>
                        </p>
                    <?php else: ?>
                        <div style="width:160px;height:160px;background:#f0ede0;border-radius:12px;border:2px dashed rgba(45,90,39,.2);display:flex;flex-direction:column;align-items:center;justify-content:center;margin:0 auto" id="qris-preview-img">
                            <i class="bi bi-qr-code" style="font-size:2.5rem;color:var(--text-muted)"></i>
                            <p style="font-size:.75rem;color:var(--text-muted);margin-top:8px">Belum ada gambar</p>
                        </div>
                    <?php endif; ?>
                </div>

                <form action="<?= base_url('/settings/update') ?>" method="POST"
                      enctype="multipart/form-data" id="form-qris">
                    <?= csrf_field() ?>
                    <input type="hidden" name="type" value="qris">

                    <div class="mb-4">
                        <label class="form-label-burjo" for="qris_image">
                            Upload Gambar QRIS Baru <span style="color:var(--danger)">*</span>
                        </label>
                        <input type="file" name="qris_image" id="qris_image"
                               class="form-control-burjo w-100"
                               accept="image/png,image/jpg,image/jpeg"
                               onchange="previewQris(this)"
                               style="padding:8px 14px;cursor:pointer" required>
                        <small style="font-size:.75rem;color:var(--text-muted)">
                            Format: JPG, PNG. Maks. 2MB. Disarankan ukuran 200×200px.
                        </small>
                    </div>

                    <!-- Preview sebelum upload -->
                    <div id="qris-new-preview" style="display:none;text-align:center;margin-bottom:16px">
                        <p style="font-size:.78rem;color:var(--text-muted);margin-bottom:8px">Preview gambar baru:</p>
                        <img id="qris-new-img" src="#" alt="Preview"
                             style="max-width:120px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,.12)">
                    </div>

                    <button type="submit" class="btn-burjo-primary w-100" id="btn-save-qris">
                        <i class="bi bi-cloud-upload-fill me-2"></i> Upload Gambar QRIS
                    </button>
                </form>
            </div>
        </div>

    </div><!-- end row -->
</div><!-- end container -->

<?= view('templates/footer') ?>

<script>
    // Toggle tampil/sembunyikan password WiFi
    function toggleWifi() {
        const inp  = document.getElementById('wifi_password');
        const icon = document.getElementById('wifi-eye-icon');
        if (inp.type === 'password') {
            inp.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            inp.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }

    // Preview gambar QRIS sebelum upload
    function previewQris(input) {
        const preview = document.getElementById('qris-new-preview');
        const img     = document.getElementById('qris-new-img');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { img.src = e.target.result; preview.style.display = 'block'; };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto-hide flash setelah 5 detik
    setTimeout(() => {
        ['flash-ok','flash-err'].forEach(id => {
            const el = document.getElementById(id);
            if (el){el.style.transition='opacity .5s';el.style.opacity='0';setTimeout(()=>el.remove(),500);}
        });
    }, 5000);
</script>
