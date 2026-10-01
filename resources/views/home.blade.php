@extends('layouts.app')

@section('title', 'TrekNesia - Platform Alat Outdoor')

@section('content')

<!-- HERO -->
<section class="hero-trek">
    <div class="container" style="max-width: 1280px;">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="hero-badge">
                    <span style="color:var(--amber-400);">★</span>
                    Dipercaya 10.000+ Petualang
                </span>
                <h1>Gear untuk <span>Setiap</span> Pendakian</h1>
                <p>Peralatan premium untuk pelari, pendaki, berkemah, dan penjelajah sehari-hari. Kualitas teruji di medan sesungguhnya.</p>
                <div class="hero-actions">
                    <a href="/login-user" class="btn btn-primary-custom btn-lg">
                        <i class="fas fa-shopping-bag"></i> Pesan Barang
                    </a>
                    <a href="/login-admin" class="btn btn-outline-custom btn-lg">
                        <i class="fas fa-store"></i> Jual Barang
                    </a>
                </div>
                <div class="hero-features">
                    <span><i class="fas fa-check-circle"></i> 100% Original</span>
                    <span><i class="fas fa-check-circle"></i> Garansi Resmi</span>
                    <span><i class="fas fa-check-circle"></i> Kirim Se-Indonesia</span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=800&h=600&fit=crop" 
                         alt="Outdoor Adventure" 
                         class="hero-image">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KATEGORI -->
<section class="section" id="kategori">
    <div class="container" style="max-width: 1280px;">
        <div class="text-center mb-5">
            <h2 class="section-title">Kategori Produk</h2>
            <p class="section-subtitle">Temukan perlengkapan sesuai kebutuhan Anda</p>
        </div>
        <div class="row g-3 justify-content-center" id="categoriesContainer">
            <div class="col-12 text-center py-4"><i class="fas fa-spinner fa-spin" style="color:var(--brand-400);"></i></div>
        </div>
    </div>
</section>

<!-- FEATURED -->
<section class="section section-soft" id="gear">
    <div class="container" style="max-width: 1280px;">
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
            <div class="col-12 text-center py-5"><i class="fas fa-spinner fa-spin" style="color:var(--brand-400);"></i></div>
        </div>
    </div>
</section>

<!-- BUNDLES -->
<section class="section" id="bundles">
    <div class="container" style="max-width: 1280px;">
        <div class="text-center mb-5">
            <h2 class="section-title">Adventure Bundles</h2>
            <p class="section-subtitle">Paket hemat untuk petualangan Anda — Diskon hingga 32%</p>
        </div>
        <div class="row g-4" id="bundlesContainer">
            <div class="col-12 text-center py-5"><i class="fas fa-spinner fa-spin" style="color:var(--brand-400);"></i></div>
        </div>
    </div>
</section>

