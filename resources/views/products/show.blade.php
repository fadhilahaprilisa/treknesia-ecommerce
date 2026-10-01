@extends('layouts.app')

@section('title', 'Detail Produk - TrekNesia')

@section('content')

<div class="container py-5" style="max-width: 1280px;" id="productDetail">
    <div class="text-center py-5">
        <i class="fas fa-spinner fa-spin fa-2x" style="color:var(--brand-400);"></i>
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
            
            let initialSize = null;
            let initialPrice = p.price;
            if (hasPriceBySize && hasSizes) {
                initialSize = p.sizes[0];
                initialPrice = getPriceForSize(p, initialSize);
                currentSize = initialSize;
            }
            
            let specsHtml = '';
            if (p.specs && Object.keys(p.specs).length > 0) {
                specsHtml = '<ul class="list-unstyled" style="font-size:0.85rem; margin:0;">';
                for (const [key, value] of Object.entries(p.specs)) {
                    if (hasSizes && key.toLowerCase() === 'ukuran') continue;
                    const val = Array.isArray(value) ? value.join(', ') : value;
                    specsHtml += `<li style="padding:10px 0; border-bottom:1px solid var(--navy-600);"><strong style="color:var(--slate-100);">${key}:</strong> <span style="color:var(--slate-400);">${val}</span></li>`;
                }
                specsHtml += '</ul>';
            }
            
            let sizesHtml = '';
            if (hasSizes) {
                const sizeOptions = p.sizes.map(s => {
                    const sizePrice = hasPriceBySize ? getPriceForSize(p, s) : null;
                    const priceLabel = sizePrice && sizePrice !== p.price ? ` — ${formatRupiah(sizePrice)}` : '';
                    const selected = s === initialSize ? 'selected' : '';
                    return `<option value="${s}" ${selected}>${s}${priceLabel}</option>`;
                }).join('');
                
                sizesHtml = `
                    <div class="mb-4 p-4" style="background:var(--navy-800); border-radius:12px; border:1px solid var(--navy-600);">
                        <label style="font-size:0.8rem; font-weight:700; color:var(--slate-100); margin-bottom:10px; display:block;">
                            <i class="fas fa-ruler"></i> Pilih Varian <span style="color:var(--rose-500)">*</span>
                        </label>
                        <select class="form-select" id="sizeSelect" onchange="onSizeChange()">
                            ${hasPriceBySize ? '' : '<option value="">-- Pilih Ukuran --</option>'}
                            ${sizeOptions}
                        </select>
                        ${hasPriceBySize ? '<small style="color:var(--slate-400); font-size:0.75rem; display:block; margin-top:8px;"><i class="fas fa-info-circle"></i> Harga berbeda per varian</small>' : ''}
                    </div>
                `;
            }
            
            c.innerHTML = `
                <div class="row g-5">
                    <div class="col-lg-6">
                        <div style="background:#ffffff; border-radius:16px; border:1px solid var(--navy-600); aspect-ratio:1; overflow:hidden; position:relative;">
                            <img src="${p.image}" alt="${p.name}" style="width:100%; height:100%; object-fit:cover; display:block;" onerror="this.src='https://placehold.co/600x600/f0f9f4/1a472a?text=TrekNesia'">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:16px;">
                            <span class="badge" style="background:rgba(16, 185, 129, 0.1); color:var(--brand-400); padding:5px 12px;">${p.category}</span>
                            <span class="badge" style="background:var(--navy-600); color:var(--slate-200); padding:5px 12px;">${p.gender}</span>
                            <span class="badge" style="background:rgba(245, 158, 11, 0.15); color:#FCD34D; padding:5px 12px;">
                                <i class="fas fa-star"></i> ${p.rating}
                            </span>
                        </div>
                        
                        <h1 style="font-family:'Plus Jakarta Sans'; font-size:1.85rem; font-weight:800; margin-bottom:8px; color:#fff; letter-spacing:-0.02em;">${p.name}</h1>
                        <p style="color:var(--slate-400); font-size:0.875rem; margin-bottom:20px;">${p.brand || 'TrekNesia'}</p>
                        
                        <div id="priceDisplay" style="font-family:'Plus Jakarta Sans'; font-size:2rem; font-weight:800; color:var(--brand-400); margin-bottom:24px; letter-spacing:-0.02em;">
                            ${formatRupiah(initialPrice)}
                        </div>
                        
                        <p style="color:var(--slate-200); font-size:0.9rem; line-height:1.7; margin-bottom:24px;">${p.description}</p>
                        
                        <div style="margin-bottom:24px;">
                            <h6 style="font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:var(--slate-400); margin-bottom:12px;">Spesifikasi</h6>
                            ${specsHtml}
                        </div>
                        
                        ${sizesHtml}
                        
                        <div style="margin-bottom:24px;">
                            <label style="font-size:0.8rem; font-weight:700; color:var(--slate-100); margin-bottom:10px; display:block;">Jumlah</label>
                            <div style="display:inline-flex; align-items:center; background:var(--navy-800); border:1px solid var(--navy-600); border-radius:10px; overflow:hidden;">
                                <button type="button" onclick="updateQty(-1)" style="width:42px; height:42px; border:none; background:transparent; color:var(--slate-200);">
                                    <i class="fas fa-minus" style="font-size:0.75rem;"></i>
                                </button>
                                <input type="number" id="qtyInput" value="1" min="1" style="width:56px; height:42px; border:none; background:transparent; text-align:center; font-weight:700; font-size:0.9rem; color:#fff; outline:none;">
                                <button type="button" onclick="updateQty(1)" style="width:42px; height:42px; border:none; background:transparent; color:var(--slate-200);">
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
                    <i class="fas fa-exclamation-triangle fa-3x" style="color:var(--rose-500);"></i>
                    <h4 style="margin-top:16px; color:#fff;">Produk tidak ditemukan</h4>
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
        if (priceDisplay) priceDisplay.textContent = formatRupiah(price);
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
            if (!size) { alert('⚠️ Silakan pilih varian terlebih dahulu!'); sel.focus(); return; }
        }
        
        const finalPrice = getPriceForSize(p, size);
        let cart = JSON.parse(localStorage.getItem('treknesia_cart') || '[]');
        const idx = cart.findIndex(item => item.id === p.id && item.size === size);
        
        if (idx !== -1) {
            cart[idx].quantity += qty;
        } else {
            cart.push({
                id: p.id, name: p.name, price: finalPrice, basePrice: p.price,
                category: p.category, gender: p.gender, image: p.image,
                size: size, quantity: qty
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