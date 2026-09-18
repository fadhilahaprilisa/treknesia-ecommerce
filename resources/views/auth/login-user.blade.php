@extends('layouts.app')

@section('title', 'Login Pembeli - TrekNesia')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-shopping-bag fa-3x text-success mb-3"></i>
                        <h3 class="fw-bold">Login Pembeli</h3>
                        <p class="text-muted">Masuk untuk mulai berbelanja</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="/login-user" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg" 
                                   value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" required>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100 btn-lg">
                            <i class="fas fa-sign-in-alt"></i> Masuk
                        </button>
                    </form>

                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="text-muted mb-2">Belum punya akun?</p>
                        <a href="/register" class="btn btn-outline-custom w-100">
                            <i class="fas fa-user-plus"></i> Daftar Sekarang
                        </a>
                    </div>

                    <div class="text-center mt-3">
                        <a href="/login-admin" class="text-muted small">
                            <i class="fas fa-store"></i> Login sebagai Penjual
                        </a>
                    </div>

                    <div class="alert alert-info mt-4 mb-0 small">
                        <strong>Demo User:</strong><br>
                        Email: budi@example.com<br>
                        Password: password
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection