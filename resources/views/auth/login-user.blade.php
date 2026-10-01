@extends('layouts.app')

@section('title', 'Login Pembeli - TrekNesia')

@section('content')

<div class="container py-5" style="max-width: 480px;">
    <div class="card-trek p-4 p-md-5">
        <div class="text-center mb-4">
            <div style="width:64px; height:64px; margin:0 auto 16px; background:rgba(16, 185, 129, 0.15); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-shopping-bag" style="font-size:1.4rem; color:var(--brand-400);"></i>
            </div>
            <h3 style="font-family:'Plus Jakarta Sans'; font-size:1.4rem; font-weight:800; margin-bottom:6px; color:#fff;">Login Pembeli</h3>
            <p style="color:var(--slate-400); font-size:0.85rem; margin:0;">Masuk untuk mulai berbelanja</p>
        </div>
        
        @if(session('error'))
            <div style="padding:12px 14px; border-radius:10px; background:rgba(239, 68, 68, 0.1); border:1px solid rgba(239, 68, 68, 0.3); color:#FCA5A5; font-size:0.82rem; margin-bottom:16px;">
                <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
            </div>
        @endif
        
        <form action="/login-user" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="contoh@email.com" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary-custom w-100">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </button>
        </form>
        
        <hr style="border-color:var(--navy-600); margin:24px 0;">
        
        <div class="text-center">
            <p style="color:var(--slate-400); font-size:0.85rem; margin-bottom:10px;">Belum punya akun?</p>
            <a href="/register" class="btn btn-outline-custom w-100">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
            <div style="margin-top:14px;">
                <a href="/login-admin" style="font-size:0.82rem; color:var(--slate-400);">
                    <i class="fas fa-store"></i> Login sebagai Penjual
                </a>
            </div>
        </div>
        
        <div style="margin-top:24px; padding:14px; background:rgba(59, 130, 246, 0.08); border:1px solid rgba(59, 130, 246, 0.2); border-radius:10px; font-size:0.78rem; color:#93C5FD; line-height:1.6;">
            <strong style="color:#BFDBFE;">Demo User:</strong><br>
            Email: <code style="color:#BFDBFE;">dila@gmail.com</code><br>
            Password: <code style="color:#BFDBFE;">user4321</code>
        </div>
    </div>
</div>

@endsection