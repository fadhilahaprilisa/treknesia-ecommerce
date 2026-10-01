@extends('layouts.app')

@section('title', 'Checkout - TrekNesia')

@section('content')

<div class="container py-5" style="max-width: 1280px;">
    <h2 class="section-title mb-4">Checkout</h2>
    
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card-trek p-4 mb-3">
                <h5 style="font-family:'Plus Jakarta Sans'; font-size:1rem; font-weight:800; margin-bottom:20px; color:#fff;">
                    <i class="fas fa-truck" style="color:var(--brand-400);"></i> Informasi Pengiriman
                </h5>
                
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" class="form-control" id="customerName" value="{{ session('user_name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor WhatsApp *</label>
                    <input type="tel" class="form-control" id="customerWhatsapp" value="{{ session('user_whatsapp') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap *</label>
                    <textarea class="form-control" id="customerAddress" rows="3" required></textarea>
                </div>
                <div class="mb-0">
                    <label class="form-label">Kota Tujuan *</label>
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
                        </optgroup>
                    </select>
                </div>
            </div>
            
            <div class="card-trek p-4">
                <h5 style="font-family:'Plus Jakarta Sans'; font-size:1rem; font-weight:800; margin-bottom:20px; color:#fff;">
                    <i class="fas fa-money-bill-wave" style="color:var(--brand-400);"></i> Metode Pembayaran
                </h5>
                
                <div class="payment-option selected" data-payment="COD" onclick="selectPayment('COD')">
                    <input type="radio" name="payment" value="COD" id="payCOD" checked>
                    <label for="payCOD" class="d-flex align-items-center w-100 m-0" style="cursor:pointer;">
                        <i class="fas fa-money-bill-wave" style="font-size:1.5rem; color:var(--brand-400); margin-right:16px;"></i>
                        <div style="flex-grow:1;">
                            <div style="font-weight:700; font-size:0.92rem; color:#fff;">COD (Bayar di Tempat)</div>
                            <div style="font-size:0.78rem; color:var(--slate-400);">Bayar saat barang tiba</div>
                        </div>
                        <i class="fas fa-check-circle check-icon" style="color:var(--brand-400); display:none;"></i>
                    </label>
                </div>
                
                <div class="payment-option mt-2" data-payment="QRIS" onclick="selectPayment('QRIS')">
                    <input type="radio" name="payment" value="QRIS" id="payQRIS">
                    <label for="payQRIS" class="d-flex align-items-center w-100 m-0" style="cursor:pointer;">
                        <i class="fas fa-qrcode" style="font-size:1.5rem; color:var(--brand-400); margin-right:16px;"></i>
                        <div style="flex-grow:1;">
                            <div style="font-weight:700; font-size:0.92rem; color:#fff;">QRIS (Scan QR Code)</div>
                            <div style="font-size:0.78rem; color:var(--slate-400);">Bayar via scan QR - upload bukti</div>
                        </div>
                        <i class="fas fa-check-circle check-icon" style="color:var(--brand-400); display:none;"></i>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="col-lg-5">
            <div class="card-trek p-4" style="position:sticky; top:90px;">
                <h5 style="font-family:'Plus Jakarta Sans'; font-size:1rem; font-weight:800; margin-bottom:20px; color:#fff;">Ringkasan Pesanan</h5>
                <div id="checkoutItems"></div>
                <hr style="border-color:var(--navy-600); margin:16px 0;">
                <div style="display:flex; justify-content:space-between; font-size:0.85rem; margin-bottom:10px;">
                    <span style="color:var(--slate-400);">Subtotal</span>
                    <span id="checkoutSubtotal" style="font-weight:700; color:var(--slate-100);">Rp 0</span>
                </div>
                <div style="display:flex; justify-content:space-between; font-size:0.85rem; margin-bottom:16px;">
                    <span style="color:var(--slate-400);">Ongkir</span>
                    <span id="checkoutShipping" style="font-weight:700; color:var(--slate-100);">Rp 0</span>
                </div>
                <hr style="border-color:var(--navy-600); margin:16px 0;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                    <span style="font-weight:700; color:var(--slate-100);">Total</span>
                    <span id="checkoutTotal" style="font-family:'Plus Jakarta Sans'; font-size:1.35rem; font-weight:800; color:var(--brand-400);">Rp 0</span>
                </div>
                <button class="btn btn-primary-custom w-100" onclick="submitOrder()" id="submitBtn">
                    <i class="fas fa-check"></i> Buat Pesanan
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .payment-option {
        border: 2px solid var(--navy-600);
        border-radius: 12px;
        padding: 18px;
        transition: all 0.15s;
        cursor: pointer;
        background: var(--navy-800);
    }
    .payment-option:hover { border-color: rgba(16, 185, 129, 0.5); }
    .payment-option input { display: none; }
    .payment-option.selected {
        border-color: var(--brand-500);
        background: rgba(16, 185, 129, 0.08);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    .payment-option.selected .check-icon { display: block !important; }
</style>
@endpush

@push('scripts')
<script>
    function getCart() { return JSON.parse(localStorage.getItem('treknesia_cart') || '[]'); }
    function formatRupiah(a) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(a);
    }
    function selectPayment(v) {
        document.querySelectorAll('input[name="payment"]').forEach(el => el.checked = false);
        document.querySelector(`input[name="payment"][value="${v}"]`).checked = true;
        document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('selected'));
        document.querySelector(`.payment-option[data-payment="${v}"]`).classList.add('selected');
    }
    
    function renderCheckout() {
        const cart = getCart();
        if (cart.length === 0) { alert('Keranjang kosong!'); window.location.href = '/products'; return; }
        
        const c = document.getElementById('checkoutItems');
        c.innerHTML = '';
        cart.forEach(item => {
            const sizeText = item.size ? ` (${item.size})` : '';
            c.innerHTML += `
                <div style="display:flex; justify-content:space-between; font-size:0.85rem; margin-bottom:10px; gap:10px;">
                    <span style="color:var(--slate-200);">${item.name}${sizeText} <span style="color:var(--slate-400);">×${item.quantity}</span></span>
                    <span style="font-weight:700; color:var(--slate-100); white-space:nowrap;">${formatRupiah(item.price * item.quantity)}</span>
                </div>
            `;
        });
        
        const subtotal = cart.reduce((s, i) => s + (i.price * i.quantity), 0);
        document.getElementById('checkoutSubtotal').textContent = formatRupiah(subtotal);
        updateShipping();
    }
    
    document.getElementById('customerCity').addEventListener('change', updateShipping);
    
    function updateShipping() {
        const city = document.getElementById('customerCity').value;
        const cart = getCart();
        const subtotal = cart.reduce((s, i) => s + (i.price * i.quantity), 0);
        let shipping = 0;
        if (city) {
            if (['Jakarta','Bogor','Depok','Tangerang','Bekasi'].includes(city)) shipping = 20000;
            else if (['Bandung','Semarang','Yogyakarta','Surabaya','Malang','Solo'].includes(city)) shipping = 30000;
            else shipping = 50000;
        }
        document.getElementById('checkoutShipping').textContent = formatRupiah(shipping);
        document.getElementById('checkoutTotal').textContent = formatRupiah(subtotal + shipping);
    }
    
    function submitOrder() {
        const cart = getCart();
        const name = document.getElementById('customerName').value.trim();
        const wa = document.getElementById('customerWhatsapp').value.trim();
        const addr = document.getElementById('customerAddress').value.trim();
        const city = document.getElementById('customerCity').value;
        const payment = document.querySelector('input[name="payment"]:checked').value;
        
        if (!name || !wa || !addr || !city) { alert('⚠️ Mohon lengkapi semua data!'); return; }
        if (cart.length === 0) { alert('Keranjang kosong!'); return; }
        
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        
        const payload = {
            customer_name: name,
            customer_whatsapp: wa,
            customer_address: addr,
            customer_city: city,
            payment_method: payment,
            items: cart.map(i => ({
                product_id: i.id,
                quantity: i.quantity,
                size: i.size || null,
                price: i.price,
                original_price: i.originalPrice || null,
                bundle_name: i.bundleName || null
            }))
        };
        
        fetch('/api/orders', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                localStorage.setItem('last_order_id', data.data.order_id);
                localStorage.removeItem('treknesia_cart');
                window.location.href = `/invoice/${data.data.order_id}`;
            } else {
                alert('Gagal: ' + (data.message || 'Unknown error'));
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check"></i> Buat Pesanan';
            }
        })
        .catch(err => {
            alert('Terjadi kesalahan. Silakan coba lagi.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check"></i> Buat Pesanan';
        });
    }
    
    renderCheckout();
</script>
@endpush