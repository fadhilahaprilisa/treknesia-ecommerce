@extends('layouts.app')

@section('title', 'Brands - TrekNesia')

@section('content')

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">Brands</h2>
        <p class="section-subtitle">Brand perlengkapan outdoor terpercaya</p>
    </div>
    
    <div class="row g-3 justify-content-center" id="brandsContainer">
        <div class="text-center py-5">
            <i class="fas fa-spinner fa-spin fa-2x"></i>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    fetch('/api/brands')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('brandsContainer');
            
            if (data.data.length === 0) {
                container.innerHTML = '<p class="text-center text-muted">Belum ada brand</p>';
                return;
            }
            
            container.innerHTML = '';
            data.data.forEach(brand => {
                container.innerHTML += `
                    <div class="col-lg-3 col-md-4 col-6">
                        <a href="/products?brand=${encodeURIComponent(brand)}" class="text-decoration-none">
                            <div class="category-card">
                                <i class="fas fa-tag category-icon"></i>
                                <h6>${brand}</h6>
                            </div>
                        </a>
                    </div>
                `;
            });
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('brandsContainer').innerHTML = 
                '<p class="text-center text-danger">Gagal memuat brands</p>';
        });
</script>
@endpush