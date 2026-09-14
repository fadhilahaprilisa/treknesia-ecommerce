@extends('layouts.app')

@section('title', $product['name'] ?? 'Detail Produk')

@section('content')

<div class="container py-5" id="productDetail">
    <!-- Akan diisi JavaScript -->
</div>

@endsection

@push('scripts')
<script>
    const productId = {{ $id }};
    
    fetch(`/api/products/${productId}`)
        .then(res => res.json())
        .then(data => {
            const product = data.data;
            const container = document.getElementById('productDetail');
            
            const priceFormatted = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(product.price);
            
            let specsHtml = '';
            if (product.specs) {
                specsHtml = '<ul class="list-unstyled">';
                for (const [key, value] of Object.entries(product.specs)) {
                    if (Array.isArray(value)) {
                        specsHtml += `<li><strong>${key}:</strong> ${value.join(', ')}</li>`;
                    } else {
                        specsHtml += `<li><strong>${key}:</strong> ${value}</li>`;
                    }
                }
                specsHtml += '</ul>';
            }
            
            container.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=600&h=400&fit=crop" 
                             class="img-fluid rounded-4 shadow" alt="${product.name}">
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2 mb-3">
                            <span class="badge bg-success">${product.category}</span>
                            <span class="badge bg-secondary">${product.gender}</span>
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star"></i> ${product.rating}
                            </span>
                        </div>
                        <h1 class="fw-bold">${product.name}</h1>
                        <p class="text-muted">${product.brand || 'TrekNesia'}</p>
                        <h2 class="text-success fw-bold">${priceFormatted}</h2>
                        <p class="mt-3">${product.description}</p>
                        
                        <div class="mt-4">
                            <h6 class="fw-bold">Spesifikasi:</h6>
                            ${specsHtml}
                        </div>
                        
                        <div class="mt-4">
                            <div class="d-flex gap-3 align-items-center">
                                <label class="fw-bold">Jumlah:</label>
                                <div class="input-group" style="width: 130px;">
                                    <button class="btn btn-outline-secondary" onclick="updateQty(-1)">-</button>
                                    <input type="number" id="qtyInput" value="1" min="1" class="form-control text-center">
                                    <button class="btn btn-outline-secondary" onclick="updateQty(1)">+</button>
                                </div>
                            </div>
                            <button class="btn btn-primary-custom mt-3 w-100" onclick="addToCart(${product.id})">
                                <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            document.getElementById('productDetail').innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                    <h3>Produk tidak ditemukan</h3>
                    <a href="/products" class="btn btn-primary-custom">Kembali</a>
                </div>
            `;
        });
    
    function updateQty(delta) {
        const input = document.getElementById('qtyInput');
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;
        input.value = val;
    }
    
    function addToCart(productId) {
        const qty = parseInt(document.getElementById('qtyInput').value);
        // Akan diimplementasikan di Fase 4
        alert(`Produk ${productId} dengan jumlah ${qty} ditambahkan ke keranjang!`);
    }
</script>
@endpush