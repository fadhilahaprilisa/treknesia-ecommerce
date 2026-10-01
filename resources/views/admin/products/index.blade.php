@extends('layouts.admin')

@section('title', 'Kelola Produk')
@section('page-title', 'Kelola Produk')

@section('content')

<div class="table-card">
    <div class="table-card-header">
        <h5 class="table-card-title">Daftar Produk ({{ count($products) }})</h5>
        <a href="/admin/products/create" class="btn btn-primary-custom btn-sm">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>
    
    <div style="overflow-x:auto;">
        <table class="table-trek">
            <thead>
                <tr>
                    <th style="width:70px;">ID</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Gender</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                <tr>
                    <td style="color:var(--slate-400); font-weight:600;">#{{ $p['id'] }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:48px; height:48px; border-radius:8px; background:var(--navy-800); overflow:hidden; flex-shrink:0; padding:4px;">
                                <img src="{{ $p['image'] ?? '' }}" style="width:100%; height:100%; object-fit:contain;" onerror="this.src='https://placehold.co/48x48/0D1C2D/34d399?text=T'">
                            </div>
                            <div>
                                <div style="font-weight:700; color:var(--slate-100);">{{ $p['name'] }}</div>
                                <div style="font-size:0.75rem; color:var(--slate-400);">{{ $p['brand'] ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge-status badge-muted">{{ $p['category'] }}</span></td>
                    <td>{{ $p['gender'] }}</td>
                    <td style="font-weight:700; color:var(--brand-400);">Rp {{ number_format($p['price'], 0, ',', '.') }}</td>
                    <td>
                        @if($p['stock'] > 10)
                            <span class="badge-status badge-success">{{ $p['stock'] }}</span>
                        @elseif($p['stock'] > 0)
                            <span class="badge-status badge-warning">{{ $p['stock'] }}</span>
                        @else
                            <span class="badge-status badge-danger">Habis</span>
                        @endif
                    </td>
                    <td style="text-align:right; white-space:nowrap;">
                        <a href="/admin/products/{{ $p['id'] }}/edit" class="btn-icon" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="/admin/products/{{ $p['id'] }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-icon danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection