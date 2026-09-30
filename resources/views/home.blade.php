@extends('layouts.app')

@section('title', 'TrekNesia - Platform Alat Outdoor')

@section('content')

<!-- ============ HERO ============ -->
<section class="hero-trek">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="hero-badge">
                    <i class="fas fa-star"></i> Dipercaya 10.000+ Petualang
                </span>
                <h1>Gear untuk <span>Setiap Pendakian</span></h1>
                <p>Peralatan premium untuk pelari, pendaki, berkemah, dan penjelajah sehari-hari. Kualitas teruji di medan sesungguhnya.</p>
                <div class="hero-actions">
                    <a href="/login-user" class="btn btn-primary-custom btn-lg">
                        <i class="fas fa-shopping-bag"></i> Pesan Barang
                    </a>
                    <a href="/login-admin" class="btn btn-outline-custom btn-lg">
                        <i class="fas fa-store"></i> Jual Barang
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=700&h=525&fit=crop" 
                     alt="Outdoor Adventure" 
                     class="hero-image">
            </div>
        </div>
    </div>
</section>

<!-- ============ KATEGORI ============ -->
<section class="section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Kategori Produk</h2>
            <p class="section-subtitle">Temukan perlengkapan sesuai kebutuhan Anda</p>
        </div>
        
        <div class="row g-3 justify-content-center" id="categoriesContainer">
            <div class="col-12 text-center py-4"><i class="fas fa-spinner fa-spin"></i></div>
        </div>
    </div>
</section>

<!-- ============ FEATURED ============ -->
<section class="section section-soft">
    <div class="container">
        <div class="section-head">
            <div>
                <h2 class="section-title">Gear Unggulan</h2>
                <p class="section-subtitle">Produk terbaik untuk petualangan Anda</p>
            </div>
            <a href="/products" class="btn btn-outline-custom btn-sm">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="row g-4" id="featuredProducts">
            <div class="col-12 text-center py-5"><i class="fas fa-spinner fa-spin"></i></div>
        </div>
    </div>
</section>

<!-- ============ BUNDLES ============ -->
<section class="section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Adventure Bundles</h2>
            <p class="section-subtitle">Paket hemat untuk petualangan Anda — Diskon hingga 30%</p>
        </div>
        
        <div class="row g-4" id="bundlesContainer">
            <div class="col-12 text-center py-5"><i class="fas fa-spinner fa-spin"></i></div>
        </div>
    </div>
</section>

