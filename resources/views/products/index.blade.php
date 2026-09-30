@extends('layouts.app')

@section('title', 'Produk - TrekNesia')

@section('content')

<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar Filter -->
        <div class="col-lg-3">
            <div class="card-trek p-4 sticky-top" style="top:90px;">
                <h6 style="font-size:0.85rem; text-transform:uppercase; letter-spacing:0.05em; color:var(--trek-text-muted); margin-bottom:20px;">
                    <i class="fas fa-filter me-1"></i> Filter
                </h6>
                
                <div class="mb-4">
                    <h6 style="font-size:0.78rem; font-weight:700; color:var(--trek-dark); margin-bottom:12px;">Kategori</h6>
                    <div id="categoryFilters"></div>
                </div>
                
                <div class="mb-4">
                    <h6 style="font-size:0.78rem; font-weight:700; color:var(--trek-dark); margin-bottom:12px;">Brand</h6>
                    <div id="brandFilters"></div>
                </div>
                
                <div class="mb-2">
                    <h6 style="font-size:0.78rem; font-weight:700; color:var(--trek-dark); margin-bottom:12px;">Gender</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="" checked id="allGender">
                        <label class="form-check-label" for="allGender" style="font-size:0.85rem;">Semua</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Pria" id="maleGender">
                        <label class="form-check-label" for="maleGender" style="font-size:0.85rem;">Pria</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Wanita" id="femaleGender">
                        <label class="form-check-label" for="femaleGender" style="font-size:0.85rem;">Wanita</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Unisex" id="unisexGender">
                        <label class="form-check-label" for="unisexGender" style="font-size:0.85rem;">Unisex</label>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Product List -->
        <div class="col-lg-9">
            <div class="section-head">
                <div>
                    <h4 style="font-family:Manrope; font-size:1.35rem; font-weight:800;" id="productCount">Memuat...</h4>
                </div>
                <div style="min-width:180px;">
                    <select class="form-select form-select-sm" id="sortSelect">
                        <option value="default">Urutkan: Default</option>
                        <option value="price_asc">Harga Termurah</option>
                        <option value="price_desc">Harga Termahal</option>
                        <option value="rating">Rating Tertinggi</option>
                    </select>
                </div>
            </div>
            
            <div class="row g-4" id="productList"></div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let allProducts = [];
    let currentCategory = '{{ request("category") }}';
    let currentBrand = '{{ request("brand") }}';
    
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency', currency: 'IDR', minimumFractionDigits: 0
        }).format(angka);
    }
    
    // Load categories
    fetch('/api/categories')
        .then(r => r.json())
        .then(data => {
            const c = document.getElementById('categoryFilters');
            data.data.forEach(cat => {
                const checked = cat.slug === currentCategory ? 'checked' : '';
                c.innerHTML += `
                    <div class="form-check">
                        <input class="form-check-input category-filter" type="radio" name="category" value="${cat.slug}" id="cat_${cat.slug}" ${checked}>
                        <label class="form-check-label" for="cat_${cat.slug}" style="font-size:0.85rem;">${cat.name}</label>
                    </div>
                `;
            });
            document.querySelectorAll('.category-filter').forEach(el => el.addEventListener('change', filterProducts));
        });
    
    // Load brands
    fetch('/api/brands')
        .then(r => r.json())
        .then(data => {
            const c = document.getElementById('brandFilters');
            c.innerHTML = `
                <div class="form-check">
                    <input class="form-check-input brand-filter" type="radio" name="brand" value="" checked id="allBrand">
                    <label class="form-check-label" for="allBrand" style="font-size:0.85rem;">Semua</label>
                </div>
            `;
            data.data.forEach(brand => {
                const checked = brand === currentBrand ? 'checked' : '';
                const bid = 'brand_' + brand.replace(/[^a-zA-Z0-9]/g, '_');
                c.innerHTML += `
                    <div class="form-check">
                        <input class="form-check-input brand-filter" type="radio" name="brand" value="${brand}" id="${bid}" ${checked}>
                        <label class="form-check-label" for="${bid}" style="font-size:0.85rem;">${brand}</label>
                    </div>
                `;
            });
            document.querySelectorAll('.brand-filter').forEach(el => el.addEventListener('change', filterProducts));
        });
    
    document.querySelectorAll('input[name="gender"]').forEach(el => el.addEventListener('change', filterProducts));
    document.getElementById('sortSelect').addEventListener('change', filterProducts);
    
    // Load products
    fetch('/api/products')
        .then(r => r.json())
        .then(data => {
            allProducts = data.data;
            filterProducts();
        });
    
    function filterProducts() {
        let products = [...allProducts];
        
        const cat = document.querySelector('input[name="category"]:checked');
        if (cat && cat.value) {
            products = products.filter(p => p.category.toLowerCase() === cat.value.toLowerCase());
        }
        
        const brand = document.querySelector('input[name="brand"]:checked');
        if (brand && brand.value) {
            products = products.filter(p => p.brand === brand.value);
        }
        
        const gender = document.querySelector('input[name="gender"]:checked');
        if (gender && gender.value) {
            products = products.filter(p => p.gender === gender.value);
        }
        
        const sort = document.getElementById('sortSelect').value;
        if (sort === 'price_asc') products.sort((a,b) => a.price - b.price);
        else if (sort === 'price_desc') products.sort((a,b) => b.price - a.price);
        else if (sort === 'rating') products.sort((a,b) => b.rating - a.rating);
        
        renderProducts(products);
    }
    
    function renderProducts(products) {
        const c = document.getElementById('productList');
        document.getElementById('productCount').textContent = `${products.length} produk ditemukan`;
        
        if (products.length === 0) {
            c.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada produk yang ditemukan</p>
                </div>
            `;
            return;
        }
        
        c.innerHTML = '';
        products.forEach(p => {
            c.innerHTML += `
                <div class="col-lg-4 col-md-6 col-6">
                    <div class="product-card">
                        <div class="product-card-image">
                            <img src="${p.image}" alt="${p.name}" loading="lazy" onerror="this.src='https://placehold.co/400x400/f0f9f4/1a472a?text=TrekNesia'">
                        </div>
                        <div class="product-card-body">
                            <span class="product-card-tag">${p.category}</span>
                            <h5 class="product-card-title">${p.name}</h5>
                            <div class="product-card-brand">${p.brand || ''}</div>
                            <div class="product-card-meta">
                                <span class="rating"><i class="fas fa-star"></i> ${p.rating}</span>
                            </div>
                            <div class="product-card-price">${formatRupiah(p.price)}</div>
                            <a href="/product/${p.id}" class="btn btn-primary-custom btn-sm">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            `;
        });
    }
</script>
@endpush