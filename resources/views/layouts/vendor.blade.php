<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Vendor') — SatuJiwa</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Nunito:wght@300;400;500;600&display=swap" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>

/* ══════════════════════════════════════════
   SATUJIWA VENDOR DASHBOARD — DUSTY ROSE & GOLD
   ══════════════════════════════════════════ */

:root {
    --rose:         #C9788A;
    --rose-light:   #E8B4BE;
    --rose-pale:    #F5D9DE;
    --rose-blush:   #FDF0F2;
    --gold:         #C9A06A;
    --gold-light:   #E8D0A0;
    --gold-dark:    #9A7040;
    --cream:        #FDF8F3;
    --warm-white:   #FFFAF7;
    --surface:      #FFF8F5;
    --card:         rgba(255,255,255,0.78);
    --card-solid:   #FFFFFF;
    --text-dark:    #4A3040;
    --text-mid:     #7A5868;
    --text-soft:    rgba(74,48,64,0.5);
    --border:       rgba(201,120,138,0.18);
    --border-rose:  rgba(201,120,138,0.35);
    --input-bg:     rgba(255,255,255,0.72);
    --green:        #4A8C6A;
    --red:          #C05060;
    --muted:        #9A7888;
}

* { margin:0; padding:0; box-sizing:border-box; }

body {
    background: var(--surface);
    color: var(--text-dark);
    font-family: 'Nunito', sans-serif;
    font-weight: 300;
    min-height: 100vh;
}

body::before {
    content: '';
    position: fixed; inset: 0; z-index: 0; pointer-events: none;
    background:
        radial-gradient(ellipse 70% 50% at 0%   0%,  rgba(232,180,190,0.28) 0%, transparent 60%),
        radial-gradient(ellipse 50% 45% at 100% 5%,  rgba(201,160,106,0.14) 0%, transparent 55%),
        radial-gradient(ellipse 55% 50% at 90% 100%, rgba(232,180,190,0.18) 0%, transparent 60%),
        linear-gradient(155deg, #FFF5F7 0%, #FDF8F3 55%, #FFFAF5 100%);
}

/* ── TOPBAR ── */
.topbar {
    position: fixed; top: 0; left: 0; right: 0;
    height: 56px;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center;
    padding: 0 20px;
    justify-content: space-between;
    z-index: 100;
    box-shadow: 0 2px 20px rgba(201,120,138,0.07);
}

.topbar::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, var(--rose-light), var(--gold-light), var(--rose-light), transparent);
}

.topbar-logo {
    font-family: 'Cormorant Garamond', serif;
    font-size: 19px;
    font-weight: 400;
    letter-spacing: 3px;
    color: var(--rose);
    text-decoration: none;
}
.topbar-logo span { font-style: italic; color: var(--gold); }

.topbar-right {
    display: flex; align-items: center; gap: 10px;
}

.topbar-user {
    font-size: 12px;
    color: var(--text-soft);
}

.btn-logout {
    background: none; border: 1px solid var(--border); border-radius: 50px;
    color: var(--text-soft); cursor: pointer;
    font-size: 11px; font-family: 'Nunito', sans-serif;
    transition: all 0.25s; flex-shrink: 0;
}
.btn-logout span { display: inline; }
@media(max-width: 480px) {
    .btn-logout span { display: none; }
    .btn-logout { padding: 8px; border-radius: 50%; }
    .topbar-user { display: none; }
}
.btn-logout:hover { color: var(--rose); border-color: var(--border-rose); }

/* ── TABS BAR ── */
.tabs-bar {
    position: fixed; top: 56px; left: 0; right: 0;
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--border);
    display: flex; padding: 0 16px; gap: 2px;
    z-index: 99; overflow-x: auto; scrollbar-width: none;
}
.tabs-bar::-webkit-scrollbar { display: none; }

.tab {
    padding: 10px 14px;
    border-radius: 6px 6px 0 0;
    cursor: pointer;
    font-size: 11px; font-weight: 500; letter-spacing: 0.3px;
    color: var(--text-soft);
    white-space: nowrap; text-decoration: none;
    display: inline-flex; align-items: center; gap: 5px;
    transition: all 0.2s;
    border-bottom: 2px solid transparent;
    margin-bottom: -1px;
}
.tab:hover { color: var(--rose); background: rgba(201,120,138,0.04); }
.tab.active {
    color: var(--rose);
    border-bottom-color: var(--rose);
    background: rgba(201,120,138,0.06);
}
.tab svg { opacity: 0.7; transition: opacity 0.2s; }
.tab:hover svg, .tab.active svg { opacity: 1; }

/* ── MAIN CONTENT ── */
.content {
    position: relative; z-index: 1;
    padding-top: 116px;
    max-width: 900px;
    margin: 0 auto;
    padding-left: 20px; padding-right: 20px;
    padding-bottom: 80px;
}

/* ── SECTION CARDS ── */
.section-card {
    background: var(--card);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(201,120,138,0.14);
    border-radius: 14px;
    margin-bottom: 14px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(201,120,138,0.06);
    transition: box-shadow 0.3s;
}
.section-card:hover {
    box-shadow: 0 6px 28px rgba(201,120,138,0.1);
}

