<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'TrekNesia - Platform Alat Outdoor')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { overflow-x: hidden; }
        
        /* ============ NAVBAR ============ */
        .navbar-brand { font-weight: 800; font-size: 1.6rem; color: #1a472a !important; }
        .navbar-brand span { color: #2d6a4f; }
        .nav-link { font-weight: 600; color: #2d3748 !important; }
        .nav-link:hover { color: #1a472a !important; }
        
        /* ============ BUTTONS ============ */
        .btn-primary-custom {
            background: #1a472a; color: white; border: none;
            padding: 10px 24px; border-radius: 50px;
            font-weight: 600; transition: all 0.3s; font-size: 0.95rem;
        }
        .btn-primary-custom:hover {
            background: #2d6a4f; transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(26, 71, 42, 0.3); color: white;
        }
        .btn-outline-custom {
            border: 2px solid #1a472a; color: #1a472a;
            padding: 10px 24px; border-radius: 50px;
            font-weight: 600; transition: all 0.3s; font-size: 0.95rem;
        }
        .btn-outline-custom:hover { background: #1a472a; color: white; }
        
        /* ============ HERO ============ */
        .hero-section {
            background: linear-gradient(135deg, #1a472a 0%, #2d6a4f 100%);
            color: white;
            padding: 60px 0;
            border-radius: 0 0 40px 40px;
            overflow: hidden;
        }
        .hero-section h1 {
            font-weight: 800;
            font-size: 2.8rem;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        .hero-section p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        .hero-image {
            width: 100%;
            height: 380px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        }
        
        /* ============ SECTIONS ============ */
        .section-title { font-weight: 800; color: #1a202c; margin-bottom: 10px; font-size: 2rem; }
        .section-subtitle { color: #718096; font-weight: 300; }
        
        /* ============ PRODUCT CARD ============ */
        .product-card {
            border: none; border-radius: 16px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }
        .product-card .card-img-top {
            height: 200px; object-fit: cover; background: #f7fafc;
        }
        .product-card .card-body { padding: 1.25rem; }
        .product-card .card-title { font-weight: 700; font-size: 1rem; margin-bottom: 8px; }
        .product-card .price { font-weight: 800; color: #1a472a; font-size: 1.2rem; }
        .product-card .rating { color: #f6ad55; font-size: 0.85rem; }
        .product-card .badge-gender {
            background: #edf2f7; color: #2d3748;
            font-size: 0.65rem; padding: 4px 10px; border-radius: 20px;
        }
        
        /* ============ CATEGORY CARD ============ */
        .category-icon { font-size: 2.2rem; color: #1a472a; margin-bottom: 10px; }
        .category-card {
            border: 2px solid #e2e8f0; border-radius: 16px;
            padding: 20px 12px; text-align: center;
            transition: all 0.3s; cursor: pointer; background: white;
            height: 100%;
        }
        .category-card:hover {
            border-color: #1a472a; transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(26, 71, 42, 0.12);
        }
        .category-card h6 { font-weight: 700; margin-top: 8px; color: #1a202c; font-size: 0.9rem; }
        
        /* ============ BUNDLE CARD ============ */
        .bundle-card {
            background: #f7fafc; border-radius: 16px; padding: 25px;
            transition: all 0.3s; border: 2px solid transparent;
            height: 100%;
        }
        .bundle-card:hover { border-color: #1a472a; transform: translateY(-5px); }
        
        /* ============ FOOTER ============ */
        .footer { background: #1a202c; color: white; padding: 60px 0 30px; }
        .footer a { color: #a0aec0; text-decoration: none; transition: color 0.3s; }
        .footer a:hover { color: white; }
        
        /* ============ CART BADGE ============ */
        .cart-badge {
            position: absolute; top: -8px; right: -8px;
            background: #e53e3e; color: white; border-radius: 50%;
            padding: 2px 8px; font-size: 0.7rem; font-weight: 700;
        }
        
        /* ============ RESPONSIVE ============ */
        @media (max-width: 768px) {
            .hero-section h1 { font-size: 2rem; }
            .hero-image { height: 250px; margin-top: 30px; }
            .section-title { font-size: 1.5rem; }
        }
    </style>
    
    @stack('styles')
</head>
<body>

    <!-- ============ NAVBAR ============ -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-mountain"></i> Trek<span>Nesia</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-4">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="fas fa-home"></i> Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/products">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Brands</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sale</a>
                    </li>
                    @if(session('user_id'))
                        <li class="nav-item">
                            <a class="nav-link" href="/cek-status"><i class="fas fa-search"></i> Cek Status</a>
                        </li>
                    @endif
                </ul>
                
                <div class="d-flex gap-2 align-items-center">
                    @if(session('user_id'))
                        <a href="/cart" class="btn btn-outline-custom position-relative">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge" id="cartCount">0</span>
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-primary-custom dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ session('user_name') }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/cek-status"><i class="fas fa-search"></i> Cek Pesanan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @elseif(session('admin_id'))
                        <a href="/admin/dashboard" class="btn btn-primary-custom">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-outline-custom dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-store"></i> {{ session('admin_name') }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="/login-admin" class="btn btn-outline-custom">
                            <i class="fas fa-store"></i> Jual Barang
                        </a>
                        <a href="/login-user" class="btn btn-primary-custom">
                            <i class="fas fa-shopping-bag"></i> Pesan Barang
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- ============ CONTENT ============ -->
    <main>
        @yield('content')
    </main>

    <!-- ============ FOOTER ============ -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-mountain"></i> TrekNesia</h5>
                    <p class="text-secondary">Platform penjualan alat outdoor dinamis dengan fitur checkout otomatis.</p>
                    <div>
                        <a href="#" class="me-2"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-youtube fa-lg"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-tiktok fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h6>Shop</h6>
                    <ul class="list-unstyled">
                        <li><a href="/products">All Products</a></li>
                        <li><a href="#">New Arrivals</a></li>
                        <li><a href="#">Best Sellers</a></li>
                        <li><a href="#">Sale</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6>Help</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">Customer Service</a></li>
                        <li><a href="#">Shipping Info</a></li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6>Company</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">Our Story</a></li>
                        <li><a href="#">Sustainability</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center text-secondary">
                <small>&copy; 2026 TrekNesia. All rights reserved.</small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
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