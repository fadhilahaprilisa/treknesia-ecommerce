@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')

<div class="row g-3 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <div class="stat-card-label">Total Produk</div>
                <div class="stat-card-value">{{ $totalProducts }}</div>
            </div>
            <div class="stat-card-icon stat-primary"><i class="fas fa-box"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <div class="stat-card-label">Total Pesanan</div>
                <div class="stat-card-value">{{ $totalOrders }}</div>
            </div>
            <div class="stat-card-icon stat-warning"><i class="fas fa-shopping-bag"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <div class="stat-card-label">Total Pendapatan</div>
                <div class="stat-card-value" style="color:var(--brand-400); font-size:1.3rem;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
            <div class="stat-card-icon stat-success"><i class="fas fa-money-bill-wave"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <div class="stat-card-label">Menunggu Bayar</div>
                <div class="stat-card-value" style="color:#FCD34D;">{{ $pendingOrders }}</div>
            </div>
            <div class="stat-card-icon stat-danger"><i class="fas fa-clock"></i></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="table-card" style="padding:22px;">
            <h6 style="font-family:'Plus Jakarta Sans'; font-size:0.95rem; font-weight:800; color:#fff; margin-bottom:18px;">Status Pesanan</h6>
            
            <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid var(--navy-600);">
                <span style="font-size:0.85rem; color:var(--slate-200);">
                    <i class="fas fa-clock" style="color:#FCD34D; width:16px;"></i> PENDING
                </span>
                <span style="font-weight:800; color:#FCD34D;">{{ $pendingOrders }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid var(--navy-600);">
                <span style="font-size:0.85rem; color:var(--slate-200);">
                    <i class="fas fa-check" style="color:var(--brand-400); width:16px;"></i> PAID
                </span>
                <span style="font-weight:800; color:var(--brand-400);">{{ $paidOrders }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 0;">
                <span style="font-size:0.85rem; color:var(--slate-200);">
                    <i class="fas fa-truck" style="color:#93C5FD; width:16px;"></i> SHIPPED
                </span>
                <span style="font-weight:800; color:#93C5FD;">{{ $shippedOrders }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="table-card">
            <div class="table-card-header">
                <h5 class="table-card-title"><i class="fas fa-receipt" style="color:var(--brand-400);"></i> Pesanan Terbaru</h5>
                <a href="/admin/orders" class="btn btn-outline-custom btn-sm">Lihat Semua</a>
            </div>
            
            @if(count($recentOrders) > 0)
                <div style="overflow-x:auto;">
                    <table class="table-trek">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th style="text-align:right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $o)
                            <tr>
                                <td><strong style="color:var(--slate-100);">{{ $o['id'] }}</strong></td>
                                <td>{{ $o['customer_name'] }}</td>
                                <td style="font-weight:700; color:var(--brand-400);">Rp {{ number_format($o['total_amount'], 0, ',', '.') }}</td>
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
                                <td style="text-align:right;">
                                    <a href="/admin/orders/{{ $o['id'] }}" class="btn-icon"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align:center; padding:60px 20px; color:var(--slate-400);">
                    <i class="fas fa-inbox" style="font-size:2.5rem; margin-bottom:12px; opacity:0.5;"></i>
                    <p style="margin:0;">Belum ada pesanan</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection