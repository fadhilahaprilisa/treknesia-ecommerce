@extends('layouts.app')

@section('title', 'Sale - TrekNesia')

@section('content')

<div class="container py-5">
    <div class="text-center mb-5">
        <div style="display:inline-flex; align-items:center; gap:8px; background:#fee2e2; color:#991b1b; padding:6px 16px; border-radius:99px; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:16px;">
            <i class="fas fa-tags"></i> Diskon Spesial
        </div>
        <h2 class="section-title">Sale</h2>
        <p class="section-subtitle">Diskon spesial untuk perlengkapan outdoor pilihan</p>
    </div>
    
    <div class="row g-4" id="saleContainer">
        <div class="col-12 text-center py-5">
            <i class="fas fa-spinner fa-spin fa-2x" style="color:var(--trek-primary);"></i>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency', currency: 'IDR', minimumFractionDigits: 0
        }).format(angka);
    }
    
    fetch('/api/products')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('saleContainer');
            
            // Ambil produk harga < 500.000
            const saleProducts = data.data.filter(p => p.price < 500000).slice(0, 8);
            
            if (saleProducts.length === 0) {
                container.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-tags fa-3x" style="color:var(--trek-text-muted); margin-bottom:16px;"></i>
                        <p style="color:var(--trek-text-muted);">Belum ada produk sale</p>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = '';
            saleProducts.forEach(product => {
                const priceFormatted = formatRupiah(product.price);
                const oldPrice = Math.round(product.price * 1.3);
                const oldPriceFormatted = formatRupiah(oldPrice);
                
                // ✅ PAKAI FOTO PRODUK ASLI
                const imageUrl = product.image || `https://placehold.co/400x400/f0f9f4/1a472a?text=${encodeURIComponent(product.name)}`;
                
                container.innerHTML += `
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="product-card position-relative">
                            <span class="badge-status badge-danger" style="position:absolute; top:12px; right:12px; z-index:2; font-size:0.68rem; padding:4px 10px;">
                                -30%
                            </span>
                            <div class="product-card-image">
                                <img src="${imageUrl}" alt="${product.name}" loading="lazy" onerror="this.src='https://placehold.co/400x400/f0f9f4/1a472a?text=TrekNesia'">
                            </div>
                            <div class="product-card-body">
                                <span class="product-card-tag">${product.category}</span>
                                <h5 class="product-card-title">${product.name}</h5>
                                <div class="product-card-brand">${product.brand || ''}</div>
                                <div class="product-card-meta">
                                    <span class="rating"><i class="fas fa-star"></i> ${product.rating}</span>
                                </div>
                                <div style="margin-top:auto; margin-bottom:10px;">
                                    <div style="font-size:0.75rem; color:var(--trek-text-muted); text-decoration:line-through;">${oldPriceFormatted}</div>
                                    <div class="product-card-price" style="margin-bottom:0;">${priceFormatted}</div>
                                </div>
                                <a href="/product/${product.id}" class="btn btn-primary-custom btn-sm">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            });
        })
        .catch(err => {
            console.error('Error:', err);
            document.getElementById('saleContainer').innerHTML = `
                <div class="col-12 text-center py-5">
                    <p style="color:var(--trek-danger);">Gagal memuat produk sale</p>
                </div>
            `;
        });
</script>
@endpush