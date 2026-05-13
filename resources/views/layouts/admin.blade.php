<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin') — SatuJiwa</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Nunito:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
:root {
    --pink:        #E8678A;
    --pink-light:  #F5A8BE;
    --pink-soft:   #FDEEF3;
    --gold:        #C9A06A;
    --gold-light:  #E8D0A0;
    --bg:          #FDF0F5;
    --surface:     #FDF0F5;
    --card:        #FFFFFF;
    --text:        #3D1A28;
    --text-dark:   #4A3040;
    --muted:       rgba(61,26,40,0.45);
    --border:      rgba(232,103,138,0.18);
    --green:       #4A8C6A;
    --red:         #C05060;
    --sidebar-w:   260px;
    --sidebar-collapsed-w: 80px;
}

* { margin:0; padding:0; box-sizing:border-box; }

body {
    background: var(--surface);
    color: var(--text);
    font-family: 'Nunito', sans-serif;
    min-height: 100vh;
    display: flex;
}

/* ── SIDEBAR ── */
.adm-sidebar {
    width: var(--sidebar-w);
    background: #fff;
    border-right: 1px solid var(--border);
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 100;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
}

.body-collapsed .adm-sidebar {
    width: var(--sidebar-collapsed-w);
}

.sidebar-header {
    padding: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid var(--border);
}
.sidebar-logo {
    font-family: 'Cormorant Garamond', serif;
    font-size: 24px;
    font-weight: 700;
    color: var(--pink);
    text-decoration: none;
    white-space: nowrap;
    overflow: hidden;
    transition: 0.3s;
}
.body-collapsed .sidebar-logo {
    opacity: 0;
    width: 0;
}

.sidebar-toggle {
    background: none;
    border: none;
    color: var(--pink);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4px;
    border-radius: 8px;
    transition: 0.2s;
}
.sidebar-toggle:hover { background: var(--pink-soft); }

.sidebar-nav {
    padding: 20px 12px;
    flex: 1;
    overflow-y: auto;
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 12px 14px;
    color: var(--muted);
    text-decoration: none;
    border-radius: 12px;
    margin-bottom: 4px;
    transition: all 0.2s;
    white-space: nowrap;
    gap: 12px;
}
.nav-item:hover {
    background: var(--pink-soft);
    color: var(--pink);
}
.nav-item.active {
    background: var(--pink);
    color: #fff;
    box-shadow: 0 4px 12px rgba(232,103,138,0.2);
}
.nav-item i { flex-shrink: 0; }
.nav-text {
    font-size: 14px;
    font-weight: 600;
    transition: 0.3s;
}
.body-collapsed .nav-text {
    opacity: 0;
    pointer-events: none;
}

.sidebar-footer {
    padding: 20px 12px;
    border-top: 1px solid var(--border);
}

/* ── MAIN CONTENT ── */
.adm-main {
    flex: 1;
    margin-left: var(--sidebar-w);
    padding: 40px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.body-collapsed .adm-main {
    margin-left: var(--sidebar-collapsed-w);
}

/* ── SHARED STYLES (From previous) ── */
.adm-page-header { margin-bottom: 28px; }
.adm-page-header h2 { font-family: 'Cormorant Garamond', serif; font-size: 30px; color: var(--pink); font-weight: 400; }
.adm-page-header p { color: var(--muted); font-size: 13px; margin-top: 4px; }

.adm-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 28px; }
.adm-stat { background: var(--card); border: 1px solid var(--border); border-radius: 14px; padding: 20px; display: flex; align-items: center; gap: 15px; box-shadow: 0 4px 15px rgba(232,103,138,0.05); }
.adm-stat-icon { width: 42px; height: 42px; background: rgba(232,103,138,0.08); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--pink); }
.adm-stat--green .adm-stat-icon { background: rgba(74,140,106,0.08); color: var(--green); }
.adm-stat--red .adm-stat-icon { background: rgba(192,80,96,0.08); color: var(--red); }
.adm-stat--gold .adm-stat-icon { background: rgba(201,160,106,0.08); color: var(--gold); }
.adm-stat-val { font-family: 'Cormorant Garamond', serif; font-size: 28px; color: var(--text-dark); line-height: 1; }
.adm-stat-lbl { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px; }

.adm-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(232,103,138,0.05); }
.adm-card-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; background: linear-gradient(90deg, rgba(232,103,138,0.04), transparent); }
.adm-card-header h3 { font-family: 'Cormorant Garamond', serif; font-size: 18px; color: var(--pink); }

.input, .select { width: 100%; border: 1px solid var(--border); border-radius: 10px; padding: 10px 14px; font-size: 13px; outline: none; transition: all 0.2s; background: #fff; }
.input:focus { border-color: var(--pink); box-shadow: 0 0 0 3px rgba(232,103,138,0.08); }

/* ── RESPONSIVE GRIDS ── */
.adm-grid-2-1 {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 24px;
    align-items: start;
}
@media(max-width: 1100px) {
    .adm-grid-2-1 { grid-template-columns: 1fr; }
}

.adm-grid-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}
@media(max-width: 900px) {
    .adm-grid-stats { grid-template-columns: repeat(2, 1fr); gap: 12px; }
}
@media(max-width: 480px) {
    .adm-grid-stats { grid-template-columns: 1fr; }
}

.adm-report-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
}
@media(max-width: 1000px) {
    .adm-report-grid { grid-template-columns: 1fr; }
}

