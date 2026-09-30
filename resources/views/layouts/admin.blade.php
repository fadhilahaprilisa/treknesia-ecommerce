<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - TrekNesia')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --trek-primary: #1a472a;
            --trek-primary-hover: #2d6a4f;
            --trek-primary-light: #f0f9f4;
            --trek-accent: #38a169;
            --trek-dark: #0f172a;
            --trek-text: #334155;
            --trek-text-muted: #64748b;
            --trek-border: #e2e8f0;
            --trek-border-soft: #f1f5f9;
            --trek-bg: #f8fafc;
            --trek-bg-soft: #f1f5f9;
            --trek-success: #16a34a;
            --trek-warning: #ea580c;
            --trek-danger: #dc2626;
            --trek-info: #0ea5e9;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --shadow-xs: 0 1px 2px rgba(15,23,42,0.04);
            --shadow-sm: 0 1px 3px rgba(15,23,42,0.06), 0 1px 2px rgba(15,23,42,0.04);
            --shadow-md: 0 4px 12px rgba(15,23,42,0.08);
        }
        
        * { box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 14px;
            background: var(--trek-bg);
            color: var(--trek-text);
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Manrope', 'Inter', sans-serif;
            font-weight: 700;
            color: var(--trek-dark);
            letter-spacing: -0.02em;
        }
        
        a { text-decoration: none; }
        
        /* ============ SIDEBAR ============ */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: #fff;
            border-right: 1px solid var(--trek-border);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar-brand {
            padding: 18px 20px;
            border-bottom: 1px solid var(--trek-border);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar-brand img {
            height: 36px;
            width: auto;
        }
        
        .sidebar-brand-text {
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            font-size: 1.05rem;
            color: var(--trek-primary);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .sidebar-menu {
            padding: 16px 12px;
            flex-grow: 1;
        }
        
        .sidebar-section-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--trek-text-muted);
            padding: 8px 12px;
            margin-top: 8px;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            color: var(--trek-text);
            font-size: 0.85rem;
            font-weight: 500;
            border-radius: var(--radius-md);
            margin-bottom: 2px;
            transition: all 0.15s;
        }
        
        .sidebar-menu a i {
            width: 18px;
            font-size: 0.9rem;
            color: var(--trek-text-muted);
            transition: color 0.15s;
        }
        
        .sidebar-menu a:hover {
            background: var(--trek-bg-soft);
            color: var(--trek-primary);
        }
        
        .sidebar-menu a:hover i { color: var(--trek-primary); }
        
        .sidebar-menu a.active {
            background: var(--trek-primary-light);
            color: var(--trek-primary);
            font-weight: 600;
        }
        
        .sidebar-menu a.active i { color: var(--trek-primary); }
        
        .sidebar-logout {
            border-top: 1px solid var(--trek-border);
            padding: 12px;
        }
        
        .sidebar-logout button {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            color: var(--trek-danger);
            font-size: 0.85rem;
            font-weight: 500;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            border-radius: var(--radius-md);
            transition: all 0.15s;
        }
        
        .sidebar-logout button:hover {
            background: #fef2f2;
        }
        
        /* ============ MAIN ============ */
        .admin-main {
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .admin-topbar {
            background: #fff;
            padding: 14px 28px;
            border-bottom: 1px solid var(--trek-border);
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
            font-weight: 700;
        }
        
        .admin-user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
        }
        
        .admin-user-name {
            font-weight: 600;
            color: var(--trek-dark);
        }
        
        .admin-user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--trek-primary-light);
            color: var(--trek-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }
        
        .admin-content {
            padding: 24px 28px;
            flex-grow: 1;
        }
        
        /* ============ STAT CARDS ============ */
        .stat-card {
            background: #fff;
            border: 1px solid var(--trek-border);
            border-radius: var(--radius-lg);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            transition: all 0.15s;
            height: 100%;
        }
        
        .stat-card:hover {
            border-color: var(--trek-accent-light);
            box-shadow: var(--shadow-sm);
        }
        
        .stat-card-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--trek-text-muted);
            margin-bottom: 10px;
        }
        
        .stat-card-value {
            font-family: 'Manrope', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--trek-dark);
            line-height: 1.1;
            letter-spacing: -0.02em;
        }
        
        .stat-card-icon {
            width: 42px;
            height: 42px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        
        .stat-primary { background: var(--trek-primary-light); color: var(--trek-primary); }
        .stat-warning { background: #fef3c7; color: #92400e; }
        .stat-success { background: #dcfce7; color: #166534; }
        .stat-danger  { background: #fee2e2; color: #991b1b; }
        
        /* ============ TABLE ============ */
        .table-card {
            background: #fff;
            border: 1px solid var(--trek-border);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }
        
        .table-card-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--trek-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .table-card-title {
            font-family: 'Manrope', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--trek-dark);
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
            letter-spacing: 0.05em;
            color: var(--trek-text-muted);
            padding: 12px 20px;
            border-bottom: 1px solid var(--trek-border);
            text-align: left;
            background: var(--trek-bg-soft);
            white-space: nowrap;
        }
        
        .table-trek td {
            padding: 14px 20px;
            border-bottom: 1px solid var(--trek-border-soft);
            color: var(--trek-text);
            vertical-align: middle;
        }
        
        .table-trek tr:last-child td { border-bottom: none; }
        .table-trek tr:hover td { background: var(--trek-bg-soft); }
        
        /* ============ BADGES ============ */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 99px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        
        .badge-pending   { background: #fef3c7; color: #92400e; }
        .badge-paid      { background: #dcfce7; color: #166534; }
        .badge-shipped   { background: #dbeafe; color: #1e40af; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .badge-success   { background: #dcfce7; color: #166534; }
        .badge-warning   { background: #fef3c7; color: #92400e; }
        .badge-danger    { background: #fee2e2; color: #991b1b; }
        .badge-muted     { background: var(--trek-bg-soft); color: var(--trek-text); }
        
        /* ============ BUTTONS ============ */
        .btn {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 9px 16px;
            border-radius: var(--radius-md);
            transition: all 0.15s;
            border: 1.5px solid transparent;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            line-height: 1.4;
        }
        
        .btn-sm { font-size: 0.78rem; padding: 6px 12px; }
        
        .btn-primary-custom {
            background: var(--trek-primary);
            color: #fff;
            border-color: var(--trek-primary);
        }
        
        .btn-primary-custom:hover {
            background: var(--trek-primary-hover);
            color: #fff;
            box-shadow: 0 4px 12px rgba(26,71,42,0.2);
        }
        
        .btn-outline-custom {
            background: #fff;
            color: var(--trek-primary);
            border-color: var(--trek-primary);
        }
        
        .btn-outline-custom:hover { background: var(--trek-primary); color: #fff; }
        
        .btn-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-md);
            background: #fff;
            border: 1px solid var(--trek-border);
            color: var(--trek-text);
            font-size: 0.8rem;
            transition: all 0.15s;
        }
        
        .btn-icon:hover { border-color: var(--trek-primary); color: var(--trek-primary); }
        .btn-icon.danger:hover { border-color: var(--trek-danger); color: var(--trek-danger); }
        
        /* ============ FORM ============ */
        .form-control, .form-select {
            font-size: 0.875rem;
            padding: 10px 14px;
            border-radius: var(--radius-md);
            border: 1px solid var(--trek-border);
            transition: all 0.15s;
            color: var(--trek-text);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--trek-primary);
            box-shadow: 0 0 0 3px rgba(26,71,42,0.1);
        }
        
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--trek-text);
            margin-bottom: 6px;
        }
        
        /* ============ ALERT ============ */
        .alert-trek {
            padding: 14px 18px;
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid transparent;
        }
        
        .alert-success-trek { background: #dcfce7; color: #166534; border-color: #bbf7d0; }
        .alert-danger-trek  { background: #fee2e2; color: #991b1b; border-color: #fecaca; }
        
        /* ============ RESPONSIVE ============ */
        @media (max-width: 992px) {
            .admin-sidebar { transform: translateX(-100%); transition: transform 0.2s; }
            .admin-sidebar.open { transform: translateX(0); }
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

    <!-- SIDEBAR -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="TrekNesia">
            @else
                <span class="sidebar-brand-text">
                    <i class="fas fa-mountain"></i> Trek<span style="color:var(--trek-accent)">Nesia</span>
                </span>
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
                <button type="submit">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="admin-main">
        <div class="admin-topbar">
            <h5>@yield('page-title', 'Dashboard')</h5>
            <div class="admin-user">
                <span class="admin-user-name d-none d-md-inline">{{ session('admin_name') }}</span>
                <div class="admin-user-avatar">
                    {{ strtoupper(substr(session('admin_name') ?? 'A', 0, 1)) }}
                </div>
            </div>
        </div>
        
        <div class="admin-content">
            @if(session('success'))
                <div class="alert-trek alert-success-trek">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert-trek alert-danger-trek">
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