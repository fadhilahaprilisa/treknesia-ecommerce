@extends('layouts.app')

@section('title', 'Invoice - TrekNesia')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div id="invoiceContainer">
                <!-- Akan diisi JS -->
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const orderId = '{{ $id }}';
    
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
        fetch(`/api/orders/${orderId}`)
            .then(res => res.json())
            .then(data => {
                if (data.status !== 'success') {
                    throw new Error('Order not found');
                }
                
                const order = data.data;
                const container = document.getElementById('invoiceContainer');
                
                let itemsHtml = '';
                order.items.forEach(item => {
                    itemsHtml += `
                        <tr>
                            <td>${item.product_name}</td>
                            <td class="text-center">${item.quantity}</td>
                            <td class="text-end">${formatRupiah(item.price)}</td>
                            <td class="text-end">${formatRupiah(item.subtotal)}</td>
                        </tr>
                    `;
                });
                
                container.innerHTML = `
                    <div class="card shadow">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    <h3 class="fw-bold"><i class="fas fa-mountain"></i> TrekNesia</h3>
                                    <p class="text-muted mb-0">Invoice Pesanan</p>
                                </div>
                                <div class="text-end">
                                    ${getStatusBadge(order.status)}
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="fw-bold">Informasi Pesanan</h6>
                                    <p class="mb-1"><strong>Order ID:</strong> ${order.order_id}</p>
                                    <p class="mb-1"><strong>Tanggal:</strong> ${order.created_at}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold">Dikirim ke:</h6>
                                    <p class="mb-1"><strong>${order.customer_name}</strong></p>
                                    <p class="mb-1">${order.customer_whatsapp}</p>
                                    <p class="mb-1">${order.customer_address}</p>
                                    <p class="mb-1">${order.customer_city}</p>
                                </div>
                            </div>
                            
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${itemsHtml}
                                </tbody>
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
                                        <td class="text-end text-success fs-5">${formatRupiah(order.total_amount)}</td>
                                    </tr>
                                </tfoot>
                            </table>
                            
                            ${order.status === 'PENDING' ? `
                                <div class="alert alert-warning">
                                    <i class="fas fa-info-circle"></i> 
                                    <strong>Menunggu Pembayaran.</strong> 
                                    Silakan selesaikan pembayaran untuk memproses pesanan Anda.
                                    <br><small class="text-muted">(Payment gateway akan diintegrasikan di Fase 5)</small>
                                </div>
                                <button class="btn btn-primary-custom w-100" disabled>
                                    <i class="fas fa-credit-card"></i> Bayar Sekarang (Segera Hadir)
                                </button>
                            ` : ''}
                            
                            ${order.status === 'PAID' ? `
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i> 
                                    <strong>Pembayaran Berhasil!</strong> 
                                    Pesanan Anda sedang diproses.
                                </div>
                            ` : ''}
                            
                            <div class="mt-3 text-center">
                                <a href="/products" class="btn btn-outline-custom">
                                    <i class="fas fa-shopping-bag"></i> Lanjut Belanja
                                </a>
                                <button onclick="window.print()" class="btn btn-outline-custom">
                                    <i class="fas fa-print"></i> Cetak Invoice
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                document.getElementById('invoiceContainer').innerHTML = `
                    <div class="card shadow">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-exclamation-triangle fa-4x text-danger mb-3"></i>
                            <h4>Pesanan Tidak Ditemukan</h4>
                            <p class="text-muted">Order ID: ${orderId}</p>
                            <a href="/products" class="btn btn-primary-custom">
                                <i class="fas fa-shopping-bag"></i> Kembali Belanja
                            </a>
                        </div>
                    </div>
                `;
            });
    }
    
    loadInvoice();
</script>
@endpush