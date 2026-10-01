@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')

<div class="row g-3">
    <div class="col-lg-8">
        <div class="table-card" style="padding:24px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
                <h5 style="font-family:'Plus Jakarta Sans'; font-size:1.05rem; font-weight:800; color:#fff; margin:0;">
                    Pesanan {{ $order['id'] }}
                </h5>
                <a href="/admin/orders" class="btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            
            <hr style="border-color:var(--navy-600); margin:16px 0;">
            
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <h6 style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--slate-400); margin-bottom:10px;">Informasi Pelanggan</h6>
                    <p style="margin-bottom:4px; color:var(--slate-100); font-weight:700;">{{ $order['customer_name'] }}</p>
                    <p style="margin-bottom:4px; font-size:0.85rem;"><i class="fab fa-whatsapp" style="color:var(--brand-400);"></i> {{ $order['customer_whatsapp'] }}</p>
                    <p style="margin-bottom:4px; font-size:0.85rem;">{{ $order['customer_address'] }}</p>
                    <p style="margin-bottom:0; font-size:0.85rem;">{{ $order['customer_city'] }}</p>
                </div>
                <div class="col-md-6">
                    <h6 style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--slate-400); margin-bottom:10px;">Informasi Pesanan</h6>
                    <p style="margin-bottom:4px; font-size:0.85rem;"><strong style="color:var(--slate-100);">Order ID:</strong> {{ $order['id'] }}</p>
                    <p style="margin-bottom:4px; font-size:0.85rem;"><strong style="color:var(--slate-100);">Tanggal:</strong> {{ $order['created_at'] }}</p>
                    <p style="margin-bottom:4px; font-size:0.85rem;"><strong style="color:var(--slate-100);">Metode:</strong> {{ $order['payment_method'] ?? 'COD' }}</p>
                    <p style="margin-bottom:0; font-size:0.85rem;"><strong style="color:var(--slate-100);">Status:</strong> 
                        @if($order['status'] === 'PENDING')
                            <span class="badge-status badge-pending">PENDING</span>
                        @elseif($order['status'] === 'PAID')
                            <span class="badge-status badge-paid">PAID</span>
                        @elseif($order['status'] === 'SHIPPED')
                            <span class="badge-status badge-shipped">SHIPPED</span>
                        @else
                            <span class="badge-status badge-cancelled">{{ $order['status'] }}</span>
                        @endif
                    </p>
                </div>
            </div>
            
            <h6 style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--slate-400); margin-bottom:12px;">Item Pesanan</h6>
            <div style="overflow-x:auto;">
                <table class="table-trek">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th style="text-align:center;">Qty</th>
                            <th style="text-align:right;">Harga</th>
                            <th style="text-align:right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order['items'] as $item)
                        <tr>
                            <td>
                                {{ $item['product_name'] }}
                                @if(!empty($item['size']))
                                    <span style="color:var(--slate-400); font-size:0.8rem;">({{ $item['size'] }})</span>
                                @endif
                                @if(!empty($item['bundle_name']))
                                    <span class="badge-status badge-danger" style="font-size:0.6rem; padding:2px 6px; margin-left:4px;">BUNDLE</span>
                                @endif
                            </td>
                            <td style="text-align:center;">{{ $item['quantity'] }}</td>
                            <td style="text-align:right;">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td style="text-align:right; font-weight:700; color:var(--brand-400);">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align:right; color:var(--slate-400);">Subtotal</td>
                            <td style="text-align:right;">Rp {{ number_format($order['total_price'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right; color:var(--slate-400);">Ongkir</td>
                            <td style="text-align:right;">Rp {{ number_format($order['shipping_cost'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right; font-weight:800; color:var(--slate-100);">Total</td>
                            <td style="text-align:right; font-family:'Plus Jakarta Sans'; font-weight:800; color:var(--brand-400); font-size:1.05rem;">Rp {{ number_format($order['total_amount'], 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="table-card" style="padding:22px;">
            <h6 style="font-family:'Plus Jakarta Sans'; font-size:0.95rem; font-weight:800; color:#fff; margin-bottom:18px;">
                <i class="fas fa-tasks" style="color:var(--brand-400);"></i> Update Status
            </h6>
            
            <form action="/admin/orders/{{ $order['id'] }}/status" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Status Pesanan</label>
                    <select name="status" class="form-select">
                        <option value="PENDING" {{ $order['status'] == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                        <option value="PAID" {{ $order['status'] == 'PAID' ? 'selected' : '' }}>PAID</option>
                        <option value="SHIPPED" {{ $order['status'] == 'SHIPPED' ? 'selected' : '' }}>SHIPPED</option>
                        <option value="CANCELLED" {{ $order['status'] == 'CANCELLED' ? 'selected' : '' }}>CANCELLED</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary-custom w-100">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </form>
            
            <hr style="border-color:var(--navy-600); margin:20px 0;">
            
            <button onclick="window.print()" class="btn btn-outline-custom w-100">
                <i class="fas fa-print"></i> Cetak Struk
            </button>
        </div>
        
        @if(isset($order['payment_proof']) && $order['payment_proof'])
        <div class="table-card mt-3" style="padding:22px;">
            <h6 style="font-family:'Plus Jakarta Sans'; font-size:0.95rem; font-weight:800; color:#fff; margin-bottom:14px;">
                <i class="fas fa-receipt" style="color:var(--brand-400);"></i> Bukti Pembayaran
            </h6>
            <p style="font-size:0.82rem; margin-bottom:4px; color:var(--slate-200);"><strong style="color:var(--slate-100);">Pengirim:</strong> {{ $order['payment_proof']['sender_name'] }}</p>
            <p style="font-size:0.82rem; margin-bottom:12px; color:var(--slate-200);"><strong style="color:var(--slate-100);">Waktu:</strong> {{ $order['payment_proof']['uploaded_at'] }}</p>
            <img src="{{ $order['payment_proof']['path'] }}" alt="Bukti" style="width:100%; border-radius:10px; border:1px solid var(--navy-600); cursor:pointer;" onclick="window.open(this.src)">
        </div>
        @endif
    </div>
</div>

@endsection