<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - TrekNesia')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f7fafc; }
        
        /* Sidebar */
        .sidebar {
            min-height: 100vh;
            background: #1a472a;
            color: white;
            width: 250px;
            position: fixed;
            top: 0; left: 0;
            padding: 20px 0;
            z-index: 1000;
        }
        .sidebar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            padding: 15px 25px;
            color: white;
            text-decoration: none;
            display: block;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .sidebar-brand span { color: #68d391; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
        }
        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left: 4px solid #68d391;
        }
        .sidebar-menu li a i { width: 25px; margin-right: 10px; }
        
        /* Content */
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }
        .topbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .content-area { padding: 30px; }
        
        /* Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border-left: 4px solid #1a472a;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .stat-card .icon {
            width: 50px; height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .stat-card h3 { font-weight: 800; margin: 10px 0 5px; }
        .stat-card p { color: #718096; margin: 0; font-size: 0.9rem; }
        
        /* Buttons */
        .btn-primary-custom {
            background: #1a472a; color: white; border: none;
            padding: 8px 20px; border-radius: 8px;
            font-weight: 600; transition: all 0.3s;
        }
        .btn-primary-custom:hover { background: #2d6a4f; color: white; }
        
        /* Table */
        .table-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <a href="/admin/dashboard" class="sidebar-brand">
        <i class="fas fa-mountain"></i> Trek<span>Nesia</span>
    </a>
    <ul class="sidebar-menu">
        <li>
            <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="/admin/products" class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Produk
            </a>
        </li>
        <li>
            <a href="/admin/orders" class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag"></i> Pesanan
            </a>
        </li>
        <li>
            <a href="/admin/reports" class="{{ request()->is('admin/reports*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Laporan
            </a>
        </li>
        <li style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
            <a href="/">
                <i class="fas fa-store"></i> Lihat Toko
            </a>
        </li>
        <li>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" style="background:none; border:none; width:100%; text-align:left; color: rgba(255,255,255,0.8); padding: 12px 25px; font-weight: 500;">
                    <i class="fas fa-sign-out-alt" style="width: 25px; margin-right: 10px;"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</aside>

<!-- Main Content -->
<div class="main-content">
    <div class="topbar">
        <h5 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h5>
        <div>
            <span class="text-muted">Halo, <strong>{{ session('admin_name') }}</strong></span>
        </div>
    </div>
    
    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>