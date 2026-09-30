@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')

<div class="row g-3">
    <div class="col-lg-8">
        <div class="table-card" style="padding:24px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:10px;">
                <h5 style="font-family:Manrope; font-size:1.05rem; font-weight:700; margin:0;">
                    Pesanan {{ $order['id'] }}
                </h5>
                <a href="/admin/orders" class="btn-icon" title="Kembali">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            
            <hr style="border-color:var(--trek-border-soft); margin:16px 0;">
            
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <h6 style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--trek-text-muted); margin-bottom:10px;">Informasi Pelanggan</h6>
                    <p style="margin-bottom:4px;"><strong style="color:var(--trek-dark);">{{ $order['customer_name'] }}</strong></p>
                    <p style="margin-bottom:4px; font-size:0.85rem;">
                        <i class="fab fa-whatsapp" style="color:var(--trek-success);"></i> {{ $order['customer_whatsapp'] }}
                    </p>
                    <p style="margin-bottom:4px; font-size:0.85rem;">{{ $order['customer_address'] }}</p>
                    <p style="margin-bottom:0; font-size:0.85rem;">{{ $order['customer_city'] }}</p>
                </div>
                <div class="col-md-6">
                    <h6 style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--trek-text-muted); margin-bottom:10px;">Informasi Pesanan</h6>
                    <p style="margin-bottom:4px; font-size:0.85rem;"><strong>Order ID:</strong> {{ $order['id'] }}</p>
                    <p style="margin-bottom:4px; font-size:0.85rem;"><strong>Tanggal:</strong> {{ $order['created_at'] }}</p>
                    <p style="margin-bottom:4px; font-size:0.85rem;"><strong>Metode:</strong> {{ $order['payment_method'] ?? 'COD' }}</p>
                    <p style="margin-bottom:0; font-size:0.85rem;"><strong>Status:</strong> 
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
            
            <h6 style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--trek-text-muted); margin-bottom:10px;">Item Pesanan</h6>
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
                                    <span style="color:var(--trek-text-muted); font-size:0.8rem;">({{ $item['size'] }})</span>
                                @endif
                            </td>
                            <td style="text-align:center;">{{ $item['quantity'] }}</td>
                            <td style="text-align:right;">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td style="text-align:right; font-weight:600;">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align:right; color:var(--trek-text-muted);">Subtotal</td>
                            <td style="text-align:right;">Rp {{ number_format($order['total_price'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right; color:var(--trek-text-muted);">Ongkir</td>
                            <td style="text-align:right;">Rp {{ number_format($order['shipping_cost'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right; font-weight:700;">Total</td>
                            <td style="text-align:right; font-weight:800; color:var(--trek-success); font-size:1rem;">Rp {{ number_format($order['total_amount'], 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="table-card" style="padding:20px;">
            <h6 style="font-family:Manrope; font-size:0.95rem; font-weight:700; margin-bottom:16px;">
                <i class="fas fa-tasks" style="color:var(--trek-primary);"></i> Update Status
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
            
            <hr style="border-color:var(--trek-border-soft); margin:20px 0;">
            
            <button onclick="window.print()" class="btn btn-outline-custom w-100">
                <i class="fas fa-print"></i> Cetak Struk
            </button>
        </div>
        
        @if(isset($order['payment_proof']) && $order['payment_proof'])
        <div class="table-card mt-3" style="padding:20px;">
            <h6 style="font-family:Manrope; font-size:0.95rem; font-weight:700; margin-bottom:14px;">
                <i class="fas fa-receipt" style="color:var(--trek-primary);"></i> Bukti Pembayaran
            </h6>
            <p style="font-size:0.82rem; margin-bottom:4px;"><strong>Pengirim:</strong> {{ $order['payment_proof']['sender_name'] }}</p>
            <p style="font-size:0.82rem; margin-bottom:12px;"><strong>Waktu:</strong> {{ $order['payment_proof']['uploaded_at'] }}</p>
            <img src="{{ $order['payment_proof']['path'] }}" alt="Bukti" style="width:100%; border-radius:var(--radius-md); border:1px solid var(--trek-border); cursor:pointer;" onclick="window.open(this.src)">
        </div>
        @endif
    </div>
</div>

@endsection