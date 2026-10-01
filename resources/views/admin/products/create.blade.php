@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')

<div class="table-card" style="padding:28px;">
    <h5 style="font-family:'Plus Jakarta Sans'; font-size:1.05rem; font-weight:800; color:#fff; margin-bottom:24px;">
        <i class="fas fa-plus-circle" style="color:var(--brand-400);"></i> Form Tambah Produk
    </h5>
    
    @if($errors->any())
        <div style="padding:14px 18px; border-radius:10px; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); color:#FCA5A5; font-size:0.85rem; margin-bottom:20px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="/admin/products" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row g-3">
            <!-- Upload Gambar -->
            <div class="col-12">
                <label class="form-label">Foto Produk</label>
                <div style="display:flex; gap:16px; align-items:flex-start; flex-wrap:wrap;">
                    <div id="imagePreview" style="width:140px; height:140px; background:var(--navy-800); border:2px dashed var(--navy-500); border-radius:12px; display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0;">
                        <div style="text-align:center; color:var(--slate-400);">
                            <i class="fas fa-image" style="font-size:2rem; margin-bottom:6px; display:block;"></i>
                            <span style="font-size:0.72rem;">Preview</span>
                        </div>
                    </div>
                    <div style="flex:1; min-width:200px;">
                        <input type="file" name="image" id="imageInput" class="form-control" accept="image/*" onchange="previewImage(event)">
                        <small style="color:var(--slate-500); font-size:0.75rem; display:block; margin-top:8px;">
                            <i class="fas fa-info-circle"></i> Format: JPG, PNG, WEBP. Max: 2MB
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <label class="form-label">Nama Produk *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Brand</label>
                <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" placeholder="PeakStride, dll">
            </div>
            <div class="col-md-6">
                <label class="form-label">Kategori *</label>
                <select name="category" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat['name'] }}" {{ old('category') == $cat['name'] ? 'selected' : '' }}>{{ $cat['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Gender *</label>
                <select name="gender" class="form-select" required>
                    <option value="Pria" {{ old('gender') == 'Pria' ? 'selected' : '' }}>Pria</option>
                    <option value="Wanita" {{ old('gender') == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                    <option value="Unisex" {{ old('gender') == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Harga (Rp) *</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" required min="0">
            </div>
            <div class="col-md-6">
                <label class="form-label">Stok *</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" required min="0">
            </div>
            <div class="col-12">
                <label class="form-label">Deskripsi *</label>
                <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
            </div>
        </div>
        
        <div style="margin-top:28px; display:flex; gap:10px; flex-wrap:wrap;">
            <button type="submit" class="btn btn-primary-custom">
                <i class="fas fa-save"></i> Simpan Produk
            </button>
            <a href="/admin/products" class="btn btn-outline-custom">Batal</a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;
        
        const preview = document.getElementById('imagePreview');
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
        };
        
        reader.readAsDataURL(file);
    }
</script>
@endpush