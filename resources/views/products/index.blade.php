@extends('layouts.app')

@section('title', 'Produk - TrekNesia')

@section('content')

<div class="container py-5">
    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-filter"></i> Filter</h5>
                    
                    <h6 class="fw-bold mt-3">Kategori</h6>
                    <div id="categoryFilters">
                        <!-- Akan diisi JS -->
                    </div>
                    
                    <h6 class="fw-bold mt-3">Gender</h6>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="" checked id="allGender">
                            <label class="form-check-label" for="allGender">Semua</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="Pria" id="male">
                            <label class="form-check-label" for="male">Pria</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="Wanita" id="female">
                            <label class="form-check-label" for="female">Wanita</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="Unisex" id="unisex">
                            <label class="form-check-label" for="unisex">Unisex</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Product List -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold" id="productCount">Memuat produk...</h4>
                <div>
                    <select class="form-select" id="sortSelect">
                        <option value="default">Urutkan</option>
                        <option value="price_asc">Termurah</option>
                        <option value="price_desc">Termahal</option>
                        <option value="rating">Rating Tertinggi</option>
                    </select>
                </div>
            </div>
            
            <div class="row g-4" id="productList">
                <!-- Akan diisi JS -->
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let allProducts = [];
    let currentCategory = '{{ request("category") }}';
    
    // ============================================
    // LOAD CATEGORIES FOR FILTER
    // ============================================
    fetch('/api/categories')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('categoryFilters');
            data.data.forEach(cat => {
                const checked = cat.slug === currentCategory ? 'checked' : '';
                container.innerHTML += `
                    <div class="form-check">
                        <input class="form-check-input category-filter" type="radio" 
                               name="category" value="${cat.slug}" id="cat_${cat.slug}" ${checked}>
                        <label class="form-check-label" for="cat_${cat.slug}">${cat.name}</label>
                    </div>
                `;
            });
            
            // Event listeners untuk filter
            document.querySelectorAll('.category-filter').forEach(el => {
                el.addEventListener('change', filterProducts);
            });
            document.querySelectorAll('input[name="gender"]').forEach(el => {
                el.addEventListener('change', filterProducts);
            });
            document.getElementById('sortSelect').addEventListener('change', filterProducts);
            
            loadProducts();
        });

    // ============================================
    // LOAD PRODUCTS
    // ============================================
    function loadProducts() {
        let url = '/api/products';
        if (currentCategory) {
            url += `?category=${currentCategory}`;
        }
        
        fetch(url)
            .then(res => res.json())
            .then(data => {
                allProducts = data.data;
                filterProducts();
            });
    }
    
    // ============================================
    // FILTER PRODUCTS
    // ============================================
    function filterProducts() {
        let products = [...allProducts];
        
        // Filter kategori
        const selectedCategory = document.querySelector('input[name="category"]:checked');
        if (selectedCategory && selectedCategory.value) {
            const categoryName = selectedCategory.value;
            products = products.filter(p => p.category.toLowerCase() === categoryName);
        }
        
        // Filter gender
        const selectedGender = document.querySelector('input[name="gender"]:checked');
        if (selectedGender && selectedGender.value) {
            products = products.filter(p => p.gender === selectedGender.value);
        }
        
        // Sort
        const sort = document.getElementById('sortSelect').value;
        if (sort === 'price_asc') {
            products.sort((a, b) => a.price - b.price);
        } else if (sort === 'price_desc') {
            products.sort((a, b) => b.price - a.price);
        } else if (sort === 'rating') {
            products.sort((a, b) => b.rating - a.rating);
        }
        
        renderProducts(products);
    }
    
    // ============================================
    // RENDER PRODUCTS
    // ============================================
    function renderProducts(products) {
        const container = document.getElementById('productList');
        const countEl = document.getElementById('productCount');
        
        countEl.textContent = `${products.length} produk ditemukan`;
        
        if (products.length === 0) {
            container.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada produk yang ditemukan</p>
                </div>
            `;
            return;
        }
        
        container.innerHTML = '';
        products.forEach(product => {
            const priceFormatted = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(product.price);
            
            container.innerHTML += `
                <div class="col-md-4 col-6">
                    <div class="card product-card h-100">
                        <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=400&h=200&fit=crop" 
                             class="card-img-top" alt="${product.name}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-light text-dark">${product.category}</span>
                                <span class="badge-gender">${product.gender}</span>
                            </div>
                            <h5 class="card-title">${product.name}</h5>
                            <div class="rating">
                                <i class="fas fa-star"></i> ${product.rating}
                            </div>
                            <div class="price mt-2">${priceFormatted}</div>
                            <a href="/product/${product.id}" class="btn btn-primary-custom w-100 mt-3">
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