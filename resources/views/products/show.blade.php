@extends('layouts.app')

@section('title', 'Detail Produk - TrekNesia')

@section('content')

<div class="container py-5" id="productDetail">
    <div class="text-center py-5">
        <i class="fas fa-spinner fa-spin fa-2x" style="color:var(--trek-primary);"></i>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const productId = {{ $id }};
    let currentProduct = null;
    let currentSize = null;
    
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency', currency: 'IDR', minimumFractionDigits: 0
        }).format(angka);
    }
    
    // ✅ Hitung harga berdasarkan size
    function getPriceForSize(product, size) {
        if (product.priceBySize && size && product.priceBySize[size]) {
            return product.priceBySize[size];
        }
        return product.price;
    }
    
    fetch(`/api/products/${productId}`)
        .then(r => r.json())
        .then(data => {
            const p = data.data;
            currentProduct = p;
            const c = document.getElementById('productDetail');
            const hasSizes = p.sizes && Array.isArray(p.sizes) && p.sizes.length > 0;
            const hasPriceBySize = p.priceBySize && Object.keys(p.priceBySize).length > 0;
            
            // Default: pakai size pertama kalau ada priceBySize
            let initialSize = null;
            let initialPrice = p.price;
            if (hasPriceBySize && hasSizes) {
                initialSize = p.sizes[0];
                initialPrice = getPriceForSize(p, initialSize);
                currentSize = initialSize;
            }
            
            // Specs
            let specsHtml = '';
            if (p.specs && Object.keys(p.specs).length > 0) {
                specsHtml = '<ul class="list-unstyled" style="font-size:0.85rem; margin:0;">';
                for (const [key, value] of Object.entries(p.specs)) {
                    if (hasSizes && key.toLowerCase() === 'ukuran') continue;
                    const val = Array.isArray(value) ? value.join(', ') : value;
                    specsHtml += `<li style="padding:6px 0; border-bottom:1px solid var(--trek-border-soft);"><strong style="color:var(--trek-dark);">${key}:</strong> <span style="color:var(--trek-text-muted);">${val}</span></li>`;
                }
                specsHtml += '</ul>';
            }
            
            // Sizes dropdown
            let sizesHtml = '';
            if (hasSizes) {
                const sizeOptions = p.sizes.map(s => {
                    const sizePrice = hasPriceBySize ? getPriceForSize(p, s) : null;
                    const priceLabel = sizePrice && sizePrice !== p.price ? ` — ${formatRupiah(sizePrice)}` : '';
                    const selected = s === initialSize ? 'selected' : '';
                    return `<option value="${s}" ${selected}>${s}${priceLabel}</option>`;
                }).join('');
                
                sizesHtml = `
                    <div class="mb-4 p-3" style="background:var(--trek-bg-soft); border-radius:var(--radius-md); border:1px solid var(--trek-border);">
                        <label style="font-size:0.8rem; font-weight:700; color:var(--trek-dark); margin-bottom:8px; display:block;">
                            <i class="fas fa-ruler"></i> Pilih Varian <span style="color:var(--trek-danger)">*</span>
                        </label>
                        <select class="form-select" id="sizeSelect" onchange="onSizeChange()">
                            ${hasPriceBySize ? '' : '<option value="">-- Pilih Ukuran --</option>'}
                            ${sizeOptions}
                        </select>
                        ${hasPriceBySize ? '<small style="color:var(--trek-text-muted); font-size:0.75rem; display:block; margin-top:6px;"><i class="fas fa-info-circle"></i> Harga berbeda per varian</small>' : ''}
                    </div>
                `;
            }
            
            c.innerHTML = `
                <div class="row g-5">
                    <div class="col-lg-6">
                        <div style="background:var(--trek-bg-soft); border-radius:var(--radius-lg); border:1px solid var(--trek-border); padding:40px; aspect-ratio:1; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                            <img src="${p.image}" alt="${p.name}" style="max-width:100%; max-height:100%; object-fit:contain;" onerror="this.src='https://placehold.co/600x600/f0f9f4/1a472a?text=TrekNesia'">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:14px;">
                            <span class="badge" style="background:var(--trek-primary-light); color:var(--trek-primary);">${p.category}</span>
                            <span class="badge" style="background:var(--trek-border-soft); color:var(--trek-text);">${p.gender}</span>
                            <span class="badge" style="background:#fef3c7; color:#92400e;">
                                <i class="fas fa-star"></i> ${p.rating}
                            </span>
                        </div>
                        
                        <h1 style="font-family:Manrope; font-size:1.75rem; font-weight:800; margin-bottom:6px; color:var(--trek-dark); letter-spacing:-0.02em;">${p.name}</h1>
                        <p style="color:var(--trek-text-muted); font-size:0.875rem; margin-bottom:16px;">${p.brand || 'TrekNesia'}</p>
                        
                        <div id="priceDisplay" style="font-family:Manrope; font-size:1.85rem; font-weight:800; color:var(--trek-primary); margin-bottom:24px; letter-spacing:-0.02em;">
                            ${formatRupiah(initialPrice)}
                        </div>
                        
                        <p style="color:var(--trek-text); font-size:0.9rem; line-height:1.7; margin-bottom:24px;">${p.description}</p>
                        
                        <div style="margin-bottom:24px;">
                            <h6 style="font-size:0.8rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--trek-text-muted); margin-bottom:10px;">Spesifikasi</h6>
                            ${specsHtml}
                        </div>
                        
                        ${sizesHtml}
                        
                        <div style="margin-bottom:20px;">
                            <label style="font-size:0.8rem; font-weight:700; color:var(--trek-dark); margin-bottom:8px; display:block;">Jumlah</label>
                            <div style="display:inline-flex; align-items:center; border:1px solid var(--trek-border); border-radius:var(--radius-md); overflow:hidden;">
                                <button type="button" onclick="updateQty(-1)" style="width:38px; height:38px; border:none; background:#fff; color:var(--trek-text);">
                                    <i class="fas fa-minus" style="font-size:0.75rem;"></i>
                                </button>
                                <input type="number" id="qtyInput" value="1" min="1" style="width:50px; height:38px; border:none; text-align:center; font-weight:600; font-size:0.9rem; outline:none;">
                                <button type="button" onclick="updateQty(1)" style="width:38px; height:38px; border:none; background:#fff; color:var(--trek-text);">
                                    <i class="fas fa-plus" style="font-size:0.75rem;"></i>
                                </button>
                            </div>
                        </div>
                        
                        <button class="btn btn-primary-custom btn-lg w-100" onclick="addToCart()">
                            <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            `;
        })
        .catch(err => {
            document.getElementById('productDetail').innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x" style="color:var(--trek-danger);"></i>
                    <h4 style="margin-top:16px;">Produk tidak ditemukan</h4>
                    <a href="/products" class="btn btn-primary-custom mt-3">Kembali</a>
                </div>
            `;
        });
    
    function onSizeChange() {
        const sizeSelect = document.getElementById('sizeSelect');
        if (!sizeSelect || !currentProduct) return;
        
        const size = sizeSelect.value;
        currentSize = size;
        
        const price = getPriceForSize(currentProduct, size);
        const priceDisplay = document.getElementById('priceDisplay');
        if (priceDisplay) {
            priceDisplay.textContent = formatRupiah(price);
        }
    }
    
    function updateQty(delta) {
        const input = document.getElementById('qtyInput');
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;
        input.value = val;
    }
    
    function addToCart() {
        if (!currentProduct) return;
        
        const p = currentProduct;
        const qty = parseInt(document.getElementById('qtyInput').value);
        const hasSizes = p.sizes && Array.isArray(p.sizes) && p.sizes.length > 0;
        
        let size = null;
        if (hasSizes) {
            const sel = document.getElementById('sizeSelect');
            size = sel.value;
            if (!size) {
                alert('⚠️ Silakan pilih varian terlebih dahulu!');
                sel.focus();
                return;
            }
        }
        
        // ✅ Harga berdasarkan size yang dipilih
        const finalPrice = getPriceForSize(p, size);
        
        let cart = JSON.parse(localStorage.getItem('treknesia_cart') || '[]');
        const idx = cart.findIndex(item => item.id === p.id && item.size === size);
        
        if (idx !== -1) {
            cart[idx].quantity += qty;
        } else {
            cart.push({
                id: p.id, 
                name: p.name, 
                price: finalPrice,         // ✅ Harga per size
                basePrice: p.price,        // Harga dasar
                category: p.category, 
                gender: p.gender,
                image: p.image, 
                size: size, 
                quantity: qty
            });
        }
        
        localStorage.setItem('treknesia_cart', JSON.stringify(cart));
        const total = cart.reduce((s, i) => s + i.quantity, 0);
        const badge = document.getElementById('cartCount');
        if (badge) badge.textContent = total;
        
        const sizeText = size ? ` (${size})` : '';
        alert(`✅ ${p.name}${sizeText} - ${qty} pcs berhasil ditambahkan!\nHarga: ${formatRupiah(finalPrice * qty)}`);
    }
</script>
@endpush