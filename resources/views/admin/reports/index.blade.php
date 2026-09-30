@extends('layouts.admin')

@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')

@section('content')

<div class="table-card mb-3" style="padding:20px;">
    <h6 style="font-family:Manrope; font-size:0.95rem; font-weight:700; margin-bottom:14px;">
        <i class="fas fa-filter" style="color:var(--trek-primary);"></i> Filter Tanggal
    </h6>
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Dari Tanggal</label>
            <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Sampai Tanggal</label>
            <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to') }}">
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary-custom btn-sm">
                <i class="fas fa-search"></i> Filter
            </button>
            <a href="/admin/reports" class="btn btn-outline-custom btn-sm">Reset</a>
        </div>
    </form>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <div class="stat-card-label">Pendapatan (PAID)</div>
                <div class="stat-card-value" style="color:var(--trek-success); font-size:1.15rem;">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </div>
            </div>
            <div class="stat-card-icon stat-success"><i class="fas fa-money-bill-wave"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <div class="stat-card-label">Total Pesanan</div>
                <div class="stat-card-value">{{ $totalOrders }}</div>
            </div>
            <div class="stat-card-icon stat-primary"><i class="fas fa-shopping-bag"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <div class="stat-card-label">Pesanan PAID</div>
                <div class="stat-card-value" style="color:var(--trek-success);">{{ $paidOrders }}</div>
            </div>
            <div class="stat-card-icon stat-success"><i class="fas fa-check"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <div class="stat-card-label">Pesanan PENDING</div>
                <div class="stat-card-value" style="color:var(--trek-warning);">{{ $pendingOrders }}</div>
            </div>
            <div class="stat-card-icon stat-warning"><i class="fas fa-clock"></i></div>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-card-header">
        <h5 class="table-card-title">Detail Transaksi</h5>
        <button onclick="window.print()" class="btn btn-outline-custom btn-sm">
            <i class="fas fa-print"></i> Cetak
        </button>
    </div>
    
    @if(count($orders) > 0)
        <div style="overflow-x:auto;">
            <table class="table-trek">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Order ID</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $i => $o)
                    <tr>
                        <td style="color:var(--trek-text-muted);">{{ $i + 1 }}</td>
                        <td><strong>{{ $o['id'] }}</strong></td>
                        <td>{{ $o['customer_name'] }}</td>
                        <td style="font-weight:600;">Rp {{ number_format($o['total_amount'], 0, ',', '.') }}</td>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align:center; padding:60px 20px; color:var(--trek-text-muted);">
            <i class="fas fa-chart-line" style="font-size:2.5rem; margin-bottom:12px; opacity:0.4;"></i>
            <p style="margin:0;">Tidak ada data untuk periode ini</p>
        </div>
    @endif
</div>

@endsection