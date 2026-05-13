<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Dashboard') — SatuJiwa</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Nunito:wght@300;400;500;600&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
/* ══════════════════════════════════════════
   SATUJIWA DASHBOARD — DUSTY ROSE & GOLD
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
    --card:         rgba(255,255,255,0.94);
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

/* ── BG LAYER ── */
.bg-layer {
    position: fixed; inset: 0; z-index: 0; pointer-events: none;
    background:
        radial-gradient(ellipse 70% 50% at 0%   0%,  rgba(232,180,190,0.28) 0%, transparent 60%),
        radial-gradient(ellipse 50% 45% at 100% 5%,  rgba(201,160,106,0.14) 0%, transparent 55%),
        radial-gradient(ellipse 55% 50% at 90% 100%, rgba(232,180,190,0.18) 0%, transparent 60%),
        linear-gradient(155deg, #FFF5F7 0%, #FDF8F3 55%, #FFFAF5 100%);
    will-change: transform;
    transform: translateZ(0);
    backface-visibility: hidden;
    isolation: isolate;
    contain: strict;
}

/* ── TOPBAR ── */
.topbar {
    position: fixed; top: 0; left: 0; right: 0;
    height: 56px;
    background: #ffffff;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center;
    padding: 0 20px;
    justify-content: space-between;
    z-index: 100;
    box-shadow: 0 2px 20px rgba(201,120,138,0.07);
    will-change: transform;
    transform: translateZ(0);
    backface-visibility: hidden;
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

/* ── CUSTOMER SERVICE BUTTON ── */
.cs-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 32px; height: 32px; border-radius: 50%;
    background: rgba(37,211,102,0.1);
    border: 1px solid rgba(37,211,102,0.3);
    color: #25D366;
    text-decoration: none;
    transition: all 0.3s;
    flex-shrink: 0;
}
.cs-btn:hover {
    background: rgba(37,211,102,0.2);
    border-color: #25D366;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37,211,102,0.25);
}

.preview-btn {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(201,120,138,0.08);
    border: 1px solid var(--border-rose);
    border-radius: 50px;
    padding: 6px 14px;
    color: var(--rose);
    font-size: 11px; font-weight: 500; letter-spacing: 0.5px;
    cursor: pointer; text-decoration: none;
    transition: all 0.3s;
    font-family: 'Nunito', sans-serif;
}
.preview-btn:hover {
    background: rgba(201,120,138,0.16);
    border-color: var(--rose);
    transform: translateY(-1px);
}

.topbar-user {
    font-size: 12px;
    color: var(--text-soft);
}

.btn-logout {
    background: none; border: 1px solid var(--border); border-radius: 50px;
    color: var(--text-soft); cursor: pointer;
    font-size: 11px; font-family: 'Nunito', sans-serif;
    letter-spacing: 0.5px; padding: 6px 14px;
    transition: all 0.25s;
}
.btn-logout:hover { color: var(--rose); border-color: var(--border-rose); }

/* ── TABS BAR ── */
.tabs-bar {
    position: fixed; top: 56px; left: 0; right: 0;
    background: #ffffff;
    border-bottom: 1px solid var(--border);
    display: flex; padding: 0 16px; gap: 2px;
    z-index: 99; overflow-x: auto; scrollbar-width: none;
    will-change: transform;
    transform: translateZ(0);
    backface-visibility: hidden;
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
.tab span { display: inline; }
@media(max-width: 768px) {
    .tab { padding: 10px 12px; }
    .tab span { display: none; }
}
.tab svg { opacity: 0.7; transition: opacity 0.2s; }
.tab:hover svg, .tab.active svg { opacity: 1; }

/* ── MAIN CONTENT ── */
.content {
    position: relative; z-index: 1;
    padding-top: 116px;
    max-width: 800px;
    margin: 0 auto;
    padding-left: 20px; padding-right: 20px;
    padding-bottom: 80px;
}

/* ── SECTION CARDS ── */
.section-card {
    background: rgba(255,255,255,0.94);
    border: 1px solid rgba(201,120,138,0.14);
    border-radius: 14px;
    margin-bottom: 14px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(201,120,138,0.06);
    transition: box-shadow 0.3s;
    will-change: transform;
    transform: translateZ(0);
    backface-visibility: hidden;
    contain: layout style paint;
}
.section-card:hover {
    box-shadow: 0 6px 28px rgba(201,120,138,0.1);
}

.section-head {
    padding: 14px 20px;
    border-bottom: 1px solid rgba(201,120,138,0.1);
    display: flex; align-items: center; justify-content: space-between;
    background: rgba(255,255,255,0.6);
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
    -webkit-appearance: none;
}
.input:focus, .textarea:focus, .select:focus {
    border-color: var(--rose);
    background: rgba(255,255,255,0.95);
    box-shadow: 0 0 0 3px rgba(201,120,138,0.1);
}
.input::placeholder, .textarea::placeholder { color: rgba(74,48,64,0.28); }
.textarea { resize: vertical; min-height: 80px; line-height: 1.6; }
.select { cursor: pointer; }
.select option { background: #fff; color: var(--text-dark); }

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

input[type="radio"], input[type="checkbox"] { accent-color: var(--rose); }

/* ── TOGGLE SWITCH ── */
.switch { position: relative; display: inline-block; width: 40px; height: 22px; flex-shrink: 0; }
.switch input { opacity: 0; width: 0; height: 0; }
.slider {
    position: absolute; cursor: pointer; inset: 0;
    background: rgba(201,120,138,0.15); border-radius: 22px;
    transition: .3s; border: 1px solid var(--border);
}
.slider:before {
    position: absolute; content: ""; height: 16px; width: 16px;
    left: 2px; bottom: 2px; background: var(--text-soft);
    border-radius: 50%; transition: .3s;
}
.switch input:checked + .slider { background: rgba(201,120,138,0.2); border-color: var(--rose-light); }
.switch input:checked + .slider:before { transform: translateX(18px); background: var(--rose); }

/* ── UPLOAD ZONE ── */
.upload-zone {
    border: 1.5px dashed rgba(201,120,138,0.28);
    border-radius: 12px; padding: 22px;
    text-align: center; cursor: pointer;
    transition: all 0.25s; position: relative;
    background: rgba(253,240,242,0.35);
}
.upload-zone:hover { border-color: var(--rose); background: rgba(253,240,242,0.6); }
.upload-zone input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
.upload-text { font-size: 13px; color: var(--text-mid); margin-top: 6px; }
.upload-hint { font-size: 11px; color: var(--text-soft); margin-top: 4px; }

/* ── IMAGE GRID ── */
.images-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 8px; margin-top: 12px; }
.img-thumb {
    aspect-ratio: 1; border-radius: 10px; overflow: hidden;
    position: relative; background: var(--rose-blush);
    border: 1px solid var(--border);
}
.img-thumb img { width: 100%; height: 100%; object-fit: cover; }
.img-remove {
    position: absolute; top: 4px; right: 4px;
    background: rgba(192,80,96,0.82); border: none; border-radius: 50%;
    width: 20px; height: 20px; color: white; cursor: pointer;
    font-size: 10px; display: none; align-items: center; justify-content: center;
}
.img-thumb:hover .img-remove { display: flex; }

/* ── SAVE BAR ── */
.save-bar {
    position: fixed; bottom: 0; left: 0; right: 0;
    padding: 11px 20px;
    background: #ffffff;
    border-top: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    z-index: 100;
    box-shadow: 0 -4px 20px rgba(201,120,138,0.07);
    will-change: transform;
    transform: translateZ(0);
    backface-visibility: hidden;
}
.save-status { font-size: 12px; color: var(--text-soft); }

.btn-save {
    background: linear-gradient(135deg, #C9788A 0%, #B05A70 100%);
    border: none; border-radius: 50px;
    padding: 10px 28px;
    color: #fff; font-weight: 600; font-size: 12px;
    letter-spacing: 1.5px; text-transform: uppercase;
    cursor: pointer; font-family: 'Nunito', sans-serif;
    transition: all 0.3s;
    box-shadow: 0 4px 14px rgba(201,120,138,0.3);
}
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(201,120,138,0.4); }
.btn-save:active { transform: none; }

/* ── MISC ── */
.hint { font-size: 11px; color: var(--text-soft); margin-top: 5px; }
.separator { height: 1px; background: var(--border); margin: 16px 0; }

.info-banner {
    background: rgba(201,120,138,0.06);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 11px 16px;
    font-size: 12px; color: var(--text-mid);
    margin-bottom: 14px; line-height: 1.6;
}

.alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 14px; font-size: 13px; }
.alert-success {
    background: rgba(74,140,106,0.08);
    border: 1px solid rgba(74,140,106,0.22);
    color: var(--green);
}

/* ── THEME GRID ── */
.theme-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 8px; margin-bottom: 14px; }
.theme-opt {
    border: 2px solid var(--border); border-radius: 10px;
    padding: 8px; cursor: pointer; text-align: center;
    transition: all 0.25s; font-size: 11px; color: var(--text-mid);
    background: rgba(255,255,255,0.6);
}
.theme-opt:hover, .theme-opt.selected {
    border-color: var(--rose);
    background: rgba(201,120,138,0.06);
    color: var(--rose);
}
.theme-swatch { height: 30px; border-radius: 6px; margin-bottom: 6px; }

