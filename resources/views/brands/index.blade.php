@extends('layouts.app')

@section('title', 'Brands - TrekNesia')

@section('content')

<div class="container py-5" style="max-width: 1280px;">
    <div class="text-center mb-5">
        <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(16, 185, 129, 0.1); color:var(--brand-400); padding:6px 16px; border-radius:99px; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:16px; border:1px solid rgba(16, 185, 129, 0.3);">
            <i class="fas fa-tag"></i> Brand Partner
        </div>
        <h2 class="section-title">Brands</h2>
        <p class="section-subtitle">Brand perlengkapan outdoor terpercaya</p>
    </div>
    
    <div class="row g-3 justify-content-center" id="brandsContainer">
        <div class="col-12 text-center py-5">
            <i class="fas fa-spinner fa-spin fa-2x" style="color:var(--brand-400);"></i>
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
        background: var(--navy-700);
        border: 1px solid var(--navy-600);
        border-radius: 14px;
        text-decoration: none;
        color: var(--slate-200);
        transition: all 0.2s;
        height: 100%;
        min-height: 150px;
    }
    
    .brand-card:hover {
        border-color: var(--brand-500);
        background: var(--navy-650);
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.3);
    }
    
    .brand-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
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
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--slate-100);
        margin-bottom: 4px;
        text-align: center;
    }
    
    .brand-count {
        font-size: 0.72rem;
        color: var(--slate-400);
    }
</style>
@endpush

@push('scripts')
<script>
    const brandColors = {
        'PeakStride': '#10b981', 'Northridge': '#059669',
        'Wildsphere': '#047857', 'Altitude': '#065F46',
        'Weatherguard': '#0f5132', 'Nordic': '#166534',
        'TrailReady': '#15803d', 'LightPro': '#22c55e',
        'DreamSleep': '#3b82f6', 'HydraPack': '#0ea5e9',
        'RunTech': '#f59e0b', 'BikePro': '#ef4444',
        'RecoverPro': '#8b5cf6', 'CompressTech': '#ec4899',
        'AeroSafe': '#06b6d4', 'ComfortCamp': '#84cc16',
        'Uniqlo': '#dc2626'
    };
    
    Promise.all([
        fetch('/api/brands').then(r => r.json()),
        fetch('/api/products').then(r => r.json())
    ])
    .then(([brandsData, productsData]) => {
        const container = document.getElementById('brandsContainer');
        
        if (brandsData.data.length === 0) {
            container.innerHTML = '<p class="text-center" style="color:var(--slate-400);">Belum ada brand</p>';
            return;
        }
        
        const productCount = {};
        productsData.data.forEach(p => {
            if (p.brand) productCount[p.brand] = (productCount[p.brand] || 0) + 1;
        });
        
        container.innerHTML = '';
        brandsData.data.forEach(brand => {
            const color = brandColors[brand] || '#10b981';
            const initial = brand.charAt(0).toUpperCase();
            const count = productCount[brand] || 0;
            
            container.innerHTML += `
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="/products?brand=${encodeURIComponent(brand)}" class="brand-card">
                        <div class="brand-avatar" style="background:${color};">${initial}</div>
                        <div class="brand-name">${brand}</div>
                        <div class="brand-count">${count} produk</div>
                    </a>
                </div>
            `;
        });
    })
    .catch(err => {
        console.error(err);
        document.getElementById('brandsContainer').innerHTML = '<p class="text-center" style="color:#FCA5A5;">Gagal memuat brands</p>';
    });
</script>
@endpush