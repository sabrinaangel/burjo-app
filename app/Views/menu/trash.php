<?php include APPPATH . 'Views/templates/header.php'; ?>

<!-- HERO SECTION -->
<section style="background: linear-gradient(135deg, #fff5f5 0%, #ffe8e8 100%); padding: 40px 0 32px; border-bottom: 1px solid rgba(231,76,60,0.12);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <p style="color: var(--danger); font-size: 0.82rem; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 8px;">
                    🗑️ Sampah / Trash
                </p>
                <h1 style="font-family:'Playfair Display',serif; font-size: clamp(1.6rem,3.5vw,2.4rem); font-weight: 800; color: var(--primary); line-height: 1.2; margin-bottom: 10px;">
                    Sampah <span style="color: var(--danger);">Menu</span>
                </h1>
                <p style="color: var(--text-muted); font-size: 0.9rem; max-width: 500px; line-height: 1.7; margin-bottom: 0;">
                    Data menu yang dihapus tersimpan di sini. Anda bisa memulihkan atau menghapus secara permanen.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="<?= base_url('/menu') ?>" class="btn-burjo-outline text-decoration-none d-inline-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Kembali ke Menu
                </a>
            </div>
        </div>
    </div>
</section>

<!-- KONTEN UTAMA -->
<section style="padding: 40px 0 60px;">
    <div class="container">

        <?php if (empty($menu)): ?>
            <!-- Empty State -->
            <div class="empty-state card-burjo py-5">
                <span class="empty-state-icon">🗑️</span>
                <h4 style="color:var(--text-muted); font-family:'Poppins',sans-serif; font-size:1.1rem;">
                    Sampah kosong
                </h4>
                <p style="color:#aaa; font-size:0.875rem; margin-bottom:20px;">
                    Tidak ada menu yang dihapus saat ini.
                </p>
                <a href="<?= base_url('/menu') ?>" class="btn-burjo-primary text-decoration-none d-inline-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Menu
                </a>
            </div>

        <?php else: ?>
            <!-- Info jumlah data -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 style="font-family:'Playfair Display',serif; font-size:1.4rem; color:var(--primary); margin:0;">
                    Data Terhapus
                    <span style="font-size:1rem; color:var(--text-muted); font-family:'Poppins',sans-serif;">(<?= count($menu) ?>)</span>
                </h2>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($menu as $item): ?>
                    <div class="col">
                        <div class="card-burjo h-100" style="border-radius:16px; overflow:hidden; opacity:0.92; border: 2px dashed rgba(231,76,60,0.25);">
                            <!-- Card Header -->
                            <div style="background: linear-gradient(135deg, #fff0f0, #fde8e8); padding: 20px 20px 14px; text-align:center; border-bottom: 1px solid rgba(0,0,0,0.05);">
                                <div style="font-size:2.6rem; margin-bottom:8px; filter: grayscale(0.4);">
                                    <?= $item['kategori'] === 'Makanan' ? '🍛' : '🥤' ?>
                                </div>
                                <span class="badge-<?= strtolower($item['kategori']) ?>">
                                    <?= esc($item['kategori']) ?>
                                </span>
                            </div>

                            <!-- Card Body -->
                            <div style="padding: 16px 20px 20px;">
                                <h5 style="font-family:'Playfair Display',serif; font-size:1rem; font-weight:700; color:var(--text-main); margin-bottom:4px;">
                                    <?= esc($item['nama_menu']) ?>
                                </h5>
                                <p class="harga-tag mb-2" style="font-size:1rem;">
                                    Rp <?= number_format($item['harga'], 0, ',', '.') ?>
                                </p>
                                <!-- Tanggal dihapus -->
                                <p style="color: var(--danger); font-size:0.75rem; margin-bottom:14px;">
                                    <i class="bi bi-trash3 me-1"></i>
                                    Dihapus: <?= date('d M Y, H:i', strtotime($item['deleted_at'])) ?>
                                </p>

                                <hr style="border-color: rgba(0,0,0,0.07); margin: 12px 0;">

                                <!-- Tombol Aksi -->
                                <div class="d-flex gap-2">
                                    <!-- Form Restore -->
                                    <form action="<?= base_url('/menu/restore/' . $item['id']) ?>" method="POST" style="flex:1;">
                                        <?= csrf_field() ?>
                                        <button type="submit"
                                                class="w-100 d-inline-flex align-items-center justify-content-center gap-1"
                                                style="background: linear-gradient(135deg, #28a745, #218838); border:none; color:#fff; font-weight:600; font-size:0.82rem; padding: 9px 12px; border-radius:10px; cursor:pointer; transition: all 0.3s; box-shadow: 0 2px 8px rgba(40,167,69,0.25);"
                                                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                            <i class="bi bi-arrow-counterclockwise"></i> Pulihkan
                                        </button>
                                    </form>

                                    <!-- Form Force Delete -->
                                    <form id="force-del-<?= $item['id'] ?>"
                                          action="<?= base_url('/menu/force-delete/' . $item['id']) ?>"
                                          method="POST" style="flex:1;">
                                        <?= csrf_field() ?>
                                        <button type="button"
                                                class="btn-burjo-danger w-100 d-inline-flex align-items-center justify-content-center gap-1"
                                                onclick="konfirmasiForceDelete('force-del-<?= $item['id'] ?>', '<?= esc($item['nama_menu'], 'js') ?>')"
                                                style="padding: 9px 12px; border-radius:10px; cursor:pointer; width:100%; font-size:0.82rem;">
                                            <i class="bi bi-trash3-fill"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<script>
/**
 * Konfirmasi hapus permanen menu dari sampah menggunakan SweetAlert2
 */
function konfirmasiForceDelete(formId, namaMenu) {
    Swal.fire({
        title: 'Hapus Permanen?',
        html: `Menu <strong>"${namaMenu}"</strong> akan dihapus secara permanen.<br><small class="text-danger">⚠️ Data tidak bisa dipulihkan kembali!</small>`,
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#E74C3C',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-trash3-fill me-1"></i>Ya, Hapus Permanen!',
        cancelButtonText: '<i class="bi bi-x me-1"></i>Batal',
        customClass: { popup: 'rounded-4', confirmButton: 'rounded-3 px-4', cancelButton: 'rounded-3 px-4' },
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>

<?php include APPPATH . 'Views/templates/footer.php'; ?>
