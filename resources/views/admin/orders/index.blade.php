@extends('layouts.admin')

@section('title', 'Kelola Pesanan')
@section('page-title', 'Kelola Pesanan')

@section('content')

<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="fw-bold mb-0"><i class="fas fa-shopping-bag"></i> Daftar Pesanan ({{ count($orders) }})</h5>
        <form method="GET" class="d-flex gap-2">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                <option value="PAID" {{ request('status') == 'PAID' ? 'selected' : '' }}>PAID</option>
                <option value="SHIPPED" {{ request('status') == 'SHIPPED' ? 'selected' : '' }}>SHIPPED</option>
                <option value="CANCELLED" {{ request('status') == 'CANCELLED' ? 'selected' : '' }}>CANCELLED</option>
            </select>
        </form>
    </div>
    
    @if(count($orders) > 0)
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Pelanggan</th>
                    <th>Kota</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><strong>{{ $order['id'] }}</strong></td>
                    <td>{{ $order['customer_name'] }}<br><small class="text-muted">{{ $order['customer_whatsapp'] }}</small></td>
                    <td>{{ $order['customer_city'] }}</td>
                    <td>Rp {{ number_format($order['total_amount'], 0, ',', '.') }}</td>
                    <td><span class="badge bg-secondary">{{ $order['payment_method'] ?? 'COD' }}</span></td>
                    <td>
                        @if($order['status'] === 'PENDING')
                            <span class="badge bg-warning text-dark">PENDING</span>
                        @elseif($order['status'] === 'PAID')
                            <span class="badge bg-success">PAID</span>
                        @elseif($order['status'] === 'SHIPPED')
                            <span class="badge bg-info">SHIPPED</span>
                        @else
                            <span class="badge bg-danger">{{ $order['status'] }}</span>
                        @endif
                    </td>
                    <td><small>{{ $order['created_at'] }}</small></td>
                    <td>
                        <a href="/admin/orders/{{ $order['id'] }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center text-muted py-5">
        <i class="fas fa-inbox fa-3x mb-2"></i>
        <p>Belum ada pesanan</p>
    </div>
    @endif
</div>

@endsection