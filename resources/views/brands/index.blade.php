@extends('layouts.app')

@section('title', 'Brands - TrekNesia')

@section('content')

<div class="container py-5">
    <div class="text-center mb-5">
        <div style="display:inline-flex; align-items:center; gap:8px; background:var(--trek-primary-light); color:var(--trek-primary); padding:6px 16px; border-radius:99px; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:16px;">
            <i class="fas fa-tag"></i> Brand Partner
        </div>
        <h2 class="section-title">Brands</h2>
        <p class="section-subtitle">Brand perlengkapan outdoor terpercaya</p>
    </div>
    
    <div class="row g-3 justify-content-center" id="brandsContainer">
        <div class="col-12 text-center py-5">
            <i class="fas fa-spinner fa-spin fa-2x" style="color:var(--trek-primary);"></i>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .brand-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 28px 16px;
        background: #fff;
        border: 1px solid var(--trek-border);
        border-radius: var(--radius-lg);
        text-decoration: none;
        color: var(--trek-text);
        transition: all 0.2s;
        height: 100%;
        min-height: 140px;
    }
    
    .brand-card:hover {
        border-color: var(--trek-primary);
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        color: var(--trek-primary);
    }
    
    .brand-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Manrope', sans-serif;
        font-weight: 800;
        font-size: 1.4rem;
        color: #fff;
        margin-bottom: 14px;
        transition: transform 0.2s;
    }
    
    .brand-card:hover .brand-avatar {
        transform: scale(1.08);
    }
    
    .brand-name {
        font-family: 'Manrope', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--trek-dark);
        margin-bottom: 4px;
        text-align: center;
    }
    
    .brand-count {
        font-size: 0.72rem;
        color: var(--trek-text-muted);
    }
</style>
@endpush

@push('scripts')
<script>
    // Warna brand berbeda-beda
    const brandColors = {
        'PeakStride': '#1a472a',
        'Northridge': '#2d6a4f',
        'Wildsphere': '#2f855a',
        'Altitude': '#276749',
        'Weatherguard': '#0f5132',
        'Nordic': '#166534',
        'TrailReady': '#15803d',
        'LightPro': '#22c55e',
        'DreamSleep': '#3b82f6',
        'HydraPack': '#0ea5e9',
        'RunTech': '#f59e0b',
        'BikePro': '#ef4444',
        'RecoverPro': '#8b5cf6',
        'CompressTech': '#ec4899',
        'AeroSafe': '#06b6d4',
        'ComfortCamp': '#84cc16',
        'Uniqlo': '#dc2626'
    };
    
    Promise.all([
        fetch('/api/brands').then(r => r.json()),
        fetch('/api/products').then(r => r.json())
    ])
    .then(([brandsData, productsData]) => {
        const container = document.getElementById('brandsContainer');
        
        if (brandsData.data.length === 0) {
            container.innerHTML = '<p class="text-center" style="color:var(--trek-text-muted);">Belum ada brand</p>';
            return;
        }
        
        // Hitung jumlah produk per brand
        const productCount = {};
        productsData.data.forEach(p => {
            if (p.brand) {
                productCount[p.brand] = (productCount[p.brand] || 0) + 1;
            }
        });
        
        container.innerHTML = '';
        brandsData.data.forEach(brand => {
            const color = brandColors[brand] || '#1a472a';
            const initial = brand.charAt(0).toUpperCase();
            const count = productCount[brand] || 0;
            
            container.innerHTML += `
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="/products?brand=${encodeURIComponent(brand)}" class="brand-card">
                        <div class="brand-avatar" style="background:${color};">
                            ${initial}
                        </div>
                        <div class="brand-name">${brand}</div>
                        <div class="brand-count">${count} produk</div>
                    </a>
                </div>
            `;
        });
    })
    .catch(err => {
        console.error('Error:', err);
        document.getElementById('brandsContainer').innerHTML = `
            <p class="text-center" style="color:var(--trek-danger);">Gagal memuat brands</p>
        `;
    });
</script>
@endpush