<!-- ============ NEWSLETTER ============ -->
<section class="section section-soft">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h2 class="section-title">Dapatkan Info Terbaru</h2>
                <p class="section-subtitle mb-4">Subscribe untuk mendapatkan update produk dan tips outdoor</p>
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Email Anda">
                    <button class="btn btn-primary-custom">Subscribe</button>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // ============================================
    // STATE
    // ============================================
    const isLoggedIn = {{ session('user_id') ? 'true' : 'false' }};
    
    // ✅ DEFINISI BUNDLE dengan DISCOUNT RATE
    const bundleDefinitions = [
        {
            name: 'Weekend Hiker',
            items: 3,
            discountRate: 0.75,  // 25% off
            rating: 4.7,
            productKeys: ['Sepatu Trail', 'Trekking Pole', 'Headlamp']
        },
        {
            name: 'Bike Explorer',
            items: 4,
            discountRate: 0.68,  // 32% off
            rating: 5.0,
            productKeys: ['Cycling Helmet', 'Cycling Gloves', 'Hydration Bladder', 'Running Vest']
        },
        {
            name: 'Backcountry Camp',
            items: 5,
            discountRate: 0.70,  // 30% off
            rating: 4.6,
            productKeys: ['Tenda', 'Sleeping Bag', 'Matras', 'Headlamp', 'Carrier 60L']
        },
        {
            name: 'Trail Runner',
            items: 3,
            discountRate: 0.72,  // 28% off
            rating: 5.1,
            productKeys: ['Sepatu Trail', 'Running Vest', 'Compression Socks']
        }
    ];
    
    let allProductsCache = [];
    let bundleComputed = [];  // Simpan harga dinamis
    
    function formatRupiah(n) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency', currency: 'IDR', minimumFractionDigits: 0
        }).format(n);
    }
    
    // ============================================
    // LOAD PRODUCTS
    // ============================================
    fetch('/api/products')
        .then(res => res.json())
        .then(data => {
            allProductsCache = data.data || [];
            console.log('✅ Products loaded:', allProductsCache.length);
            
            // Pre-compute bundle data
            computeBundles();
            
            renderFeatured();
            renderBundles();
        })
        .catch(err => {
            console.error('❌ Products failed:', err);
            document.getElementById('featuredProducts').innerHTML = '<div class="col-12 text-center py-5 text-danger">Gagal memuat produk</div>';
            document.getElementById('bundlesContainer').innerHTML = '<div class="col-12 text-center py-5 text-danger">Gagal memuat bundle</div>';
        });
    
    fetch('/api/categories')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('categoriesContainer');
            const icons = {
                'Running': 'fa-running', 'Hiking': 'fa-hiking',
                'Camping': 'fa-campground', 'Cycling': 'fa-bicycle',
                'Training': 'fa-dumbbell', 'Recovery': 'fa-heart'
            };
            container.innerHTML = '';
            data.data.forEach(cat => {
                container.innerHTML += `
                    <div class="col-lg-2 col-md-3 col-4">
                        <a href="/products?category=${cat.slug}" class="category-card">
                            <i class="fas ${icons[cat.name] || 'fa-tag'}"></i>
                            <h6>${cat.name}</h6>
                        </a>
                    </div>
                `;
            });
        });
    
    // ============================================
    // ✅ COMPUTE BUNDLES — Hitung harga dinamis
    // ============================================
    function computeBundles() {
        bundleComputed = bundleDefinitions.map(def => {
            // Cari produk untuk bundle ini
            const products = [];
            def.productKeys.forEach(key => {
                const p = allProductsCache.find(x => 
                    x.name.toLowerCase().includes(key.toLowerCase())
                );
                if (p) products.push(p);
            });
            
            // Total harga asli
            const originalTotal = products.reduce((sum, p) => sum + p.price, 0);
            
            // Harga bundle (diskon)
            const bundlePrice = Math.round(originalTotal * def.discountRate / 1000) * 1000;  // Bulatkan ke ribuan
            
            // Discount ratio untuk harga per produk
            const ratio = originalTotal > 0 ? bundlePrice / originalTotal : 1;
            
            // Produk dengan harga sudah didiskon
            const discountedProducts = products.map(p => ({
                ...p,
                originalPrice: p.price,
                bundlePrice: Math.round(p.price * ratio)  // Harga per produk setelah diskon
            }));
            
            return {
                ...def,
                products: discountedProducts,
                originalTotal: originalTotal,
                bundlePrice: bundlePrice,
                savings: originalTotal - bundlePrice,
                discountPercent: Math.round((1 - def.discountRate) * 100),
                thumbnail: products[0] ? products[0].image : null
            };
        });
        
        console.log('✅ Bundles computed:', bundleComputed.map(b => ({
            name: b.name,
            original: b.originalTotal,
            bundle: b.bundlePrice,
            savings: b.savings
        })));
    }
    
    // ============================================
    // RENDER FEATURED
    // ============================================
    function renderFeatured() {
        const container = document.getElementById('featuredProducts');
        const products = allProductsCache.slice(0, 8);
        if (products.length === 0) {
            container.innerHTML = '<div class="col-12 text-center py-5 text-muted">Tidak ada produk</div>';
            return;
        }
        container.innerHTML = '';
        products.forEach(product => {
            container.innerHTML += `
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="product-card">
                        <div class="product-card-image">
                            <img src="${product.image}" alt="${product.name}" loading="lazy" onerror="this.src='https://placehold.co/400x400/f0f9f4/1a472a?text=TrekNesia'">
                        </div>
                        <div class="product-card-body">
                            <span class="product-card-tag">${product.category}</span>
                            <h5 class="product-card-title">${product.name}</h5>
                            <div class="product-card-brand">${product.brand || 'TrekNesia'}</div>
                            <div class="product-card-meta">
                                <span class="rating"><i class="fas fa-star"></i> ${product.rating}</span>
                            </div>
                            <div class="product-card-price">${formatRupiah(product.price)}</div>
                            <a href="/product/${product.id}" class="btn btn-primary-custom btn-sm">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            `;
        });
    }
    
    // ============================================
    // RENDER BUNDLES — dengan harga dinamis
    // ============================================
    function renderBundles() {
        const container = document.getElementById('bundlesContainer');
        if (bundleComputed.length === 0) {
            container.innerHTML = '<div class="col-12 text-center py-5 text-muted">Produk belum tersedia</div>';
            return;
        }
        
        container.innerHTML = '';
        bundleComputed.forEach((bundle, idx) => {
            const imageUrl = bundle.thumbnail || 'https://placehold.co/600x400/f0f9f4/1a472a?text=Bundle';
            
            container.innerHTML += `
                <div class="col-lg-3 col-md-6">
                    <div class="product-card">
                        <div class="product-card-image" style="aspect-ratio:4/3; position:relative;">
                            <img src="${imageUrl}" alt="${bundle.name}" loading="lazy" onerror="this.src='https://placehold.co/600x400/f0f9f4/1a472a?text=Bundle'">
                            <span style="position:absolute; top:12px; left:12px; font-size:0.7rem; font-weight:700; padding:4px 10px; background:#fff; color:var(--trek-primary); border:1px solid var(--trek-primary); border-radius:6px;">
                                ${bundle.items} Items
                            </span>
                            <span style="position:absolute; top:12px; right:12px; font-size:0.7rem; font-weight:700; padding:4px 10px; background:#dc2626; color:#fff; border-radius:6px;">
                                -${bundle.discountPercent}%
                            </span>
                        </div>
                        <div class="product-card-body">
                            <h5 class="product-card-title" style="min-height:auto; margin-bottom:8px;">${bundle.name}</h5>
                            <div class="product-card-meta" style="margin-bottom:12px;">
                                <span class="rating"><i class="fas fa-star"></i> ${bundle.rating}</span>
                            </div>
                            <div style="margin-bottom:10px;">
                                <div style="font-size:0.75rem; color:var(--trek-text-muted); text-decoration:line-through;">
                                    ${formatRupiah(bundle.originalTotal)}
                                </div>
                                <div class="product-card-price" style="margin-bottom:4px;">
                                    ${formatRupiah(bundle.bundlePrice)}
                                </div>
                                <div style="font-size:0.72rem; color:#16a34a; font-weight:600;">
                                    <i class="fas fa-tag"></i> Hemat ${formatRupiah(bundle.savings)}
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary-custom btn-sm w-100" onclick="orderBundle(${idx})">
                                <i class="fas fa-shopping-bag"></i> Pesan Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });
    }
    
    // ============================================
    // ✅ ORDER BUNDLE — pakai harga diskon
    // ============================================
    window.orderBundle = function(bundleIndex) {
        if (!isLoggedIn) {
            alert('⚠️ Silakan login terlebih dahulu untuk memesan bundle!');
            window.location.href = '/login-user';
            return;
        }
        
        const bundle = bundleComputed[bundleIndex];
        if (!bundle || bundle.products.length === 0) {
            alert('Bundle tidak tersedia');
            return;
        }
        
        // Konfirmasi dengan rincian harga
        let confirmMsg = `📦 Pesan Bundle: ${bundle.name}\n\n`;
        confirmMsg += `Produk yang akan ditambahkan:\n`;
        bundle.products.forEach(p => {
            confirmMsg += `• ${p.name}\n`;
            confirmMsg += `  ${formatRupiah(p.originalPrice)} → ${formatRupiah(p.bundlePrice)}\n`;
        });
        confirmMsg += `\n─────────────────\n`;
        confirmMsg += `Total asli: ${formatRupiah(bundle.originalTotal)}\n`;
        confirmMsg += `Harga bundle: ${formatRupiah(bundle.bundlePrice)}\n`;
        confirmMsg += `Hemat: ${formatRupiah(bundle.savings)} (-${bundle.discountPercent}%)\n\n`;
        confirmMsg += `Lanjutkan?`;
        
        if (!confirm(confirmMsg)) return;
        
        let cart = JSON.parse(localStorage.getItem('treknesia_cart') || '[]');
        
        // ✅ Tambahkan produk dengan HARGA DISKON + tag bundle
        bundle.products.forEach(product => {
            const defaultSize = (product.sizes && product.sizes.length > 0) ? product.sizes[0] : null;
            const existingIdx = cart.findIndex(item => 
                item.id === product.id && item.size === defaultSize && item.bundleName === bundle.name
            );
            
            if (existingIdx !== -1) {
                cart[existingIdx].quantity += 1;
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.bundlePrice,  // ✅ HARGA DISKON
                    originalPrice: product.originalPrice,
                    category: product.category,
                    gender: product.gender,
                    image: product.image,
                    size: defaultSize,
                    bundleName: bundle.name,  // ✅ Tag bundle
                    quantity: 1
                });
            }
        });
        
        localStorage.setItem('treknesia_cart', JSON.stringify(cart));
        
        const total = cart.reduce((sum, item) => sum + item.quantity, 0);
        const badge = document.getElementById('cartCount');
        if (badge) badge.textContent = total;
        
        alert(`✅ Bundle "${bundle.name}" berhasil ditambahkan!\n\n${bundle.products.length} produk masuk keranjang dengan harga spesial.`);
        window.location.href = '/cart';
    };
</script>
@endpush