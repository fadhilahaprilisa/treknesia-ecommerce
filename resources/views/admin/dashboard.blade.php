@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p>Total Produk</p>
                    <h3>{{ $totalProducts }}</h3>
                </div>
                <div class="icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-box"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #ed8936;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p>Total Pesanan</p>
                    <h3>{{ $totalOrders }}</h3>
                </div>
                <div class="icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #38a169;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p>Total Pendapatan</p>
                    <h3 class="text-success">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #e53e3e;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p>Menunggu Bayar</p>
                    <h3 class="text-danger">{{ $pendingOrders }}</h3>
                </div>
                <div class="icon bg-danger bg-opacity-10 text-danger">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <h6 class="text-muted">Status Pesanan</h6>
            <hr>
            <div class="d-flex justify-content-between mb-2">
                <span><i class="fas fa-clock text-warning"></i> PENDING</span>
                <strong>{{ $pendingOrders }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span><i class="fas fa-check text-success"></i> PAID</span>
                <strong>{{ $paidOrders }}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span><i class="fas fa-truck text-info"></i> SHIPPED</span>
                <strong>{{ $shippedOrders }}</strong>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0"><i class="fas fa-receipt"></i> Pesanan Terbaru</h5>
                <a href="/admin/orders" class="btn btn-sm btn-primary-custom">Lihat Semua</a>
            </div>
            @if(count($recentOrders) > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td><strong>{{ $order['id'] }}</strong></td>
                            <td>{{ $order['customer_name'] }}</td>
                            <td>Rp {{ number_format($order['total_amount'], 0, ',', '.') }}</td>
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
                            <td>
                                <a href="/admin/orders/{{ $order['id'] }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center text-muted py-4">
                <i class="fas fa-inbox fa-3x mb-2"></i>
                <p>Belum ada pesanan</p>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection