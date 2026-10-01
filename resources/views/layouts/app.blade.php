<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TrekNesia - Platform Alat Outdoor')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --navy-950: #010B17;
            --navy-900: #010F1F;
            --navy-850: #051424;
            --navy-800: #0D1C2D;
            --navy-750: #0D1B2B;
            --navy-700: #122131;
            --navy-650: #182A3C;
            --navy-600: #1C3042;
            --navy-500: #24394D;
            
            --brand-50: #ecfdf5;
            --brand-100: #d1fae5;
            --brand-200: #a7f3d0;
            --brand-400: #34d399;
            --brand-500: #10b981;
            --brand-600: #059669;
            --brand-700: #047857;
            --brand-800: #065F46;
            --brand-900: #064E3B;
            --brand-950: #022c22;
            
            --slate-100: #F8FAFC;
            --slate-200: #E2E8F0;
            --slate-300: #CBD5E1;
            --slate-400: #94A3B8;
            --slate-500: #64748B;
            
            --amber-400: #F59E0B;
            --rose-500: #EF4444;
            --red-500: #EF4444;
        }
        
        * { box-sizing: border-box; }
        
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: var(--slate-200);
            background: var(--navy-900);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: var(--slate-100);
            letter-spacing: -0.02em;
            margin-bottom: 0;
        }
        
        h1 { font-size: 1.75rem; line-height: 1.2; }
        h2 { font-size: 1.35rem; line-height: 1.3; }
        h3 { font-size: 1.1rem; line-height: 1.35; }
        h4 { font-size: 1rem; }
        h5 { font-size: 0.9rem; }
        h6 { font-size: 0.8rem; }
        
        p { margin-bottom: 0.75rem; }
        a { color: var(--brand-400); text-decoration: none; transition: color 0.15s; }
        a:hover { color: var(--brand-500); }
        
        /* ============ NAVBAR ============ */
        .navbar-trek {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(1, 15, 31, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--navy-600);
        }
        
        .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }
        
        .navbar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
            transition: transform 0.15s;
        }
        
        .navbar-logo:hover { transform: scale(1.02); }
        
        .navbar-logo img {
            height: 40px;
            width: auto;
            object-fit: contain;
        }
        
        .navbar-logo-fallback {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .navbar-logo-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand-400);
            font-size: 1.1rem;
        }
        
        .navbar-logo-text {
            font-weight: 800;
            font-size: 1.25rem;
            color: #fff;
            letter-spacing: -0.02em;
        }
        
        .navbar-logo-text span { color: var(--brand-400); }
        
        .navbar-center {
            display: flex;
            align-items: center;
            gap: 4px;
            background: var(--navy-800);
            padding: 6px;
            border-radius: 9999px;
            border: 1px solid var(--navy-600);
        }
        
        .navbar-center a {
            padding: 6px 20px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--slate-200);
            border-radius: 9999px;
            transition: all 0.15s;
            display: flex;
            align-items: center;
            gap: 6px;
            position: relative;
            text-decoration: none;
        }
        
        .navbar-center a:hover { color: #fff; }
        
        .navbar-center a.active {
            background: rgba(16, 185, 129, 0.15);
            color: var(--brand-400);
            font-weight: 600;
        }
        
        .navbar-center a.active::after {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--brand-400);
        }
        
        .navbar-center a.sale-link:hover { color: var(--rose-500); }
        
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }
        
        .btn-nav-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--slate-200);
            background: var(--navy-800);
            border: 1px solid var(--navy-500);
            border-radius: 10px;
            transition: all 0.15s;
            text-decoration: none;
            white-space: nowrap;
        }
        
        .btn-nav-secondary:hover {
            color: var(--brand-400);
            border-color: var(--brand-500);
            background: var(--navy-700);
        }
        
        .btn-nav-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--navy-950);
            background: var(--brand-500);
            border: 1px solid var(--brand-500);
            border-radius: 10px;
            transition: all 0.15s;
            text-decoration: none;
            white-space: nowrap;
        }
        
        .btn-nav-primary:hover {
            background: var(--brand-400);
            border-color: var(--brand-400);
            color: var(--navy-950);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }
        
        .cart-btn {
            position: relative;
            width: 42px;
            height: 42px;
            padding: 0;
            border-radius: 10px;
            background: var(--navy-800);
            border: 1px solid var(--navy-500);
            color: var(--slate-200);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            text-decoration: none;
        }
        
        .cart-btn:hover {
            border-color: var(--brand-500);
            color: var(--brand-400);
        }
        
        .cart-badge-count {
            position: absolute;
            top: -6px;
            right: -6px;
            min-width: 20px;
            height: 20px;
            background: var(--rose-500);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            border-radius: 99px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            border: 2px solid var(--navy-900);
        }
        
        .user-menu-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: var(--brand-500);
            color: var(--navy-950);
            border: none;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            transition: all 0.15s;
        }
        
        .user-menu-btn:hover, .user-menu-btn:focus {
            background: var(--brand-400);
            color: var(--navy-950);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }
        
        /* ============ BUTTONS ============ */
        .btn {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.15s;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            line-height: 1.4;
            white-space: nowrap;
        }
        
        .btn-sm { font-size: 0.78rem; padding: 8px 14px; }
        .btn-lg { font-size: 0.9rem; padding: 12px 24px; }
        
        .btn-primary-custom {
            background: var(--brand-500);
            color: var(--navy-950);
            border-color: var(--brand-500);
        }
        
        .btn-primary-custom:hover {
            background: var(--brand-400);
            border-color: var(--brand-400);
            color: var(--navy-950);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }
        
        .btn-outline-custom {
            background: var(--navy-800);
            color: var(--slate-200);
            border-color: var(--navy-500);
        }
        
        .btn-outline-custom:hover {
            background: var(--navy-700);
            color: var(--brand-400);
            border-color: var(--brand-500);
        }
        
        /* ============ CARDS ============ */
        .card-trek {
            background: var(--navy-700);
            border: 1px solid var(--navy-600);
            border-radius: 14px;
        }
        
        /* ============ PRODUCT CARD ============ */
        .product-card {
            background: var(--navy-700);
            border: 1px solid var(--navy-600);
            border-radius: 14px;
            overflow: hidden;
            transition: all 0.2s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .product-card:hover {
            background: var(--navy-650);
            border-color: rgba(16, 185, 129, 0.5);
            box-shadow: 0 12px 32px rgba(0,0,0,0.3);
            transform: translateY(-2px);
        }
        
        .product-card-image {
            width: 100%;
            aspect-ratio: 1 / 1;
            background: var(--navy-750);
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        
        .product-card-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.3s;
        }
        
        .product-card:hover .product-card-image img {
            transform: scale(1.05);
        }
        
        .product-card-body {
            padding: 16px 20px 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        
        .product-card-tag {
            display: inline-block;
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--brand-400);
            background: rgba(16, 185, 129, 0.1);
            padding: 3px 10px;
            border-radius: 99px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
            align-self: flex-start;
        }
        
        .product-card-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.4em;
        }
        
        .product-card-brand {
            font-size: 0.75rem;
            color: var(--slate-400);
            margin-bottom: 8px;
        }
        
        .product-card-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 12px;
            font-size: 0.78rem;
        }
        
        .product-card-meta .rating {
            color: var(--amber-400);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .product-card-price {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--brand-400);
            margin-top: auto;
            margin-bottom: 12px;
            font-variant-numeric: tabular-nums;
        }
        
        .product-card .btn { width: 100%; }
        
        /* ============ SECTION ============ */
        .section { padding: 64px 0; }
        .section-soft { background: var(--navy-850); }
        
        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 32px;
            gap: 16px;
            flex-wrap: wrap;
        }
        
        .section-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 4px;
            letter-spacing: -0.02em;
        }
        
        .section-subtitle {
            font-size: 0.875rem;
            color: var(--slate-400);
            margin: 0;
        }
        
        /* ============ HERO ============ */
        .hero-trek {
            background: linear-gradient(180deg, var(--navy-850) 0%, var(--navy-900) 100%);
            padding: 60px 0 80px;
            border-bottom: 1px solid var(--navy-600);
            position: relative;
            overflow: hidden;
        }
        
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(16, 185, 129, 0.1);
            color: var(--brand-400);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 99px;
            border: 1px solid rgba(16, 185, 129, 0.3);
            margin-bottom: 24px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .hero-trek h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.1;
            color: #fff;
            margin-bottom: 20px;
            letter-spacing: -0.03em;
        }
        
        .hero-trek h1 span {
            color: var(--brand-400);
            text-decoration: underline;
            text-decoration-color: var(--brand-500);
            text-decoration-style: wavy;
            text-underline-offset: 6px;
        }
        
        .hero-trek p {
            font-size: 1rem;
            color: var(--slate-400);
            margin-bottom: 32px;
            max-width: 500px;
            line-height: 1.7;
        }
        
        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .hero-image-wrapper {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            border: 4px solid var(--navy-700);
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        
        .hero-image {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
            display: block;
        }
        
        .hero-features {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            padding-top: 20px;
            margin-top: 8px;
            border-top: 1px solid var(--navy-600);
            font-size: 0.78rem;
            color: var(--slate-400);
            font-weight: 500;
        }
        
        .hero-features span {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .hero-features i { color: var(--brand-400); }
        
        /* ============ CATEGORY ============ */
        .category-card {
            border: 1px solid var(--navy-600);
            border-radius: 12px;
            padding: 24px 12px;
            text-align: center;
            background: var(--navy-700);
            transition: all 0.2s;
            display: block;
            color: var(--slate-200);
            height: 100%;
            text-decoration: none;
        }
        
        .category-card:hover {
            border-color: var(--brand-500);
            background: var(--navy-650);
            color: var(--brand-400);
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.3);
        }
        
        .category-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.1);
            color: var(--brand-400);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 1.2rem;
            transition: transform 0.2s;
        }
        
        .category-card:hover .category-icon-wrapper {
            transform: scale(1.1);
        }
        
        .category-card h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--slate-200);
            margin: 0;
        }
        
        .category-card:hover h6 { color: var(--brand-400); }
        
        /* ============ FOOTER ============ */
        .footer-trek {
            background: var(--navy-950);
            color: var(--slate-400);
            padding: 64px 0 32px;
            margin-top: 0;
            border-top: 1px solid var(--navy-600);
        }
        
        .footer-trek h6 {
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 16px;
        }
        
        .footer-trek a {
            color: var(--slate-400);
            font-size: 0.85rem;
            display: block;
            padding: 4px 0;
            transition: color 0.15s;
            text-decoration: none;
        }
        
        .footer-trek a:hover { color: var(--brand-400); }
        
        .footer-trek p {
            color: var(--slate-400);
            font-size: 0.85rem;
            line-height: 1.7;
        }
        
        .footer-trek hr {
            border-color: var(--navy-600);
            margin: 32px 0 20px;
            opacity: 1;
        }
        
        .footer-social {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .footer-social a {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--navy-800);
            border: 1px solid var(--navy-600);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            padding: 0;
            color: var(--slate-300);
        }
        
        .footer-social a:hover {
            background: var(--navy-700);
            border-color: var(--brand-500);
            color: var(--brand-400);
            transform: translateY(-2px);
        }
        
        .footer-copyright {
            text-align: center;
            font-size: 0.78rem;
            color: var(--slate-500);
            padding-top: 8px;
        }
        
        /* ============ FORM ============ */
        .form-control, .form-select {
            font-size: 0.875rem;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid var(--navy-600);
            background: var(--navy-800);
            color: var(--slate-200);
            transition: all 0.15s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--brand-500);
            background: var(--navy-800);
            color: var(--slate-200);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }
        
        .form-control::placeholder { color: var(--slate-500); }
        
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--slate-200);
            margin-bottom: 6px;
        }
        
        /* ============ BADGE ============ */
        .badge {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            letter-spacing: 0.03em;
        }
        
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 99px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        
        .badge-pending   { background: rgba(245, 158, 11, 0.15); color: #FCD34D; }
        .badge-paid      { background: rgba(16, 185, 129, 0.15); color: var(--brand-400); }
        .badge-shipped   { background: rgba(59, 130, 246, 0.15); color: #93C5FD; }
        .badge-cancelled { background: rgba(239, 68, 68, 0.15); color: #FCA5A5; }
        .badge-danger    { background: var(--rose-500); color: #fff; }
        .badge-success   { background: rgba(16, 185, 129, 0.15); color: var(--brand-400); }
        .badge-warning   { background: rgba(245, 158, 11, 0.15); color: #FCD34D; }
        .badge-muted     { background: var(--navy-600); color: var(--slate-400); }
        
        /* ============ DROPDOWN ============ */
        .dropdown-menu {
            background: var(--navy-700);
            border: 1px solid var(--navy-600);
            border-radius: 10px;
            padding: 6px;
            box-shadow: 0 12px 32px rgba(0,0,0,0.4);
        }
        
        .dropdown-item {
            font-size: 0.85rem;
            padding: 8px 14px;
            border-radius: 6px;
            color: var(--slate-200);
            transition: all 0.15s;
        }
        
        .dropdown-item:hover {
            background: var(--navy-600);
            color: #fff;
        }
        
        .dropdown-item.text-danger { color: #FCA5A5 !important; }
        .dropdown-item.text-danger:hover { background: rgba(239, 68, 68, 0.15); }
        
        .dropdown-divider { border-color: var(--navy-600); }
        
        /* ============ RESPONSIVE ============ */
        @media (max-width: 992px) {
            .navbar-center { display: none; }
            .navbar-inner { height: 70px; }
            .hero-trek h1 { font-size: 2.25rem; }
        }
        
        @media (max-width: 768px) {
            .hero-trek { padding: 40px 0 60px; }
            .hero-trek h1 { font-size: 1.75rem; }
            .hero-trek p { font-size: 0.9rem; }
            .section { padding: 40px 0; }
            .section-title { font-size: 1.25rem; }
            .footer-trek { padding: 40px 0 20px; }
        }
    </style>
    
    @stack('styles')
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar-trek">
        <div class="navbar-inner">
            <a href="/" class="navbar-logo">
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="TrekNesia">
                @else
                    <div class="navbar-logo-fallback">
                        <div class="navbar-logo-icon"><i class="fas fa-mountain"></i></div>
                        <span class="navbar-logo-text">Trek<span>Nesia</span></span>
                    </div>
                @endif
            </a>
            
            <nav class="navbar-center d-none d-lg-flex">
                <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Shop</a>
                <a href="/products" class="{{ request()->is('products*') ? 'active' : '' }}">Produk</a>
                <a href="/brands" class="{{ request()->is('brands*') ? 'active' : '' }}">Brands</a>
                <a href="/sale" class="sale-link {{ request()->is('sale*') ? 'active' : '' }}">Sale</a>
            </nav>
            
            <div class="navbar-actions">
                @if(session('user_id'))
                    <a href="/cart" class="cart-btn">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-badge-count" id="cartCount">0</span>
                    </a>
                    <div class="dropdown">
                        <button class="user-menu-btn dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i>
                            <span class="d-none d-md-inline">{{ session('user_name') }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/cek-status"><i class="fas fa-search me-2"></i>Cek Pesanan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @elseif(session('admin_id'))
                    <a href="/admin/dashboard" class="btn-nav-primary">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="d-none d-md-inline">Dashboard</span>
                    </a>
                    <div class="dropdown">
                        <button class="btn-nav-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-store"></i>
                            <span class="d-none d-md-inline">{{ session('admin_name') }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="/login-admin" class="btn-nav-secondary">
                        <i class="fas fa-store"></i>
                        <span class="d-none d-md-inline">Jual Barang</span>
                    </a>
                    <a href="/login-user" class="btn-nav-primary">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="d-none d-md-inline">Pesan Barang</span>
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer-trek">
        <div class="container" style="max-width: 1280px;">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <a href="/" class="d-flex align-items-center gap-2 mb-3 text-decoration-none">
                        @if(file_exists(public_path('images/logo.png')))
                            <img src="{{ asset('images/logo.png') }}" alt="TrekNesia" style="height: 40px;">
                        @else
                            <div class="navbar-logo-icon" style="width:32px; height:32px;">
                                <i class="fas fa-mountain" style="font-size:0.95rem;"></i>
                            </div>
                            <span style="color:#fff; font-weight:800; font-size:1.1rem; letter-spacing:-0.02em;">
                                Trek<span style="color:var(--brand-400);">Nesia</span>
                            </span>
                        @endif
                    </a>
                    <p>Platform penjualan alat outdoor dinamis dengan fitur checkout otomatis untuk petualangan Anda.</p>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-6">
                    <h6>Shop</h6>
                    <a href="/products">All Products</a>
                    <a href="/brands">Brands</a>
                    <a href="/sale">Sale</a>
                </div>
                <div class="col-lg-2 col-md-6 col-6">
                    <h6>Help</h6>
                    <a href="#">Customer Service</a>
                    <a href="#">Shipping Info</a>
                    <a href="#">Returns</a>
                    <a href="#">FAQ</a>
                </div>
                <div class="col-lg-2 col-md-6 col-6">
                    <h6>Company</h6>
                    <a href="#">Our Story</a>
                    <a href="#">Sustainability</a>
                    <a href="#">Careers</a>
                    <a href="#">Contact Us</a>
                </div>
                <div class="col-lg-2 col-md-6 col-6">
                    <h6>Contact</h6>
                    <a href="#"><i class="fas fa-phone me-1"></i> +62 812-3456-7890</a>
                    <a href="#"><i class="fas fa-envelope me-1"></i> hello@treknesia.id</a>
                </div>
            </div>
            <hr>
            <div class="footer-copyright">
                &copy; {{ date('Y') }} TrekNesia. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('treknesia_cart') || '[]');
            const total = cart.reduce((sum, item) => sum + item.quantity, 0);
            const badge = document.getElementById('cartCount');
            if (badge) badge.textContent = total;
        }
        document.addEventListener('DOMContentLoaded', updateCartCount);
    </script>
    
    @stack('scripts')
</body>
</html>