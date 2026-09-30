@extends('layouts.app')

@section('title', 'Invoice - TrekNesia')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            {{-- Flash Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div id="invoiceContainer">
                <div class="text-center py-5">
                    <i class="fas fa-spinner fa-spin fa-3x"></i>
                    <p class="mt-2">Memuat invoice...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ✅ FIX: Order ID dari URL (bukan dari data order)
    const orderIdFromUrl = '{{ $id }}';
    
    console.log('Order ID from URL:', orderIdFromUrl);
    
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }
    
    function getStatusBadge(status) {
        const badges = {
            'PENDING': '<span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Menunggu Pembayaran</span>',
            'PAID': '<span class="badge bg-success"><i class="fas fa-check"></i> Sudah Dibayar</span>',
            'SHIPPED': '<span class="badge bg-info"><i class="fas fa-truck"></i> Sedang Dikirim</span>',
            'CANCELLED': '<span class="badge bg-danger"><i class="fas fa-times"></i> Dibatalkan</span>'
        };
        return badges[status] || `<span class="badge bg-secondary">${status}</span>`;
    }
    
    function loadInvoice() {
        fetch(`/api/orders/${orderIdFromUrl}`)
            .then(res => res.json())
            .then(data => {
                console.log('API Response:', data);
                
                if (data.status !== 'success') {
                    throw new Error(data.message || 'Order not found');
                }
                
                const order = data.data;
                
                // ✅ FIX: Ambil order ID dari berbagai kemungkinan field
                const displayOrderId = order.order_id || order.id || orderIdFromUrl;
                
                console.log('Display Order ID:', displayOrderId);
                
                const container = document.getElementById('invoiceContainer');
                const paymentMethod = order.payment_method || 'COD';
                const paymentStatus = order.payment_status || 'NONE';
                const proof = order.payment_proof || null;
                
                let itemsHtml = '';
order.items.forEach(item => {
    const sizeText = item.size ? ` (${item.size})` : '';
    
    // ✅ Tag bundle
    const bundleTag = item.bundle_name 
        ? `<span style="display:inline-block; font-size:0.6rem; background:#dc2626; color:#fff; padding:2px 6px; border-radius:4px; font-weight:700; margin-right:4px;">
            BUNDLE
        </span>` 
        : '';
    
    // ✅ Harga asli dicoret (kalau berbeda)
    const originalPriceHtml = item.original_price && item.original_price !== item.price
        ? `<div style="font-size:0.72rem; color:var(--trek-text-muted); text-decoration:line-through;">
            ${formatRupiah(item.original_price)}
        </div>`
        : '';
    
    itemsHtml += `
        <tr>
            <td>${bundleTag}${item.product_name}${sizeText}</td>
            <td class="text-center">${item.quantity}</td>
            <td class="text-end">
                <div>${formatRupiah(item.price)}</div>
                ${originalPriceHtml}
            </td>
            <td class="text-end">${formatRupiah(item.subtotal)}</td>
        </tr>
    `;
});
                
                container.innerHTML = `
                    <div class="card shadow-sm mb-3">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h4 class="fw-bold mb-1"><i class="fas fa-mountain text-success"></i> TrekNesia</h4>
                                    <p class="text-muted mb-0 small">Invoice Pesanan</p>
                                </div>
                                <div>${getStatusBadge(order.status)}</div>
                            </div>
                            
                            <hr>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6 class="fw-bold small text-uppercase text-muted">Informasi Pesanan</h6>
                                    <p class="mb-1 small"><strong>Order ID:</strong> ${displayOrderId}</p>
                                    <p class="mb-1 small"><strong>Tanggal:</strong> ${order.created_at}</p>
                                    <p class="mb-1 small"><strong>Metode:</strong> <span class="badge bg-secondary">${paymentMethod}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold small text-uppercase text-muted">Dikirim ke:</h6>
                                    <p class="mb-1 small"><strong>${order.customer_name}</strong></p>
                                    <p class="mb-1 small">${order.customer_whatsapp}</p>
                                    <p class="mb-1 small">${order.customer_address}</p>
                                    <p class="mb-1 small">${order.customer_city}</p>
                                </div>
                            </div>
                            
                            <table class="table table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>${itemsHtml}</tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end">Subtotal</td>
                                        <td class="text-end">${formatRupiah(order.total_price)}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end">Ongkir</td>
                                        <td class="text-end">${formatRupiah(order.shipping_cost)}</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td colspan="3" class="text-end">Total</td>
                                        <td class="text-end text-success">${formatRupiah(order.total_amount)}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    ${renderPaymentSection(order, paymentMethod, paymentStatus, proof, displayOrderId)}
                `;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('invoiceContainer').innerHTML = `
                    <div class="card shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-exclamation-triangle fa-4x text-danger mb-3"></i>
                            <h4>Pesanan Tidak Ditemukan</h4>
                            <p class="text-muted">Order ID: ${orderIdFromUrl}</p>
                            <a href="/products" class="btn btn-primary-custom">
                                <i class="fas fa-shopping-bag"></i> Kembali Belanja
                            </a>
                        </div>
                    </div>
                `;
            });
    }
    
    function renderPaymentSection(order, method, status, proof, displayOrderId) {
        // Kalau sudah PAID atau SHIPPED
        if (order.status === 'PAID' || order.status === 'SHIPPED') {
            return `
                <div class="card shadow-sm">
                    <div class="card-body p-4 text-center">
                        <i class="fas fa-check-circle fa-3x text-success mb-2"></i>
                        <h5 class="fw-bold">Pembayaran Berhasil!</h5>
                        <p class="text-muted">Pesanan Anda sedang diproses.</p>
                        <a href="/receipt/${displayOrderId}" class="btn btn-primary-custom">
                            <i class="fas fa-receipt"></i> Lihat Struk
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-custom">
                            <i class="fas fa-print"></i> Cetak
                        </button>
                    </div>
                </div>
            `;
        }
        
        // COD
        if (method === 'COD') {
            return `
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold"><i class="fas fa-money-bill-wave text-success"></i> Pembayaran COD</h5>
                        <hr>
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle"></i>
                            <strong>Bayar di Tempat (COD)</strong><br>
                            Silakan siapkan uang tunai sebesar <strong>${formatRupiah(order.total_amount)}</strong> saat kurir tiba.
                        </div>
                        <p class="text-muted small mb-0">Pesanan akan diproses dan dikirim ke alamat Anda.</p>
                    </div>
                </div>
            `;
        }
        
        // QRIS — sudah upload, tunggu verifikasi
        if (method === 'QRIS' && proof && proof.filename) {
            if (status === 'WAITING_VERIFICATION') {
                return `
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold"><i class="fas fa-qrcode text-success"></i> Pembayaran QRIS</h5>
                            <hr>
                            <div class="alert alert-warning">
                                <i class="fas fa-clock"></i>
                                <strong>Menunggu Verifikasi Admin</strong><br>
                                Bukti pembayaran Anda sedang diverifikasi.
                            </div>
                            <p class="small mb-1"><strong>Pengirim:</strong> ${proof.sender_name}</p>
                            <p class="small mb-0"><strong>Waktu Upload:</strong> ${proof.uploaded_at}</p>
                        </div>
                    </div>
                `;
            }
            if (status === 'REJECTED') {
                return `
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold"><i class="fas fa-qrcode text-success"></i> Pembayaran QRIS</h5>
                            <hr>
                            <div class="alert alert-danger">
                                <i class="fas fa-times-circle"></i>
                                <strong>Pembayaran Ditolak!</strong><br>
                                ${order.payment_note || 'Silakan upload ulang.'}
                            </div>
                            ${renderUploadForm(displayOrderId)}
                        </div>
                    </div>
                `;
            }
        }
        
        // QRIS — belum upload
        return `
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold"><i class="fas fa-qrcode text-success"></i> Pembayaran QRIS</h5>
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-5 text-center mb-3">
                            <div class="border rounded p-3 bg-light">
                                <p class="small text-muted mb-2">Scan QR Code berikut:</p>
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=TrekNesia-${displayOrderId}-${order.total_amount}" 
                                     alt="QR Code" class="img-fluid" style="max-width: 200px;">
                                <p class="fw-bold mt-2 mb-0">${formatRupiah(order.total_amount)}</p>
                                <small class="text-muted">a.n. TrekNesia</small>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h6 class="fw-bold">Cara Bayar:</h6>
                            <ol class="small">
                                <li>Buka aplikasi e-wallet / mobile banking</li>
                                <li>Pilih menu <strong>Scan QRIS</strong></li>
                                <li>Scan QR code di samping</li>
                                <li>Bayar sesuai nominal</li>
                                <li>Screenshot bukti pembayaran</li>
                                <li>Upload bukti di form bawah</li>
                            </ol>
                            <div class="alert alert-info small mb-0">
                                <i class="fas fa-info-circle"></i>
                                Verifikasi manual maksimal 1x24 jam.
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    ${renderUploadForm(displayOrderId)}
                </div>
            </div>
        `;
    }
    
    function renderUploadForm(orderId) {
        console.log('Render upload form with orderId:', orderId);
        
        return `
            <h6 class="fw-bold"><i class="fas fa-upload"></i> Upload Bukti Pembayaran</h6>
            <form action="/payment/upload/${orderId}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Nama Pengirim</label>
                        <input type="text" name="sender_name" class="form-control form-control-sm" 
                               placeholder="Nama sesuai rekening" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">File Bukti (JPG/PNG)</label>
                        <input type="file" name="proof" class="form-control form-control-sm" 
                               accept="image/*" required>
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-upload"></i> Upload Bukti Bayar
                        </button>
                    </div>
                </div>
            </form>
        `;
    }
    
    loadInvoice();
</script>
@endpush