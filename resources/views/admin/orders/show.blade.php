@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')

<div class="row g-4">
    <div class="col-md-8">
        <div class="table-card">
            <h5 class="fw-bold mb-3"><i class="fas fa-receipt"></i> Pesanan {{ $order['id'] }}</h5>
            <hr>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="fw-bold">Informasi Pelanggan</h6>
                    <p class="mb-1"><strong>{{ $order['customer_name'] }}</strong></p>
                    <p class="mb-1"><i class="fab fa-whatsapp text-success"></i> {{ $order['customer_whatsapp'] }}</p>
                    <p class="mb-1">{{ $order['customer_address'] }}</p>
                    <p class="mb-0">{{ $order['customer_city'] }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Informasi Pesanan</h6>
                    <p class="mb-1"><strong>Order ID:</strong> {{ $order['id'] }}</p>
                    <p class="mb-1"><strong>Tanggal:</strong> {{ $order['created_at'] }}</p>
                    <p class="mb-1"><strong>Metode:</strong> {{ $order['payment_method'] ?? 'COD' }}</p>
                    <p class="mb-0"><strong>Status:</strong> 
                        @if($order['status'] === 'PENDING')
                            <span class="badge bg-warning text-dark">PENDING</span>
                        @elseif($order['status'] === 'PAID')
                            <span class="badge bg-success">PAID</span>
                        @elseif($order['status'] === 'SHIPPED')
                            <span class="badge bg-info">SHIPPED</span>
                        @else
                            <span class="badge bg-danger">{{ $order['status'] }}</span>
                        @endif
                    </p>
                </div>
            </div>
            
            <h6 class="fw-bold">Item Pesanan</h6>
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
                    @foreach($order['items'] as $item)
                    <tr>
                        <td>
    {{ $item['product_name'] }}
    @if(!empty($item['size']))
        <small class="text-muted">({{ $item['size'] }})</small>
    @endif
</td>
                        <td class="text-center">{{ $item['quantity'] }}</td>
                        <td class="text-end">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end">Subtotal</td>
                        <td class="text-end">Rp {{ number_format($order['total_price'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end">Ongkir</td>
                        <td class="text-end">Rp {{ number_format($order['shipping_cost'], 0, ',', '.') }}</td>
                    </tr>
                    <tr class="fw-bold">
                        <td colspan="3" class="text-end">Total</td>
                        <td class="text-end text-success">Rp {{ number_format($order['total_amount'], 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="table-card">
            <h5 class="fw-bold mb-3"><i class="fas fa-tasks"></i> Update Status</h5>
            <form action="/admin/orders/{{ $order['id'] }}/status" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Status Pesanan</label>
                    <select name="status" class="form-select">
                        <option value="PENDING" {{ $order['status'] == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                        <option value="PAID" {{ $order['status'] == 'PAID' ? 'selected' : '' }}>PAID</option>
                        <option value="SHIPPED" {{ $order['status'] == 'SHIPPED' ? 'selected' : '' }}>SHIPPED</option>
                        <option value="CANCELLED" {{ $order['status'] == 'CANCELLED' ? 'selected' : '' }}>CANCELLED</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary-custom w-100">
                    <i class="fas fa-save"></i> Update Status
                </button>
            </form>
            
            <hr>
            @if(isset($order['payment_proof']) && $order['payment_proof'])
    <hr>
    <h6 class="fw-bold"><i class="fas fa-receipt"></i> Bukti Pembayaran</h6>
    <div class="mb-2">
        <p class="small mb-1"><strong>Pengirim:</strong> {{ $order['payment_proof']['sender_name'] }}</p>
        <p class="small mb-1"><strong>Waktu:</strong> {{ $order['payment_proof']['uploaded_at'] }}</p>
    </div>
    <div class="mb-2">
        <img src="{{ $order['payment_proof']['path'] }}" alt="Bukti Bayar" 
             class="img-fluid rounded border" style="max-height: 200px; cursor: pointer;"
             onclick="window.open(this.src)">
    </div>
    
    @if(($order['payment_status'] ?? '') === 'WAITING_VERIFICATION')
        <form action="/admin/payment/verify/{{ $order['id'] }}" method="POST">
            @csrf
            <div class="mb-2">
                <input type="text" name="note" class="form-control form-control-sm" 
                       placeholder="Catatan (opsional)">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" name="status" value="VERIFIED" class="btn btn-success btn-sm">
                    <i class="fas fa-check"></i> Verifikasi (Set PAID)
                </button>
                <button type="submit" name="status" value="REJECTED" class="btn btn-danger btn-sm">
                    <i class="fas fa-times"></i> Tolak
                </button>
            </div>
        </form>
    @elseif(($order['payment_status'] ?? '') === 'VERIFIED')
        <div class="alert alert-success small mb-0">
            <i class="fas fa-check-circle"></i> Sudah diverifikasi
        </div>
    @elseif(($order['payment_status'] ?? '') === 'REJECTED')
        <div class="alert alert-danger small mb-0">
            <i class="fas fa-times-circle"></i> Ditolak: {{ $order['payment_note'] ?? '-' }}
        </div>
    @endif
@endif
            <button onclick="window.print()" class="btn btn-outline-secondary w-100">
                <i class="fas fa-print"></i> Cetak Struk
            </button>
            
            <a href="/admin/orders" class="btn btn-secondary w-100 mt-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

@endsection