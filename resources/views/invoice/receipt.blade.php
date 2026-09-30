@extends('layouts.app')

@section('title', 'Struk Pembelian - TrekNesia')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm" id="receipt">
                <div class="card-body p-4">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h4 class="fw-bold mb-1"><i class="fas fa-mountain text-success"></i> TrekNesia</h4>
                        <p class="text-muted small mb-0">Platform Alat Outdoor</p>
                        <p class="text-muted small">treknesia.com</p>
                    </div>
                    
                    <hr style="border-style: dashed;">
                    
                    <div class="small">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Order ID</span>
                            <strong>{{ $order['id'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Tanggal</span>
                            <span>{{ $order['created_at'] }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Pelanggan</span>
                            <span>{{ $order['customer_name'] }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>WhatsApp</span>
                            <span>{{ $order['customer_whatsapp'] }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Kota</span>
                            <span>{{ $order['customer_city'] }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Pembayaran</span>
                            <span class="badge bg-secondary">{{ $order['payment_method'] ?? 'COD' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Status</span>
                            <span>
                                @if($order['status'] === 'PAID')
                                    <span class="badge bg-success">PAID</span>
                                @elseif($order['status'] === 'PENDING')
                                    <span class="badge bg-warning text-dark">PENDING</span>
                                @elseif($order['status'] === 'SHIPPED')
                                    <span class="badge bg-info">SHIPPED</span>
                                @else
                                    <span class="badge bg-secondary">{{ $order['status'] }}</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <hr style="border-style: dashed;">
                    
                    <!-- Items -->
                    <h6 class="fw-bold small text-uppercase">Item Pesanan</h6>
                    @foreach($order['items'] as $item)
<div class="mb-2 small">
    <div class="d-flex justify-content-between align-items-center">
        <span>
            @if(!empty($item['bundle_name']))
                <span style="font-size:0.6rem; background:#dc2626; color:#fff; padding:2px 6px; border-radius:4px; font-weight:700; margin-right:4px;">BUNDLE</span>
            @endif
            {{ $item['product_name'] }}
            @if(!empty($item['size']))
                <span style="color:#718096; font-size:0.8rem;">({{ $item['size'] }})</span>
            @endif
        </span>
    </div>
    <div class="d-flex justify-content-between text-muted">
        <span>
            {{ $item['quantity'] }}x Rp {{ number_format($item['price'], 0, ',', '.') }}
            @if(!empty($item['original_price']) && $item['original_price'] != $item['price'])
                <span style="text-decoration:line-through; font-size:0.75rem; margin-left:4px;">
                    Rp {{ number_format($item['original_price'], 0, ',', '.') }}
                </span>
            @endif
        </span>
        <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
    </div>
</div>
@endforeach
                    
                    <hr style="border-style: dashed;">
                    
                    <div class="small">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order['total_price'], 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Ongkir</span>
                            <span>Rp {{ number_format($order['shipping_cost'], 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold fs-5 mt-2 pt-2" style="border-top: 2px solid #333;">
                            <span>TOTAL</span>
                            <span class="text-success">Rp {{ number_format($order['total_amount'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <hr style="border-style: dashed;">
                    
                    <div class="text-center small text-muted mt-3">
                        <p class="mb-1">Terima kasih telah berbelanja di TrekNesia!</p>
                        <p class="mb-0">Simpan struk ini sebagai bukti pembelian.</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <button onclick="window.print()" class="btn btn-primary-custom">
                    <i class="fas fa-print"></i> Cetak Struk
                </button>
                <a href="/products" class="btn btn-outline-custom">
                    <i class="fas fa-shopping-bag"></i> Belanja Lagi
                </a>
                <a href="/cek-status" class="btn btn-outline-custom">
                    <i class="fas fa-search"></i> Cek Status
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    @media print {
        body * { visibility: hidden; }
        #receipt, #receipt * { visibility: visible; }
        #receipt { position: absolute; left: 0; top: 0; width: 100%; }
        .navbar, .footer, .btn { display: none !important; }
    }
</style>
@endpush