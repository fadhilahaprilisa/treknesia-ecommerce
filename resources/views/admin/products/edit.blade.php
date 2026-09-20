@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')

<div class="table-card">
    <h5 class="fw-bold mb-4"><i class="fas fa-edit"></i> Form Edit Produk</h5>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="/admin/products/{{ $product['id'] }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-bold">Nama Produk *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product['name']) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Brand</label>
                <input type="text" name="brand" class="form-control" value="{{ old('brand', $product['brand'] ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Kategori *</label>
                <select name="category" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat['name'] }}" {{ $product['category'] == $cat['name'] ? 'selected' : '' }}>
                            {{ $cat['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Gender *</label>
                <select name="gender" class="form-select" required>
                    <option value="Pria" {{ $product['gender'] == 'Pria' ? 'selected' : '' }}>Pria</option>
                    <option value="Wanita" {{ $product['gender'] == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                    <option value="Unisex" {{ $product['gender'] == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Rating</label>
                <input type="number" step="0.1" min="0" max="5" name="rating" class="form-control" value="{{ old('rating', $product['rating'] ?? 4.5) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Harga (Rp) *</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $product['price']) }}" required min="0">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Stok *</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product['stock']) }}" required min="0">
            </div>
            <div class="col-12">
                <label class="form-label fw-bold">Deskripsi *</label>
                <textarea name="description" class="form-control" rows="4" required>{{ old('description', $product['description']) }}</textarea>
            </div>
        </div>
        
        <div class="mt-4">
            <button type="submit" class="btn btn-primary-custom">
                <i class="fas fa-save"></i> Update Produk
            </button>
            <a href="/admin/products" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

@endsection