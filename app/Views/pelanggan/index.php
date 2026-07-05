<?php include APPPATH . 'Views/templates/header.php'; ?>

<!-- HERO SECTION -->
<section style="background: linear-gradient(135deg, var(--bg-cream) 0%, #fff9ec 100%); padding: 44px 0 36px; border-bottom: 1px solid rgba(45,90,39,0.08);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <p style="color: var(--accent); font-size: 0.82rem; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 8px;">
                    👥 Manajemen Pelanggan
                </p>
                <h1 style="font-family:'Playfair Display',serif; font-size: clamp(1.8rem,4vw,2.6rem); font-weight: 800; color: var(--primary); line-height: 1.2; margin-bottom: 12px;">
                    Daftar <span style="color: var(--accent);">Pelanggan</span>
                </h1>
                <p style="color: var(--text-muted); font-size: 0.92rem; max-width: 480px; line-height: 1.7; margin-bottom: 20px;">
                    Kelola data pelanggan setia Warung Burjo Ku dengan mudah dan terorganisir.
                </p>
                <a href="<?= base_url('/pelanggan/create') ?>" class="btn-burjo-primary text-decoration-none d-inline-flex align-items-center gap-2">
                    <i class="bi bi-person-plus-fill"></i> Tambah Pelanggan
                </a>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <div style="font-size: 5rem; filter: drop-shadow(0 8px 16px rgba(0,0,0,0.1));">👨‍👩‍👧‍👦</div>
            </div>
        </div>
    </div>
</section>

<!-- STATISTIK -->
<section style="padding: 20px 0; background: var(--primary); color: #fff;">
    <div class="container">
        <div class="row text-center g-3">
            <div class="col-6">
                <div style="font-family:'Playfair Display',serif; font-size: 1.8rem; font-weight: 800; color: var(--accent);">
                    <?= $total ?>
                </div>
                <div style="font-size: 0.78rem; color: rgba(255,255,255,0.7); font-weight: 500;">Total Pelanggan Aktif</div>
            </div>
            <div class="col-6" style="border-left: 1px solid rgba(255,255,255,0.15);">
                <div style="font-family:'Playfair Display',serif; font-size: 1.8rem; font-weight: 800; color: #ff9a9a;">
                    <?= $totalSampah ?>
                </div>
                <div style="font-size: 0.78rem; color: rgba(255,255,255,0.7); font-weight: 500;">
                    🗑️ Di Sampah
                    <?php if ($totalSampah > 0): ?>
                        <a href="<?= base_url('/pelanggan/trash') ?>" style="color: #ffb3b3; font-size: 0.72rem; text-decoration: underline; margin-left: 4px;">Lihat</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KONTEN UTAMA: TABEL PELANGGAN -->