/* ── TEMPLATE OPT ── */
.template-opt { transition: all .2s; }
.template-opt:hover { transform: scale(1.03); }
.template-opt.selected { box-shadow: 0 0 0 3px var(--rose) !important; }

/* ── COPY BTN ── */
.copy-btn {
    display: inline-flex; align-items: center; gap: 5px;
    margin-left: 10px; cursor: pointer;
    font-size: 11px; color: var(--rose);
    padding: 3px 10px;
    border: 1px solid var(--border-rose); border-radius: 50px;
    background: rgba(201,120,138,0.07);
    transition: all 0.25px; font-family: 'Nunito', sans-serif;
    vertical-align: middle;
}
.copy-btn:hover { background: rgba(201,120,138,0.16); }

/* ── PAGINATION ── */
.page-nav { display: flex; align-items: center; justify-content: center; gap: 10px; }
.page-nav a {
    background: rgba(201,120,138,0.07);
    border: 1px solid var(--border); border-radius: 8px;
    padding: 7px 16px; color: var(--rose); text-decoration: none;
    font-size: 12px; transition: all 0.25s;
}
.page-nav a:hover { background: rgba(201,120,138,0.15); border-color: var(--rose); }

/* ── RANGE SLIDER ── */
input[type=range] {
    -webkit-appearance: none;
    height: 4px; border-radius: 2px;
    background: var(--border); outline: none; flex: 1;
}
input[type=range]::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 16px; height: 16px; border-radius: 50%;
    background: var(--rose); cursor: pointer;
    box-shadow: 0 2px 8px rgba(201,120,138,0.3);
}

