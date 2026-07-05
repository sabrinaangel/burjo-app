<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Burjo Ku</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FFFDF7;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: radial-gradient(circle at 20% 50%, rgba(45, 90, 39, 0.05) 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, rgba(242, 161, 53, 0.08) 0%, transparent 50%);
        }
        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }
        .login-card {
            background: #FFFFFF;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(45, 90, 39, 0.12);
            padding: 40px;
            border-top: 4px solid #2D5A27;
        }
        .logo-section {
            text-align: center;
            margin-bottom: 32px;
        }
        .logo-icon {
            font-size: 48px;
            margin-bottom: 8px;
        }
        .logo-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #2D5A27;
        }
        .logo-title span {
            color: #F2A135;
        }
        .logo-subtitle {
            font-size: 13px;
            color: #888;
            margin-top: 4px;
        }
        .form-label {
            font-weight: 500;
            color: #2C2C2C;
            font-size: 14px;
            margin-bottom: 6px;
        }
        .form-control {
            border: 1.5px solid #E0E0E0;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background-color: #FAFAFA;
        }
        .form-control:focus {
            border-color: #2D5A27;
            box-shadow: 0 0 0 3px rgba(45, 90, 39, 0.1);
            background-color: #FFFFFF;
        }
        .input-group .form-control {
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        .input-group-text {
            background: #FAFAFA;
            border: 1.5px solid #E0E0E0;
            border-left: none;
            border-radius: 0 10px 10px 0;
            cursor: pointer;
            color: #888;
            transition: all 0.3s ease;
        }
        .input-group:focus-within .input-group-text {
            border-color: #2D5A27;
            background-color: #FFFFFF;
        }
        .btn-login {
            background-color: #2D5A27;
            color: #FFFFFF;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            width: 100%;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }
        .btn-login:hover {
            background-color: #1e3d1b;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(45, 90, 39, 0.3);
        }
        .btn-login:active {
            transform: translateY(0);
        }
        .alert {
            border-radius: 10px;
            font-size: 13px;
            padding: 12px 16px;
            border: none;
        }
        .alert-danger {
            background-color: #FFF0F0;
            color: #C0392B;
            border-left: 3px solid #E74C3C;
        }
        .alert-success {
            background-color: #F0FFF4;
            color: #2D5A27;
            border-left: 3px solid #2D5A27;
        }
        .divider {
            text-align: center;
            color: #CCC;
            font-size: 12px;
            margin: 20px 0;
            position: relative;
        }
        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 42%;
            height: 1px;
            background: #EEE;
        }
        .divider::before { left: 0; }
        .divider::after { right: 0; }
        .hint-box {
            background: #EAF2E8;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 12px;
            color: #2D5A27;
            margin-top: 20px;
        }
        .hint-box i { margin-right: 6px; }
        .mb-3 { margin-bottom: 18px !important; }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <!-- Logo -->
            <div class="logo-section">
                <div class="logo-icon">🍲</div>
                <div class="logo-title">Burjo <span>Ku</span></div>
                <div class="logo-subtitle">Sistem Manajemen Menu Warung</div>
            </div>

            <!-- Flash Message Error -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger mb-3">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Flash Message Success -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success mb-3">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- Form Login -->
            <form action="/login" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-envelope me-1" style="color: #2D5A27;"></i> Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="admin@burjoku.com"
                        value="<?= old('email') ?>"
                        required
                        autofocus
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-lock me-1" style="color: #2D5A27;"></i> Password
                    </label>
                    <div class="input-group">
                        <input
                            type="password"
                            name="password"
                            id="passwordInput"
                            class="form-control"
                            placeholder="Masukkan password"
                            required
                        >
                        <span class="input-group-text" onclick="togglePassword()">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-login mt-2">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Dashboard
                </button>
            </form>

            <!-- Hint -->
            <div class="hint-box">
                <i class="fas fa-info-circle"></i>
                <strong>Halaman ini khusus admin.</strong> Pelanggan dapat langsung mengakses menu tanpa login.
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle show/hide password
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>
