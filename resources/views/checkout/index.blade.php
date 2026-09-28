@extends('layouts.app')

@section('title', 'Checkout - TrekNesia')

@section('content')

<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="fas fa-credit-card"></i> Checkout</h2>
    
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-truck"></i> Informasi Pengiriman</h5>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Lengkap *</label>
                        <input type="text" class="form-control" id="customerName" 
                               value="{{ session('user_name') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nomor WhatsApp *</label>
                        <input type="tel" class="form-control" id="customerWhatsapp" 
                               value="{{ session('user_whatsapp') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Alamat Lengkap *</label>
                        <textarea class="form-control" id="customerAddress" rows="3" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Kota Tujuan *</label>
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
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-money-bill-wave"></i> Metode Pembayaran</h5>
                    
                    <div class="payment-option selected" data-payment="COD" onclick="selectPayment('COD')">
                        <input type="radio" name="payment" value="COD" id="payCOD" checked>
                        <label for="payCOD" class="w-100 m-0" style="cursor:pointer;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-money-bill-wave fa-2x text-success me-3"></i>
                                <div>
                                    <strong>COD (Bayar di Tempat)</strong>
                                    <br><small class="text-muted">Bayar saat barang tiba</small>
                                </div>
                                <i class="fas fa-check-circle text-success ms-auto check-icon" style="display:none;"></i>
                            </div>
                        </label>
                    </div>
                    
                    <div class="payment-option mt-2" data-payment="QRIS" onclick="selectPayment('QRIS')">
                        <input type="radio" name="payment" value="QRIS" id="payQRIS">
                        <label for="payQRIS" class="w-100 m-0" style="cursor:pointer;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-qrcode fa-2x text-success me-3"></i>
                                <div>
                                    <strong>QRIS (Scan QR Code)</strong>
                                    <br><small class="text-muted">Bayar via scan QR - upload bukti</small>
                                </div>
                                <i class="fas fa-check-circle text-success ms-auto check-icon" style="display:none;"></i>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-receipt"></i> Ringkasan Pesanan</h5>
                    
                    <div id="checkoutItems"></div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2 small">
                        <span>Subtotal</span>
                        <span id="checkoutSubtotal">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span>Ongkir</span>
                        <span id="checkoutShipping">Rp 0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
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

@push('styles')
<style>
    .payment-option {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 15px;
        transition: all 0.2s;
        cursor: pointer;
        background: white;
    }
    .payment-option:hover { 
        border-color: #1a472a; 
        background: #f7fafc;
    }
    .payment-option input { 
        display: none; 
    }
    .payment-option.selected {
        border-color: #1a472a;
        background: #f0fdf4;
        box-shadow: 0 0 0 3px rgba(26, 71, 42, 0.1);
    }
    .payment-option.selected .check-icon {
        display: block !important;
    }
</style>
@endpush

@push('scripts')
<script>
    function getCart() {
        return JSON.parse(localStorage.getItem('treknesia_cart') || '[]');
    }
    
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency', currency: 'IDR', minimumFractionDigits: 0
        }).format(angka);
    }
    
    // ✅ FIX: Fungsi selectPayment dengan update visual
    function selectPayment(value) {
        // Update radio checked
        document.querySelectorAll('input[name="payment"]').forEach(el => {
            el.checked = false;
        });
        document.querySelector(`input[name="payment"][value="${value}"]`).checked = true;
        
        // Update visual semua payment-option
        document.querySelectorAll('.payment-option').forEach(el => {
            el.classList.remove('selected');
        });
        
        // Tambah class selected ke yang dipilih
        const selected = document.querySelector(`.payment-option[data-payment="${value}"]`);
        if (selected) {
            selected.classList.add('selected');
        }
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
            const variantText = item.size ? ` (${item.size})` : '';
            container.innerHTML += `
                <div class="d-flex justify-content-between mb-2 small">
                    <span>${item.name}${variantText} <small class="text-muted">x${item.quantity}</small></span>
                    <span>${formatRupiah(item.price * item.quantity)}</span>
                </div>
            `;
        });
        
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        document.getElementById('checkoutSubtotal').textContent = formatRupiah(subtotal);
        updateShipping();
    }
    
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
    
    function submitOrder() {
        const cart = getCart();
        const name = document.getElementById('customerName').value.trim();
        const whatsapp = document.getElementById('customerWhatsapp').value.trim();
        const address = document.getElementById('customerAddress').value.trim();
        const city = document.getElementById('customerCity').value;
        const payment = document.querySelector('input[name="payment"]:checked').value;
        
        if (!name || !whatsapp || !address || !city) {
            alert('⚠️ Mohon lengkapi semua data pengiriman!');
            return;
        }
        
        if (cart.length === 0) {
            alert('Keranjang kosong!');
            return;
        }
        
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        
        const orderData = {
            customer_name: name,
            customer_whatsapp: whatsapp,
            customer_address: address,
            customer_city: city,
            payment_method: payment,
            items: cart.map(item => ({
                product_id: item.id,
                quantity: item.quantity,
                size: item.size || null
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
                localStorage.setItem('last_order_id', data.data.order_id);
                localStorage.removeItem('treknesia_cart');
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
    
    renderCheckout();
</script>
@endpush