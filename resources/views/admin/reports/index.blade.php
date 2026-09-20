@extends('layouts.admin')

@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')

@section('content')

<div class="table-card mb-4">
    <h5 class="fw-bold mb-3"><i class="fas fa-filter"></i> Filter Tanggal</h5>
    <form method="GET" class="row g-2">
        <div class="col-md-4">
            <label class="form-label">Dari Tanggal</label>
            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Sampai Tanggal</label>
            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
        </div>
        <div class="col-md-4 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary-custom">
                <i class="fas fa-search"></i> Filter
            </button>
            <a href="/admin/reports" class="btn btn-secondary">Reset</a>
        </div>
    </form>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #38a169;">
            <p>Total Pendapatan (PAID)</p>
            <h3 class="text-success">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p>Total Pesanan</p>
            <h3>{{ $totalOrders }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #38a169;">
            <p>Pesanan PAID</p>
            <h3 class="text-success">{{ $paidOrders }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left-color: #ed8936;">
            <p>Pesanan PENDING</p>
            <h3 class="text-warning">{{ $pendingOrders }}</h3>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="d-flex justify-content-between mb-3">
        <h5 class="fw-bold mb-0"><i class="fas fa-list"></i> Detail Transaksi</h5>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
    </div>
    
    @if(count($orders) > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Order ID</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $i => $order)
                <tr>
                    <td>{{ $i + 1 }}</td>
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
                    <td><small>{{ $order['created_at'] }}</small></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center text-muted py-5">
        <i class="fas fa-chart-line fa-3x mb-2"></i>
        <p>Tidak ada data untuk periode ini</p>
    </div>
    @endif
</div>

@endsection