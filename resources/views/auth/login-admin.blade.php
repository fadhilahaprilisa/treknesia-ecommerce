@extends('layouts.app')

@section('title', 'Login Penjual - TrekNesia')

@section('content')

<div class="container py-5" style="max-width: 480px;">
    <div class="card-trek p-4 p-md-5">
        <div class="text-center mb-4">
            <div style="width:64px; height:64px; margin:0 auto 16px; background:rgba(16, 185, 129, 0.15); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-store" style="font-size:1.4rem; color:var(--brand-400);"></i>
            </div>
            <h3 style="font-family:'Plus Jakarta Sans'; font-size:1.4rem; font-weight:800; margin-bottom:6px; color:#fff;">Login Penjual</h3>
            <p style="color:var(--slate-400); font-size:0.85rem; margin:0;">Masuk untuk mengelola toko</p>
        </div>
        
        @if(session('error'))
            <div style="padding:12px 14px; border-radius:10px; background:rgba(239, 68, 68, 0.1); border:1px solid rgba(239, 68, 68, 0.3); color:#FCA5A5; font-size:0.82rem; margin-bottom:16px;">
                <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
            </div>
        @endif
        
        <form action="/login-admin" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Admin</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="admin@treknesia.com" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary-custom w-100">
                <i class="fas fa-sign-in-alt"></i> Masuk sebagai Admin
            </button>
        </form>
        
        <div class="text-center" style="margin-top:16px;">
            <a href="/login-user" style="font-size:0.82rem; color:var(--slate-400);">
                <i class="fas fa-shopping-bag"></i> Login sebagai Pembeli
            </a>
        </div>
        
        <div style="margin-top:24px; padding:14px; background:rgba(59, 130, 246, 0.08); border:1px solid rgba(59, 130, 246, 0.2); border-radius:10px; font-size:0.78rem; color:#93C5FD; line-height:1.6;">
            <strong style="color:#BFDBFE;">Demo Admin:</strong><br>
            Email: <code style="color:#BFDBFE;">admin@treknesia.com</code><br>
            Password: <code style="color:#BFDBFE;">admin4321</code>
        </div>
    </div>
</div>

@endsection