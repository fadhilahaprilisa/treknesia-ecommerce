@extends('layouts.admin')

@section('title', 'Kelola Pesanan')
@section('page-title', 'Kelola Pesanan')

@section('content')

<div class="table-card">
    <div class="table-card-header">
        <h5 class="table-card-title">Daftar Pesanan ({{ count($orders) }})</h5>
        <form method="GET" style="min-width:180px;">
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                <option value="PAID" {{ request('status') == 'PAID' ? 'selected' : '' }}>PAID</option>
                <option value="SHIPPED" {{ request('status') == 'SHIPPED' ? 'selected' : '' }}>SHIPPED</option>
                <option value="CANCELLED" {{ request('status') == 'CANCELLED' ? 'selected' : '' }}>CANCELLED</option>
            </select>
        </form>
    </div>
    
    @if(count($orders) > 0)
        <div style="overflow-x:auto;">
            <table class="table-trek">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Pelanggan</th>
                        <th>Kota</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $o)
                    <tr>
                        <td><strong>{{ $o['id'] }}</strong></td>
                        <td>
                            <div style="font-weight:600; color:var(--trek-dark);">{{ $o['customer_name'] }}</div>
                            <div style="font-size:0.75rem; color:var(--trek-text-muted);">{{ $o['customer_whatsapp'] }}</div>
                        </td>
                        <td>{{ $o['customer_city'] }}</td>
                        <td style="font-weight:600;">Rp {{ number_format($o['total_amount'], 0, ',', '.') }}</td>
                        <td>
                            <span class="badge-status badge-muted">{{ $o['payment_method'] ?? 'COD' }}</span>
                        </td>
                        <td>
                            @if($o['status'] === 'PENDING')
                                <span class="badge-status badge-pending">PENDING</span>
                            @elseif($o['status'] === 'PAID')
                                <span class="badge-status badge-paid">PAID</span>
                            @elseif($o['status'] === 'SHIPPED')
                                <span class="badge-status badge-shipped">SHIPPED</span>
                            @else
                                <span class="badge-status badge-cancelled">{{ $o['status'] }}</span>
                            @endif
                        </td>
                        <td style="font-size:0.78rem; color:var(--trek-text-muted);">{{ $o['created_at'] }}</td>
                        <td style="text-align:right;">
                            <a href="/admin/orders/{{ $o['id'] }}" class="btn-icon">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align:center; padding:60px 20px; color:var(--trek-text-muted);">
            <i class="fas fa-inbox" style="font-size:2.5rem; margin-bottom:12px; opacity:0.4;"></i>
            <p style="margin:0;">Belum ada pesanan</p>
        </div>
    @endif
</div>

@endsection