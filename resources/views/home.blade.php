@extends('layouts.app')

@section('title', 'TrekNesia - Platform Alat Outdoor')

@section('content')

<!-- ============ HERO SECTION ============ -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <h1>Gear untuk Setiap Pendakian</h1>
                <p>Peralatan premium untuk pelari, pendaki, berkemah, dan penjelajah sehari-hari.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="/login-user" class="btn btn-light btn-lg px-4 fw-bold text-success">
                        <i class="fas fa-shopping-bag"></i> Pesan Barang
                    </a>
                    <a href="/login-admin" class="btn btn-outline-light btn-lg px-4">
                        <i class="fas fa-store"></i> Jual Barang
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=600&h=400&fit=crop" 
                     alt="Outdoor Adventure" 
                     class="hero-image">
            </div>
        </div>
    </div>
</section>

<!-- ============ KATEGORI ============ -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Kategori Produk</h2>
            <p class="section-subtitle">Temukan perlengkapan sesuai kebutuhan Anda</p>
        </div>
        
        <div class="row g-3 justify-content-center" id="categoriesContainer">
            <!-- Akan diisi JavaScript -->
        </div>
    </div>
</section>

<!-- ============ FEATURED GEAR ============ -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="section-title">Gear Unggulan</h2>
                <p class="section-subtitle mb-0">Produk terbaik untuk petualangan Anda</p>
            </div>
            <a href="/products" class="btn btn-outline-custom">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="row g-4" id="featuredProducts">
            <!-- Akan diisi JavaScript -->
        </div>
    </div>
</section>

<!-- ============ ADVENTURE BUNDLES ============ -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Adventure Bundles</h2>
            <p class="section-subtitle">Paket hemat untuk petualangan Anda</p>
        </div>
        
        <div class="row g-4" id="bundlesContainer">
            <!-- Akan diisi JavaScript -->
        </div>
    </div>
</section>

<!-- ============ NEWSLETTER ============ -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="section-title">Dapatkan Info Terbaru</h2>
        <p class="section-subtitle mb-4">Subscribe untuk mendapatkan update produk dan tips outdoor</p>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="email" class="form-control form-control-lg" placeholder="Email Anda">
                    <button class="btn btn-primary-custom">Subscribe</button>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // LOAD CATEGORIES
    fetch('/api/categories')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('categoriesContainer');
            const icons = {
                'Running': 'fa-running', 'Hiking': 'fa-hiking',
                'Camping': 'fa-campground', 'Cycling': 'fa-bicycle',
                'Training': 'fa-dumbbell', 'Recovery': 'fa-heart'
            };
            
            data.data.forEach(cat => {
                const icon = icons[cat.name] || 'fa-tag';
                container.innerHTML += `
                    <div class="col-lg-2 col-md-3 col-4">
                        <a href="/products?category=${cat.slug}" class="text-decoration-none">
                            <div class="category-card">
                                <i class="fas ${icon} category-icon"></i>
                                <h6>${cat.name}</h6>
                            </div>
                        </a>
                    </div>
                `;
            });
        });

    // LOAD FEATURED PRODUCTS
    fetch('/api/products')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('featuredProducts');
            data.data.slice(0, 4).forEach(product => {
                const priceFormatted = new Intl.NumberFormat('id-ID', {
                    style: 'currency', currency: 'IDR', minimumFractionDigits: 0
                }).format(product.price);
                
                container.innerHTML += `
                    <div class="col-lg-3 col-md-6">
                        <div class="card product-card h-100">
                            <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=400&h=200&fit=crop" 
                                 class="card-img-top" alt="${product.name}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-light text-dark">${product.category}</span>
                                    <span class="badge-gender">${product.gender}</span>
                                </div>
                                <h5 class="card-title">${product.name}</h5>
                                <div class="rating"><i class="fas fa-star"></i> ${product.rating}</div>
                                <div class="price mt-2">${priceFormatted}</div>
                                <a href="/product/${product.id}" class="btn btn-primary-custom w-100 mt-3">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            });
        });

    // LOAD BUNDLES
    const bundles = [
        { name: 'Weekend Hiker', items: 3, price: 279, rating: 4.7 },
        { name: 'Bike Explorer', items: 4, price: 399, rating: 5.0 },
        { name: 'Backcountry Camp', items: 5, price: 499, rating: 4.6 },
        { name: 'Trail Runner', items: 3, price: 239, rating: 5.1 }
    ];
    
    const bundlesContainer = document.getElementById('bundlesContainer');
    bundles.forEach(bundle => {
        bundlesContainer.innerHTML += `
            <div class="col-lg-3 col-md-6">
                <div class="bundle-card text-center">
                    <i class="fas fa-box-open fa-3x text-success mb-3"></i>
                    <h5>${bundle.name}</h5>
                    <p class="text-muted">${bundle.items} Items</p>
                    <h4 class="text-success">Rp ${bundle.price}.000</h4>
                    <div class="text-warning"><i class="fas fa-star"></i> ${bundle.rating}</div>
                    <button class="btn btn-primary-custom mt-3 w-100">Pesan Sekarang</button>
                </div>
            </div>
        `;
    });
</script>
@endpush