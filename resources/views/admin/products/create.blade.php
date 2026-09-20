@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')

<div class="table-card">
    <h5 class="fw-bold mb-4"><i class="fas fa-plus-circle"></i> Form Tambah Produk</h5>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="/admin/products" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-bold">Nama Produk *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Brand</label>
                <input type="text" name="brand" class="form-control" value="{{ old('brand') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Kategori *</label>
                <select name="category" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat['name'] }}" {{ old('category') == $cat['name'] ? 'selected' : '' }}>
                            {{ $cat['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Gender *</label>
                <select name="gender" class="form-select" required>
                    <option value="Pria" {{ old('gender') == 'Pria' ? 'selected' : '' }}>Pria</option>
                    <option value="Wanita" {{ old('gender') == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                    <option value="Unisex" {{ old('gender') == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Rating</label>
                <input type="number" step="0.1" min="0" max="5" name="rating" class="form-control" value="{{ old('rating', 4.5) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Harga (Rp) *</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" required min="0">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Stok *</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" required min="0">
            </div>
            <div class="col-12">
                <label class="form-label fw-bold">Deskripsi *</label>
                <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
            </div>
        </div>
        
        <div class="mt-4">
            <button type="submit" class="btn btn-primary-custom">
                <i class="fas fa-save"></i> Simpan Produk
            </button>
            <a href="/admin/products" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

@endsection