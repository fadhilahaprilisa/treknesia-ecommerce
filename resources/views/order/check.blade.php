@extends('layouts.app')

@section('title', 'Cek Status Pesanan - TrekNesia')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-3"><i class="fas fa-search"></i> Cek Status Pesanan</h3>
                    <p class="text-muted">Masukkan Order ID Anda untuk melihat status pesanan</p>
                    
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="orderIdInput" 
                               placeholder="Contoh: TRK-000001">
                        <button class="btn btn-primary-custom" onclick="checkOrder()">
                            <i class="fas fa-search"></i> Cek
                        </button>
                    </div>
                    
                    <div id="resultContainer"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function checkOrder() {
        const orderId = document.getElementById('orderIdInput').value.trim().toUpperCase();
        const container = document.getElementById('resultContainer');
        
        if (!orderId) {
            container.innerHTML = '<div class="alert alert-warning">Masukkan Order ID terlebih dahulu</div>';
            return;
        }
        
        container.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i></div>';
        
        fetch(`/api/orders/${orderId}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    container.innerHTML = `
                        <div class="alert alert-success">
                            <h6><i class="fas fa-check-circle"></i> Pesanan Ditemukan</h6>
                            <hr>
                            <p class="mb-1"><strong>Order ID:</strong> ${data.data.order_id}</p>
                            <p class="mb-1"><strong>Nama:</strong> ${data.data.customer_name}</p>
                            <p class="mb-1"><strong>Status:</strong> ${data.data.status}</p>
                            <p class="mb-1"><strong>Total:</strong> ${formatRupiah(data.data.total_amount)}</p>
                            <a href="/invoice/${data.data.order_id}" class="btn btn-primary-custom mt-2">
                                Lihat Invoice Lengkap
                            </a>
                        </div>
                    `;
                } else {
                    container.innerHTML = '<div class="alert alert-danger">Pesanan tidak ditemukan</div>';
                }
            })
            .catch(error => {
                container.innerHTML = '<div class="alert alert-danger">Pesanan tidak ditemukan</div>';
            });
    }
    
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }
</script>
@endpush