<!-- NEWSLETTER -->
<section class="section section-soft">
    <div class="container" style="max-width: 1024px;">
        <div class="card-trek p-5 text-center">
            <h2 class="section-title">Dapatkan Info Terbaru</h2>
            <p class="section-subtitle mb-4">Subscribe untuk mendapatkan update produk dan tips outdoor</p>
            <div style="max-width: 500px; margin: 0 auto;">
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Email Anda">
                    <button class="btn btn-primary-custom" type="button">Subscribe</button>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    const isLoggedIn = {{ session('user_id') ? 'true' : 'false' }};
    
    const bundleDefinitions = [
        { name: 'Weekend Hiker', items: 3, discountRate: 0.75, rating: 4.7, productKeys: ['Sepatu Trail', 'Trekking Pole', 'Headlamp'] },
        { name: 'Bike Explorer', items: 4, discountRate: 0.68, rating: 5.0, productKeys: ['Cycling Helmet', 'Cycling Gloves', 'Hydration Bladder', 'Running Vest'] },
        { name: 'Backcountry Camp', items: 5, discountRate: 0.70, rating: 4.6, productKeys: ['Tenda', 'Sleeping Bag', 'Matras', 'Headlamp', 'Carrier 60L'] },
        { name: 'Trail Runner', items: 3, discountRate: 0.72, rating: 5.1, productKeys: ['Sepatu Trail', 'Running Vest', 'Compression Socks'] }
    ];
    
    let allProductsCache = [];
    let bundleComputed = [];
    
    function formatRupiah(n) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(n);
    }
    
    // LOAD PRODUCTS
    fetch('/api/products')
        .then(res => res.json())
        .then(data => {
            allProductsCache = data.data || [];
            computeBundles();
            renderFeatured();
            renderBundles();
        })
        .catch(err => {
            console.error('Products failed:', err);
            document.getElementById('featuredProducts').innerHTML = '<div class="col-12 text-center py-5" style="color:var(--rose-500);">Gagal memuat produk</div>';
            document.getElementById('bundlesContainer').innerHTML = '<div class="col-12 text-center py-5" style="color:var(--rose-500);">Gagal memuat bundle</div>';
        });
    
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
            container.innerHTML = '';
            data.data.forEach(cat => {
                const icon = icons[cat.name] || 'fa-tag';
                container.innerHTML += `
                    <div class="col-lg-2 col-md-3 col-4">
                        <a href="/products?category=${cat.slug}" class="category-card">
                            <div class="category-icon-wrapper"><i class="fas ${icon}"></i></div>
                            <h6>${cat.name}</h6>
                        </a>
                    </div>
                `;
            });
        });
    
    // COMPUTE BUNDLES
    function computeBundles() {
        bundleComputed = bundleDefinitions.map(def => {
            const products = [];
            def.productKeys.forEach(key => {
                const p = allProductsCache.find(x => x.name.toLowerCase().includes(key.toLowerCase()));
                if (p) products.push(p);
            });
            const originalTotal = products.reduce((sum, p) => sum + p.price, 0);
            const bundlePrice = Math.round(originalTotal * def.discountRate / 1000) * 1000;
            const ratio = originalTotal > 0 ? bundlePrice / originalTotal : 1;
            const discountedProducts = products.map(p => ({
                ...p,
                originalPrice: p.price,
                bundlePrice: Math.round(p.price * ratio)
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
    }
    
    // RENDER FEATURED
    function renderFeatured() {
        const container = document.getElementById('featuredProducts');
        const products = allProductsCache.slice(0, 8);
        if (products.length === 0) {
            container.innerHTML = '<div class="col-12 text-center py-5" style="color:var(--slate-400);">Tidak ada produk</div>';
            return;
        }
        container.innerHTML = '';
        products.forEach(p => {
            container.innerHTML += `
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="product-card">
                        <div class="product-card-image">
                            <img src="${p.image}" alt="${p.name}" loading="lazy" onerror="this.src='https://placehold.co/400x400/0D1C2D/34d399?text=TrekNesia'">
                        </div>
                        <div class="product-card-body">
                            <span class="product-card-tag">${p.category}</span>
                            <h5 class="product-card-title">${p.name}</h5>
                            <div class="product-card-brand">${p.brand || 'TrekNesia'}</div>
                            <div class="product-card-meta">
                                <span class="rating"><i class="fas fa-star"></i> ${p.rating}</span>
                            </div>
                            <div class="product-card-price">${formatRupiah(p.price)}</div>
                            <a href="/product/${p.id}" class="btn btn-outline-custom btn-sm">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            `;
        });
    }
    
    // RENDER BUNDLES
    function renderBundles() {
        const container = document.getElementById('bundlesContainer');
        if (bundleComputed.length === 0) {
            container.innerHTML = '<div class="col-12 text-center py-5" style="color:var(--slate-400);">Produk belum tersedia</div>';
            return;
        }
        container.innerHTML = '';
        bundleComputed.forEach((bundle, idx) => {
            const imageUrl = bundle.thumbnail || 'https://placehold.co/600x400/0D1C2D/34d399?text=Bundle';
            container.innerHTML += `
                <div class="col-lg-3 col-md-6">
                    <div class="product-card">
                        <div class="product-card-image" style="aspect-ratio:4/3; position:relative;">
                            <img src="${imageUrl}" alt="${bundle.name}" loading="lazy" onerror="this.src='https://placehold.co/600x400/0D1C2D/34d399?text=Bundle'">
                            <span style="position:absolute; top:12px; left:12px; font-size:0.7rem; font-weight:700; padding:4px 10px; background:rgba(1,15,31,0.9); color:var(--slate-300); border:1px solid var(--navy-600); border-radius:6px;">
                                ${bundle.items} Items
                            </span>
                            <span style="position:absolute; top:12px; right:12px; font-size:0.7rem; font-weight:700; padding:4px 10px; background:var(--rose-500); color:#fff; border-radius:6px;">
                                -${bundle.discountPercent}%
                            </span>
                        </div>
                        <div class="product-card-body">
                            <h5 class="product-card-title" style="min-height:auto; margin-bottom:8px;">${bundle.name}</h5>
                            <div class="product-card-meta" style="margin-bottom:12px;">
                                <span class="rating"><i class="fas fa-star"></i> ${bundle.rating}</span>
                            </div>
                            <div style="margin-bottom:10px;">
                                <div style="font-size:0.75rem; color:var(--slate-500); text-decoration:line-through;">
                                    ${formatRupiah(bundle.originalTotal)}
                                </div>
                                <div class="product-card-price" style="margin-bottom:4px;">
                                    ${formatRupiah(bundle.bundlePrice)}
                                </div>
                                <div style="font-size:0.72rem; color:var(--brand-400); font-weight:600;">
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
    
    // ORDER BUNDLE
    window.orderBundle = function(bundleIndex) {
        if (!isLoggedIn) {
            alert('⚠️ Silakan login terlebih dahulu untuk memesan bundle!');
            window.location.href = '/login-user';
            return;
        }
        const bundle = bundleComputed[bundleIndex];
        if (!bundle || bundle.products.length === 0) { alert('Bundle tidak tersedia'); return; }
        
        let confirmMsg = `📦 Pesan Bundle: ${bundle.name}\n\n`;
        bundle.products.forEach(p => {
            confirmMsg += `• ${p.name}\n  ${formatRupiah(p.originalPrice)} → ${formatRupiah(p.bundlePrice)}\n`;
        });
        confirmMsg += `\n─────────────────\n`;
        confirmMsg += `Total asli: ${formatRupiah(bundle.originalTotal)}\n`;
        confirmMsg += `Harga bundle: ${formatRupiah(bundle.bundlePrice)}\n`;
        confirmMsg += `Hemat: ${formatRupiah(bundle.savings)} (-${bundle.discountPercent}%)\n\n`;
        confirmMsg += `Lanjutkan?`;
        if (!confirm(confirmMsg)) return;
        
        let cart = JSON.parse(localStorage.getItem('treknesia_cart') || '[]');
        bundle.products.forEach(product => {
            const defaultSize = (product.sizes && product.sizes.length > 0) ? product.sizes[0] : null;
            const existingIdx = cart.findIndex(item => 
                item.id === product.id && item.size === defaultSize && item.bundleName === bundle.name
            );
            if (existingIdx !== -1) {
                cart[existingIdx].quantity += 1;
            } else {
                cart.push({
                    id: product.id, name: product.name, price: product.bundlePrice,
                    originalPrice: product.originalPrice, category: product.category,
                    gender: product.gender, image: product.image, size: defaultSize,
                    bundleName: bundle.name, quantity: 1
                });
            }
        });
        localStorage.setItem('treknesia_cart', JSON.stringify(cart));
        const total = cart.reduce((sum, item) => sum + item.quantity, 0);
        const badge = document.getElementById('cartCount');
        if (badge) badge.textContent = total;
        alert(`✅ Bundle "${bundle.name}" berhasil ditambahkan!\n\n${bundle.products.length} produk masuk keranjang.`);
        window.location.href = '/cart';
    };
</script>
@endpush