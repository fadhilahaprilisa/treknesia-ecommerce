@extends('layouts.app')

@section('title', 'Login Pembeli - TrekNesia')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card-trek p-4 p-md-5">
                <div class="text-center mb-4">
                    <div style="width:64px; height:64px; margin:0 auto 16px; background:var(--trek-primary-light); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-shopping-bag" style="font-size:1.5rem; color:var(--trek-primary);"></i>
                    </div>
                    <h3 style="font-family:Manrope; font-size:1.35rem; font-weight:800; margin-bottom:6px;">Login Pembeli</h3>
                    <p style="color:var(--trek-text-muted); font-size:0.85rem; margin:0;">Masuk untuk mulai berbelanja</p>
                </div>
                
                @if(session('error'))
                    <div class="alert-trek alert-danger-trek" style="padding:12px; border-radius:var(--radius-md); background:#fee2e2; color:#991b1b; font-size:0.85rem; margin-bottom:16px;">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form action="/login-user" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>
                </form>
                
                <hr style="border-color:var(--trek-border-soft); margin:24px 0;">
                
                <div class="text-center">
                    <p style="color:var(--trek-text-muted); font-size:0.85rem; margin-bottom:10px;">Belum punya akun?</p>
                    <a href="/register" class="btn btn-outline-custom w-100">
                        <i class="fas fa-user-plus"></i> Daftar Sekarang
                    </a>
                    <div style="margin-top:14px;">
                        <a href="/login-admin" style="font-size:0.82rem; color:var(--trek-text-muted);">
                            <i class="fas fa-store"></i> Login sebagai Penjual
                        </a>
                    </div>
                </div>
                
                <div style="margin-top:24px; padding:14px; background:#f0f9ff; border-radius:var(--radius-md); font-size:0.78rem; color:#0369a1;">
                    <strong>Demo User:</strong><br>
                    Email: budi@example.com<br>
                    Password: password
                </div>
            </div>
        </div>
    </div>
</div>

@endsection