<?php include APPPATH . 'Views/templates/header.php'; ?>

<!-- PAGE HEADER -->
<section style="background: linear-gradient(135deg, #fff5f5 0%, #ffe8e8 100%); padding: 40px 0 32px; border-bottom: 1px solid rgba(231,76,60,0.12);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <a href="<?= base_url('/pelanggan') ?>" style="color: var(--text-muted); text-decoration:none; font-size:0.85rem;">
                        <i class="bi bi-people-fill me-1"></i>Pelanggan
                    </a>
                    <i class="bi bi-chevron-right" style="color:#ccc; font-size:0.75rem;"></i>
                    <span style="color: var(--danger); font-size:0.85rem; font-weight:600;">🗑️ Sampah</span>
                </div>
                <h1 style="font-family:'Playfair Display',serif; font-size: clamp(1.6rem,3.5vw,2.3rem); font-weight:800; color:var(--primary); line-height:1.2; margin-bottom:8px;">
                    Sampah <span style="color: var(--danger);">Pelanggan</span>
                </h1>
                <p style="color: var(--text-muted); font-size:0.88rem; margin:0;">
                    Data pelanggan yang dihapus tersimpan di sini. Pulihkan atau hapus secara permanen.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="<?= base_url('/pelanggan') ?>" class="btn-burjo-outline text-decoration-none d-inline-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Kembali ke Pelanggan
                </a>
            </div>
        </div>
    </div>
</section>

<!-- KONTEN UTAMA -->
<section style="padding: 40px 0 60px;">
    <div class="container">

        <?php if (empty($pelanggan)): ?>
            <!-- Empty State -->
            <div class="empty-state card-burjo py-5">
                <span class="empty-state-icon">🗑️</span>
                <h4 style="color:var(--text-muted); font-family:'Poppins',sans-serif; font-size:1.1rem;">Sampah kosong</h4>
                <p style="color:#aaa; font-size:0.875rem; margin-bottom:20px;">Tidak ada data pelanggan yang dihapus.</p>
                <a href="<?= base_url('/pelanggan') ?>" class="btn-burjo-primary text-decoration-none d-inline-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pelanggan
                </a>
            </div>

        <?php else: ?>
            <!-- Header info -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 style="font-family:'Playfair Display',serif; font-size:1.4rem; color:var(--primary); margin:0;">
                    Data Terhapus
                    <span style="font-size:1rem; color:var(--text-muted); font-family:'Poppins',sans-serif;">(<?= count($pelanggan) ?>)</span>
                </h2>
            </div>

            <!-- Tabel Sampah Pelanggan -->
            <div class="card-burjo" style="overflow:hidden; border: 2px dashed rgba(231,76,60,0.25);">
                <div style="overflow-x: auto;">
                    <table style="width:100%; border-collapse:collapse; font-family:'Poppins',sans-serif;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);">
                                <th style="padding:14px 20px; color:rgba(255,255,255,0.85); font-size:0.78rem; font-weight:600; text-align:left; text-transform:uppercase; letter-spacing:0.5px;">#</th>
                                <th style="padding:14px 20px; color:rgba(255,255,255,0.85); font-size:0.78rem; font-weight:600; text-align:left; text-transform:uppercase; letter-spacing:0.5px;">Nama</th>
                                <th style="padding:14px 20px; color:rgba(255,255,255,0.85); font-size:0.78rem; font-weight:600; text-align:left; text-transform:uppercase; letter-spacing:0.5px;">No. HP</th>
                                <th style="padding:14px 20px; color:rgba(255,255,255,0.85); font-size:0.78rem; font-weight:600; text-align:left; text-transform:uppercase; letter-spacing:0.5px;">Dihapus Pada</th>
                                <th style="padding:14px 20px; color:rgba(255,255,255,0.85); font-size:0.78rem; font-weight:600; text-align:center; text-transform:uppercase; letter-spacing:0.5px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pelanggan as $i => $p): ?>
                                <tr style="border-bottom:1px solid rgba(0,0,0,0.05); transition: background 0.2s;"
                                    onmouseover="this.style.background='rgba(231,76,60,0.03)'"
                                    onmouseout="this.style.background='transparent'">
                                    <td style="padding:14px 20px; color:var(--text-muted); font-size:0.85rem;">
                                        <?= $i + 1 ?>
                                    </td>
                                    <td style="padding:14px 20px;">
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <!-- Avatar dengan warna merah (menandakan sudah terhapus) -->
                                            <div style="width:36px; height:36px; border-radius:50%; background: linear-gradient(135deg, #e74c3c, #c0392b); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:0.85rem; flex-shrink:0; opacity:0.7;">
                                                <?= strtoupper(substr($p['nama'], 0, 1)) ?>
                                            </div>
                                            <span style="font-weight:600; color:var(--text-muted); font-size:0.9rem; text-decoration: line-through; opacity:0.8;">
                                                <?= esc($p['nama']) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td style="padding:14px 20px; color:var(--text-muted); font-size:0.875rem;">
                                        <?= esc($p['no_hp']) ?>
                                    </td>
                                    <td style="padding:14px 20px;">
                                        <span style="color: var(--danger); font-size:0.8rem;">
                                            <i class="bi bi-trash3 me-1"></i>
                                            <?= date('d M Y, H:i', strtotime($p['deleted_at'])) ?>
                                        </span>
                                    </td>
                                    <td style="padding:14px 20px; text-align:center; white-space:nowrap;">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <!-- Tombol Pulihkan -->
                                            <a href="<?= base_url('/pelanggan/restore/' . $p['id']) ?>"
                                               class="text-decoration-none d-inline-flex align-items-center gap-1"
                                               style="background: linear-gradient(135deg, #28a745, #218838); color:#fff; font-weight:600; font-size:0.8rem; padding:7px 14px; border-radius:8px; transition:all 0.3s;"
                                               onclick="return konfirmasiPulihkan(event, this.href, '<?= esc($p['nama'], 'js') ?>')"
                                               onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                                <i class="bi bi-arrow-counterclockwise"></i> Pulihkan
                                            </a>

                                            <!-- Tombol Hapus Permanen -->
                                            <a href="<?= base_url('/pelanggan/force-delete/' . $p['id']) ?>"
                                               class="btn-burjo-danger text-decoration-none d-inline-flex align-items-center gap-1"
                                               style="padding:7px 14px; border-radius:8px; font-size:0.8rem;"
                                               onclick="return konfirmasiForceDelete(event, this.href, '<?= esc($p['nama'], 'js') ?>')">
                                                <i class="bi bi-trash3-fill"></i> Hapus Permanen
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
 * Konfirmasi pulihkan pelanggan dari sampah
 */
