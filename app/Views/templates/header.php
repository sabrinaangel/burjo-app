<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Burjo Ku - Aplikasi manajemen menu warung burjo. Kelola data makanan dan minuman khas Indonesia dengan mudah.">
    <title><?= esc($title ?? 'Burjo Ku - Manajemen Menu') ?></title>

    <!-- Google Fonts: Playfair Display & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom CSS -->
    <style>
        /* ============================================================
           ROOT VARIABLES – WARNA & TIPOGRAFI BURJO KU
        ============================================================ */
        :root {
            --bg-cream:     #FFFDF7;
            --primary:      #2D5A27;
            --primary-dark: #1e3d1a;
            --primary-light:#3a7232;
            --accent:       #F2A135;
            --accent-dark:  #d4882a;
            --text-main:    #2C2C2C;
            --text-muted:   #6c757d;
            --card-bg:      #FFFFFF;
            --danger:       #E74C3C;
            --danger-dark:  #c0392b;
            --success-bg:   #d4edda;
            --success-text: #155724;
            --shadow-sm:    0 2px 8px rgba(45,90,39,0.08);
            --shadow-md:    0 4px 20px rgba(45,90,39,0.12);
            --shadow-lg:    0 8px 32px rgba(45,90,39,0.16);
            --border-radius:16px;
            --transition:   all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* ============================================================
           BASE STYLES
        ============================================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-cream);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
        }

        main {
            flex: 1;
        }

        /* ============================================================
           NAVBAR
        ============================================================ */
        .navbar-burjo {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 14px 0;
            box-shadow: 0 4px 20px rgba(45,90,39,0.25);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .navbar-brand-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: #FFFFFF !important;
            letter-spacing: -0.5px;
            text-decoration: none;
        }

        .navbar-brand-text span {
            color: var(--accent);
        }

        .navbar-brand-emoji {
            font-size: 1.4rem;
            margin-right: 6px;
        }

        .navbar-tagline {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.65);
            font-weight: 300;
            display: block;
            margin-top: -4px;
            letter-spacing: 0.5px;
        }

        .nav-link-burjo {
            color: rgba(255,255,255,0.85) !important;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: var(--transition);
        }

        .nav-link-burjo:hover {
            background: rgba(255,255,255,0.12);
            color: #fff !important;
        }

        .nav-link-burjo.active {
            background: rgba(242,161,53,0.2);
            color: var(--accent) !important;
        }

        /* ============================================================
           BUTTONS
        ============================================================ */
        .btn-burjo-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 10px 22px;
            border-radius: 10px;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .btn-burjo-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-burjo-accent {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
            border: none;
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.875rem;
            padding: 10px 22px;
            border-radius: 10px;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .btn-burjo-accent:hover {
            background: linear-gradient(135deg, var(--accent-dark) 0%, #b8751f 100%);
            color: var(--text-main);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-burjo-danger {
            background: linear-gradient(135deg, var(--danger) 0%, var(--danger-dark) 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 10px 22px;
            border-radius: 10px;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .btn-burjo-danger:hover {
            background: linear-gradient(135deg, var(--danger-dark) 0%, #a93226 100%);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-burjo-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
            font-weight: 600;
            font-size: 0.875rem;
            padding: 8px 20px;
            border-radius: 10px;
            transition: var(--transition);
        }

        .btn-burjo-outline:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-2px);
        }

        /* ============================================================
           FORM STYLES
        ============================================================ */
        .form-label-burjo {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .form-control-burjo,
        .form-select-burjo {
            border: 2px solid #e8e8e8;
            border-radius: 10px;
            padding: 10px 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.875rem;
            background-color: #fafafa;
            transition: var(--transition);
            color: var(--text-main);
        }

        .form-control-burjo:focus,
        .form-select-burjo:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(45,90,39,0.12);
            background-color: #fff;
            outline: none;
        }

        .form-control-burjo.is-invalid,
        .form-select-burjo.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            font-size: 0.8rem;
            color: var(--danger);
        }

        /* ============================================================
           CARD STYLES
        ============================================================ */
        .card-burjo {
            background: var(--card-bg);
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            overflow: hidden;
        }

        .card-burjo:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        /* ============================================================
           BADGE KATEGORI
        ============================================================ */
        .badge-makanan {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: #fff;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
            letter-spacing: 0.3px;
        }

        .badge-minuman {
            background: linear-gradient(135deg, #1a73e8, #0d47a1);
            color: #fff;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
            letter-spacing: 0.3px;
        }

        /* ============================================================
           FLASH MESSAGES
        ============================================================ */
        .alert-burjo-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border: 1px solid #b8dabd;
            border-left: 5px solid var(--primary);
            color: var(--success-text);
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 14px 18px;
        }

        .alert-burjo-error {
            background: linear-gradient(135deg, #fde8e8, #fcc9c9);
            border: 1px solid #f5b7b7;
            border-left: 5px solid var(--danger);
            color: #721c24;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 14px 18px;
        }

        /* ============================================================
           FILTER BUTTONS
        ============================================================ */
        .filter-btn {
            border: 2px solid #e0e0e0;
            background: #fff;
            color: var(--text-muted);
            font-size: 0.82rem;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 25px;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .filter-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .filter-btn.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .filter-btn.active-makanan {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            border-color: #ff6b35;
            color: #fff;
        }

        .filter-btn.active-minuman {
            background: linear-gradient(135deg, #1a73e8, #0d47a1);
            border-color: #1a73e8;
            color: #fff;
        }

        /* ============================================================
           EMPTY STATE
        ============================================================ */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 16px;
            display: block;
        }

        /* ============================================================
           PAGE HEADER CARD
        ============================================================ */
        .page-header-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: var(--border-radius);
            padding: 28px 32px;
            color: #fff;
            margin-bottom: 24px;
        }

        .page-header-card h4 {
            color: #fff;
            font-size: 1.4rem;
        }

        .page-header-card p {
            color: rgba(255,255,255,0.75);
            font-size: 0.85rem;
            margin: 0;
        }

        /* ============================================================
           HARGA STYLE
        ============================================================ */
        .harga-tag {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary);
            font-family: 'Poppins', sans-serif;
        }

        /* ============================================================
           RESPONSIVE TWEAKS
        ============================================================ */
        @media (max-width: 768px) {
            .navbar-brand-text { font-size: 1.3rem; }
            .page-header-card { padding: 20px; }
        }

        @media (max-width: 576px) {
            .btn-burjo-primary,
            .btn-burjo-accent,
            .btn-burjo-danger { padding: 8px 16px; font-size: 0.8rem; }
        }
    </style>
</head>
<body>

<!-- ================================================================
     NAVBAR
================================================================ -->
<nav class="navbar-burjo">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Logo / Brand -->
            <a href="<?= base_url('/menu') ?>" class="navbar-brand-text text-decoration-none">
                <span class="navbar-brand-emoji">🍜</span>
                Burjo <span>Ku</span>
                <span class="navbar-tagline">Sistem Manajemen Menu Warung</span>
            </a>

            <!-- Nav Links -->
            <div class="d-flex gap-1 align-items-center">
                <a href="<?= base_url('/menu') ?>"
                   class="nav-link-burjo <?= (uri_string() === 'menu' || uri_string() === '') ? 'active' : '' ?>">
                    <i class="bi bi-grid-3x3-gap-fill me-1"></i>Menu
                </a>
                <a href="<?= base_url('/menu/create') ?>"
                   class="nav-link-burjo <?= str_contains(uri_string(), 'create') ? 'active' : '' ?>">
                    <i class="bi bi-plus-circle-fill me-1"></i>Tambah
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- ================================================================
     FLASH MESSAGES
================================================================ -->
<div class="container mt-3">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert-burjo-success d-flex align-items-center gap-2 mb-0" role="alert" id="flash-success">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span><?= session()->getFlashdata('success') ?></span>
            <button type="button" class="btn-close ms-auto" onclick="document.getElementById('flash-success').style.display='none'"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert-burjo-error d-flex align-items-center gap-2 mb-0" role="alert" id="flash-error">
            <i class="bi bi-x-circle-fill fs-5"></i>
            <span><?= session()->getFlashdata('error') ?></span>
            <button type="button" class="btn-close ms-auto" onclick="document.getElementById('flash-error').style.display='none'"></button>
        </div>
    <?php endif; ?>
</div>

<main>
