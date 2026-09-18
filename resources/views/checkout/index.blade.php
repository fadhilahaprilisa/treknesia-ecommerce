@extends('layouts.app')

@section('title', 'Checkout - TrekNesia')

@section('content')

<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="fas fa-credit-card"></i> Checkout</h2>
    
    <div class="row">
        <!-- Form Pengiriman -->
        <div class="col-lg-7">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-truck"></i> Informasi Pengiriman</h5>
                    
                    <form id="checkoutForm">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap *</label>
                            <input type="text" class="form-control" id="customerName" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor WhatsApp *</label>
                            <input type="tel" class="form-control" id="customerWhatsapp" 
                                   placeholder="08123456789" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Lengkap *</label>
                            <textarea class="form-control" id="customerAddress" rows="3" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kota Tujuan *</label>
                            <select class="form-select" id="customerCity" required>
                                <option value="">-- Pilih Kota --</option>
                                <optgroup label="Jabodetabek (Rp 20.000)">
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Bogor">Bogor</option>
                                    <option value="Depok">Depok</option>
                                    <option value="Tangerang">Tangerang</option>
                                    <option value="Bekasi">Bekasi</option>
                                </optgroup>
                                <optgroup label="Jawa (Rp 30.000)">
                                    <option value="Bandung">Bandung</option>
                                    <option value="Semarang">Semarang</option>
                                    <option value="Yogyakarta">Yogyakarta</option>
                                    <option value="Surabaya">Surabaya</option>
                                    <option value="Malang">Malang</option>
                                    <option value="Solo">Solo</option>
                                </optgroup>
                                <optgroup label="Luar Jawa (Rp 50.000)">
                                    <option value="Medan">Medan</option>
                                    <option value="Palembang">Palembang</option>
                                    <option value="Makassar">Makassar</option>
                                    <option value="Manado">Manado</option>
                                    <option value="Bali">Bali</option>
                                    <option value="Lombok">Lombok</option>
                                    <option value="Pontianak">Pontianak</option>
                                    <option value="Banjarmasin">Banjarmasin</option>
                                </optgroup>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Ringkasan Pesanan -->
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-receipt"></i> Ringkasan Pesanan</h5>
                    
                    <div id="checkoutItems">
                        <!-- Akan diisi JS -->
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span id="checkoutSubtotal">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkir</span>
                        <span id="checkoutShipping">Rp 0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span class="text-success" id="checkoutTotal">Rp 0</span>
                    </div>
                    
                    <button class="btn btn-primary-custom w-100 mt-3" onclick="submitOrder()" id="submitBtn">
                        <i class="fas fa-check"></i> Buat Pesanan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ============================================
    // LOAD CART & RENDER
    // ============================================
    function getCart() {
        return JSON.parse(localStorage.getItem('treknesia_cart') || '[]');
    }
    
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }
    
    function renderCheckout() {
        const cart = getCart();
        const container = document.getElementById('checkoutItems');
        
        if (cart.length === 0) {
            alert('Keranjang kosong! Silakan belanja dulu.');
            window.location.href = '/products';
            return;
        }
        
        container.innerHTML = '';
        cart.forEach(item => {
            container.innerHTML += `
                <div class="d-flex justify-content-between mb-2">
                    <span>${item.name} <small class="text-muted">x${item.quantity}</small></span>
                    <span>${formatRupiah(item.price * item.quantity)}</span>
                </div>
            `;
        });
        
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        document.getElementById('checkoutSubtotal').textContent = formatRupiah(subtotal);
        updateShipping();
    }
    
    // ============================================
    // UPDATE ONGKIR
    // ============================================
    document.getElementById('customerCity').addEventListener('change', updateShipping);
    
    function updateShipping() {
        const city = document.getElementById('customerCity').value;
        const cart = getCart();
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        
        let shipping = 0;
        if (city) {
            if (['Jakarta', 'Bogor', 'Depok', 'Tangerang', 'Bekasi'].includes(city)) {
                shipping = 20000;
            } else if (['Bandung', 'Semarang', 'Yogyakarta', 'Surabaya', 'Malang', 'Solo'].includes(city)) {
                shipping = 30000;
            } else {
                shipping = 50000;
            }
        }
        
        document.getElementById('checkoutShipping').textContent = formatRupiah(shipping);
        document.getElementById('checkoutTotal').textContent = formatRupiah(subtotal + shipping);
    }
    
    // ============================================
    // SUBMIT ORDER
    // ============================================
    function submitOrder() {
        const cart = getCart();
        const name = document.getElementById('customerName').value.trim();
        const whatsapp = document.getElementById('customerWhatsapp').value.trim();
        const address = document.getElementById('customerAddress').value.trim();
        const city = document.getElementById('customerCity').value;
        
        // Validasi
        if (!name || !whatsapp || !address || !city) {
            alert('⚠️ Mohon lengkapi semua data pengiriman!');
            return;
        }
        
        if (cart.length === 0) {
            alert('Keranjang kosong!');
            return;
        }
        
        // Disable button
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        
        // Kirim ke API
        const orderData = {
            customer_name: name,
            customer_whatsapp: whatsapp,
            customer_address: address,
            customer_city: city,
            items: cart.map(item => ({
                product_id: item.id,
                quantity: item.quantity
            }))
        };
        
        fetch('/api/orders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(orderData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                // Simpan order ID untuk halaman invoice
                localStorage.setItem('last_order_id', data.data.order_id);
                
                // Kosongkan cart
                localStorage.removeItem('treknesia_cart');
                
                // Redirect ke invoice
                window.location.href = `/invoice/${data.data.order_id}`;
            } else {
                alert('Gagal membuat pesanan: ' + (data.message || 'Unknown error'));
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check"></i> Buat Pesanan';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check"></i> Buat Pesanan';
        });
    }
    
    // Init
    renderCheckout();
</script>
@endpush