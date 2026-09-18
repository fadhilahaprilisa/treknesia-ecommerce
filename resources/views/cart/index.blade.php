@extends('layouts.app')

@section('title', 'Keranjang Belanja - TrekNesia')

@section('content')

<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h2>
    
    <div id="cartContainer">
        <!-- Akan diisi JavaScript -->
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ============================================
    // LOAD CART DARI LOCALSTORAGE
    // ============================================
    function getCart() {
        return JSON.parse(localStorage.getItem('treknesia_cart') || '[]');
    }
    
    function saveCart(cart) {
        localStorage.setItem('treknesia_cart', JSON.stringify(cart));
        updateCartCount();
    }
    
    function updateCartCount() {
        const cart = getCart();
        const total = cart.reduce((sum, item) => sum + item.quantity, 0);
        document.getElementById('cartCount').textContent = total;
    }
    
    // ============================================
    // RENDER CART
    // ============================================
    function renderCart() {
        const cart = getCart();
        const container = document.getElementById('cartContainer');
        
        if (cart.length === 0) {
            container.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                    <h4>Keranjang Anda Kosong</h4>
                    <p class="text-muted">Yuk, mulai belanja alat outdoor!</p>
                    <a href="/products" class="btn btn-primary-custom mt-3">
                        <i class="fas fa-shopping-bag"></i> Mulai Belanja
                    </a>
                </div>
            `;
            return;
        }
        
        let html = `
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
        `;
        
        cart.forEach((item, index) => {
            const priceFormatted = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(item.price);
            
            const subtotalFormatted = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(item.price * item.quantity);
            
            html += `
                <div class="d-flex align-items-center border-bottom py-3">
                    <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=100&h=100&fit=crop" 
                         class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                    <div class="ms-3 flex-grow-1">
                        <h6 class="fw-bold mb-1">${item.name}</h6>
                        <small class="text-muted">${item.category}</small>
                        <div class="text-success fw-bold">${priceFormatted}</div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-secondary" onclick="updateQty(${index}, -1)">-</button>
                        <input type="number" class="form-control form-control-sm text-center mx-2" 
                               value="${item.quantity}" min="1" style="width: 60px;"
                               onchange="setQty(${index}, this.value)">
                        <button class="btn btn-sm btn-outline-secondary" onclick="updateQty(${index}, 1)">+</button>
                    </div>
                    <div class="ms-3 text-end" style="min-width: 120px;">
                        <div class="fw-bold">${subtotalFormatted}</div>
                        <button class="btn btn-sm btn-link text-danger" onclick="removeItem(${index})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });
        
        html += `
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Ringkasan Pesanan</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Item</span>
                                <span id="totalItems">0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span id="subtotal">Rp 0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total</span>
                                <span class="text-success" id="grandTotal">Rp 0</span>
                            </div>
                            <a href="/checkout" class="btn btn-primary-custom w-100 mt-3">
                                <i class="fas fa-arrow-right"></i> Lanjut ke Checkout
                            </a>
                            <a href="/products" class="btn btn-outline-custom w-100 mt-2">
                                <i class="fas fa-arrow-left"></i> Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        container.innerHTML = html;
        updateSummary();
    }
    
    // ============================================
    // UPDATE SUMMARY
    // ============================================
    function updateSummary() {
        const cart = getCart();
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        
        document.getElementById('totalItems').textContent = totalItems;
        document.getElementById('subtotal').textContent = formatRupiah(subtotal);
        document.getElementById('grandTotal').textContent = formatRupiah(subtotal);
    }
    
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }
    
    // ============================================
    // UPDATE QUANTITY
    // ============================================
    function updateQty(index, delta) {
        let cart = getCart();
        cart[index].quantity += delta;
        if (cart[index].quantity < 1) cart[index].quantity = 1;
        saveCart(cart);
        renderCart();
    }
    
    function setQty(index, value) {
        let cart = getCart();
        let qty = parseInt(value);
        if (qty < 1) qty = 1;
        cart[index].quantity = qty;
        saveCart(cart);
        renderCart();
    }
    
    // ============================================
    // REMOVE ITEM
    // ============================================
    function removeItem(index) {
        if (!confirm('Hapus produk ini dari keranjang?')) return;
        let cart = getCart();
        cart.splice(index, 1);
        saveCart(cart);
        renderCart();
    }
    
    // ============================================
    // INIT
    // ============================================
    renderCart();
    updateCartCount();
</script>
@endpush