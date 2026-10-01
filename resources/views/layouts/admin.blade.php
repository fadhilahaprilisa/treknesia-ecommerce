<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - TrekNesia')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --navy-950: #010B17;
            --navy-900: #010F1F;
            --navy-850: #051424;
            --navy-800: #0D1C2D;
            --navy-750: #0D1B2B;
            --navy-700: #122131;
            --navy-650: #182A3C;
            --navy-600: #1C3042;
            --navy-500: #24394D;
            --brand-400: #34d399;
            --brand-500: #10b981;
            --brand-600: #059669;
            --slate-100: #F8FAFC;
            --slate-200: #E2E8F0;
            --slate-300: #CBD5E1;
            --slate-400: #94A3B8;
            --slate-500: #64748B;
            --amber-400: #F59E0B;
            --rose-500: #EF4444;
        }
        
        * { box-sizing: border-box; }
        
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 14px;
            background: var(--navy-900);
            color: var(--slate-200);
            margin: 0;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: var(--slate-100);
            letter-spacing: -0.02em;
        }
        
        a { text-decoration: none; }
        
        /* SIDEBAR */
        .admin-sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: 240px;
            background: var(--navy-850);
            border-right: 1px solid var(--navy-600);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid var(--navy-600);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar-brand img {
            height: 38px;
            width: auto;
        }
        
        .sidebar-brand-text {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1.1rem;
            color: #fff;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .sidebar-brand-text span { color: var(--brand-400); }
        
        .sidebar-brand-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand-400);
            font-size: 0.95rem;
        }
        
        .sidebar-menu {
            padding: 16px 12px;
            flex-grow: 1;
        }
        
        .sidebar-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--slate-500);
            padding: 12px 12px 6px;
            margin-top: 8px;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: var(--slate-300);
            font-size: 0.85rem;
            font-weight: 500;
            border-radius: 10px;
            margin-bottom: 2px;
            transition: all 0.15s;
        }
        
        .sidebar-menu a i {
            width: 18px;
            font-size: 0.9rem;
            color: var(--slate-500);
            transition: color 0.15s;
            text-align: center;
        }
        
        .sidebar-menu a:hover {
            background: var(--navy-800);
            color: #fff;
        }
        
        .sidebar-menu a:hover i { color: var(--brand-400); }
        
        .sidebar-menu a.active {
            background: rgba(16, 185, 129, 0.12);
            color: var(--brand-400);
            font-weight: 600;
            border-left: 3px solid var(--brand-500);
            padding-left: 11px;
        }
        
        .sidebar-menu a.active i { color: var(--brand-400); }
        
        .sidebar-logout {
            border-top: 1px solid var(--navy-600);
            padding: 12px;
        }
        
        .sidebar-logout button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: #FCA5A5;
            font-size: 0.85rem;
            font-weight: 500;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            border-radius: 10px;
            transition: all 0.15s;
            font-family: inherit;
        }
        
        .sidebar-logout button:hover {
            background: rgba(239, 68, 68, 0.1);
        }
        
        .sidebar-logout button i { width: 18px; text-align: center; }
        
        /* MAIN */
        .admin-main {
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .admin-topbar {
            background: var(--navy-850);
            padding: 16px 28px;
            border-bottom: 1px solid var(--navy-600);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .admin-topbar h5 {
            font-size: 1.05rem;
            margin: 0;
            font-weight: 800;
            color: #fff;
        }
        
        .admin-user {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.85rem;
        }
        
        .admin-user-name {
            font-weight: 600;
            color: var(--slate-200);
        }
        
        .admin-user-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.15);
            color: var(--brand-400);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.9rem;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        
        .admin-content {
            padding: 24px 28px;
            flex-grow: 1;
        }
        
        /* STAT CARD */
        .stat-card {
            background: var(--navy-700);
            border: 1px solid var(--navy-600);
            border-radius: 14px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            transition: all 0.15s;
            height: 100%;
        }
        
        .stat-card:hover {
            border-color: rgba(16, 185, 129, 0.4);
            background: var(--navy-650);
            transform: translateY(-2px);
        }
        
        .stat-card-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--slate-400);
            margin-bottom: 10px;
        }
        
        .stat-card-value {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            letter-spacing: -0.02em;
        }
        
        .stat-card-icon {
            width: 44px; height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            flex-shrink: 0;
        }
        
        .stat-primary { background: rgba(16, 185, 129, 0.15); color: var(--brand-400); }
        .stat-warning { background: rgba(245, 158, 11, 0.15); color: #FCD34D; }
        .stat-success { background: rgba(16, 185, 129, 0.15); color: var(--brand-400); }
        .stat-danger  { background: rgba(239, 68, 68, 0.15); color: #FCA5A5; }
        
        /* TABLE */
        .table-card {
            background: var(--navy-700);
            border: 1px solid var(--navy-600);
            border-radius: 14px;
            overflow: hidden;
        }
        
        .table-card-header {
            padding: 20px 22px;
            border-bottom: 1px solid var(--navy-600);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .table-card-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1rem;
            font-weight: 800;
            color: #fff;
            margin: 0;
        }
        
        .table-trek {
            width: 100%;
            margin: 0;
            font-size: 0.85rem;
            border-collapse: collapse;
        }
        
        .table-trek th {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--slate-400);
            padding: 12px 20px;
            border-bottom: 1px solid var(--navy-600);
            text-align: left;
            background: var(--navy-800);
            white-space: nowrap;
        }
        
        .table-trek td {
            padding: 14px 20px;
            border-bottom: 1px solid var(--navy-750);
            color: var(--slate-200);
            vertical-align: middle;
        }
        
        .table-trek tr:last-child td { border-bottom: none; }
        .table-trek tr:hover td { background: var(--navy-650); }
        
        /* BADGES */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.68rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 99px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        
        .badge-pending   { background: rgba(245, 158, 11, 0.15); color: #FCD34D; }
        .badge-paid      { background: rgba(16, 185, 129, 0.15); color: var(--brand-400); }
        .badge-shipped   { background: rgba(59, 130, 246, 0.15); color: #93C5FD; }
        .badge-cancelled { background: rgba(239, 68, 68, 0.15); color: #FCA5A5; }
        .badge-success   { background: rgba(16, 185, 129, 0.15); color: var(--brand-400); }
        .badge-warning   { background: rgba(245, 158, 11, 0.15); color: #FCD34D; }
        .badge-danger    { background: rgba(239, 68, 68, 0.15); color: #FCA5A5; }
        .badge-muted     { background: var(--navy-600); color: var(--slate-400); }
        
        /* BUTTONS */
        .btn {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 10px 18px;
            border-radius: 10px;
            transition: all 0.15s;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            line-height: 1.4;
            white-space: nowrap;
        }
        
        .btn-sm { font-size: 0.78rem; padding: 8px 14px; }
        
        .btn-primary-custom {
            background: var(--brand-500);
            color: var(--navy-950);
            border-color: var(--brand-500);
        }
        
        .btn-primary-custom:hover {
            background: var(--brand-400);
            color: var(--navy-950);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }
        
        .btn-outline-custom {
            background: var(--navy-800);
            color: var(--slate-200);
            border-color: var(--navy-500);
        }
        
        .btn-outline-custom:hover {
            background: var(--navy-700);
            color: var(--brand-400);
            border-color: var(--brand-500);
        }
        
        .btn-icon {
            width: 34px; height: 34px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: var(--navy-800);
            border: 1px solid var(--navy-600);
            color: var(--slate-300);
            font-size: 0.85rem;
            transition: all 0.15s;
        }
        
        .btn-icon:hover {
            border-color: var(--brand-500);
            color: var(--brand-400);
            background: var(--navy-700);
        }
        
        .btn-icon.danger:hover {
            border-color: var(--rose-500);
            color: #FCA5A5;
            background: rgba(239, 68, 68, 0.1);
        }
        
        /* FORM */
        .form-control, .form-select {
            font-size: 0.875rem;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid var(--navy-600);
            background: var(--navy-800);
            color: var(--slate-200);
            transition: all 0.15s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--brand-500);
            background: var(--navy-800);
            color: var(--slate-200);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }
        
        .form-control::placeholder { color: var(--slate-500); }
        
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--slate-200);
            margin-bottom: 6px;
        }
        
        /* RESPONSIVE */
        @media (max-width: 992px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-main { margin-left: 0; }
        }
        
        @media (max-width: 576px) {
            .admin-content { padding: 16px; }
            .admin-topbar { padding: 12px 16px; }
            .table-trek th, .table-trek td { padding: 10px 12px; }
        }
    </style>
    
    @stack('styles')
</head>
<body>

    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="TrekNesia">
            @else
                <div class="sidebar-brand-text">
                    <div class="sidebar-brand-icon"><i class="fas fa-mountain"></i></div>
                    Trek<span>Nesia</span>
                </div>
            @endif
        </div>
        
        <nav class="sidebar-menu">
            <div class="sidebar-section-label">Menu Utama</div>
            <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
            <a href="/admin/products" class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Produk
            </a>
            <a href="/admin/orders" class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag"></i> Pesanan
            </a>
            <a href="/admin/reports" class="{{ request()->is('admin/reports*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Laporan
            </a>
            
            <div class="sidebar-section-label" style="margin-top:20px;">Lainnya</div>
            <a href="/" target="_blank">
                <i class="fas fa-external-link-alt"></i> Lihat Toko
            </a>
        </nav>
        
        <div class="sidebar-logout">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </aside>

    <div class="admin-main">
        <div class="admin-topbar">
            <h5>@yield('page-title', 'Dashboard')</h5>
            <div class="admin-user">
                <span class="admin-user-name d-none d-md-inline">{{ session('admin_name') }}</span>
                <div class="admin-user-avatar">{{ strtoupper(substr(session('admin_name') ?? 'A', 0, 1)) }}</div>
            </div>
        </div>
        
        <div class="admin-content">
            @if(session('success'))
                <div style="padding:14px 18px; border-radius:10px; background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.3); color:var(--brand-400); font-size:0.85rem; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="padding:14px 18px; border-radius:10px; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); color:#FCA5A5; font-size:0.85rem; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>