/* ── FONT PREVIEW ── */
.font-preview-box {
    margin-top: 10px; padding: 12px 14px;
    background: rgba(253,240,242,0.4);
    border-radius: 8px; border: 1px solid var(--border);
}

/* ── DATA TABLE ── */
.data-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.data-table th {
    padding: 10px 14px; text-align: left;
    font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase;
    color: var(--text-soft); border-bottom: 1px solid var(--border); font-weight: 500;
}
.data-table td {
    padding: 12px 14px; border-bottom: 1px solid rgba(201,120,138,0.07);
    color: var(--text-dark); vertical-align: top;
}
.data-table tr:last-child td { border-bottom: none; }
.data-table tr:hover td { background: rgba(201,120,138,0.03); }

.badge {
    display: inline-flex; align-items: center;
    padding: 3px 10px; border-radius: 50px;
    font-size: 10px; font-weight: 600; letter-spacing: 1px;
}
.badge-hadir   { background: rgba(74,140,106,0.12); color: var(--green); }
.badge-tidak   { background: rgba(192,80,96,0.1);  color: var(--red); }
.badge-mungkin { background: rgba(201,160,106,0.12); color: var(--gold-dark); }

/* ── RESPONSIVE ── */
@media(max-width:768px){
    .topbar { padding: 0 14px; }
    .content { padding-top: 100px; padding-left: 15px; padding-right: 15px; }
    .topbar-logo { letter-spacing: 1.5px; font-size: 17px; }
    .topbar-user { display: none; }
    .preview-btn span { display: none; }
    .preview-btn { padding: 8px; border-radius: 50%; }
}
@media(max-width:480px){
    .form-row { grid-template-columns: 1fr; }
    .theme-grid { grid-template-columns: repeat(2,1fr); }
    .images-grid { grid-template-columns: repeat(2,1fr); }
    .save-bar { padding: 10px 14px; }
    .btn-save { padding: 9px 22px; font-size: 11px; }
    .btn-logout span { display: none; }
    .btn-logout { padding: 8px; border-radius: 50%; }
}
</style>
</head>
<body>

<div class="bg-layer"></div>

{{-- TOPBAR --}}
<div class="topbar">
    <a href="{{ route('dashboard.index') }}" class="topbar-logo">Satu<span>Jiwa</span></a>
    <div class="topbar-right">

        {{-- Customer Service - sentiasa kelihatan --}}
        <a href="https://wa.me/60195161874?text=Hi%20SatuJiwa" target="_blank" class="cs-btn" title="Hubungi Kami">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 18v-6a9 9 0 0 1 18 0v6"/>
                <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/>
            </svg>
        </a>

        @if(auth()->user()->invitation)
            <a href="{{ route('invitation.show', auth()->user()->invitation->slug) }}" target="_blank" class="preview-btn">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Pratonton
            </a>
        @endif

        <span class="topbar-user">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" style="margin:0">
            @csrf
            <button class="btn-logout" style="display:flex; align-items:center; gap:5px;">
                <i data-lucide="log-out" style="width:14px; height:14px;"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</div>

