@extends('layouts.app')

@section('title', 'Invoice - TrekNesia')

@section('content')

<div class="container py-5" style="max-width: 1080px;">
    @if(session('success'))
        <div class="alert-trek alert-success-trek">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert-trek alert-danger-trek">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif
    
    <div id="invoiceContainer">
        <div class="text-center py-5">
            <i class="fas fa-spinner fa-spin fa-2x" style="color:var(--brand-400);"></i>
            <p style="color:var(--slate-400); margin-top:12px;">Memuat invoice...</p>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .alert-trek {
        padding: 14px 18px;
        border-radius: 10px;
        font-size: 0.875rem;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid transparent;
    }
    .alert-success-trek { background: rgba(16, 185, 129, 0.1); color: var(--brand-400); border-color: rgba(16, 185, 129, 0.3); }
    .alert-danger-trek  { background: rgba(239, 68, 68, 0.1); color: #FCA5A5; border-color: rgba(239, 68, 68, 0.3); }
</style>
@endpush

@push('scripts')
<script>
    const orderIdFromUrl = '{{ $id }}';
    
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency', currency: 'IDR', minimumFractionDigits: 0
        }).format(angka);
    }
    
    function getStatusBadge(status) {
        const badges = {
            'PENDING': '<span class="badge-status badge-pending"><i class="fas fa-clock"></i> Menunggu Pembayaran</span>',
            'PAID': '<span class="badge-status badge-paid"><i class="fas fa-check"></i> Sudah Dibayar</span>',
            'SHIPPED': '<span class="badge-status badge-shipped"><i class="fas fa-truck"></i> Sedang Dikirim</span>',
            'CANCELLED': '<span class="badge-status badge-cancelled"><i class="fas fa-times"></i> Dibatalkan</span>'
        };
        return badges[status] || `<span class="badge-status badge-muted">${status}</span>`;
    }
    
    fetch(`/api/orders/${orderIdFromUrl}`)
        .then(res => res.json())
        .then(data => {
            if (data.status !== 'success') throw new Error('Order not found');
            const order = data.data;
            const displayOrderId = order.order_id || order.id || orderIdFromUrl;
            const container = document.getElementById('invoiceContainer');
            const paymentMethod = order.payment_method || 'COD';
            const paymentStatus = order.payment_status || 'NONE';
            const proof = order.payment_proof || null;
            
            let itemsHtml = '';
            order.items.forEach(item => {
                const sizeText = item.size ? ` (${item.size})` : '';
                const bundleTag = item.bundle_name 
                    ? `<span style="display:inline-block; font-size:0.6rem; background:var(--rose-500); color:#fff; padding:2px 6px; border-radius:4px; font-weight:700; margin-right:6px;">BUNDLE</span>` 
                    : '';
                const originalPriceHtml = item.original_price && item.original_price !== item.price
                    ? `<div style="font-size:0.72rem; color:var(--slate-500); text-decoration:line-through;">${formatRupiah(item.original_price)}</div>`
                    : '';
                
                itemsHtml += `
                    <tr style="border-bottom:1px solid var(--navy-600);">
                        <td style="padding:14px 12px; color:var(--slate-200); font-size:0.85rem;">
                            ${bundleTag}${item.product_name}${sizeText}
                        </td>
                        <td style="padding:14px 12px; text-align:center; color:var(--slate-200); font-size:0.85rem;">${item.quantity}</td>
                        <td style="padding:14px 12px; text-align:right; color:var(--slate-200); font-size:0.85rem;">
                            <div>${formatRupiah(item.price)}</div>
                            ${originalPriceHtml}
                        </td>
                        <td style="padding:14px 12px; text-align:right; font-weight:700; color:var(--brand-400); font-size:0.85rem;">${formatRupiah(item.subtotal)}</td>
                    </tr>
                `;
            });
            
            container.innerHTML = `
                <div class="card-trek p-4 mb-3">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
                        <div>
                            <h3 style="font-family:'Plus Jakarta Sans'; font-size:1.35rem; font-weight:800; color:#fff; margin-bottom:4px;">
                                <i class="fas fa-mountain" style="color:var(--brand-400);"></i> TrekNesia
                            </h3>
                            <p style="color:var(--slate-400); font-size:0.82rem; margin:0;">Invoice Pesanan</p>
                        </div>
                        <div>${getStatusBadge(order.status)}</div>
                    </div>
                    
                    <hr style="border-color:var(--navy-600); margin:20px 0;">
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <h6 style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--slate-400); margin-bottom:12px;">Informasi Pesanan</h6>
                            <p style="margin-bottom:6px; font-size:0.85rem; color:var(--slate-200);"><strong style="color:var(--slate-100);">Order ID:</strong> ${displayOrderId}</p>
                            <p style="margin-bottom:6px; font-size:0.85rem; color:var(--slate-200);"><strong style="color:var(--slate-100);">Tanggal:</strong> ${order.created_at}</p>
                            <p style="margin-bottom:0; font-size:0.85rem; color:var(--slate-200);"><strong style="color:var(--slate-100);">Metode:</strong> <span class="badge-status badge-muted">${paymentMethod}</span></p>
                        </div>
                        <div class="col-md-6">
                            <h6 style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--slate-400); margin-bottom:12px;">Dikirim ke:</h6>
                            <p style="margin-bottom:4px; font-size:0.85rem; color:var(--slate-100); font-weight:700;">${order.customer_name}</p>
                            <p style="margin-bottom:4px; font-size:0.85rem; color:var(--slate-200);">${order.customer_whatsapp}</p>
                            <p style="margin-bottom:4px; font-size:0.85rem; color:var(--slate-200);">${order.customer_address}</p>
                            <p style="margin-bottom:0; font-size:0.85rem; color:var(--slate-200);">${order.customer_city}</p>
                        </div>
                    </div>
                    
                    <div style="overflow-x:auto;">
                        <table style="width:100%; border-collapse:collapse;">
                            <thead>
                                <tr style="background:var(--navy-800); border-bottom:1px solid var(--navy-600);">
                                    <th style="padding:12px; text-align:left; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--slate-400);">Produk</th>
                                    <th style="padding:12px; text-align:center; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--slate-400);">Qty</th>
                                    <th style="padding:12px; text-align:right; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--slate-400);">Harga</th>
                                    <th style="padding:12px; text-align:right; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--slate-400);">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>${itemsHtml}</tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="padding:12px; text-align:right; color:var(--slate-400); font-size:0.85rem;">Subtotal</td>
                                    <td style="padding:12px; text-align:right; color:var(--slate-200); font-size:0.85rem;">${formatRupiah(order.total_price)}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding:12px; text-align:right; color:var(--slate-400); font-size:0.85rem;">Ongkir</td>
                                    <td style="padding:12px; text-align:right; color:var(--slate-200); font-size:0.85rem;">${formatRupiah(order.shipping_cost)}</td>
                                </tr>
                                <tr style="border-top:2px solid var(--navy-500);">
                                    <td colspan="3" style="padding:16px 12px; text-align:right; font-weight:800; color:var(--slate-100);">Total</td>
                                    <td style="padding:16px 12px; text-align:right; font-family:'Plus Jakarta Sans'; font-weight:800; color:var(--brand-400); font-size:1.1rem;">${formatRupiah(order.total_amount)}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                ${renderPaymentSection(order, paymentMethod, paymentStatus, proof, displayOrderId)}
            `;
        })
        .catch(err => {
            document.getElementById('invoiceContainer').innerHTML = `
                <div class="card-trek text-center p-5">
                    <i class="fas fa-exclamation-triangle fa-3x" style="color:var(--rose-500); margin-bottom:16px;"></i>
                    <h4 style="color:#fff; margin-bottom:8px;">Pesanan Tidak Ditemukan</h4>
                    <p style="color:var(--slate-400);">Order ID: ${orderIdFromUrl}</p>
                    <a href="/products" class="btn btn-primary-custom mt-3">
                        <i class="fas fa-shopping-bag"></i> Kembali Belanja
                    </a>
                </div>
            `;
        });
    
    function renderPaymentSection(order, method, status, proof, displayOrderId) {
        // PAID atau SHIPPED
        if (order.status === 'PAID' || order.status === 'SHIPPED') {
            return `
                <div class="card-trek p-5 text-center">
                    <div style="width:72px; height:72px; border-radius:50%; background:rgba(16, 185, 129, 0.15); display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                        <i class="fas fa-check-circle" style="font-size:2rem; color:var(--brand-400);"></i>
                    </div>
                    <h4 style="font-family:'Plus Jakarta Sans'; font-weight:800; color:#fff; margin-bottom:8px;">Pembayaran Berhasil!</h4>
                    <p style="color:var(--slate-400); margin-bottom:20px;">Pesanan Anda sedang diproses.</p>
                    <div style="display:flex; gap:10px; justify-content:center; flex-wrap:wrap;">
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
                <div class="card-trek p-4">
                    <h5 style="font-family:'Plus Jakarta Sans'; font-size:1rem; font-weight:800; color:#fff; margin-bottom:16px;">
                        <i class="fas fa-money-bill-wave" style="color:var(--brand-400);"></i> Pembayaran COD
                    </h5>
                    <div style="padding:16px; background:rgba(16, 185, 129, 0.08); border:1px solid rgba(16, 185, 129, 0.3); border-radius:10px; margin-bottom:16px;">
                        <div style="font-weight:700; color:var(--brand-400); margin-bottom:6px;">
                            <i class="fas fa-info-circle"></i> Bayar di Tempat (COD)
                        </div>
                        <div style="font-size:0.85rem; color:var(--slate-200);">
                            Silakan siapkan uang tunai sebesar <strong style="color:var(--brand-400);">${formatRupiah(order.total_amount)}</strong> saat kurir tiba.
                        </div>
                    </div>
                    <p style="color:var(--slate-400); font-size:0.82rem; margin:0;">Pesanan akan diproses dan dikirim ke alamat Anda.</p>
                </div>
            `;
        }
        
        // QRIS — sudah upload
        if (method === 'QRIS' && proof && proof.filename) {
            if (status === 'WAITING_VERIFICATION') {
                return `
                    <div class="card-trek p-4">
                        <h5 style="font-family:'Plus Jakarta Sans'; font-size:1rem; font-weight:800; color:#fff; margin-bottom:16px;">
                            <i class="fas fa-qrcode" style="color:var(--brand-400);"></i> Pembayaran QRIS
                        </h5>
                        <div style="padding:16px; background:rgba(245, 158, 11, 0.08); border:1px solid rgba(245, 158, 11, 0.3); border-radius:10px; margin-bottom:16px;">
                            <div style="font-weight:700; color:#FCD34D; margin-bottom:6px;">
                                <i class="fas fa-clock"></i> Menunggu Verifikasi Admin
                            </div>
                            <div style="font-size:0.85rem; color:var(--slate-200);">Bukti pembayaran Anda sedang diverifikasi.</div>
                        </div>
                        <p style="font-size:0.85rem; margin-bottom:4px; color:var(--slate-200);"><strong style="color:var(--slate-100);">Pengirim:</strong> ${proof.sender_name}</p>
                        <p style="font-size:0.85rem; margin:0; color:var(--slate-200);"><strong style="color:var(--slate-100);">Waktu Upload:</strong> ${proof.uploaded_at}</p>
                    </div>
                `;
            }
            if (status === 'REJECTED') {
                return `
                    <div class="card-trek p-4">
                        <h5 style="font-family:'Plus Jakarta Sans'; font-size:1rem; font-weight:800; color:#fff; margin-bottom:16px;">
                            <i class="fas fa-qrcode" style="color:var(--brand-400);"></i> Pembayaran QRIS
                        </h5>
                        <div style="padding:16px; background:rgba(239, 68, 68, 0.08); border:1px solid rgba(239, 68, 68, 0.3); border-radius:10px; margin-bottom:16px;">
                            <div style="font-weight:700; color:#FCA5A5; margin-bottom:6px;">
                                <i class="fas fa-times-circle"></i> Pembayaran Ditolak!
                            </div>
                            <div style="font-size:0.85rem; color:var(--slate-200);">${order.payment_note || 'Silakan upload ulang bukti pembayaran.'}</div>
                        </div>
                        ${renderUploadForm(displayOrderId)}
                    </div>
                `;
            }
        }
        
        // QRIS — belum upload
        return `
            <div class="card-trek p-4">
                <h5 style="font-family:'Plus Jakarta Sans'; font-size:1rem; font-weight:800; color:#fff; margin-bottom:20px;">
                    <i class="fas fa-qrcode" style="color:var(--brand-400);"></i> Pembayaran QRIS
                </h5>
                
                <div class="row g-4">
                    <div class="col-md-5 text-center">
                        <div style="padding:20px; background:var(--navy-800); border:1px solid var(--navy-600); border-radius:12px;">
                            <p style="font-size:0.78rem; color:var(--slate-400); margin-bottom:12px;">Scan QR Code berikut:</p>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=TrekNesia-${displayOrderId}-${order.total_amount}" 
                                 alt="QR Code" style="max-width:200px; border-radius:8px; background:#fff; padding:8px;">
                            <p style="font-weight:800; margin-top:12px; margin-bottom:2px; color:var(--brand-400); font-size:1.1rem;">${formatRupiah(order.total_amount)}</p>
                            <small style="color:var(--slate-400); font-size:0.75rem;">a.n. TrekNesia</small>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h6 style="font-weight:700; color:var(--slate-100); font-size:0.88rem; margin-bottom:10px;">Cara Bayar:</h6>
                        <ol style="font-size:0.82rem; color:var(--slate-200); padding-left:20px; line-height:1.8; margin:0 0 16px;">
                            <li>Buka aplikasi e-wallet / mobile banking</li>
                            <li>Pilih menu <strong>Scan QRIS</strong></li>
                            <li>Scan QR code di samping</li>
                            <li>Bayar sesuai nominal</li>
                            <li>Screenshot bukti pembayaran</li>
                            <li>Upload bukti di form bawah</li>
                        </ol>
                        <div style="padding:12px; background:rgba(59, 130, 246, 0.08); border:1px solid rgba(59, 130, 246, 0.3); border-radius:8px; font-size:0.78rem; color:#93C5FD;">
                            <i class="fas fa-info-circle"></i> Verifikasi manual maksimal 1x24 jam.
                        </div>
                    </div>
                </div>
                
                <hr style="border-color:var(--navy-600); margin:24px 0;">
                ${renderUploadForm(displayOrderId)}
            </div>
        `;
    }
    
    function renderUploadForm(orderId) {
        return `
            <h6 style="font-weight:700; color:var(--slate-100); font-size:0.88rem; margin-bottom:14px;">
                <i class="fas fa-upload" style="color:var(--brand-400);"></i> Upload Bukti Pembayaran
            </h6>
            <form action="/payment/upload/${orderId}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:0.78rem;">Nama Pengirim</label>
                        <input type="text" name="sender_name" class="form-control" placeholder="Nama sesuai rekening" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:0.78rem;">File Bukti (JPG/PNG)</label>
                        <input type="file" name="proof" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-upload"></i> Upload Bukti Bayar
                        </button>
                    </div>
                </div>
            </form>
        `;
    }
</script>
@endpush