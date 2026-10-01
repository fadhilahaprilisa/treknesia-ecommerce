@extends('layouts.app')

@section('title', 'Struk Pembelian - TrekNesia')

@section('content')

<div class="container py-5" style="max-width: 720px;">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card-trek p-4" id="receipt" style="background:var(--navy-700);">
                <!-- Header -->
                <div class="text-center mb-4">
                    <h4 style="font-family:'Plus Jakarta Sans'; font-weight:800; color:#fff; margin-bottom:4px;">
                        <i class="fas fa-mountain" style="color:var(--brand-400);"></i> TrekNesia
                    </h4>
                    <p style="color:var(--slate-400); font-size:0.78rem; margin:0;">Platform Alat Outdoor</p>
                    <p style="color:var(--slate-400); font-size:0.78rem; margin:0;">treknesia.id</p>
                </div>
                
                <hr style="border-style:dashed; border-color:var(--navy-500);">
                
                <div style="font-size:0.82rem;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span style="color:var(--slate-400);">Order ID</span>
                        <strong style="color:var(--slate-100);">{{ $order['id'] }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span style="color:var(--slate-400);">Tanggal</span>
                        <span style="color:var(--slate-200);">{{ $order['created_at'] }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span style="color:var(--slate-400);">Pelanggan</span>
                        <span style="color:var(--slate-200);">{{ $order['customer_name'] }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span style="color:var(--slate-400);">WhatsApp</span>
                        <span style="color:var(--slate-200);">{{ $order['customer_whatsapp'] }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span style="color:var(--slate-400);">Kota</span>
                        <span style="color:var(--slate-200);">{{ $order['customer_city'] }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span style="color:var(--slate-400);">Pembayaran</span>
                        <span class="badge-status badge-muted">{{ $order['payment_method'] ?? 'COD' }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:0;">
                        <span style="color:var(--slate-400);">Status</span>
                        <span>
                            @if($order['status'] === 'PAID')
                                <span class="badge-status badge-paid">PAID</span>
                            @elseif($order['status'] === 'PENDING')
                                <span class="badge-status badge-pending">PENDING</span>
                            @elseif($order['status'] === 'SHIPPED')
                                <span class="badge-status badge-shipped">SHIPPED</span>
                            @else
                                <span class="badge-status badge-muted">{{ $order['status'] }}</span>
                            @endif
                        </span>
                    </div>
                </div>
                
                <hr style="border-style:dashed; border-color:var(--navy-500); margin:20px 0;">
                
                <h6 style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--slate-400); margin-bottom:14px;">Item Pesanan</h6>
                @foreach($order['items'] as $item)
                <div style="margin-bottom:12px; font-size:0.82rem;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:var(--slate-100); font-weight:600;">
                            @if(!empty($item['bundle_name']))
                                <span style="font-size:0.6rem; background:var(--rose-500); color:#fff; padding:2px 6px; border-radius:4px; font-weight:700; margin-right:6px;">BUNDLE</span>
                            @endif
                            {{ $item['product_name'] }}
                            @if(!empty($item['size']))
                                <span style="color:var(--slate-400); font-size:0.78rem;">({{ $item['size'] }})</span>
                            @endif
                        </span>
                    </div>
                    <div style="display:flex; justify-content:space-between; color:var(--slate-400);">
                        <span>
                            {{ $item['quantity'] }}x Rp {{ number_format($item['price'], 0, ',', '.') }}
                            @if(!empty($item['original_price']) && $item['original_price'] != $item['price'])
                                <span style="text-decoration:line-through; font-size:0.75rem; margin-left:4px;">Rp {{ number_format($item['original_price'], 0, ',', '.') }}</span>
                            @endif
                        </span>
                        <span style="color:var(--slate-200);">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach
                
                <hr style="border-style:dashed; border-color:var(--navy-500); margin:20px 0;">
                
                <div style="font-size:0.82rem;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span style="color:var(--slate-400);">Subtotal</span>
                        <span style="color:var(--slate-200);">Rp {{ number_format($order['total_price'], 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span style="color:var(--slate-400);">Ongkir</span>
                        <span style="color:var(--slate-200);">Rp {{ number_format($order['shipping_cost'], 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-weight:800; font-size:1.05rem; padding-top:12px; border-top:1px solid var(--navy-500); margin-top:12px;">
                        <span style="color:var(--slate-100);">TOTAL</span>
                        <span style="color:var(--brand-400); font-family:'Plus Jakarta Sans';">Rp {{ number_format($order['total_amount'], 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <hr style="border-style:dashed; border-color:var(--navy-500); margin:20px 0;">
                
                <div style="text-align:center; font-size:0.78rem; color:var(--slate-400);">
                    <p style="margin-bottom:4px;">Terima kasih telah berbelanja di TrekNesia!</p>
                    <p style="margin:0;">Simpan struk ini sebagai bukti pembelian.</p>
                </div>
            </div>
            
            <div class="text-center mt-4" style="display:flex; gap:10px; justify-content:center; flex-wrap:wrap;">
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
        body { background: #fff !important; color: #000 !important; }
        body * { visibility: hidden; }
        #receipt, #receipt * { visibility: visible; color: #000 !important; }
        #receipt { position: absolute; left: 0; top: 0; width: 100%; background: #fff !important; border: 1px solid #ccc !important; }
        .navbar-trek, .footer-trek, .btn { display: none !important; }
    }
</style>
@endpush