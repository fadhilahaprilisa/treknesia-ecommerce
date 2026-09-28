@extends('layouts.app')

@section('title', 'Sale - TrekNesia')

@section('content')

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title"><i class="fas fa-tags text-danger"></i> Sale</h2>
        <p class="section-subtitle">Diskon spesial untuk perlengkapan outdoor pilihan</p>
    </div>
    
    <div class="row g-3 justify-content-center" id="saleContainer">
        <div class="text-center py-5">
            <i class="fas fa-spinner fa-spin fa-2x"></i>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    fetch('/api/products')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('saleContainer');
            
            // Produk sale: harga < 500.000 (contoh diskon)
            const saleProducts = data.data.filter(p => p.price < 500000).slice(0, 8);
            
            if (saleProducts.length === 0) {
                container.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada produk sale</p>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = '';
            saleProducts.forEach(product => {
                const priceFormatted = new Intl.NumberFormat('id-ID', {
                    style: 'currency', currency: 'IDR', minimumFractionDigits: 0
                }).format(product.price);
                
                const oldPrice = product.price * 1.3;
                const oldPriceFormatted = new Intl.NumberFormat('id-ID', {
                    style: 'currency', currency: 'IDR', minimumFractionDigits: 0
                }).format(oldPrice);
                
                container.innerHTML += `
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card product-card h-100 position-relative">
                            <span class="badge bg-danger position-absolute" style="top:10px; right:10px; z-index:2;">
                                -30%
                            </span>
                            <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=400&h=300&fit=crop" 
                                 class="card-img-top" alt="${product.name}">
                            <div class="card-body">
                                <span class="badge bg-light text-dark mb-1">${product.category}</span>
                                <h5 class="card-title">${product.name}</h5>
                                <div class="rating"><i class="fas fa-star"></i> ${product.rating}</div>
                                <div class="mt-2">
                                    <small class="text-muted text-decoration-line-through">${oldPriceFormatted}</small>
                                    <div class="price">${priceFormatted}</div>
                                </div>
                                <a href="/product/${product.id}" class="btn btn-primary-custom w-100 mt-2">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            });
        });
</script>
@endpush