.section-head {
    padding: 14px 20px;
    border-bottom: 1px solid rgba(201,120,138,0.1);
    display: flex; align-items: center; justify-content: space-between;
    background: rgba(255,255,255,0.45);
}
.section-head h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 17px; font-weight: 400;
    color: var(--text-dark);
}

.section-body { padding: 20px; }

/* ── FORM ELEMENTS ── */
.form-group { margin-bottom: 14px; }
.form-group:last-child { margin-bottom: 0; }

label {
    display: block;
    font-size: 10px; color: var(--text-mid);
    text-transform: uppercase; letter-spacing: 1.5px;
    margin-bottom: 6px; font-weight: 500;
}

.input, .textarea, .select {
    width: 100%;
    background: var(--input-bg);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 10px 13px;
    color: var(--text-dark);
    font-size: 13px; font-family: 'Nunito', sans-serif; font-weight: 400;
    outline: none;
    transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
}
.input:focus, .textarea:focus, .select:focus {
    border-color: var(--rose);
    background: rgba(255,255,255,0.95);
    box-shadow: 0 0 0 3px rgba(201,120,138,0.1);
}
.input::placeholder { color: rgba(74,48,64,0.28); }

.btn-primary {
    background: linear-gradient(135deg, #C9788A 0%, #B05A70 100%);
    border: none; border-radius: 50px;
    padding: 10px 28px;
    color: #fff; font-weight: 600; font-size: 12px;
    letter-spacing: 1.5px; text-transform: uppercase;
    cursor: pointer; font-family: 'Nunito', sans-serif;
    transition: all 0.3s;
    box-shadow: 0 4px 14px rgba(201,120,138,0.3);
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(201,120,138,0.4); }

.badge {
    display: inline-flex; align-items: center;
    padding: 3px 10px; border-radius: 50px;
    font-size: 10px; font-weight: 600; letter-spacing: 1px;
}
.badge-active  { background: rgba(74,140,106,0.12); color: var(--green); }
.badge-expired { background: rgba(192,80,96,0.1);  color: var(--red); }
.badge-pending { background: rgba(201,120,138,0.1); color: var(--rose); }

/* ── STATS CARDS ── */
.stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:20px; }
.stat-card  {
    background:var(--card);
    backdrop-filter: blur(10px);
    border:1px solid var(--border);
    border-radius:14px;
    padding:16px 12px;
    text-align:center;
    box-shadow:0 4px 15px rgba(201,120,138,0.05);
}
.stat-val  { font-family:'Cormorant Garamond',serif; font-size:30px; color:var(--rose); line-height:1; }
.stat-lbl  { font-size:10px; color:var(--text-soft); letter-spacing:1px; margin-top:5px; text-transform:uppercase; }

/* ── RESPONSIVE GRIDS ── */
.vdr-grid-2-1 {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 20px;
    align-items: start;
}
@media(max-width: 1000px) {
    .vdr-grid-2-1 { grid-template-columns: 1fr; }
}

.vdr-report-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 24px;
}
@media(max-width: 900px) {
    .vdr-report-grid { grid-template-columns: 1fr; }
}

/* ── RESPONSIVE ── */
@media(max-width:768px){
    .stats-grid { grid-template-columns: repeat(2,1fr); }
    .content { padding-top: 100px; padding-left: 15px; padding-right: 15px; }
    .topbar-logo { letter-spacing: 1.5px; font-size: 17px; }
}
@media(max-width:480px){
    .stats-grid { grid-template-columns: 1fr; }
    .topbar-logo { letter-spacing: 1px; font-size: 16px; }
}
</style>
</head>
<body>

<div class="topbar">
    <a href="{{ route('vendor.index') }}" class="topbar-logo">Satu<span>Jiwa</span></a>
    <div class="topbar-right">
        <span class="topbar-user">Vendor: {{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" style="margin:0">
            @csrf
            <button class="btn-logout" style="display:flex; align-items:center; gap:5px;">
                <i data-lucide="log-out" style="width:14px; height:14px;"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</div>

<div class="tabs-bar">
    @php $tab = request('tab'); @endphp
    <a href="{{ route('vendor.index') }}?tab=pelanggan" class="tab {{ ($tab == 'pelanggan' || (!$tab && request()->routeIs('vendor.index'))) ? 'active' : '' }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        Pelanggan
    </a>
    <a href="{{ route('vendor.index') }}?tab=buat" class="tab {{ $tab == 'buat' ? 'active' : '' }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
        Buat Akaun
    </a>
    <a href="{{ route('vendor.index') }}?tab=report" class="tab {{ $tab == 'report' ? 'active' : '' }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
        Laporan
    </a>
    <a href="{{ route('vendor.profile') }}" class="tab {{ request()->routeIs('vendor.profile') ? 'active' : '' }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Profil
    </a>
</div>

<div class="content">
    @if(session('success'))
        <div class="alert alert-success" style="padding: 12px 16px; border-radius: 10px; margin-bottom: 14px; font-size: 13px; background: rgba(74,140,106,0.08); border: 1px solid rgba(74,140,106,0.22); color: var(--green);">
            {{ session('success') }}
        </div>
    @endif
    @yield('content')
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();
</script>

</body>
</html>
