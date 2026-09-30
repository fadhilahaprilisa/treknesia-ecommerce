@extends('layouts.app')

@section('title', 'Login Penjual - TrekNesia')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card-trek p-4 p-md-5">
                <div class="text-center mb-4">
                    <div style="width:64px; height:64px; margin:0 auto 16px; background:var(--trek-primary-light); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-store" style="font-size:1.5rem; color:var(--trek-primary);"></i>
                    </div>
                    <h3 style="font-family:Manrope; font-size:1.35rem; font-weight:800; margin-bottom:6px;">Login Penjual</h3>
                    <p style="color:var(--trek-text-muted); font-size:0.85rem; margin:0;">Masuk untuk mengelola toko</p>
                </div>
                
                @if(session('error'))
                    <div style="padding:12px; border-radius:var(--radius-md); background:#fee2e2; color:#991b1b; font-size:0.85rem; margin-bottom:16px;">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form action="/login-admin" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email Admin</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="fas fa-sign-in-alt"></i> Masuk sebagai Admin
                    </button>
                </form>
                
                <div class="text-center" style="margin-top:14px;">
                    <a href="/login-user" style="font-size:0.82rem; color:var(--trek-text-muted);">
                        <i class="fas fa-shopping-bag"></i> Login sebagai Pembeli
                    </a>
                </div>
                
                <div style="margin-top:24px; padding:14px; background:#f0f9ff; border-radius:var(--radius-md); font-size:0.78rem; color:#0369a1;">
                    <strong>Demo Admin:</strong><br>
                    Email: admin@treknesia.com<br>
                    Password: password
                </div>
            </div>
        </div>
    </div>
</div>

@endsection