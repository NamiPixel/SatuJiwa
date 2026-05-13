<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SatuJiwa — Undangan Digital Malaysia</title>
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

        /* ─── PASTEL GRADIENT BG ─── */
        .bg-wrap {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 80% 55% at 5%  0%,  rgba(232,180,190,0.38) 0%, transparent 60%),
                radial-gradient(ellipse 55% 50% at 95% 8%,  rgba(201,160,106,0.2)  0%, transparent 55%),
                radial-gradient(ellipse 65% 55% at 85% 95%, rgba(232,180,190,0.28) 0%, transparent 60%),
                radial-gradient(ellipse 45% 40% at 2%  88%, rgba(201,160,106,0.13) 0%, transparent 55%),
                linear-gradient(155deg, #FFF5F7 0%, #FDF8F3 45%, #FFF0F3 72%, #FFFAF5 100%);
        }

        /* ─── FLORAL DECO ─── */
        .floral-deco { position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden; }

        /* ─── PETALS ─── */
        .petals { position: fixed; inset: 0; pointer-events: none; z-index: 1; overflow: hidden; }
        .petal { position: absolute; opacity: 0; animation: petalFall linear infinite; border-radius: 50% 0 50% 0; }
        @keyframes petalFall {
            0%   { opacity:0; transform:translateY(-40px) rotate(0deg) scale(0.7); }
            8%   { opacity:0.5; }
            88%  { opacity:0.25; }
            100% { opacity:0; transform:translateY(105vh) rotate(400deg) scale(1.1); }
        }

        /* ─── NAV ─── */
        nav {
            position: fixed; top:0; left:0; right:0; z-index:500;
            padding: 22px 48px;
            display: flex; align-items:center; justify-content:space-between;
            transition: all 0.4s ease;
        }
        nav.scrolled {
            padding: 14px 48px;
            background: rgba(253,248,243,0.93);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 24px rgba(201,120,138,0.09);
        }
        .nav-logo {
            font-family:'Cormorant Garamond',serif;
            font-size:22px; font-weight:400; letter-spacing:4px;
            color:var(--rose); text-decoration:none;
        }
        .nav-logo span { color:var(--gold); font-style:italic; }

        .btn-nav-cta {
            display:inline-flex; align-items:center; gap:8px;
            padding:11px 26px;
            background:rgba(201,120,138,0.1);
            color:var(--rose); font-family:'Nunito',sans-serif;
            font-size:11px; font-weight:500; letter-spacing:2px; text-transform:uppercase;
            text-decoration:none; border-radius:50px;
            border:1px solid var(--border-rose);
            transition:all 0.35s ease;
        }
        .btn-nav-cta:hover { background:rgba(201,120,138,0.2); border-color:var(--rose); box-shadow:0 4px 18px rgba(201,120,138,0.2); }

        /* ─── HERO ─── */
        .hero {
            position:relative; min-height:100vh;
            display:flex; align-items:center; justify-content:center;
            padding:120px 48px 80px; z-index:2;
        }
        .hero-inner {
            display:grid; grid-template-columns:1fr 1fr;
            align-items:center; gap:80px;
            max-width:1200px; width:100%;
        }

        .hero-badge {
            display:inline-flex; align-items:center; gap:10px;
            padding:8px 20px;
            border:1px solid var(--border-rose); border-radius:50px;
            background:rgba(201,120,138,0.07);
            font-size:10px; letter-spacing:3px; text-transform:uppercase;
            color:var(--rose); margin-bottom:32px;
            opacity:0; animation:fadeUp 0.8s 0.2s ease forwards;
        }
        .hero-badge .dot {
            width:5px; height:5px; background:var(--rose);
            border-radius:50%; animation:pulse 2s ease infinite;
        }
        @keyframes pulse {
            0%,100%{ opacity:1; transform:scale(1); }
            50%    { opacity:0.3; transform:scale(0.5); }
        }

        .hero-title {
            font-family:'Cormorant Garamond',serif;
            font-size:clamp(44px,5.5vw,80px);
            font-weight:300; line-height:1.08; letter-spacing:-0.5px;
            margin-bottom:24px; color:var(--text-dark);
            opacity:0; animation:fadeUp 0.8s 0.35s ease forwards;
        }
        .hero-title em { font-style:italic; color:var(--rose); }
        .hero-title .gold-em { font-style:italic; color:var(--gold); }

        .hero-rule {
            display:flex; align-items:center; gap:14px;
            margin-bottom:22px;
            opacity:0; animation:fadeUp 0.8s 0.5s ease forwards;
        }
        .hero-rule .line { width:32px; height:1px; background:var(--rose-light); }
        .hero-rule span {
            font-family:'Cormorant Garamond',serif;
            font-size:15px; font-style:italic; color:var(--text-soft); letter-spacing:1px;
        }

        .hero-desc {
            font-size:14px; line-height:1.9; color:var(--text-mid);
            margin-bottom:40px; max-width:420px;
            opacity:0; animation:fadeUp 0.8s 0.65s ease forwards;
        }

        .hero-actions {
            display:flex; align-items:center; gap:12px; flex-wrap:wrap;
            opacity:0; animation:fadeUp 0.8s 0.8s ease forwards;
        }

        /* Buttons */
        .btn-primary {
            display:inline-flex; align-items:center; gap:10px;
            padding:15px 36px;
            background:linear-gradient(135deg,#C9788A 0%,#B05A70 100%);
            color:#fff; font-family:'Nunito',sans-serif;
            font-size:11px; font-weight:600; letter-spacing:2px; text-transform:uppercase;
            text-decoration:none; border-radius:50px; border:none; cursor:pointer;
            transition:all 0.35s ease; position:relative; overflow:hidden;
            box-shadow:0 6px 24px rgba(201,120,138,0.3);
        }
        .btn-primary::before { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(255,255,255,0.18),transparent); opacity:0; transition:opacity 0.3s; }
        .btn-primary:hover::before { opacity:1; }
        .btn-primary:hover { transform:translateY(-3px); box-shadow:0 14px 36px rgba(201,120,138,0.4); }
        .btn-primary svg { transition:transform 0.3s; }
        .btn-primary:hover svg { transform:translateX(4px); }

        .btn-ghost {
            display:inline-flex; align-items:center; gap:10px;
            padding:14px 36px; background:transparent; color:var(--rose);
            font-family:'Nunito',sans-serif; font-size:11px; font-weight:500;
            letter-spacing:2px; text-transform:uppercase; text-decoration:none;
            border-radius:50px; border:1px solid var(--border-rose);
            transition:all 0.35s ease;
        }
        .btn-ghost:hover { background:rgba(201,120,138,0.09); border-color:var(--rose); transform:translateY(-3px); }

        .btn-whatsapp {
            display:inline-flex; align-items:center; gap:10px;
            padding:15px 36px;
            background:linear-gradient(135deg,#25D366 0%,#1aad52 100%);
            color:#fff; font-family:'Nunito',sans-serif;
            font-size:11px; font-weight:600; letter-spacing:2px; text-transform:uppercase;
            text-decoration:none; border-radius:50px; border:none; cursor:pointer;
            transition:all 0.35s ease;
            box-shadow:0 6px 24px rgba(37,211,102,0.25);
        }
        .btn-whatsapp:hover { transform:translateY(-3px); box-shadow:0 14px 36px rgba(37,211,102,0.35); }
        .btn-whatsapp svg { flex-shrink:0; }

        /* ─── STATS ─── */
        .hero-stats {
            display:flex; align-items:center; gap:28px;
            margin-top:44px; padding-top:28px; border-top:1px solid var(--border);
            opacity:0; animation:fadeUp 0.8s 1s ease forwards;
        }
        .stat-num { font-family:'Cormorant Garamond',serif; font-size:30px; font-weight:400; color:var(--rose); line-height:1; }
        .stat-label { font-size:10px; letter-spacing:1.5px; text-transform:uppercase; color:var(--text-soft); margin-top:3px; }
        .stat-divider { width:1px; height:36px; background:var(--border); }

        /* ─── TRUST BADGES ─── */
        .trust-badges { display:flex; align-items:center; gap:10px; margin-top:18px; flex-wrap:wrap; }
        .trust-badge {
            display:flex; align-items:center; gap:6px;
            padding:6px 14px; border:1px solid var(--border); border-radius:50px;
            font-size:10px; letter-spacing:1px; color:var(--text-mid);
            background:rgba(255,255,255,0.65);
        }

        /* ─── MOCKUP ─── */
        .hero-visual { position:relative; opacity:0; animation:fadeLeft 1s 0.6s ease forwards; }
        @keyframes fadeLeft { from{opacity:0;transform:translateX(40px);} to{opacity:1;transform:translateX(0);} }

        .mockup-banner {
            position:relative; overflow:hidden;
            aspect-ratio:9/16; max-height:620px;
            display:flex; flex-direction:column;
            
            animation:floatBanner 1s ease-in-out infinite;
        }
        @keyframes floatBanner { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-10px);} }



        .mockup-img-placeholder {
            flex:1; background:linear-gradient(160deg,#FDF0F2 0%,#F9E4E8 100%);
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            min-height:500px; position:relative; overflow:hidden;
        }
        .upload-hint {
            position:absolute; inset:16px;
            border:1.5px dashed rgba(201,120,138,0.3); border-radius:18px;
            display:flex; flex-direction:column; align-items:center; justify-content:center; gap:12px;
        }
        .upload-icon {
            width:56px;height:56px; border:1px solid var(--border-rose); border-radius:16px;
            display:flex; align-items:center; justify-content:center; background:rgba(201,120,138,0.08);
        }
        .upload-title { font-family:'Cormorant Garamond',serif; font-size:18px; color:var(--rose); text-align:center; }
        .upload-sub { font-size:11px; color:var(--text-soft); text-align:center; line-height:1.7; }

        .mockup-bottom-bar {
            padding:18px 22px; background:rgba(255,255,255,0.96);
            border-top:1px solid rgba(201,120,138,0.15);
            display:flex; align-items:center; justify-content:space-between;
        }
        .mockup-bottom-bar .names { font-family:'Cormorant Garamond',serif; font-size:17px; color:var(--text-dark); }
        .mockup-bottom-bar .date  { font-size:10px; letter-spacing:1.5px; color:var(--text-soft); margin-top:2px; }
        .mockup-open-btn { padding:9px 18px; background:linear-gradient(135deg,var(--rose),#B05A70); color:#fff; font-size:10px; letter-spacing:1.5px; text-transform:uppercase; border-radius:50px; font-weight:600; }

        /* ─── DIVIDER ─── */
        .section-divider { position:relative;z-index:2; display:flex; align-items:center; justify-content:center; gap:16px; padding:0 48px; max-width:700px; margin:0 auto; }
        .section-divider .line { flex:1; height:1px; background:var(--border); }
        .section-divider .ornament { font-family:'Cormorant Garamond',serif; font-size:20px; color:var(--rose-light); }

        /* ─── SECTION HEADER ─── */
        .section-header { text-align:center; margin-bottom:52px; }
        .section-eyebrow {
            display:inline-flex; align-items:center; gap:12px;
            font-size:10px; letter-spacing:4px; text-transform:uppercase; color:var(--rose); margin-bottom:14px;
        }
        .section-eyebrow::before,.section-eyebrow::after { content:''; width:22px; height:1px; background:var(--rose-light); }
        .section-title { font-family:'Cormorant Garamond',serif; font-size:clamp(30px,4.5vw,48px); font-weight:300; color:var(--text-dark); line-height:1.25; }
        .section-title em { font-style:italic; color:var(--rose); }

        /* ─── FEATURES ─── */
        .features { position:relative;z-index:2; padding:100px 48px; max-width:1200px; margin:0 auto; }
        .features-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; }
@media(max-width:1100px){ .features-grid { grid-template-columns:repeat(3,1fr); } }

        .feature-card {
            background:var(--card); backdrop-filter:blur(12px);
            border:1px solid rgba(201,120,138,0.13); border-radius:20px;
            padding:36px 28px; transition:all 0.4s ease; position:relative; overflow:hidden;
            box-shadow:0 4px 24px rgba(201,120,138,0.07);
        }
        .feature-card::before { content:''; position:absolute; top:0;left:0;right:0;height:2px; background:linear-gradient(90deg,transparent,var(--rose-light),transparent); opacity:0; transition:opacity 0.4s; }
        .feature-card:hover { background:rgba(255,255,255,0.93); transform:translateY(-5px); box-shadow:0 16px 40px rgba(201,120,138,0.15); border-color:var(--border-rose); }
        .feature-card:hover::before { opacity:1; }

        .feature-icon-wrap { width:50px;height:50px; border:1px solid rgba(201,120,138,0.2); border-radius:14px; display:flex;align-items:center;justify-content:center; margin-bottom:20px; background:rgba(201,120,138,0.07); transition:all 0.3s; }
        .feature-card:hover .feature-icon-wrap { background:rgba(201,120,138,0.15); border-color:var(--rose-light); }
        .feat-icon svg { width:22px;height:22px; stroke:var(--rose); stroke-width:1.5; fill:none; stroke-linecap:round; stroke-linejoin:round; }
        .feature-name { font-family:'Cormorant Garamond',serif; font-size:20px; font-weight:400; color:var(--text-dark); margin-bottom:10px; }
        .feature-desc { font-size:13px; line-height:1.75; color:var(--text-mid); }

        /* ─── HOW IT WORKS ─── */
        .how { position:relative;z-index:2; padding:80px 48px 100px; max-width:1000px; margin:0 auto; }
        .steps { display:grid; grid-template-columns:repeat(3,1fr); gap:0; position:relative; }
        .steps::before { content:''; position:absolute; top:27px; left:16.66%;right:16.66%; height:1px; background:linear-gradient(90deg,var(--border),var(--rose-light),var(--border)); }
        .step { text-align:center; padding:0 28px 28px; }
        .step-dot { width:54px;height:54px; border:1.5px solid var(--border-rose); border-radius:50%; background:rgba(255,255,255,0.85); display:flex;align-items:center;justify-content:center; margin:0 auto 22px; position:relative;z-index:1; transition:all 0.4s; box-shadow:0 4px 16px rgba(201,120,138,0.1); }
        .step:hover .step-dot { background:rgba(201,120,138,0.11); border-color:var(--rose); box-shadow:0 8px 28px rgba(201,120,138,0.24); transform:scale(1.08); }
        .step-num { font-family:'Cormorant Garamond',serif; font-size:20px; color:var(--rose); }
        .step-title { font-family:'Cormorant Garamond',serif; font-size:22px; color:var(--text-dark); margin-bottom:10px; }
        .step-desc { font-size:13px; color:var(--text-mid); line-height:1.75; }

        /* ─── TESTIMONIALS ─── */
        .testimonials { position:relative;z-index:2; padding:80px 48px 100px; max-width:1200px; margin:0 auto; }
        .testimonials-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; }
        .testimonial-card { background:var(--card); backdrop-filter:blur(12px); border:1px solid rgba(201,120,138,0.13); border-radius:20px; padding:30px 26px; transition:all 0.4s; position:relative; overflow:hidden; box-shadow:0 4px 20px rgba(201,120,138,0.07); }
        .testimonial-card::before { content:'\201C'; position:absolute; top:8px;left:20px; font-family:'Cormorant Garamond',serif; font-size:80px; color:var(--rose); opacity:0.07; line-height:1; }
        .testimonial-card:hover { transform:translateY(-4px); box-shadow:0 16px 40px rgba(201,120,138,0.15); border-color:var(--border-rose); }
        .testimonial-stars { display:flex;gap:3px;margin-bottom:14px; }
        .star { color:var(--gold); font-size:13px; }
        .testimonial-text { font-family:'Cormorant Garamond',serif; font-size:16px; font-style:italic; color:var(--text-dark); line-height:1.7; margin-bottom:18px; }
        .testimonial-author { display:flex;align-items:center;gap:12px; }
        .author-avatar { width:38px;height:38px; border-radius:50%; background:linear-gradient(135deg,var(--rose-light),var(--rose)); display:flex;align-items:center;justify-content:center; font-family:'Cormorant Garamond',serif; font-size:14px; color:#fff; font-weight:600; flex-shrink:0; }
        .author-name { font-size:13px;font-weight:600;color:var(--text-dark); }
        .author-loc  { font-size:11px;color:var(--text-soft);margin-top:2px; }

        /* ─── CTA ─── */
        .cta-section { position:relative;z-index:2; padding:80px 24px 120px; text-align:center; }
        .cta-box { max-width:680px;margin:0 auto; padding:68px 60px; border:1px solid rgba(201,120,138,0.2); border-radius:28px; background:rgba(255,255,255,0.78); backdrop-filter:blur(16px); position:relative;overflow:hidden; box-shadow:0 20px 60px rgba(201,120,138,0.13); }
        .cta-box::before { content:''; position:absolute; top:0;left:0;right:0;height:2px; background:linear-gradient(90deg,transparent,var(--rose-light),var(--gold-light),var(--rose-light),transparent); }
        .cta-box .section-title { margin-bottom:16px; }
        .cta-box p { font-size:14px;color:var(--text-mid);margin-bottom:36px;line-height:1.9; }
        .cta-box .hero-actions { justify-content:center; }

        /* ─── FOOTER ─── */
        footer { position:relative;z-index:2; padding:36px 48px; border-top:1px solid var(--border); display:flex;align-items:center;justify-content:space-between; background:rgba(255,255,255,0.55); }
        .footer-logo { font-family:'Cormorant Garamond',serif; font-size:18px; letter-spacing:4px; color:var(--rose); }
        .footer-logo span { font-style:italic; color:var(--gold); }
        footer p { font-size:11px;color:var(--text-soft);letter-spacing:1px; }
        .footer-links { display:flex;gap:22px; }
        .footer-links a { font-size:11px;letter-spacing:1.5px;text-transform:uppercase;color:var(--text-soft);text-decoration:none;transition:color 0.3s; }
        .footer-links a:hover { color:var(--rose); }

        /* ─── WA FLOAT ─── */
        .wa-float { position:fixed;bottom:30px;right:30px;z-index:600; width:56px;height:56px; background:linear-gradient(135deg,#25D366,#1aad52); border-radius:50%; display:flex;align-items:center;justify-content:center; box-shadow:0 6px 24px rgba(37,211,102,0.35); text-decoration:none; transition:all 0.3s; animation:waPulse 3s ease infinite; }
        .wa-float:hover { transform:scale(1.1) translateY(-3px); }
        @keyframes waPulse { 0%,100%{box-shadow:0 6px 24px rgba(37,211,102,0.35),0 0 0 0 rgba(37,211,102,0.25);} 50%{box-shadow:0 6px 24px rgba(37,211,102,0.35),0 0 0 12px rgba(37,211,102,0);} }

        /* ─── REVEAL ─── */
        .reveal { opacity:0; transform:translateY(28px); transition:opacity 0.7s ease,transform 0.7s ease; }
        .reveal.visible { opacity:1; transform:none; }

        @keyframes fadeUp { from{opacity:0;transform:translateY(28px);} to{opacity:1;transform:none;} }

        /* ─── RESPONSIVE ─── */
        @media(max-width:900px){
            nav { padding:16px 24px; } nav.scrolled { padding:12px 24px; }
            .hero { padding:100px 24px 60px; }
            .hero-inner { grid-template-columns:1fr; gap:50px; text-align:center; }
            .hero-rule { justify-content:center; } .hero-desc { margin:0 auto 40px; }
            .hero-actions { justify-content:center; } .hero-stats { justify-content:center; }
            .trust-badges { justify-content:center; } .hero-visual { max-width:300px;margin:0 auto; }
            .features { padding:70px 24px; } .features-grid { grid-template-columns:1fr 1fr;gap:12px; }
            .how { padding:60px 24px 80px; } .steps { grid-template-columns:1fr; } .steps::before { display:none; }
            .testimonials { padding:60px 24px 80px; } .testimonials-grid { grid-template-columns:1fr; }
            .cta-box { padding:44px 28px; }
            footer { flex-direction:column;gap:14px;text-align:center; } .footer-links { justify-content:center; }
        }
        @media(max-width:600px){ .features-grid { grid-template-columns:1fr; } }
    </style>
</head>
<body>

    <div class="bg-wrap"></div>

    <!-- FLORAL DECORATIONS -->
    <div class="floral-deco">
        <svg style="position:absolute;top:-30px;left:-30px;width:340px;opacity:0.13;" viewBox="0 0 220 220" fill="none">
            <g transform="translate(110,100)">
                <ellipse rx="12" ry="45" fill="#C9788A" transform="rotate(0)"/>
                <ellipse rx="12" ry="45" fill="#E8B4BE" transform="rotate(45)"/>
                <ellipse rx="12" ry="45" fill="#C9788A" transform="rotate(90)"/>
                <ellipse rx="12" ry="45" fill="#E8B4BE" transform="rotate(135)"/>
                <ellipse rx="10" ry="40" fill="#C9788A" opacity=".5" transform="rotate(22)"/>
                <ellipse rx="10" ry="40" fill="#E8B4BE" opacity=".5" transform="rotate(67)"/>
                <ellipse rx="10" ry="40" fill="#C9788A" opacity=".5" transform="rotate(112)"/>
                <ellipse rx="10" ry="40" fill="#E8B4BE" opacity=".5" transform="rotate(157)"/>
                <circle r="14" fill="#C9A06A" opacity=".75"/>
            </g>
        </svg>
        <svg style="position:absolute;bottom:-30px;right:-30px;width:280px;opacity:0.1;transform:rotate(200deg);" viewBox="0 0 220 220" fill="none">
            <g transform="translate(110,100)">
                <ellipse rx="12" ry="42" fill="#C9788A" transform="rotate(0)"/>
                <ellipse rx="12" ry="42" fill="#E8B4BE" transform="rotate(60)"/>
                <ellipse rx="12" ry="42" fill="#C9788A" transform="rotate(120)"/>
                <ellipse rx="10" ry="36" fill="#E8B4BE" opacity=".5" transform="rotate(30)"/>
                <ellipse rx="10" ry="36" fill="#C9788A" opacity=".5" transform="rotate(90)"/>
                <ellipse rx="10" ry="36" fill="#E8B4BE" opacity=".5" transform="rotate(150)"/>
                <circle r="12" fill="#C9A06A" opacity=".8"/>
            </g>
        </svg>
        <!-- Small florals scattered -->
        <svg style="position:absolute;top:35%;right:2%;width:100px;opacity:0.07;" viewBox="0 0 100 100" fill="none">
            <g transform="translate(50,50)"><ellipse rx="7" ry="30" fill="#C9A06A" transform="rotate(0)"/><ellipse rx="7" ry="30" fill="#C9A06A" transform="rotate(60)"/><ellipse rx="7" ry="30" fill="#C9A06A" transform="rotate(120)"/><circle r="8" fill="#C9A06A"/></g>
        </svg>
        <svg style="position:absolute;top:55%;left:1%;width:80px;opacity:0.08;" viewBox="0 0 100 100" fill="none">
            <g transform="translate(50,50)"><ellipse rx="6" ry="26" fill="#C9788A" transform="rotate(0)"/><ellipse rx="6" ry="26" fill="#C9788A" transform="rotate(72)"/><ellipse rx="6" ry="26" fill="#C9788A" transform="rotate(144)"/><ellipse rx="6" ry="26" fill="#C9788A" transform="rotate(216)"/><ellipse rx="6" ry="26" fill="#C9788A" transform="rotate(288)"/><circle r="7" fill="#C9788A"/></g>
        </svg>
    </div>

    <!-- PETALS -->
    <div class="petals" id="petals"></div>

    <!-- NAV -->
    <nav id="navbar">
        <a href="/" class="nav-logo">Satu<span>Jiwa</span></a>
        <div>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-nav-cta">Dashboard ↗</a>
            @else
                <a href="{{ route('login') }}" class="btn-nav-cta">Log Masuk</a>
            @endauth
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-inner">
            <!-- LEFT -->
            <div class="hero-content">
                <div class="hero-badge"><div class="dot"></div>Undangan Digital Malaysia</div>

                <h1 class="hero-title">
                    Undangan<br>
                    yang <em>Menawan</em><br>
                    Hati <span class="gold-em">Tetamu</span>
                </h1>

                <div class="hero-rule">
                    <div class="line"></div>
                    <span>Cipta · Kongsi · Kenang</span>
                    <div class="line"></div>
                </div>

                <p class="hero-desc">SatuJiwa menghadirkan pengalaman undangan digital yang anggun dan mewah — disesuaikan sepenuhnya mengikut tema majlis anda. Kesan pertama yang tak terlupakan.</p>

                <div class="hero-actions">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
                    @else
                        <a href="{{ route('designs') }}" class="btn-ghost">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            Lihat Design Header
                        </a>
                        <a href="https://satujiwa.my/naim-nabila" target="_blank" class="btn-ghost">Lihat Demo</a>
                        <a href="https://wa.me/60195161874?text=Salam%2C%20saya%20berminat%20untuk%20membuat%20undangan%20digital%20dengan%20SatuJiwa.%20Boleh%20saya%20tahu%20lebih%20lanjut%3F" target="_blank" class="btn-whatsapp">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                            Order via WhatsApp
                        </a>
                    @endauth
                </div>

                <div class="hero-stats">
                    <div class="stat"><div class="stat-num">500+</div><div class="stat-label">Majlis Berjaya</div></div>
                    <div class="stat-divider"></div>
                    <div class="stat"><div class="stat-num">98%</div><div class="stat-label">Kepuasan Pelanggan</div></div>
                    <div class="stat-divider"></div>
                    <div class="stat"><div class="stat-num">10k+</div><div class="stat-label">RSVP Diterima</div></div>
                </div>

                <div class="trust-badges">
                    <div class="trust-badge"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>Selamat & Privasi</div>
                    <div class="trust-badge"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>Setup 5 Minit</div>
                    <div class="trust-badge"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>Mobile-Friendly</div>
                </div>
            </div>

            <!-- RIGHT: Mockup -->
            <div class="hero-visual">
                <div class="mockup-banner">
                    <div class="mockup-corner tl"></div>
                    <div class="mockup-corner br"></div>
                    <!--
                    GANTI GAMBAR: tukar src kepada gambar anda
                    <img src="{{ asset('images/mockup-preview1.PNG') }}" alt="SatuJiwa Preview" style="width:100%;height:100%;object-fit:cover;display:block;">
                    -->
                    <img src="{{ asset('images/mockup-preview1.PNG') }}"
                         alt="SatuJiwa Preview"
                         style="width:100%;height:100%;object-fit:cover;display:block;">
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"><div class="line"></div><div class="ornament">✿</div><div class="line"></div></div>

    <!-- FEATURES -->
    <section class="features">
        <div class="section-header reveal">
            <div class="section-eyebrow">Kenapa SatuJiwa</div>
            <h2 class="section-title">Direka untuk <em>Hari Istimewa</em> Anda</h2>
        </div>
        <div class="features-grid reveal">
            <div class="feature-card"><div class="feature-icon-wrap feat-icon"><svg viewBox="0 0 24 24"><circle cx="13.5" cy="6.5" r=".5" fill="var(--rose)"/><circle cx="17.5" cy="10.5" r=".5" fill="var(--rose)"/><circle cx="8.5" cy="7.5" r=".5" fill="var(--rose)"/><circle cx="6.5" cy="12.5" r=".5" fill="var(--rose)"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg></div><div class="feature-name">Tema yang Cantik</div><p class="feature-desc">Pelbagai pilihan tema warna dan fon yang elegan untuk disesuaikan sepenuhnya dengan majlis anda.</p></div>
            <div class="feature-card"><div class="feature-icon-wrap feat-icon"><svg viewBox="0 0 24 24"><path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></div><div class="feature-name">Aturcara Majlis</div><p class="feature-desc">Susun slot aturcara majlis anda dengan kemas untuk rujukan tetamu sepanjang hari bahagia.</p></div>
            <div class="feature-card"><div class="feature-icon-wrap feat-icon"><svg viewBox="0 0 24 24"><path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 1.9l.58 14.15a2 2 0 002 1.92h14.28a2 2 0 002-1.92l.58-14.15a2 2 0 00-1.34-1.9zM12 11.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg></div><div class="feature-name">Tema Pakaian</div><p class="feature-desc">Beritahu tetamu tema warna atau kod etika pakaian (dress code) untuk keselarasan foto majlis.</p></div>
            <div class="feature-card"><div class="feature-icon-wrap feat-icon"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div><div class="feature-name">Galeri Gambar</div><p class="feature-desc">Muat naik gambar pra-nikah dan galeri untuk dikongsikan bersama tetamu istimewa anda.</p></div>
            <div class="feature-card"><div class="feature-icon-wrap feat-icon"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div><div class="feature-name">Lokasi & Navigasi</div><p class="feature-desc">Integrasi Google Maps dan Waze memudahkan tetamu mencari lokasi majlis dengan tepat.</p></div>
            <div class="feature-card"><div class="feature-icon-wrap feat-icon"><svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div><div class="feature-name">RSVP & Ucapan</div><p class="feature-desc">Tetamu boleh menghantar kehadiran dan ucapan tahniah terus melalui undangan digital anda.</p></div>
            <div class="feature-card"><div class="feature-icon-wrap feat-icon"><svg viewBox="0 0 24 24"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg></div><div class="feature-name">Muzik Latar</div><p class="feature-desc">Tambah lagu pilihan untuk menghidupkan suasana romantik dan berkesan dalam undangan anda.</p></div>
            <div class="feature-card"><div class="feature-icon-wrap feat-icon"><svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg></div><div class="feature-name">Wang Digital</div><p class="feature-desc">Tetamu boleh menghantar hadiah wang dengan mudah melalui QR DuitNow atau nombor akaun.</p></div>

        </div>
    </section>

    <div class="section-divider"><div class="line"></div><div class="ornament">✿</div><div class="line"></div></div>

    <!-- HOW IT WORKS -->
    <section class="how">
        <div class="section-header reveal"><div class="section-eyebrow">Cara Penggunaan</div><h2 class="section-title">Mudah dalam <em>Tiga Langkah</em></h2></div>
        <div class="steps reveal">
            <div class="step"><div class="step-dot"><div class="step-num">01</div></div><div class="step-title">Log Masuk</div><p class="step-desc">Log masuk ke akaun anda dan akses dashboard undangan digital dengan mudah.</p></div>
            <div class="step"><div class="step-dot"><div class="step-num">02</div></div><div class="step-title">Sesuaikan</div><p class="step-desc">Pilih tema, masukkan maklumat majlis, muat naik gambar dan tetapkan muzik pilihan.</p></div>
            <div class="step"><div class="step-dot"><div class="step-num">03</div></div><div class="step-title">Kongsi</div><p class="step-desc">Salin pautan dan kongsi kepada tetamu melalui WhatsApp, Telegram atau media sosial.</p></div>
        </div>
    </section>

    <div class="section-divider"><div class="line"></div><div class="ornament">✿</div><div class="line"></div></div>

    <!-- TESTIMONIALS -->
    <section class="testimonials">
        <div class="section-header reveal"><div class="section-eyebrow">Kata Mereka</div><h2 class="section-title">Dipercayai oleh <em>Pasangan</em> Malaysia</h2></div>
        <div class="testimonials-grid reveal">
            <div class="testimonial-card"><div class="testimonial-stars"><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span></div><p class="testimonial-text">"Undangan kami sangat cantik dan tetamu terkesan dengan rekaan yang mewah. Sangat mudah untuk disediakan dan dikongsi!"</p><div class="testimonial-author"><div class="author-avatar">AN</div><div><div class="author-name">Alia & Nazrin</div><div class="author-loc">Kuala Lumpur · Mac 2025</div></div></div></div>
            <div class="testimonial-card"><div class="testimonial-stars"><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span></div><p class="testimonial-text">"Semua tetamu memuji betapa cantiknya undangan digital kami. Ciri RSVP sangat membantu dalam merancang majlis."</p><div class="testimonial-author"><div class="author-avatar">SR</div><div><div class="author-name">Siti & Rashdan</div><div class="author-loc">Johor Bahru · Feb 2025</div></div></div></div>
            <div class="testimonial-card"><div class="testimonial-stars"><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span></div><p class="testimonial-text">"SatuJiwa menjadikan hari istimewa kami lebih berkesan. Muzik latar dan galeri gambar adalah sentuhan yang sempurna!"</p><div class="testimonial-author"><div class="author-avatar">FH</div><div><div class="author-name">Farah & Hafiz</div><div class="author-loc">Penang · Jan 2025</div></div></div></div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="cta-box reveal">
            <div class="section-eyebrow" style="display:inline-flex;margin-bottom:14px;">Mulakan Sekarang</div>
            <h2 class="section-title" style="margin-bottom:14px;">Siap untuk <em>Majlis</em> Anda?</h2>
            <p>Mula cipta undangan digital yang memukau untuk hari bahagia anda. Setup dalam masa kurang dari 5 minit.</p>
            <div class="hero-actions">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
                @else
                    <a href="https://satujiwa.my/naim-nabila" target="_blank" class="btn-ghost">Lihat Demo Live</a>
                    <a href="https://wa.me/60195161874?text=Salam%2C%20saya%20berminat%20untuk%20membuat%20undangan%20digital%20dengan%20SatuJiwa.%20Boleh%20saya%20tahu%20lebih%20lanjut%3F" target="_blank" class="btn-whatsapp">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                        Order via WhatsApp
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-logo">Satu<span>Jiwa</span></div>
        <p>© {{ date('Y') }} SatuJiwa · Undangan Digital Malaysia</p>
        <div class="footer-links"><a href="#">Privasi</a><a href="#">Terma</a><a href="#">Hubungi</a></div>
    </footer>

    <!-- WA FLOAT -->
    <a href="https://wa.me/60195161874?text=Salam%2C%20saya%20berminat%20untuk%20membuat%20undangan%20digital%20dengan%20SatuJiwa.%20Boleh%20saya%20tahu%20lebih%20lanjut%3F" target="_blank" class="wa-float" title="Order via WhatsApp">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
    </a>

    <script>
        // NAV SCROLL
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => { navbar.classList.toggle('scrolled', window.scrollY > 50); }, { passive: true });

        // FLOATING PETALS
        const petalContainer = document.getElementById('petals');
        const COLORS = ['#E8B4BE','#F5D9DE','#C9A06A','#E8D0A0','#F0C8D0','#FADADD'];
        for (let i = 0; i < 24; i++) {
            const p = document.createElement('div');
            p.className = 'petal';
            const size = Math.random() * 11 + 6;
            p.style.cssText = `width:${size}px;height:${size*1.5}px;background:${COLORS[Math.floor(Math.random()*COLORS.length)]};left:${Math.random()*100}%;animation-duration:${Math.random()*18+12}s;animation-delay:${Math.random()*16}s;opacity:0;`;
            petalContainer.appendChild(p);
        }

        // SCROLL REVEAL
        const reveals = document.querySelectorAll('.reveal');
        new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { setTimeout(() => e.target.classList.add('visible'), 80); } });
        }, { threshold: 0.12 }).observe ? document.querySelectorAll('.reveal').forEach(el => {
            new IntersectionObserver((entries) => {
                entries.forEach(e => { if(e.isIntersecting){ setTimeout(()=>e.target.classList.add('visible'),80); } });
            }, {threshold:0.12}).observe(el);
        }) : null;
    </script>

</body>
</html>