<section style="padding: 40px 0 60px;">
    <div class="container">

        <!-- Header + Tombol Aksi -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <h2 style="font-family:'Playfair Display',serif; font-size:1.4rem; color:var(--primary); margin:0;">
                Semua Pelanggan
                <span style="font-size:1rem; color:var(--text-muted); font-family:'Poppins',sans-serif;">(<?= $total ?>)</span>
            </h2>
            <div class="d-flex gap-2">
                <?php if ($totalSampah > 0): ?>
                    <a href="<?= base_url('/pelanggan/trash') ?>"
                       class="text-decoration-none d-inline-flex align-items-center gap-1"
                       style="background: #fff5f5; border: 2px solid rgba(231,76,60,0.3); color: var(--danger); font-size: 0.82rem; font-weight: 600; padding: 8px 16px; border-radius: 25px; transition: all 0.3s;"
                       onmouseover="this.style.background='#fde8e8'" onmouseout="this.style.background='#fff5f5'">
                        <i class="bi bi-trash3"></i> Sampah (<?= $totalSampah ?>)
                    </a>
                <?php endif; ?>
                <a href="<?= base_url('/pelanggan/create') ?>" class="btn-burjo-primary text-decoration-none d-inline-flex align-items-center gap-2">
                    <i class="bi bi-person-plus-fill"></i> Tambah
                </a>
            </div>
        </div>

        <?php if (empty($pelanggan)): ?>
            <!-- Empty State -->
            <div class="empty-state card-burjo py-5">
                <span class="empty-state-icon">👥</span>
                <h4 style="color:var(--text-muted); font-family:'Poppins',sans-serif; font-size:1.1rem;">Belum ada pelanggan</h4>
                <p style="color:#aaa; font-size:0.875rem; margin-bottom:20px;">Mulai tambahkan data pelanggan pertama Anda sekarang!</p>
                <a href="<?= base_url('/pelanggan/create') ?>" class="btn-burjo-primary text-decoration-none d-inline-flex align-items-center gap-2">
                    <i class="bi bi-person-plus-fill"></i> Tambah Pelanggan Pertama
                </a>
            </div>

        <?php else: ?>
            <!-- Tabel Pelanggan -->
            <div class="card-burjo" style="overflow:hidden;">
                <div style="overflow-x: auto;">
                    <table style="width:100%; border-collapse: collapse; font-family: 'Poppins', sans-serif;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);">
                                <th style="padding: 14px 20px; color: rgba(255,255,255,0.85); font-size: 0.78rem; font-weight: 600; text-align: left; letter-spacing: 0.5px; text-transform: uppercase;">#</th>
                                <th style="padding: 14px 20px; color: rgba(255,255,255,0.85); font-size: 0.78rem; font-weight: 600; text-align: left; letter-spacing: 0.5px; text-transform: uppercase;">Nama</th>
                                <th style="padding: 14px 20px; color: rgba(255,255,255,0.85); font-size: 0.78rem; font-weight: 600; text-align: left; letter-spacing: 0.5px; text-transform: uppercase;">No. HP</th>
                                <th style="padding: 14px 20px; color: rgba(255,255,255,0.85); font-size: 0.78rem; font-weight: 600; text-align: left; letter-spacing: 0.5px; text-transform: uppercase;">Alamat</th>
                                <th style="padding: 14px 20px; color: rgba(255,255,255,0.85); font-size: 0.78rem; font-weight: 600; text-align: left; letter-spacing: 0.5px; text-transform: uppercase;">Terdaftar</th>
                                <th style="padding: 14px 20px; color: rgba(255,255,255,0.85); font-size: 0.78rem; font-weight: 600; text-align: center; letter-spacing: 0.5px; text-transform: uppercase;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pelanggan as $i => $p): ?>
                                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;"
                                    onmouseover="this.style.background='rgba(45,90,39,0.03)'"
                                    onmouseout="this.style.background='transparent'">
                                    <td style="padding: 14px 20px; color: var(--text-muted); font-size: 0.85rem; font-weight: 600;">
                                        <?= $i + 1 ?>
                                    </td>
                                    <td style="padding: 14px 20px;">
                                        <div style="display:flex; align-items:center; gap: 10px;">
                                            <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:0.85rem; flex-shrink:0;">
                                                <?= strtoupper(substr($p['nama'], 0, 1)) ?>
                                            </div>
                                            <span style="font-weight: 600; color: var(--text-main); font-size: 0.9rem;">
                                                <?= esc($p['nama']) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td style="padding: 14px 20px;">
                                        <a href="tel:<?= esc($p['no_hp']) ?>" style="color: var(--primary); font-size: 0.875rem; font-weight: 500; text-decoration: none;">
                                            <i class="bi bi-telephone me-1"></i><?= esc($p['no_hp']) ?>
                                        </a>
                                    </td>
                                    <td style="padding: 14px 20px; color: var(--text-muted); font-size: 0.82rem; max-width: 200px;">
                                        <?php if (!empty($p['alamat'])): ?>
                                            <span style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                                <?= esc($p['alamat']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span style="color:#ccc; font-style:italic;">–</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 14px 20px; color: var(--text-muted); font-size: 0.78rem; white-space:nowrap;">
                                        <i class="bi bi-clock me-1"></i>
                                        <?= date('d M Y', strtotime($p['created_at'])) ?>
                                    </td>
                                    <td style="padding: 14px 20px; text-align: center; white-space: nowrap;">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="<?= base_url('/pelanggan/edit/' . $p['id']) ?>"
                                               class="btn-burjo-accent text-decoration-none d-inline-flex align-items-center gap-1"
                                               style="padding: 7px 14px; border-radius: 8px; font-size: 0.8rem;">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <a href="<?= base_url('/pelanggan/delete/' . $p['id']) ?>"
                                               class="btn-burjo-danger text-decoration-none d-inline-flex align-items-center gap-1"
                                               style="padding: 7px 14px; border-radius: 8px; font-size: 0.8rem;"
                                               onclick="return konfirmasiHapusPelanggan(event, this.href, '<?= esc($p['nama'], 'js') ?>')">
                                                <i class="bi bi-trash3"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>

<script>
/**
 * Konfirmasi hapus pelanggan dengan SweetAlert2
 * Menggunakan window.location karena route delete adalah GET
 */
function konfirmasiHapusPelanggan(event, url, nama) {
    event.preventDefault();
    Swal.fire({
        title: 'Hapus Pelanggan?',
        html: `Pelanggan <strong>"${nama}"</strong> akan dipindahkan ke sampah.<br><small class="text-muted">Data masih bisa dipulihkan kembali.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#E74C3C',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-trash3-fill me-1"></i>Ya, Hapus!',
        cancelButtonText: '<i class="bi bi-x me-1"></i>Batal',
        customClass: { popup: 'rounded-4', confirmButton: 'rounded-3 px-4', cancelButton: 'rounded-3 px-4' },
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
    return false;
}
</script>

<?php include APPPATH . 'Views/templates/footer.php'; ?>
