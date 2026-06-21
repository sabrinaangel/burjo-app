</main>

<!-- ================================================================
     FOOTER
================================================================ -->
<footer style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: #fff; padding: 28px 0; margin-top: auto;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span style="font-size:1.4rem;">🍜</span>
                    <span style="font-family:'Playfair Display',serif; font-size:1.1rem; font-weight:700;">
                        Burjo <span style="color:var(--accent);">Ku</span>
                    </span>
                </div>
                <p style="color:rgba(255,255,255,0.65); font-size:0.8rem; margin:0;">
                    © <?= date('Y') ?> Burjo Ku – Kelola dengan Mudah
                </p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <span style="font-size:0.78rem; color:rgba(255,255,255,0.5);">
                    <i class="bi bi-code-slash me-1"></i>Dibangun dengan CodeIgniter 4 & Bootstrap 5
                </span>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script: Konfirmasi Hapus dengan SweetAlert2 -->
<script>
    /**
     * Fungsi konfirmasi hapus menggunakan SweetAlert2
     * Dipanggil dari tombol hapus di card menu
     */
    function konfirmasiHapus(formId, namaMenu) {
        Swal.fire({
            title: 'Hapus Menu?',
            html: `Apakah Anda yakin ingin menghapus menu <strong>"${namaMenu}"</strong>?<br><small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E74C3C',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-trash3-fill me-1"></i>Ya, Hapus!',
            cancelButtonText: '<i class="bi bi-x me-1"></i>Batal',
            customClass: {
                popup: 'rounded-4',
                confirmButton: 'rounded-3 px-4',
                cancelButton: 'rounded-3 px-4',
            },
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form hapus jika dikonfirmasi
                document.getElementById(formId).submit();
            }
        });
    }

    // Auto-hide flash messages setelah 5 detik
    setTimeout(() => {
        const flashSuccess = document.getElementById('flash-success');
        const flashError   = document.getElementById('flash-error');
        if (flashSuccess) flashSuccess.style.opacity = '0';
        if (flashError)   flashError.style.opacity = '0';
    }, 5000);
</script>

</body>
</html>
