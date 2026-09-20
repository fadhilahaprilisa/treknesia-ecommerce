@extends('layouts.admin')

@section('title', 'Kelola Produk')
@section('page-title', 'Kelola Produk')

@section('content')

<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0"><i class="fas fa-box"></i> Daftar Produk ({{ count($products) }})</h5>
        <a href="/admin/products/create" class="btn btn-primary-custom">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th width="50">ID</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Gender</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product['id'] }}</td>
                    <td>
                        <strong>{{ $product['name'] }}</strong>
                        <br><small class="text-muted">{{ $product['brand'] ?? '-' }}</small>
                    </td>
                    <td><span class="badge bg-light text-dark">{{ $product['category'] }}</span></td>
                    <td>{{ $product['gender'] }}</td>
                    <td>Rp {{ number_format($product['price'], 0, ',', '.') }}</td>
                    <td>
                        @if($product['stock'] > 10)
                            <span class="badge bg-success">{{ $product['stock'] }}</span>
                        @elseif($product['stock'] > 0)
                            <span class="badge bg-warning text-dark">{{ $product['stock'] }}</span>
                        @else
                            <span class="badge bg-danger">Habis</span>
                        @endif
                    </td>
                    <td>
                        <a href="/admin/products/{{ $product['id'] }}/edit" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="/admin/products/{{ $product['id'] }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
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