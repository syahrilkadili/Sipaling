<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'SIPALING') - Sistem Laporan Lingkungan Kampus</title>
    <meta name="description" content="SIPALING - Sistem Pelaporan Lingkungan Kampus Digital"/>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <!-- Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>

    <style>
        :root {
            --primary: #059669;
            --primary-dark: #047857;
            --primary-darker: #065f46;
            --primary-light: #d1fae5;
            --primary-glow: rgba(5,150,105,0.25);
            --accent: #10b981;
            --accent-light: #34d399;
            --sidebar-width: 272px;
            --sidebar-bg: linear-gradient(175deg, #064e3b 0%, #022c22 100%);
            --body-bg: #f0fdf4;
            --card-bg: rgba(255,255,255,0.85);
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: rgba(16,185,129,0.12);
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 20px rgba(0,0,0,0.08);
            --shadow-lg: 0 12px 40px rgba(0,0,0,0.12);
            --shadow-glow: 0 0 30px var(--primary-glow);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 20px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--body-bg);
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(16,185,129,0.06) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(5,150,105,0.04) 0%, transparent 50%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Scrollbar ────────────────────────────────────────────────── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(5,150,105,0.25); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(5,150,105,0.4); }

        /* ── Sidebar ──────────────────────────────────────────────────── */
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh;
            width: var(--sidebar-width); z-index: 1000;
            background: var(--sidebar-bg);
            display: flex; flex-direction: column;
            box-shadow: 4px 0 30px rgba(0,0,0,0.2);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }
        .sidebar::before {
            content: ''; position: absolute; inset: 0; z-index: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(16,185,129,0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(52,211,153,0.08) 0%, transparent 40%);
            pointer-events: none;
        }
        .sidebar > * { position: relative; z-index: 1; }

        .sidebar-brand {
            padding: 28px 24px 22px; border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-brand .logo-icon {
            width: 44px; height: 44px; border-radius: 14px;
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; box-shadow: 0 4px 15px rgba(16,185,129,0.4);
            animation: pulse-glow 3s ease-in-out infinite;
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 4px 15px rgba(16,185,129,0.4); }
            50% { box-shadow: 0 4px 25px rgba(16,185,129,0.6); }
        }
        .sidebar-brand .logo-text {
            font-size: 1.4rem; font-weight: 800; color: #fff;
            letter-spacing: 1.5px; line-height: 1;
        }
        .sidebar-brand .logo-sub {
            font-size: 0.68rem; color: rgba(255,255,255,0.5);
            margin-top: 3px; letter-spacing: 0.5px;
        }

        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
        .nav-section-title {
            font-size: 0.62rem; font-weight: 700; letter-spacing: 2px;
            text-transform: uppercase; color: rgba(255,255,255,0.3);
            padding: 16px 14px 8px; margin-top: 4px;
        }
        .nav-item a {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 16px; color: rgba(255,255,255,0.6);
            text-decoration: none; border-radius: var(--radius-sm);
            font-size: 0.88rem; font-weight: 500;
            transition: var(--transition); margin-bottom: 2px;
            position: relative; overflow: hidden;
        }
        .nav-item a::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(16,185,129,0.2), rgba(52,211,153,0.1));
            opacity: 0; transition: opacity 0.3s ease;
            border-radius: inherit;
        }
        .nav-item a:hover { color: #fff; transform: translateX(4px); }
        .nav-item a:hover::before { opacity: 1; }
        .nav-item a.active {
            color: #fff; background: linear-gradient(135deg, rgba(16,185,129,0.25), rgba(52,211,153,0.15));
            box-shadow: 0 2px 12px rgba(16,185,129,0.2);
        }
        .nav-item a.active::after {
            content: ''; position: absolute; right: 0; top: 50%; transform: translateY(-50%);
            width: 3px; height: 60%; border-radius: 3px;
            background: var(--accent-light);
        }
        .nav-item a i { font-size: 1.1rem; width: 22px; text-align: center; flex-shrink: 0; }
        .nav-item a .badge {
            margin-left: auto; font-size: 0.7rem; padding: 3px 8px;
            border-radius: 20px; font-weight: 600;
        }

        .sidebar-footer {
            padding: 18px 20px; border-top: 1px solid rgba(255,255,255,0.08);
            background: rgba(0,0,0,0.15); backdrop-filter: blur(10px);
        }
        .user-info { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
        .user-avatar {
            width: 40px; height: 40px; border-radius: 12px;
            background: linear-gradient(135deg, var(--accent), #6ee7b7);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 1rem; color: #fff;
            flex-shrink: 0; box-shadow: 0 3px 10px rgba(16,185,129,0.3);
        }
        .user-name { font-size: 0.85rem; font-weight: 600; color: #fff; line-height: 1.2; }
        .user-role {
            font-size: 0.65rem; color: var(--accent-light);
            background: rgba(16,185,129,0.15); padding: 2px 8px;
            border-radius: 20px; display: inline-block; margin-top: 3px;
            border: 1px solid rgba(16,185,129,0.2);
        }
        .btn-logout {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.7); border-radius: var(--radius-sm);
            font-size: 0.82rem; font-weight: 500; padding: 9px 16px;
            transition: var(--transition); width: 100;
        }
        .btn-logout:hover {
            background: rgba(239,68,68,0.15); border-color: rgba(239,68,68,0.3);
            color: #fca5a5;
        }

        /* ── Main Content ─────────────────────────────────────────────── */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh; display: flex; flex-direction: column;
        }
        .topbar {
            background: rgba(255,255,255,0.7); backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 16px 32px;
            border-bottom: 1px solid var(--border-color);
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }
        .topbar-title {
            font-size: 1.15rem; font-weight: 700; color: var(--text-dark);
            display: flex; align-items: center; gap: 10px;
        }
        .topbar-title::before {
            content: ''; width: 4px; height: 22px;
            background: linear-gradient(180deg, var(--accent), var(--primary));
            border-radius: 4px;
        }
        .topbar-date {
            display: flex; align-items: center; gap: 8px;
            font-size: 0.82rem; color: var(--text-muted); font-weight: 500;
            background: rgba(16,185,129,0.06); padding: 6px 14px;
            border-radius: 20px; border: 1px solid var(--border-color);
        }

        .page-content { padding: 28px 32px; flex: 1; width: 100%; max-width: 100%; overflow-x: hidden; }

        /* ── Cards ────────────────────────────────────────────────────── */
        .card {
            background: var(--card-bg); backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }
        .card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
        .card-header {
            background: transparent; border-bottom: 1px solid var(--border-color);
            font-weight: 700; padding: 18px 24px; font-size: 0.92rem;
            color: var(--text-dark);
        }
        .card-body { padding: 24px; }

        /* ── Stat Cards ───────────────────────────────────────────────── */
        .stat-card {
            border-radius: var(--radius-lg); padding: 26px; color: #fff;
            position: relative; overflow: hidden;
            transition: var(--transition);
            cursor: default;
        }
        .stat-card:hover { transform: translateY(-6px) scale(1.02); }
        .stat-card::before {
            content: ''; position: absolute; right: -30px; top: -30px;
            width: 120px; height: 120px; border-radius: 50%;
            background: rgba(255,255,255,0.1);
            transition: var(--transition);
        }
        .stat-card:hover::before { transform: scale(1.3); }
        .stat-card::after {
            content: ''; position: absolute; left: -20px; bottom: -20px;
            width: 80px; height: 80px; border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }
        .stat-card .stat-icon {
            font-size: 2rem; margin-bottom: 12px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        .stat-card .stat-value {
            font-size: 2.4rem; font-weight: 800; line-height: 1;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-card .stat-label {
            font-size: 0.8rem; opacity: 0.85; margin-top: 6px; font-weight: 500;
        }
        .bg-green-grad   { background: linear-gradient(135deg, #059669 0%, #34d399 100%); box-shadow: 0 8px 25px rgba(5,150,105,0.3); }
        .bg-orange-grad  { background: linear-gradient(135deg, #d97706 0%, #fbbf24 100%); box-shadow: 0 8px 25px rgba(217,119,6,0.3); }
        .bg-blue-grad    { background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%); box-shadow: 0 8px 25px rgba(37,99,235,0.3); }
        .bg-red-grad     { background: linear-gradient(135deg, #dc2626 0%, #f87171 100%); box-shadow: 0 8px 25px rgba(220,38,38,0.3); }
        .bg-purple-grad  { background: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%); box-shadow: 0 8px 25px rgba(124,58,237,0.3); }
        .bg-teal-grad    { background: linear-gradient(135deg, #0d9488 0%, #5eead4 100%); box-shadow: 0 8px 25px rgba(13,148,136,0.3); }

        /* ── Badges ───────────────────────────────────────────────────── */
        .badge {
            font-size: 0.72rem; font-weight: 600; padding: 5px 12px;
            border-radius: 20px; letter-spacing: 0.3px;
        }

        /* ── Tables ───────────────────────────────────────────────────── */
        .table { font-size: 0.87rem; }
        .table th {
            font-weight: 700; color: var(--text-muted);
            background: rgba(16,185,129,0.04);
            font-size: 0.78rem; text-transform: uppercase;
            letter-spacing: 0.5px; padding: 14px 16px;
            border-bottom: 2px solid var(--border-color);
        }
        .table td {
            padding: 14px 16px; vertical-align: middle;
            border-bottom: 1px solid rgba(0,0,0,0.04);
        }
        .table-hover tbody tr {
            transition: var(--transition);
        }
        .table-hover tbody tr:hover {
            background: rgba(16,185,129,0.04);
        }

        /* ── Buttons ──────────────────────────────────────────────────── */
        .btn-green {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff; border: none; font-weight: 600;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(5,150,105,0.3);
        }
        .btn-green:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5,150,105,0.4);
            color: #fff;
        }
        .btn-green:active { transform: translateY(0); }

        .btn-outline-primary {
            border-color: var(--primary); color: var(--primary);
            border-radius: var(--radius-sm);
        }
        .btn-outline-primary:hover {
            background: var(--primary); border-color: var(--primary);
        }

        /* ── Form Controls ────────────────────────────────────────────── */
        .form-control, .form-select {
            border: 2px solid rgba(16,185,129,0.15);
            border-radius: var(--radius-sm); padding: 11px 16px;
            font-size: 0.9rem; transition: var(--transition);
            background: rgba(255,255,255,0.8);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-glow);
            background: #fff;
        }
        .form-label { font-weight: 600; font-size: 0.85rem; color: var(--text-dark); margin-bottom: 6px; }

        /* ── Alerts ────────────────────────────────────────────────────── */
        .alert {
            border: none; border-radius: var(--radius-md);
            font-size: 0.88rem; font-weight: 500;
            animation: slideDown 0.4s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
        }
        .alert-danger {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
        }

        /* ── Animations ───────────────────────────────────────────────── */
        .fade-in { animation: fadeIn 0.5s ease; }
        @keyframes fadeIn { from { opacity:0; transform: translateY(15px); } to { opacity:1; transform: translateY(0); } }
        .stagger-1 { animation-delay: 0.05s; }
        .stagger-2 { animation-delay: 0.1s; }
        .stagger-3 { animation-delay: 0.15s; }
        .stagger-4 { animation-delay: 0.2s; }

        /* ── Progress ─────────────────────────────────────────────────── */
        .progress {
            border-radius: 20px; overflow: hidden;
            background: rgba(16,185,129,0.08);
        }
        .progress-bar {
            border-radius: 20px;
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ── Pagination ───────────────────────────────────────────────── */
        .pagination { gap: 4px; }
        .page-link {
            border-radius: var(--radius-sm) !important;
            border: 1px solid var(--border-color);
            color: var(--primary); font-weight: 500; font-size: 0.85rem;
            padding: 8px 14px; transition: var(--transition);
        }
        .page-link:hover { background: var(--primary-light); border-color: var(--primary); }
        .page-item.active .page-link {
            background: var(--primary); border-color: var(--primary);
        }

        /* ── Mobile ───────────────────────────────────────────────────── */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); z-index: 999;
            backdrop-filter: blur(4px);
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .sidebar.show + .sidebar-overlay { display: block; }
            .main-content { margin-left: 0; width: 100%; }
            .page-content { padding: 20px 16px; }
            .topbar { padding: 12px 16px; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="d-flex">
    <!-- ── Sidebar ─────────────────────────────────────────────────── -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="d-flex align-items-center gap-3">
                <div class="logo-icon">🌿</div>
                <div>
                    <div class="logo-text">SIPALING</div>
                    <div class="logo-sub">Laporan Lingkungan Kampus</div>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            @yield('sidebar-nav')
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? auth()->user()->username, 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ auth()->user()->name ?? auth()->user()->username }}</div>
                    <span class="user-role">{{ ucfirst(auth()->user()->role) }}</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout w-100">
                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- ── Main Content ───────────────────────────────────────────── -->
    <div class="main-content" id="mainContent">
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-light d-md-none" onclick="toggleSidebar()" style="border-radius:10px">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
            </div>
            <div class="topbar-date">
                <i class="bi bi-calendar3"></i>
                {{ now()->translatedFormat('l, d M Y') }}
            </div>
        </header>

        <main class="page-content">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <span>{{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }
    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebar');
        if (window.innerWidth <= 768 && !sidebar.contains(e.target) && !e.target.closest('[onclick="toggleSidebar()"]')) {
            sidebar.classList.remove('show');
        }
    });

    // Animate elements on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.stat-card, .card').forEach(el => observer.observe(el));
    });

    // Auto-dismiss alerts
    setTimeout(() => {
        document.querySelectorAll('.alert-dismissible').forEach(a => {
            new bootstrap.Alert(a).close();
        });
    }, 5000);
</script>
@stack('scripts')
</body>
</html>
