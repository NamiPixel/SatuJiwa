<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Design Header — SatuJiwa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=Nunito:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --rose:        #C9788A;
            --rose-light:  #E8B4BE;
            --rose-pale:   #F5D9DE;
            --gold:        #C9A06A;
            --gold-light:  #E8D0A0;
            --cream:       #FDF8F3;
            --warm-white:  #FFFAF7;
            --text-dark:   #4A3040;
            --text-mid:    #7A5868;
            --text-soft:   rgba(74,48,64,0.5);
            --border:      rgba(201,120,138,0.18);
            --border-rose: rgba(201,120,138,0.38);
            --card:        rgba(255,255,255,0.72);
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        html { scroll-behavior:smooth; }

        body {
            background: var(--warm-white);
            color: var(--text-dark);
            font-family: 'Nunito', sans-serif;
            font-weight: 300;
            overflow-x: hidden;
        }

        /* BG */
        .bg-wrap {
            position:fixed; inset:0; z-index:0; pointer-events:none;
            background:
                radial-gradient(ellipse 80% 55% at 5%  0%,  rgba(232,180,190,0.38) 0%, transparent 60%),
                radial-gradient(ellipse 55% 50% at 95% 8%,  rgba(201,160,106,0.2)  0%, transparent 55%),
                radial-gradient(ellipse 65% 55% at 85% 95%, rgba(232,180,190,0.28) 0%, transparent 60%),
                radial-gradient(ellipse 45% 40% at 2%  88%, rgba(201,160,106,0.13) 0%, transparent 55%),
                linear-gradient(155deg, #FFF5F7 0%, #FDF8F3 45%, #FFF0F3 72%, #FFFAF5 100%);
        }

        /* PETALS */
        .petals { position:fixed; inset:0; pointer-events:none; z-index:1; overflow:hidden; }
        .petal { position:absolute; opacity:0; animation:petalFall linear infinite; border-radius:50% 0 50% 0; }
        @keyframes petalFall {
            0%   { opacity:0; transform:translateY(-40px) rotate(0deg) scale(0.7); }
            8%   { opacity:0.4; }
            88%  { opacity:0.2; }
            100% { opacity:0; transform:translateY(105vh) rotate(400deg) scale(1.1); }
        }

        /* NAV */
        nav {
            position:fixed; top:0; left:0; right:0; z-index:500;
            padding:22px 48px;
            display:flex; align-items:center; justify-content:space-between;
            transition:all 0.4s ease;
        }
        nav.scrolled {
            padding:14px 48px;
            background:rgba(253,248,243,0.93);
            backdrop-filter:blur(20px);
            border-bottom:1px solid var(--border);
            box-shadow:0 2px 24px rgba(201,120,138,0.09);
        }
        .nav-logo {
            font-family:'Cormorant Garamond',serif;
            font-size:22px; font-weight:400; letter-spacing:4px;
            color:var(--rose); text-decoration:none;
        }
        .nav-logo span { color:var(--gold); font-style:italic; }

        .nav-back {
            display:inline-flex; align-items:center; gap:8px;
            padding:11px 26px;
            background:rgba(201,120,138,0.1);
            color:var(--rose); font-size:11px; font-weight:500;
            letter-spacing:2px; text-transform:uppercase;
            text-decoration:none; border-radius:50px;
            border:1px solid var(--border-rose);
            transition:all 0.35s ease;
        }
        .nav-back:hover { background:rgba(201,120,138,0.2); border-color:var(--rose); }

        /* HERO */
        .page-hero {
            position:relative; z-index:2;
            padding:140px 48px 60px;
            text-align:center;
        }
        .hero-badge {
            display:inline-flex; align-items:center; gap:10px;
            padding:8px 20px;
            border:1px solid var(--border-rose); border-radius:50px;
            background:rgba(201,120,138,0.07);
            font-size:10px; letter-spacing:3px; text-transform:uppercase;
            color:var(--rose); margin-bottom:28px;
            opacity:0; animation:fadeUp 0.8s 0.15s ease forwards;
        }
        .hero-badge .dot {
            width:5px; height:5px; background:var(--rose);
            border-radius:50%; animation:pulse 2s ease infinite;
        }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:0.3;transform:scale(0.5);} }

        .page-title {
            font-family:'Cormorant Garamond',serif;
            font-size:clamp(38px,5vw,68px); font-weight:300; line-height:1.1;
            color:var(--text-dark); margin-bottom:18px;
            opacity:0; animation:fadeUp 0.8s 0.3s ease forwards;
        }
        .page-title em { font-style:italic; color:var(--rose); }

        .hero-rule {
            display:flex; align-items:center; justify-content:center; gap:14px;
            margin-bottom:18px;
            opacity:0; animation:fadeUp 0.8s 0.45s ease forwards;
        }
        .hero-rule .line { width:32px; height:1px; background:var(--rose-light); }
        .hero-rule span { font-family:'Cormorant Garamond',serif; font-size:15px; font-style:italic; color:var(--text-soft); letter-spacing:1px; }

        .page-desc {
            font-size:14px; line-height:1.9; color:var(--text-mid);
            max-width:500px; margin:0 auto;
            opacity:0; animation:fadeUp 0.8s 0.55s ease forwards;
        }

        /* DIVIDER */
        .section-divider {
            position:relative; z-index:2;
            display:flex; align-items:center; justify-content:center; gap:16px;
            padding:0 48px; max-width:700px; margin:40px auto 40px;
        }
        .section-divider .line { flex:1; height:1px; background:var(--border); }
        .section-divider .ornament { font-family:'Cormorant Garamond',serif; font-size:20px; color:var(--rose-light); }

        /* GRID */
        .designs-wrap {
            position:relative; z-index:2;
            max-width:1200px; margin:0 auto;
            padding:0 48px 100px;
        }

        /* empty state */
        .empty-state {
            text-align:center; padding:80px 20px;
            color:var(--text-soft);
        }
        .empty-state svg { margin-bottom:16px; opacity:0.3; }
        .empty-state p { font-family:'Cormorant Garamond',serif; font-size:20px; font-style:italic; }

        .designs-grid {
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:18px;
        }

        /* CARD */
        .design-card {
            background:var(--card);
            backdrop-filter:blur(12px);
            border:1px solid rgba(201,120,138,0.13);
            border-radius:16px;
            overflow:hidden;
            cursor:pointer;
            position:relative;
            transition:all 0.4s ease;
            box-shadow:0 4px 20px rgba(201,120,138,0.07);
            animation:fadeUp 0.6s ease both;
        }
        .design-card:hover {
            transform:translateY(-7px);
            box-shadow:0 20px 48px rgba(201,120,138,0.18);
            border-color:var(--border-rose);
        }
        @keyframes fadeUp { from{opacity:0;transform:translateY(24px);} to{opacity:1;transform:translateY(0);} }

        .card-img-wrap {
            position:relative;
            aspect-ratio:9/16;
            overflow:hidden;
            background:linear-gradient(160deg,#FDF0F2 0%,#F9E4E8 100%);
        }
        .card-img-wrap img {
            width:100%; height:100%;
            object-fit:cover; display:block;
            transition:transform 0.5s ease;
        }
        .design-card:hover .card-img-wrap img { transform:scale(1.04); }

        /* overlay */
        .card-overlay {
            position:absolute; inset:0;
            background:linear-gradient(to top, rgba(74,30,48,0.78) 0%, rgba(74,30,48,0.1) 55%, transparent 100%);
            opacity:0; transition:opacity 0.35s ease;
            display:flex; flex-direction:column;
            align-items:center; justify-content:flex-end;
            padding:18px; gap:8px;
        }
        .design-card:hover .card-overlay { opacity:1; }

        .btn-overlay-wa {
            width:100%; display:inline-flex; align-items:center; justify-content:center; gap:7px;
            padding:10px 16px;
            background:linear-gradient(135deg,#25D366,#1aad52);
            color:#fff; font-size:10px; font-weight:600;
            letter-spacing:1.5px; text-transform:uppercase;
            border:none; border-radius:50px; cursor:pointer;
            transition:all 0.25s; font-family:'Nunito',sans-serif;
            text-decoration:none;
        }
        .btn-overlay-wa:hover { box-shadow:0 6px 20px rgba(37,211,102,0.4); }

        .btn-overlay-detail {
            width:100%; display:inline-flex; align-items:center; justify-content:center; gap:7px;
            padding:9px 16px;
            background:rgba(255,255,255,0.15); backdrop-filter:blur(8px);
            color:#fff; font-size:10px; font-weight:500;
            letter-spacing:1.5px; text-transform:uppercase;
            border:1px solid rgba(255,255,255,0.4); border-radius:50px;
            cursor:pointer; transition:all 0.25s; font-family:'Nunito',sans-serif;
        }
        .btn-overlay-detail:hover { background:rgba(255,255,255,0.28); }

        /* card body */
        .card-body {
            padding:13px 15px 15px;
            border-top:1px solid rgba(201,120,138,0.1);
        }
        .card-num {
            font-size:9px; letter-spacing:2px; text-transform:uppercase;
            color:var(--rose-light); margin-bottom:4px; font-weight:500;
        }
        .card-name {
            font-family:'Cormorant Garamond',serif;
            font-size:16px; font-weight:400; color:var(--text-dark);
        }

        /* LIGHTBOX */
        .lightbox {
            display:none; position:fixed; inset:0;
            background:rgba(30,8,18,0.88);
            z-index:800; align-items:center; justify-content:center; padding:20px;
        }
        .lightbox.open { display:flex; animation:lbFade 0.25s ease; }
        @keyframes lbFade { from{opacity:0} to{opacity:1} }

        .lb-inner {
            display:flex; gap:0;
            background:var(--warm-white);
            max-width:700px; width:100%;
            border-radius:20px; overflow:hidden;
            position:relative;
            animation:lbPop 0.3s ease;
            box-shadow:0 30px 80px rgba(74,30,48,0.35);
        }
        @keyframes lbPop { from{transform:scale(0.9);opacity:0;} to{transform:scale(1);opacity:1;} }

        .lb-close {
            position:absolute; top:14px; right:16px;
            width:32px; height:32px;
            background:rgba(255,255,255,0.9); border:1px solid var(--border);
            border-radius:50%; display:flex; align-items:center; justify-content:center;
            font-size:14px; color:var(--text-mid);
            cursor:pointer; z-index:10; transition:all 0.2s;
        }
        .lb-close:hover { color:var(--rose); border-color:var(--rose); }

        /* kiri — gambar */
        .lb-img-side {
            width:260px; flex-shrink:0;
            background:linear-gradient(160deg,#FDF0F2 0%,#F4C8D4 100%);
            overflow:hidden;
        }
        .lb-img-side img {
            width:100%; height:100%;
            object-fit:cover; display:block;
        }

        /* kanan — info */
        .lb-info-side {
            flex:1; padding:30px 28px;
            display:flex; flex-direction:column; justify-content:center;
            overflow-y:auto; max-height:80vh;
        }

        .lb-eyebrow {
            font-size:9px; letter-spacing:3px; text-transform:uppercase;
            color:var(--rose-light); margin-bottom:8px; font-weight:500;
        }
        .lb-title {
            font-family:'Cormorant Garamond',serif;
            font-size:1.9rem; color:var(--text-dark); margin-bottom:10px; line-height:1.2;
        }
        .lb-divider { width:36px; height:1px; background:var(--rose-light); margin-bottom:14px; }
        .lb-desc {
            font-size:13px; color:var(--text-mid);
            line-height:1.85; margin-bottom:22px; font-weight:300;
        }

        .lb-btn-wa {
            display:inline-flex; align-items:center; justify-content:center; gap:9px;
            padding:14px 24px;
            background:linear-gradient(135deg,#25D366,#1aad52);
            color:#fff; font-size:11px; font-weight:600;
            letter-spacing:1.5px; text-transform:uppercase;
            border-radius:50px; text-decoration:none;
            transition:all 0.3s; font-family:'Nunito',sans-serif;
            box-shadow:0 4px 16px rgba(37,211,102,0.25);
            margin-bottom:10px;
        }
        .lb-btn-wa:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(37,211,102,0.35); }

        .lb-btn-demo {
            display:inline-flex; align-items:center; justify-content:center; gap:8px;
            padding:13px 24px; background:transparent;
            color:var(--rose); font-size:11px; font-weight:500;
            letter-spacing:1.5px; text-transform:uppercase;
            border:1px solid var(--border-rose); border-radius:50px;
            text-decoration:none; transition:all 0.3s; font-family:'Nunito',sans-serif;
        }
        .lb-btn-demo:hover { background:rgba(201,120,138,0.08); border-color:var(--rose); }

        /* CTA */
        .cta-section {
            position:relative; z-index:2;
            padding:60px 24px 100px; text-align:center;
        }
        .cta-box {
            max-width:620px; margin:0 auto; padding:58px 52px;
            border:1px solid rgba(201,120,138,0.2); border-radius:28px;
            background:rgba(255,255,255,0.78); backdrop-filter:blur(16px);
            position:relative; overflow:hidden;
            box-shadow:0 20px 60px rgba(201,120,138,0.13);
        }
        .cta-box::before {
            content:''; position:absolute; top:0;left:0;right:0;height:2px;
            background:linear-gradient(90deg,transparent,var(--rose-light),var(--gold-light),var(--rose-light),transparent);
        }
        .section-eyebrow {
            display:inline-flex; align-items:center; gap:12px;
            font-size:10px; letter-spacing:4px; text-transform:uppercase; color:var(--rose); margin-bottom:14px;
        }
        .section-eyebrow::before,.section-eyebrow::after { content:''; width:22px; height:1px; background:var(--rose-light); }
        .section-title { font-family:'Cormorant Garamond',serif; font-size:clamp(28px,4vw,42px); font-weight:300; color:var(--text-dark); line-height:1.25; margin-bottom:14px; }
        .section-title em { font-style:italic; color:var(--rose); }
        .cta-box p { font-size:14px; color:var(--text-mid); margin-bottom:32px; line-height:1.9; }

        .btn-whatsapp {
            display:inline-flex; align-items:center; gap:10px;
            padding:15px 36px;
            background:linear-gradient(135deg,#25D366 0%,#1aad52 100%);
            color:#fff; font-size:11px; font-weight:600; letter-spacing:2px; text-transform:uppercase;
            text-decoration:none; border-radius:50px;
            transition:all 0.35s ease;
            box-shadow:0 6px 24px rgba(37,211,102,0.25);
        }
        .btn-whatsapp:hover { transform:translateY(-3px); box-shadow:0 14px 36px rgba(37,211,102,0.35); }

        /* FOOTER */
        footer {
            position:relative; z-index:2;
            padding:32px 48px; border-top:1px solid var(--border);
            display:flex; align-items:center; justify-content:space-between;
            background:rgba(255,255,255,0.55);
        }
        .footer-logo { font-family:'Cormorant Garamond',serif; font-size:18px; letter-spacing:4px; color:var(--rose); }
        .footer-logo span { font-style:italic; color:var(--gold); }
        footer p { font-size:11px; color:var(--text-soft); letter-spacing:1px; }
        .footer-links { display:flex; gap:22px; }
        .footer-links a { font-size:11px; letter-spacing:1.5px; text-transform:uppercase; color:var(--text-soft); text-decoration:none; transition:color 0.3s; }
        .footer-links a:hover { color:var(--rose); }

        /* WA FLOAT */
        .wa-float {
            position:fixed; bottom:30px; right:30px; z-index:600;
            width:56px; height:56px;
            background:linear-gradient(135deg,#25D366,#1aad52);
            border-radius:50%; display:flex; align-items:center; justify-content:center;
            box-shadow:0 6px 24px rgba(37,211,102,0.35);
            text-decoration:none; transition:all 0.3s;
            animation:waPulse 3s ease infinite;
        }
        .wa-float:hover { transform:scale(1.1) translateY(-3px); }
        @keyframes waPulse {
            0%,100%{box-shadow:0 6px 24px rgba(37,211,102,0.35),0 0 0 0 rgba(37,211,102,0.25);}
            50%{box-shadow:0 6px 24px rgba(37,211,102,0.35),0 0 0 12px rgba(37,211,102,0);}
        }

        /* REVEAL */
        .reveal { opacity:0; transform:translateY(28px); transition:opacity 0.7s ease,transform 0.7s ease; }
        .reveal.visible { opacity:1; transform:none; }

        /* RESPONSIVE */
        @media(max-width:1000px) { .designs-grid { grid-template-columns:repeat(3,1fr); } }
        @media(max-width:720px)  {
            nav { padding:16px 24px; } nav.scrolled { padding:12px 24px; }
            .page-hero { padding:120px 24px 50px; }
            .designs-wrap { padding:0 20px 80px; }
            .designs-grid { grid-template-columns:repeat(2,1fr); gap:12px; }
            .lb-inner { flex-direction:column; max-width:360px; }
            .lb-img-side { width:100%; height:240px; }
            .lb-info-side { padding:22px 20px; }
            footer { flex-direction:column; gap:12px; text-align:center; }
            .footer-links { justify-content:center; }
            .cta-box { padding:38px 22px; }
        }
        @media(max-width:480px) { .designs-grid { grid-template-columns:repeat(2,1fr); } }
    </style>
</head>
<body>

<div class="bg-wrap"></div>
<div class="petals" id="petals"></div>

<!-- NAV -->
<nav id="navbar">
    <a href="{{ url('/') }}" class="nav-logo">Satu<span>Jiwa</span></a>
    <a href="{{ url('/') }}" class="nav-back">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Kembali
    </a>
</nav>

<!-- HERO -->
<section class="page-hero">
    <div class="hero-badge"><div class="dot"></div>Koleksi Design Header</div>
    <h1 class="page-title">Template Header yang<br><em>Menawan Hati</em></h1>
    <div class="hero-rule">
        <div class="line"></div>
        <span>Pilih · Sesuai · Kongsi</span>
        <div class="line"></div>
    </div>
    <p class="page-desc">{{ $templates->count() }} design header tersedia. Setiap template boleh disesuaikan sepenuhnya mengikut nama, tarikh dan warna tema majlis anda.</p>
</section>

<div class="section-divider">
    <div class="line"></div>
    <div class="ornament">✿</div>
    <div class="line"></div>
</div>

<!-- FILTER -->
<div style="max-width:1200px; margin:0 auto; padding:0 48px; position:relative; z-index:2;">
    @php
        $cats = [
            'all' => 'Semua Design',
            'floral' => 'Floral',
            'minimalist' => 'Minimalist',
            'classic' => 'Classic',
            'modern' => 'Modern',
            'elegant' => 'Elegant',
            'Arts' => 'Arts',
            'islamic' => 'Islamic'
        ];
        $active = request('category', 'all');
    @endphp
    <div style="display:flex; justify-content:center; gap:12px; flex-wrap:wrap; margin-bottom:40px;">
        @foreach($cats as $id => $label)
        <a href="?category={{ $id == 'all' ? '' : $id }}" 
           style="padding:10px 24px; border-radius:50px; font-size:12px; letter-spacing:1px; text-transform:uppercase; text-decoration:none; border:1px solid {{ $active == $id ? 'var(--rose)' : 'var(--border)' }}; background:{{ $active == $id ? 'var(--rose)' : 'var(--card)' }}; color:{{ $active == $id ? '#fff' : 'var(--text-mid)' }}; transition:all 0.3s ease; box-shadow:0 4px 12px rgba(201,120,138,0.05);">
            {{ $label }}
        </a>
        @endforeach
    </div>
</div>

<!-- GRID -->
<div class="designs-wrap">

    @if($templates->isEmpty())
        <div class="empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            <p>Tiada design header tersedia buat masa ini.</p>
        </div>
    @else
        <div class="designs-grid">
            @foreach($templates as $i => $template)
            <div class="design-card"
                style="animation-delay:{{ $i * 0.07 }}s"
                onclick="openLb(
                    '{{ addslashes($template->nama ?? 'Design '.($i+1)) }}',
                    '{{ Storage::url($template->image_path) }}',
                    {{ $i + 1 }}
                )">

                <div class="card-img-wrap">
                    <img src="{{ Storage::url($template->image_path) }}"
                         alt="{{ $template->nama ?? 'Design Header '.($i+1) }}"
                         loading="lazy">
                </div>

                <div class="card-body">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <div>
                            <div class="card-num">Design #{{ $i + 1 }}</div>
                            <div class="card-name">{{ $template->nama }}</div>
                        </div>
                        @if($template->category)
                        <span style="font-size:9px; color:var(--rose); background:rgba(201,120,138,0.1); padding:3px 10px; border-radius:50px; text-transform:uppercase; letter-spacing:1px; font-weight:700;">{{ $template->category }}</span>
                        @endif
                    </div>
                </div>

                <!--<div class="card-overlay">-->
                <!--    <button class="btn-overlay-detail"-->
                <!--        onclick="event.stopPropagation();openLb(-->
                <!--            '{{ addslashes($template->nama ?? 'Design '.($i+1)) }}',-->
                <!--            '{{ Storage::url($template->image_path) }}',-->
                <!--            {{ $i + 1 }}-->
                <!--        )">-->
                <!--        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M2 12s3.636-7 10-7 10 7 10 7-3.636 7-10 7-10-7-10-7z"/></svg>-->
                <!--        Lihat Besar-->
                <!--    </button>-->
                <!--    <a class="btn-overlay-wa"-->
                <!--        href="https://wa.me/60195161874?text=Salam%2C%20saya%20berminat%20dengan%20design%20header%20nombor%20{{ $i+1 }}%20{{ urlencode($template->nama ?? '') }}%20untuk%20undangan%20digital%20SatuJiwa."-->
                <!--        target="_blank"-->
                <!--        onclick="event.stopPropagation()">-->
                <!--        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>-->
                <!--        Order Design Ini-->
                <!--    </a>-->
                <!--</div>-->


            </div>
            @endforeach
        </div>
    @endif

</div>

<!-- CTA -->
<section class="cta-section reveal">
    <div class="cta-box">
        <div class="section-eyebrow">Order Sekarang</div>
        <h2 class="section-title">Jumpa Design <em>Impian Anda?</em></h2>
        <p>Hubungi kami terus melalui WhatsApp untuk order dan sesuaikan design pilihan anda. Proses yang mudah, cepat dan mesra.</p>
        <a href="https://wa.me/60195161874?text=Salam%2C%20saya%20berminat%20untuk%20membuat%20undangan%20digital%20dengan%20SatuJiwa.%20Boleh%20saya%20tahu%20lebih%20lanjut%3F" target="_blank" class="btn-whatsapp">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
            Order via WhatsApp
        </a>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-logo">Satu<span>Jiwa</span></div>
    <p>© {{ date('Y') }} SatuJiwa · Undangan Digital Malaysia</p>
    <div class="footer-links">
        <a href="{{ url('/') }}">Utama</a>
        <a href="#">Privasi</a>
        <a href="#">Terma</a>
    </div>
</footer>

<!-- WA FLOAT -->
<a href="https://wa.me/60195161874?text=Salam%2C%20saya%20berminat%20untuk%20membuat%20undangan%20digital%20dengan%20SatuJiwa." target="_blank" class="wa-float">
    <svg width="26" height="26" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
</a>


<script>
    // NAV SCROLL
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => { navbar.classList.toggle('scrolled', window.scrollY > 50); }, { passive:true });

    // PETALS
    const pc = document.getElementById('petals');
    const COLORS = ['#E8B4BE','#F5D9DE','#C9A06A','#E8D0A0','#F0C8D0'];
    for (let i = 0; i < 18; i++) {
        const p = document.createElement('div');
        p.className = 'petal';
        const s = Math.random() * 10 + 5;
        p.style.cssText = `width:${s}px;height:${s*1.5}px;background:${COLORS[Math.floor(Math.random()*COLORS.length)]};left:${Math.random()*100}%;animation-duration:${Math.random()*18+12}s;animation-delay:${Math.random()*16}s;`;
        pc.appendChild(p);
    }

    // REVEAL
    document.querySelectorAll('.reveal').forEach(el => {
        new IntersectionObserver(entries => {
            entries.forEach(e => { if(e.isIntersecting) setTimeout(()=>e.target.classList.add('visible'),80); });
        }, {threshold:0.12}).observe(el);
    });

    // LIGHTBOX
    const WA_BASE = 'https://wa.me/60195161874?text=Salam%2C%20saya%20berminat%20dengan%20design%20header%20';

    function openLb(name, imgUrl, num) {
        document.getElementById('lbTitle').textContent = name;
        document.getElementById('lbImg').src = imgUrl;
        document.getElementById('lbImg').alt = name;
        document.getElementById('lbWaBtn').href = WA_BASE + encodeURIComponent(name) + '%20untuk%20undangan%20digital%20SatuJiwa.';
        document.getElementById('lightbox').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeLb() {
        document.getElementById('lightbox').classList.remove('open');
        document.body.style.overflow = '';
    }
    function closeLbOutside(e) { if(e.target.id === 'lightbox') closeLb(); }
    document.addEventListener('keydown', e => { if(e.key==='Escape') closeLb(); });
</script>

</body>
</html>