{{-- TABS --}}
<div class="tabs-bar">
    <a href="{{ route('dashboard.index') }}?tab=info"
       class="tab {{ !request()->routeIs('dashboard.rsvp') && !request()->routeIs('dashboard.wishes') && request('tab','info') == 'info' ? 'active' : '' }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        <span>Info Majlis</span>
    </a>
    <a href="{{ route('dashboard.index') }}?tab=reka"
       class="tab {{ request('tab') == 'reka' ? 'active' : '' }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
        <span>Reka Bentuk</span>
    </a>
    <a href="{{ route('dashboard.index') }}?tab=jemputan"
       class="tab {{ request('tab') == 'jemputan' ? 'active' : '' }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        <span>Jemputan</span>
    </a>
    <a href="{{ route('dashboard.index') }}?tab=media"
       class="tab {{ request('tab') == 'media' ? 'active' : '' }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        <span>Media</span>
    </a>
    <a href="{{ route('dashboard.index') }}?tab=muzik"
       class="tab {{ request('tab') == 'muzik' ? 'active' : '' }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
        <span>Muzik</span>
    </a>
    <a href="{{ route('dashboard.index') }}?tab=pakaian"
       class="tab {{ request('tab') == 'pakaian' ? 'active' : '' }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        <span>Tema Pakaian</span>
    </a>
    <a href="{{ route('dashboard.index') }}?tab=aturcara"
       class="tab {{ request('tab') == 'aturcara' ? 'active' : '' }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
        <span>Aturcara</span>
    </a>
    <a href="{{ route('dashboard.index') }}?tab=hadiah"
       class="tab {{ request('tab') == 'hadiah' ? 'active' : '' }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
        <span>Hadiah</span>
    </a>
    <a href="{{ route('dashboard.index') }}?tab=lokasi"
       class="tab {{ request('tab') == 'lokasi' ? 'active' : '' }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        <span>Lokasi</span>
    </a>
    <a href="{{ route('dashboard.rsvp') }}"
       class="tab {{ request()->routeIs('dashboard.rsvp') ? 'active' : '' }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        <span>RSVP</span>
    </a>
    <a href="{{ route('dashboard.wishes') }}"
       class="tab {{ request()->routeIs('dashboard.wishes') ? 'active' : '' }}">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        <span>Ucapan</span>
    </a>
</div>

{{-- CONTENT --}}
<div class="content">
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:5px"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @yield('content')
</div>

{{-- SAVE BAR --}}
<div class="save-bar">
    <span class="save-status" id="saveStatus">Klik Simpan untuk menyimpan perubahan</span>
    <button type="button" class="btn-save" onclick="submitMainForm()">Simpan Perubahan</button>
</div>

<script>
function submitMainForm() {
    const form = document.getElementById('mainForm');
    if (!form) return;

    const rows = document.querySelectorAll('.aturcara-row');
    const jsonInput = document.getElementById('aturcaraJson');
    if (jsonInput) {
        const data = [];
        rows.forEach(row => {
            const masa  = row.querySelector('.aturcara-masa')?.value?.trim();
            const tajuk = row.querySelector('.aturcara-tajuk')?.value?.trim();
            if (masa || tajuk) {
                data.push({ masa: masa || '', tajuk: tajuk || '' });
            }
        });
        data.sort((a, b) => a.masa.localeCompare(b.masa));
        jsonInput.value = JSON.stringify(data);
    }

    const qrInput = document.getElementById('qrFileInput');
    if (qrInput && qrInput.files && qrInput.files.length > 0) {
        const indicator = document.getElementById('qrSavingIndicator');
        if (indicator) {
            indicator.style.display = 'block';
            setTimeout(() => {
                const bar = document.getElementById('qrSavingBar');
                if (bar) bar.style.width = '85%';
            }, 100);
        }
    }

    form.submit();
}

document.addEventListener('input', () => {
    const el = document.getElementById('saveStatus');
    if (el) {
        el.textContent = '⚠ Perubahan belum disimpan';
        el.style.color = 'var(--rose)';
    }
});

lucide.createIcons();
</script>
</body>
</html>