.btn-primary { background: linear-gradient(135deg, #E8678A 0%, #C0446A 100%); color: #fff; border: none; border-radius: 50px; padding: 11px 24px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(232,103,138,0.2); }
.btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(232,103,138,0.3); }
.btn-sm { padding: 6px 14px; font-size: 11px; border-radius: 8px; border: 1px solid var(--border); background: #fff; color: var(--muted); cursor: pointer; transition: all 0.2s; text-decoration:none; display:inline-flex; align-items:center; gap:6px; }
.btn-sm:hover { border-color: var(--pink); color: var(--pink); }
.btn-danger { color: var(--red) !important; border-color: rgba(192,80,96,0.3) !important; }

.pelanggan-list { padding: 15px; }
.pelanggan-item { padding: 16px; border: 1px solid var(--border); border-radius: 12px; margin-bottom: 12px; transition: all 0.2s; background: #fff; }
.pelanggan-item:hover { transform: translateX(4px); border-color: var(--pink); box-shadow: 0 4px 15px rgba(232,103,138,0.08); }
.pelanggan-top { display: flex; justify-content: space-between; align-items: flex-start; }
.pelanggan-name { font-weight: 700; color: var(--text-dark); font-size: 14px; }
.pelanggan-email { font-size: 12px; color: var(--muted); margin-bottom: 4px; }

.badge { padding: 3px 10px; border-radius: 50px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
.badge-active { background: rgba(74,140,106,0.1); color: var(--green); }
.badge-expired { background: rgba(192,80,96,0.1); color: var(--red); }
.badge-pending { background: rgba(232,103,138,0.1); color: var(--pink); }
.adm-badge { background: rgba(232,103,138,0.1); color: var(--pink); padding: 4px 12px; border-radius: 50px; font-size: 11px; font-weight: 600; }

.logout-btn { background: none; border: 1px solid var(--border); border-radius: 50px; padding: 8px 16px; font-size: 11px; color: var(--muted); cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px; width: 100%; justify-content: center; }
.logout-btn:hover { color: var(--red); border-color: var(--red); background: rgba(192,80,96,0.05); }

@media(max-width: 768px) {
    .adm-sidebar { 
        transform: translateX(-100%); 
        box-shadow: 10px 0 30px rgba(0,0,0,0.1);
    }
    .body-sidebar-open .adm-sidebar { transform: translateX(0); }
    .adm-main { margin-left: 0 !important; padding: 20px; padding-top: 80px; }
    
    .mobile-topbar {
        display: flex !important;
        position: fixed; top: 0; left: 0; right: 0;
        height: 60px; background: #fff;
        border-bottom: 1px solid var(--border);
        z-index: 90; align-items: center; padding: 0 20px;
        justify-content: space-between;
    }
}
.mobile-topbar { display: none; }

.sidebar-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,0.3);
    z-index: 95; display: none;
    backdrop-filter: blur(2px);
}
.body-sidebar-open .sidebar-overlay { display: block; }
</style>
</head>
<body class="{{ session('sidebar_collapsed') ? 'body-collapsed' : '' }}">

@php $activeTab = request('tab', 'pelanggan'); @endphp

<div class="mobile-topbar">
    <a href="{{ route('admin.index') }}" style="font-family:'Cormorant Garamond',serif; font-size:20px; font-weight:700; color:var(--pink); text-decoration:none;">SatuJiwa Admin</a>
    <button class="sidebar-toggle" onclick="toggleMobileSidebar()">
        <i data-lucide="menu"></i>
    </button>
</div>

<div class="sidebar-overlay" onclick="toggleMobileSidebar()"></div>

<div class="adm-sidebar">

    <div class="sidebar-header">
        <a href="{{ route('admin.index') }}" class="sidebar-logo">SatuJiwa Admin</a>
        <button class="sidebar-toggle" onclick="toggleSidebar()">
            <i data-lucide="menu"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <a href="?tab=pelanggan" class="nav-item {{ $activeTab=='pelanggan'?'active':'' }}">
            <i data-lucide="users-2"></i>
            <span class="nav-text">Senarai Pelanggan</span>
        </a>
        <a href="?tab=buat" class="nav-item {{ $activeTab=='buat'?'active':'' }}">
            <i data-lucide="user-plus"></i>
            <span class="nav-text">Buat Akaun</span>
        </a>
        <a href="?tab=vendor" class="nav-item {{ $activeTab=='vendor'?'active':'' }}">
            <i data-lucide="building-2"></i>
            <span class="nav-text">Pengurusan Vendor</span>
        </a>
        <a href="?tab=template" class="nav-item {{ $activeTab=='template'?'active':'' }}">
            <i data-lucide="layout-template"></i>
            <span class="nav-text">Katalog Template</span>
        </a>
        <a href="?tab=report" class="nav-item {{ $activeTab=='report'?'active':'' }}">
            <i data-lucide="bar-chart-3"></i>
            <span class="nav-text">Laporan & Statistik</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div style="font-size:12px; color:var(--muted); text-align:center; margin-bottom:12px;" class="nav-text">
            {{ auth()->user()->name }}
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i data-lucide="log-out" style="width:14px; height:14px;"></i>
                <span class="nav-text">Log Keluar</span>
            </button>
        </form>
    </div>
</div>

<main class="adm-main">
    @yield('content')
</main>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();

  function toggleSidebar() {
      document.body.classList.toggle('body-collapsed');
  }

  function toggleMobileSidebar() {
      document.body.classList.toggle('body-sidebar-open');
  }
</script>

</body>
</html>
