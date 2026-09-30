<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TrekNesia - Platform Alat Outdoor')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --trek-primary: #1a472a;
            --trek-primary-hover: #2d6a4f;
            --trek-primary-light: #f0f9f4;
            --trek-accent: #38a169;
            --trek-accent-light: #68d391;
            --trek-dark: #0f172a;
            --trek-text: #334155;
            --trek-text-muted: #64748b;
            --trek-border: #e2e8f0;
            --trek-border-soft: #f1f5f9;
            --trek-bg: #ffffff;
            --trek-bg-soft: #f8fafc;
            --trek-success: #16a34a;
            --trek-warning: #ea580c;
            --trek-danger: #dc2626;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --radius-xl: 20px;
            --shadow-xs: 0 1px 2px rgba(15,23,42,0.04);
            --shadow-sm: 0 1px 3px rgba(15,23,42,0.06), 0 1px 2px rgba(15,23,42,0.04);
            --shadow-md: 0 4px 12px rgba(15,23,42,0.08);
            --shadow-lg: 0 12px 32px rgba(15,23,42,0.1);
        }
        
        * { box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: var(--trek-text);
            background: var(--trek-bg);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Manrope', 'Inter', sans-serif;
            font-weight: 700;
            color: var(--trek-dark);
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
        a { color: var(--trek-primary); text-decoration: none; transition: color 0.15s; }
        a:hover { color: var(--trek-primary-hover); }
        
        /* ============ NAVBAR ============ */
        .navbar-trek {
            background: #fff;
            border-bottom: 1px solid var(--trek-border);
            min-height: 68px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-trek .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 68px;
            gap: 24px;
        }
        
        .navbar-logo {
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }
        
        .navbar-logo img {
            height: 44px;
            width: auto;
            object-fit: contain;
        }
        
        .navbar-logo-text {
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            font-size: 1.15rem;
            color: var(--trek-primary);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .navbar-links {
            display: flex;
            align-items: center;
            gap: 2px;
            list-style: none;
            margin: 0;
            padding: 0;
            flex-grow: 1;
            justify-content: center;
        }
        
        .navbar-links a {
            display: block;
            padding: 8px 16px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--trek-text);
            border-radius: var(--radius-md);
            transition: all 0.15s;
            white-space: nowrap;
        }
        
        .navbar-links a:hover {
            background: var(--trek-bg-soft);
            color: var(--trek-primary);
        }
        
        .navbar-links a.active {
            background: var(--trek-primary-light);
            color: var(--trek-primary);
            font-weight: 600;
        }
        
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }
        
        /* ============ BUTTONS ============ */
        .btn {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 9px 18px;
            border-radius: var(--radius-md);
            transition: all 0.15s;
            border: 1.5px solid transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            line-height: 1.4;
            white-space: nowrap;
        }
        
        .btn-sm { font-size: 0.78rem; padding: 6px 12px; }
        .btn-lg { font-size: 0.9rem; padding: 11px 24px; }
        
        .btn-primary-custom {
            background: var(--trek-primary);
            color: #fff;
            border-color: var(--trek-primary);
        }
        
        .btn-primary-custom:hover {
            background: var(--trek-primary-hover);
            border-color: var(--trek-primary-hover);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26,71,42,0.2);
        }
        
        .btn-outline-custom {
            background: #fff;
            color: var(--trek-primary);
            border-color: var(--trek-primary);
        }
        
        .btn-outline-custom:hover {
            background: var(--trek-primary);
            color: #fff;
        }
        
        .btn-ghost {
            background: transparent;
            color: var(--trek-text);
            border-color: var(--trek-border);
        }
        
        .btn-ghost:hover {
            background: var(--trek-bg-soft);
            color: var(--trek-primary);
            border-color: var(--trek-primary);
        }
        
        /* ============ CARDS ============ */
        .card-trek {
            background: #fff;
            border: 1px solid var(--trek-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xs);
        }
        
        /* ============ PRODUCT CARD ============ */
        .product-card {
            background: #fff;
            border: 1px solid var(--trek-border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: all 0.2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .product-card:hover {
            border-color: var(--trek-accent-light);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        
        .product-card-image {
            width: 100%;
            aspect-ratio: 1 / 1;
            background: var(--trek-bg-soft);
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .product-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        
        .product-card:hover .product-card-image img {
            transform: scale(1.04);
        }
        
        .product-card-body {
            padding: 14px 16px 16px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        
        .product-card-tag {
            display: inline-block;
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--trek-primary);
            background: var(--trek-primary-light);
            padding: 3px 9px;
            border-radius: 99px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
            align-self: flex-start;
        }
        
        .product-card-title {
            font-family: 'Manrope', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--trek-dark);
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
            color: var(--trek-text-muted);
            margin-bottom: 8px;
        }
        
        .product-card-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 10px;
            font-size: 0.78rem;
        }
        
        .product-card-meta .rating {
            color: #f59e0b;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 3px;
        }
        
        .product-card-price {
            font-family: 'Manrope', sans-serif;
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--trek-primary);
            margin-top: auto;
            margin-bottom: 12px;
        }
        
        .product-card .btn {
            width: 100%;
        }
        
        /* ============ SECTION ============ */
        .section { padding: 56px 0; }
        .section-soft { background: var(--trek-bg-soft); }
        
        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 28px;
            gap: 16px;
            flex-wrap: wrap;
        }
        
        .section-title {
            font-family: 'Manrope', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--trek-dark);
            margin-bottom: 4px;
            letter-spacing: -0.02em;
        }
        
        .section-subtitle {
            font-size: 0.875rem;
            color: var(--trek-text-muted);
            margin: 0;
        }
        
        /* ============ HERO ============ */
        .hero-trek {
            background: linear-gradient(135deg, #f0f9f4 0%, #e7f5ec 100%);
            padding: 72px 0;
            border-bottom: 1px solid var(--trek-border);
            position: relative;
            overflow: hidden;
        }
        
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            color: var(--trek-primary);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 99px;
            border: 1px solid rgba(26,71,42,0.12);
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        
        .hero-trek h1 {
            font-family: 'Manrope', sans-serif;
            font-size: 2.75rem;
            font-weight: 800;
            line-height: 1.1;
            color: var(--trek-dark);
            margin-bottom: 18px;
            letter-spacing: -0.035em;
        }
        
        .hero-trek h1 span {
            color: var(--trek-primary);
        }
        
        .hero-trek p {
            font-size: 1rem;
            color: var(--trek-text-muted);
            margin-bottom: 32px;
            max-width: 480px;
            line-height: 1.65;
        }
        
        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .hero-image {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
        }
        
        /* ============ CATEGORY ============ */
        .category-card {
            border: 1px solid var(--trek-border);
            border-radius: var(--radius-lg);
            padding: 22px 12px;
            text-align: center;
            background: #fff;
            transition: all 0.2s;
            display: block;
            color: var(--trek-text);
            height: 100%;
        }
        
        .category-card:hover {
            border-color: var(--trek-primary);
            background: var(--trek-primary-light);
            color: var(--trek-primary);
            transform: translateY(-3px);
            box-shadow: var(--shadow-sm);
        }
        
        .category-card i {
            font-size: 1.75rem;
            color: var(--trek-primary);
            margin-bottom: 10px;
            display: block;
        }
        
        .category-card h6 {
            font-family: 'Manrope', sans-serif;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--trek-dark);
            margin: 0;
        }
        
        /* ============ FOOTER ============ */
        .footer-trek {
            background: var(--trek-dark);
            color: #cbd5e0;
            padding: 56px 0 24px;
            margin-top: 80px;
        }
        
        .footer-trek h6 {
            color: #fff;
            font-family: 'Manrope', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 18px;
        }
        
        .footer-trek a {
            color: #94a3b8;
            font-size: 0.85rem;
            display: block;
            padding: 4px 0;
            transition: color 0.15s;
        }
        
        .footer-trek a:hover { color: #fff; }
        
        .footer-trek p {
            color: #94a3b8;
            font-size: 0.85rem;
            line-height: 1.7;
        }
        
        .footer-trek hr {
            border-color: rgba(255,255,255,0.08);
            margin: 32px 0 20px;
        }
        
        .footer-social {
            display: flex;
            gap: 8px;
            margin-top: 18px;
        }
        
        .footer-social a {
            width: 38px;
            height: 38px;
            border-radius: var(--radius-md);
            background: rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            padding: 0;
        }
        
        .footer-social a:hover {
            background: var(--trek-primary);
            color: #fff;
            transform: translateY(-2px);
        }
        
        .footer-copyright {
            text-align: center;
            font-size: 0.78rem;
            color: #64748b;
        }
        
        /* ============ CART BUTTON ============ */
        .cart-btn {
            position: relative;
            width: 42px;
            height: 42px;
            padding: 0;
            border-radius: var(--radius-md);
            background: #fff;
            border: 1.5px solid var(--trek-border);
            color: var(--trek-text);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
        }
        
        .cart-btn:hover {
            border-color: var(--trek-primary);
            color: var(--trek-primary);
        }
        
        .cart-badge-count {
            position: absolute;
            top: -6px;
            right: -6px;
            min-width: 20px;
            height: 20px;
            background: var(--trek-danger);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            border-radius: 99px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            border: 2px solid #fff;
        }
        
        /* ============ USER MENU ============ */
        .user-menu-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 16px;
            background: var(--trek-primary);
            color: #fff;
            border: none;
            border-radius: var(--radius-md);
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.15s;
        }
        
        .user-menu-btn:hover, .user-menu-btn:focus {
            background: var(--trek-primary-hover);
            color: #fff;
            box-shadow: 0 4px 12px rgba(26,71,42,0.2);
        }
        
        /* ============ FORM ============ */
        .form-control, .form-select {
            font-size: 0.875rem;
            padding: 10px 14px;
            border-radius: var(--radius-md);
            border: 1px solid var(--trek-border);
            transition: all 0.15s;
            color: var(--trek-text);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--trek-primary);
            box-shadow: 0 0 0 3px rgba(26,71,42,0.1);
        }
        
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--trek-text);
            margin-bottom: 6px;
        }
        
        /* ============ BADGE ============ */
        .badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
        }
        
        /* ============ RESPONSIVE ============ */
        @media (max-width: 992px) {
            .navbar-links { display: none; }
            .hero-trek h1 { font-size: 2rem; }
        }
        
        @media (max-width: 768px) {
            .hero-trek { padding: 48px 0; }
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

    <!-- ============ NAVBAR ============ -->
    <nav class="navbar-trek">
        <div class="container">
            <a href="/" class="navbar-logo">
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="TrekNesia">
                @else
                    <span class="navbar-logo-text">
                        <i class="fas fa-mountain"></i> Trek<span style="color:var(--trek-accent)">Nesia</span>
                    </span>
                @endif
            </a>
            
            <ul class="navbar-links">
                <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Shop</a></li>
                <li><a href="/products" class="{{ request()->is('products*') ? 'active' : '' }}">Produk</a></li>
                <li><a href="/brands" class="{{ request()->is('brands*') ? 'active' : '' }}">Brands</a></li>
                <li><a href="/sale" class="{{ request()->is('sale*') ? 'active' : '' }}">Sale</a></li>
                @if(session('user_id'))
                    <li><a href="/cek-status" class="{{ request()->is('cek-status*') ? 'active' : '' }}"><i class="fas fa-search me-1"></i> Cek Status</a></li>
                @endif
            </ul>
            
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
                    <a href="/admin/dashboard" class="btn btn-primary-custom btn-sm">
                        <i class="fas fa-tachometer-alt"></i> <span class="d-none d-md-inline">Dashboard</span>
                    </a>
                    <div class="dropdown">
                        <button class="user-menu-btn dropdown-toggle" data-bs-toggle="dropdown">
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
                    <a href="/login-admin" class="btn btn-ghost btn-sm">
                        <i class="fas fa-store"></i> <span class="d-none d-md-inline">Jual Barang</span>
                    </a>
                    <a href="/login-user" class="btn btn-primary-custom btn-sm">
                        <i class="fas fa-shopping-bag"></i> <span class="d-none d-md-inline">Pesan Barang</span>
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- ============ FOOTER ============ -->
    <footer class="footer-trek">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="TrekNesia" style="height:48px; filter: brightness(0) invert(1); margin-bottom:18px;">
                    @else
                        <h5 style="color:#fff; margin-bottom:18px; font-family:Manrope; font-size:1.15rem; font-weight:800;">
                            <i class="fas fa-mountain" style="color:var(--trek-accent-light)"></i> TrekNesia
                        </h5>
                    @endif
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