@extends('layouts.app')

@section('title', 'Keranjang Belanja - TrekNesia')

@section('content')

<div class="container py-5">
    <h2 class="section-title mb-4">Keranjang Belanja</h2>
    <div id="cartContainer"></div>
</div>

@endsection

@push('scripts')
<script>
    function getCart() {
        return JSON.parse(localStorage.getItem('treknesia_cart') || '[]');
    }
    
    function saveCart(cart) {
        localStorage.setItem('treknesia_cart', JSON.stringify(cart));
        updateCount();
    }
    
    function updateCount() {
        const cart = getCart();
        const total = cart.reduce((s, i) => s + i.quantity, 0);
        const badge = document.getElementById('cartCount');
        if (badge) badge.textContent = total;
    }
    
    function formatRupiah(a) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency', currency: 'IDR', minimumFractionDigits: 0
        }).format(a);
    }
    
    function renderCart() {
        const cart = getCart();
        const c = document.getElementById('cartContainer');
        
        if (cart.length === 0) {
            c.innerHTML = `
                <div class="card-trek text-center p-5">
                    <i class="fas fa-shopping-cart fa-3x" style="color:var(--trek-text-muted); margin-bottom:16px;"></i>
                    <h5 style="font-family:Manrope; font-weight:700; margin-bottom:8px;">Keranjang Anda Kosong</h5>
                    <p style="color:var(--trek-text-muted); margin-bottom:24px;">Yuk, mulai belanja alat outdoor!</p>
                    <a href="/products" class="btn btn-primary-custom">
                        <i class="fas fa-shopping-bag"></i> Mulai Belanja
                    </a>
                </div>
            `;
            return;
        }
        
        let itemsHtml = '';
        cart.forEach((item, idx) => {
            const sizeText = item.size ? ` <small style="color:var(--trek-text-muted);">(Ukuran: ${item.size})</small>` : '';
            const bundleTag = item.bundleName 
                ? `<span style="display:inline-block; font-size:0.65rem; background:#dc2626; color:#fff; padding:2px 8px; border-radius:4px; margin-bottom:4px; font-weight:700;">
                    <i class="fas fa-tag"></i> BUNDLE ${item.bundleName}
                </span><br>` 
                : '';
            
            // ✅ Kalau harga size beda dari base price
const basePriceDiff = item.basePrice && item.basePrice !== item.price;
const originalPriceHtml = item.originalPrice && item.originalPrice !== item.price
    ? `<span style="font-size:0.72rem; color:var(--trek-text-muted); text-decoration:line-through; margin-left:6px;">${formatRupiah(item.originalPrice)}</span>`
    : (basePriceDiff
        ? `<span style="font-size:0.72rem; color:var(--trek-text-muted); margin-left:6px;">(dari ${formatRupiah(item.basePrice)})</span>`
        : '');
            
            itemsHtml += `
                <div style="display:flex; align-items:center; gap:16px; padding:16px 0; border-bottom:1px solid var(--trek-border-soft);">
                    <div style="width:80px; height:80px; border-radius:var(--radius-md); background:var(--trek-bg-soft); overflow:hidden; flex-shrink:0;">
                        <img src="${item.image}" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='https://placehold.co/80x80/f0f9f4/1a472a?text=T'">
                    </div>
                    <div style="flex-grow:1; min-width:0;">
                        ${bundleTag}
                        <h6 style="font-family:Manrope; font-size:0.9rem; font-weight:700; margin-bottom:4px;">${item.name}${sizeText}</h6>
                        <div style="font-size:0.78rem; color:var(--trek-text-muted); margin-bottom:6px;">${item.category}</div>
                        <div style="font-family:Manrope; font-size:0.9rem; font-weight:700; color:var(--trek-primary);">
                            ${formatRupiah(item.price)}${originalPriceHtml}
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; border:1px solid var(--trek-border); border-radius:var(--radius-md); overflow:hidden; flex-shrink:0;">
                        <button type="button" onclick="updateQty(${idx}, -1)" style="width:32px; height:32px; border:none; background:#fff;"><i class="fas fa-minus" style="font-size:0.7rem;"></i></button>
                        <input type="number" value="${item.quantity}" min="1" onchange="setQty(${idx}, this.value)" style="width:42px; height:32px; border:none; text-align:center; font-weight:600; font-size:0.85rem; outline:none;">
                        <button type="button" onclick="updateQty(${idx}, 1)" style="width:32px; height:32px; border:none; background:#fff;"><i class="fas fa-plus" style="font-size:0.7rem;"></i></button>
                    </div>
                    <div style="text-align:right; min-width:110px; flex-shrink:0;">
                        <div style="font-family:Manrope; font-size:0.9rem; font-weight:700; color:var(--trek-dark);">${formatRupiah(item.price * item.quantity)}</div>
                        <button onclick="removeItem(${idx})" style="background:none; border:none; color:var(--trek-danger); font-size:0.75rem; padding:4px 0; margin-top:4px;">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            `;
        });
        
        const subtotal = cart.reduce((s, i) => s + (i.price * i.quantity), 0);
        const totalItems = cart.reduce((s, i) => s + i.quantity, 0);
        
        c.innerHTML = `
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card-trek p-4">${itemsHtml}</div>
                </div>
                <div class="col-lg-4">
                    <div class="card-trek p-4 sticky-top" style="top:90px;">
                        <h5 style="font-family:Manrope; font-size:1rem; font-weight:700; margin-bottom:20px;">Ringkasan Pesanan</h5>
                        <div style="display:flex; justify-content:space-between; font-size:0.85rem; margin-bottom:10px;">
                            <span style="color:var(--trek-text-muted);">Total Item</span>
                            <span style="font-weight:600;">${totalItems}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:0.85rem; margin-bottom:16px;">
                            <span style="color:var(--trek-text-muted);">Subtotal</span>
                            <span style="font-weight:600;">${formatRupiah(subtotal)}</span>
                        </div>
                        <hr style="border-color:var(--trek-border-soft); margin:16px 0;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                            <span style="font-weight:700; color:var(--trek-dark);">Total</span>
                            <span style="font-family:Manrope; font-size:1.2rem; font-weight:800; color:var(--trek-primary);">${formatRupiah(subtotal)}</span>
                        </div>
                        <a href="/checkout" class="btn btn-primary-custom w-100 mb-2">
                            <i class="fas fa-arrow-right"></i> Lanjut ke Checkout
                        </a>
                        <a href="/products" class="btn btn-ghost w-100">
                            <i class="fas fa-arrow-left"></i> Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        `;
    }
    
    function updateQty(idx, delta) {
        let cart = getCart();
        cart[idx].quantity += delta;
        if (cart[idx].quantity < 1) cart[idx].quantity = 1;
        saveCart(cart);
        renderCart();
    }
    
    function setQty(idx, val) {
        let cart = getCart();
        let q = parseInt(val);
        if (q < 1) q = 1;
        cart[idx].quantity = q;
        saveCart(cart);
        renderCart();
    }
    
    function removeItem(idx) {
        if (!confirm('Hapus produk ini dari keranjang?')) return;
        let cart = getCart();
        cart.splice(idx, 1);
        saveCart(cart);
        renderCart();
    }
    
    renderCart();
    updateCount();
</script>
@endpush