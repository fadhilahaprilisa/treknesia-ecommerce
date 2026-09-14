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
    
    <!-- Custom CSS -->
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: #1a472a !important;
        }
        
        .navbar-brand span {
            color: #2d6a4f;
        }
        
        .nav-link {
            font-weight: 600;
            color: #2d3748 !important;
        }
        
        .nav-link:hover {
            color: #1a472a !important;
        }
        
        .btn-primary-custom {
            background: #1a472a;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background: #2d6a4f;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(26, 71, 42, 0.3);
        }
        
        .btn-outline-custom {
            border: 2px solid #1a472a;
            color: #1a472a;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-outline-custom:hover {
            background: #1a472a;
            color: white;
        }
        
        .section-title {
            font-weight: 800;
            color: #1a202c;
            margin-bottom: 10px;
        }
        
        .section-subtitle {
            color: #718096;
            font-weight: 300;
        }
        
        .product-card {
            border: none;
            border-radius: 16px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }
        
        .product-card .card-img-top {
            border-radius: 16px 16px 0 0;
            height: 200px;
            object-fit: cover;
            background: #f7fafc;
        }
        
        .product-card .card-body {
            padding: 1.5rem;
        }
        
        .product-card .card-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }
        
        .product-card .price {
            font-weight: 800;
            color: #1a472a;
            font-size: 1.3rem;
        }
        
        .product-card .rating {
            color: #f6ad55;
            font-size: 0.9rem;
        }
        
        .product-card .badge-gender {
            background: #edf2f7;
            color: #2d3748;
            font-size: 0.7rem;
            padding: 4px 10px;
            border-radius: 20px;
        }
        
        .footer {
            background: #1a202c;
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer a {
            color: #a0aec0;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer a:hover {
            color: white;
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #e53e3e;
            color: white;
            border-radius: 50%;
            padding: 2px 8px;
            font-size: 0.7rem;
            font-weight: 700;
        }
        
        .category-icon {
            font-size: 2.5rem;
            color: #1a472a;
            margin-bottom: 10px;
        }
        
        .category-card {
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 25px 15px;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            background: white;
        }
        
        .category-card:hover {
            border-color: #1a472a;
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(26, 71, 42, 0.12);
        }
        
        .category-card h6 {
            font-weight: 700;
            margin-top: 10px;
            color: #1a202c;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #1a472a 0%, #2d6a4f 100%);
            color: white;
            padding: 80px 0;
            border-radius: 0 0 40px 40px;
        }
        
        .hero-section h1 {
            font-weight: 800;
            font-size: 3.5rem;
            margin-bottom: 20px;
        }
        
        .hero-section p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        
        .bundle-card {
            background: #f7fafc;
            border-radius: 16px;
            padding: 25px;
            transition: all 0.3s;
            border: 2px solid transparent;
        }
        
        .bundle-card:hover {
            border-color: #1a472a;
            transform: translateY(-5px);
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
                        <a class="nav-link" href="#">Brands</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sale</a>
                    </li>
                </ul>
                
                <div class="position-relative">
                    <a href="/cart" class="btn btn-outline-custom">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-badge" id="cartCount">0</span>
                    </a>
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
                        <li><a href="#">All Products</a></li>
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
    
    @stack('scripts')
</body>
</html>