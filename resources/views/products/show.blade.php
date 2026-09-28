@extends('layouts.app')

@section('title', 'Detail Produk - TrekNesia')

@section('content')

<div class="container py-5" id="productDetail">
    <div class="text-center py-5">
        <i class="fas fa-spinner fa-spin fa-3x"></i>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const productId = {{ $id }};
    
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency', currency: 'IDR', minimumFractionDigits: 0
        }).format(angka);
    }
    
    fetch(`/api/products/${productId}`)
        .then(res => res.json())
        .then(data => {
            const product = data.data;
            const container = document.getElementById('productDetail');
            
            console.log('Product:', product);
            console.log('Sizes:', product.sizes);
            console.log('Specs:', product.specs);
            
            // ✅ Cek apakah produk punya ukuran
            const hasSizes = product.sizes && Array.isArray(product.sizes) && product.sizes.length > 0;
            
            // ✅ Render spesifikasi — SKIP field "ukuran" kalau ada dropdown ukuran
            let specsHtml = '';
            if (product.specs) {
                specsHtml = '<ul class="list-unstyled small mb-0">';
                for (const [key, value] of Object.entries(product.specs)) {
                    // Skip "ukuran" dari specs kalau ada dropdown sizes
                    if (hasSizes && key.toLowerCase() === 'ukuran') {
                        continue;
                    }
                    const val = Array.isArray(value) ? value.join(', ') : value;
                    specsHtml += `<li class="mb-1"><strong>${key}:</strong> ${val}</li>`;
                }
                specsHtml += '</ul>';
            }
            
            // ✅ Sizes dropdown
            let sizesHtml = '';
            if (hasSizes) {
                sizesHtml = `
                    <div class="mb-3 p-3 bg-light rounded border">
                        <label class="form-label fw-bold small mb-2">
                            <i class="fas fa-ruler"></i> Pilih Ukuran <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="sizeSelect">
                            <option value="">-- Pilih Ukuran --</option>
                            ${product.sizes.map(s => `<option value="${s}">${s}</option>`).join('')}
                        </select>
                        <small class="text-muted">Tersedia: ${product.sizes.join(', ')}</small>
                    </div>
                `;
            }
            
            container.innerHTML = `
                <div class="row g-4">
                    <div class="col-md-6">
                        <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=600&h=500&fit=crop" 
                             class="img-fluid rounded-3 shadow-sm w-100" 
                             style="height: 400px; object-fit: cover;"
                             alt="${product.name}">
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2 mb-2 flex-wrap">
                            <span class="badge bg-success">${product.category}</span>
                            <span class="badge bg-secondary">${product.gender}</span>
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star"></i> ${product.rating}
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1">${product.name}</h3>
                        <p class="text-muted small mb-2">${product.brand || 'TrekNesia'}</p>
                        <h4 class="text-success fw-bold mb-3">${formatRupiah(product.price)}</h4>
                        <p class="small">${product.description}</p>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold small text-uppercase text-muted">Spesifikasi:</h6>
                            ${specsHtml}
                        </div>
                        
                        ${sizesHtml}
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Jumlah</label>
                            <div class="input-group" style="width: 130px;">
                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQty(-1)">-</button>
                                <input type="number" id="qtyInput" value="1" min="1" class="form-control form-control-sm text-center">
                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQty(1)">+</button>
                            </div>
                        </div>
                        
                        <button class="btn btn-primary-custom w-100" type="button" onclick="addToCart()">
                            <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('productDetail').innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                    <h4>Produk tidak ditemukan</h4>
                    <a href="/products" class="btn btn-primary-custom">Kembali</a>
                </div>
            `;
        });
    
    function updateQty(delta) {
        const input = document.getElementById('qtyInput');
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;
        input.value = val;
    }
    
    function addToCart() {
        fetch(`/api/products/${productId}`)
            .then(res => res.json())
            .then(data => {
                const product = data.data;
                const qty = parseInt(document.getElementById('qtyInput').value);
                
                // ✅ Validasi ukuran
                const hasSizes = product.sizes && Array.isArray(product.sizes) && product.sizes.length > 0;
                let size = null;
                
                if (hasSizes) {
                    const sizeSelect = document.getElementById('sizeSelect');
                    size = sizeSelect.value;
                    if (!size) {
                        alert('⚠️ Silakan pilih ukuran terlebih dahulu!');
                        sizeSelect.focus();
                        return;
                    }
                }
                
                let cart = JSON.parse(localStorage.getItem('treknesia_cart') || '[]');
                
                const existingIndex = cart.findIndex(item => 
                    item.id === product.id && item.size === size
                );
                
                if (existingIndex !== -1) {
                    cart[existingIndex].quantity += qty;
                } else {
                    cart.push({
                        id: product.id,
                        name: product.name,
                        price: product.price,
                        category: product.category,
                        gender: product.gender,
                        image: product.image,
                        size: size,
                        quantity: qty
                    });
                }
                
                localStorage.setItem('treknesia_cart', JSON.stringify(cart));
                
                const total = cart.reduce((sum, item) => sum + item.quantity, 0);
                const badge = document.getElementById('cartCount');
                if (badge) badge.textContent = total;
                
                const sizeText = size ? ` (Ukuran: ${size})` : '';
                alert(`✅ ${product.name}${sizeText} - ${qty} pcs berhasil ditambahkan!`);
            });
    }
</script>
@endpush