function konfirmasiPulihkan(event, url, nama) {
    event.preventDefault();
    Swal.fire({
        title: 'Pulihkan Pelanggan?',
        html: `<strong>"${nama}"</strong> akan dipindahkan kembali ke daftar aktif.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-arrow-counterclockwise me-1"></i>Ya, Pulihkan!',
        cancelButtonText: '<i class="bi bi-x me-1"></i>Batal',
        customClass: { popup: 'rounded-4', confirmButton: 'rounded-3 px-4', cancelButton: 'rounded-3 px-4' },
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) { window.location.href = url; }
    });
    return false;
}

/**
 * Konfirmasi hapus permanen pelanggan dari sampah
 */
function konfirmasiForceDelete(event, url, nama) {
    event.preventDefault();
    Swal.fire({
        title: 'Hapus Permanen?',
        html: `<strong>"${nama}"</strong> akan dihapus selamanya.<br><small class="text-danger">⚠️ Tidak bisa dipulihkan kembali!</small>`,
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#E74C3C',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-trash3-fill me-1"></i>Ya, Hapus Permanen!',
        cancelButtonText: '<i class="bi bi-x me-1"></i>Batal',
        customClass: { popup: 'rounded-4', confirmButton: 'rounded-3 px-4', cancelButton: 'rounded-3 px-4' },
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) { window.location.href = url; }
    });
    return false;
}
</script>

<?php include APPPATH . 'Views/templates/footer.php'; ?>
