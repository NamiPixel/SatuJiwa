<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>{{ $invitation->nama_majlis }} — {{ $invitation->nama_ringkas_lelaki }}{{ $invitation->bilangan_pengantin == 2 ? ' & '.$invitation->nama_ringkas_perempuan : '' }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
@php
$fonTajuk = $invitation->fon_tajuk ?? 'Cormorant Garamond';
$fonBadan = $invitation->fon_badan ?? 'DM Sans';

function hexBrightness(string $hex): float {
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    }
    [$r, $g, $b] = array_map('hexdec', str_split($hex, 2));
    return 0.299 * $r + 0.587 * $g + 0.114 * $b;
}


$themeColors = [
    'emas-klasik' => ['bg'=>'#0F0B06','bg2'=>'#1A1208','accent'=>'#C9A96E','light'=>'#E8D5B0','dark'=>false],
    'hijau-sage'  => ['bg'=>'#081410','bg2'=>'#0D1F1A','accent'=>'#8DB8A8','light'=>'#B8D4C4','dark'=>false],
    'ros-lembut'  => ['bg'=>'#100810','bg2'=>'#1A0D14','accent'=>'#D4829A','light'=>'#E8B4C8','dark'=>false],
    'biru-sendu'  => ['bg'=>'#080D14','bg2'=>'#0D1525','accent'=>'#7A9EC8','light'=>'#A4C3E8','dark'=>false],
    'krim-coklat' => ['bg'=>'#F0E8D8','bg2'=>'#E8DCC8','accent'=>'#8B6914','light'=>'#6B4E10','dark'=>true],
    'hitam-putih' => ['bg'=>'#141414','bg2'=>'#1A1A1A','accent'=>'#C8C8C8','light'=>'#E8E8E8','dark'=>false],
    'tembaga'     => ['bg'=>'#100A06','bg2'=>'#2C1A0A','accent'=>'#C8855A','light'=>'#D4956A','dark'=>false],
    'putih-mutiara' => ['bg'=>'#FFFFFF','bg2'=>'#F8F8F8','accent'=>'#A8A8A8','light'=>'#707070','dark'=>true],
    'kuning-pastel' => ['bg'=>'#FFF9E3','bg2'=>'#FFF1C2','accent'=>'#D4AF37','light'=>'#8B7500','dark'=>true],
    'biru-awan'     => ['bg'=>'#F0F7FF','bg2'=>'#E0EEFF','accent'=>'#4A90E2','light'=>'#2171CD','dark'=>true],
    'pink-rose-gold'=> ['bg'=>'#FFF0F5','bg2'=>'#FADADD','accent'=>'#B76E79','light'=>'#8E565F','dark'=>true],
    'hijau-mint'    => ['bg'=>'#F5FFFA','bg2'=>'#E0FFF0','accent'=>'#3EB489','light'=>'#2D8E69','dark'=>true],
    'ungu-lilac'    => ['bg'=>'#F8F4FF','bg2'=>'#E6E0FF','accent'=>'#967BB6','light'=>'#745D8F','dark'=>true],
    'coklat-latte'  => ['bg'=>'#FAF5EF','bg2'=>'#F0E6D6','accent'=>'#A67B5B','light'=>'#7F5F46','dark'=>true],
];


$tema = $invitation->tema_warna ?? 'emas-klasik';
if ($tema === 'custom') {
    $bgHex     = $invitation->warna_bg    ?? '#0F0B06';
    $accentHex = $invitation->warna_aksen ?? '#C9A96E';
    $bgBrightness = hexBrightness($bgHex);
    $isDark = $bgBrightness > 128;
    $colors = [
        'bg'     => $bgHex,
        'bg2'    => $bgHex,
        'accent' => $accentHex,
        'light'  => $accentHex,
        'dark'   => $isDark,
    ];
} else {
    $colors = $themeColors[$tema] ?? $themeColors['emas-klasik'];
    $isDark = $colors['dark'] ?? false;
}



$headerImg = $invitation->header_image ? Storage::url($invitation->header_image) : null;

$textMain   = $isDark ? '#1A1208' : '#F5EDD8';
$textMuted  = $isDark ? 'rgba(26,18,8,0.55)' : 'rgba(245,237,216,0.55)';
$borderCol  = $isDark ? 'rgba(139,105,20,0.22)' : 'rgba(201,169,110,0.18)';
$navBg      = $isDark ? 'rgba(240,232,216,0.97)' : 'rgba(10,8,4,0.96)';
$popupBg    = $colors['bg2'];
$inputBg    = $isDark ? 'rgba(0,0,0,0.06)' : 'rgba(255,255,255,0.06)';
$inputColor = $isDark ? '#1A1208' : '#F5EDD8';

// AUTO HEADER TEXT — gelap jika tema cerah, cerah jika tema gelap
$hTextColor  = $isDark ? '#2C1A06'                    : '#F5EDD8';
$hMutedColor = $isDark ? 'rgba(44,26,6,0.7)'          : 'rgba(232,213,176,0.75)';
$hShadow     = $isDark
    ? '0 1px 0px rgba(255,255,255,0.6), 0 2px 12px rgba(255,255,255,0.25)'
    : '0 2px 20px rgba(0,0,0,0.5)';
$hAccent     = $isDark ? '#7A4F10'                    : $colors['accent'];
$hAccentMuted= $isDark ? 'rgba(122,79,16,0.8)'        : $colors['accent'];
@endphp
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=DM+Sans:wght@300;400;500&family=Great+Vibes&family={{ urlencode($fonTajuk) }}:ital,wght@0,400;0,600;1,400&family={{ urlencode($fonBadan) }}:wght@300;400;500&display=swap" rel="stylesheet">
<style>

.mini-cal {
    background: rgba(201,169,110,.06);
    border: 1px solid var(--border);
    border-radius: 14px; overflow: hidden;
    box-shadow: none;
    max-width: 220px; margin: 18px auto 0;
    opacity: 0; transform: translateY(30px) scale(0.95);
    transition: opacity 0.8s cubic-bezier(.22,1,.36,1), transform 0.8s cubic-bezier(.22,1,.36,1);
}
.mini-cal.in-view { opacity: 1; transform: translateY(0) scale(1) }

.mini-cal-header {
    background: rgba(201,169,110,.12);
    border-bottom: 1px solid var(--border);
    padding: 10px 16px 8px; text-align: center;
}
.mini-cal-month {
    font-family: 'DM Sans', sans-serif; font-size: 11px;
    letter-spacing: 4px; text-transform: uppercase;
    color: var(--gold); font-weight: 500;
}
.mini-cal-year {
    font-family: 'Cormorant Garamond', serif; font-size: 13px;
    color: var(--muted); letter-spacing: 2px; margin-top: 2px;
}
.mini-cal-body { padding: 10px 12px 14px }
.mini-cal-weekdays {
    display: grid; grid-template-columns: repeat(7,1fr);
    margin-bottom: 4px;
}
.mini-cal-weekday {
    text-align: center; font-size: 9px; font-family: 'DM Sans', sans-serif;
    color: var(--gold); opacity: .6; letter-spacing: 0.5px; padding: 2px 0; font-weight: 500;
}
.mini-cal-days {
    display: grid; grid-template-columns: repeat(7,1fr); gap: 1px;
}
.mini-cal-day {
    text-align: center; font-size: 11px; font-family: 'DM Sans', sans-serif;
    color: var(--text); padding: 4px 2px; border-radius: 6px; line-height: 1.3;
}
.mini-cal-day.empty { color: transparent }
.mini-cal-day.sunday { color: var(--gold); opacity: .45 }
.mini-cal-day.event-day {
    background: var(--gold);
    color: var(--bg) !important; font-weight: 700; border-radius: 50%;
    width: 26px; height: 26px; display: flex; align-items: center; justify-content: center;
    margin: 0 auto;
    box-shadow: 0 3px 12px rgba(201,169,110,0.35);
    animation: datePulse 2s ease-in-out infinite;
}
.mini-cal-day.event-day.sunday { color: var(--bg) !important; opacity: 1 }
@keyframes datePulse {
    0%,100% { box-shadow: 0 3px 12px rgba(201,169,110,0.35) }
    50%      { box-shadow: 0 3px 20px rgba(201,169,110,0.6), 0 0 0 4px rgba(201,169,110,0.12) }
}
:root {
    --bg: {{ $colors['bg'] }};
    --bg2: {{ $colors['bg2'] }};
    --gold: {{ $colors['accent'] }};
    --gold-light: {{ $colors['light'] }};
    --text: {{ $textMain }};
    --muted: {{ $textMuted }};
    --border: {{ $borderCol }};
    --nav-bg: {{ $navBg }};
    --input-bg: {{ $inputBg }};
    --input-color: {{ $inputColor }};
    --popup-bg: {{ $popupBg }};
    /* Header text vars — auto ikut tema */
    --h-text: {{ $hTextColor }};
    --h-muted: {{ $hMutedColor }};
    --h-shadow: {{ $hShadow }};
    --h-accent: {{ $hAccent }};
}
*{margin:0;padding:0;box-sizing:border-box;-webkit-tap-highlight-color:transparent}
html{scroll-behavior:smooth}
body{overscroll-behavior-y: none;background:var(--bg);color:var(--text);font-family:'{{ $fonBadan }}',sans-serif;overflow-x:hidden}
body.no-scroll{overflow:hidden}

/* OPENING */
#opening{position:fixed;inset:0;z-index:1000;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;overflow:hidden}
.op-bg{position:absolute;inset:0;background-image:url('{{ $headerImg ?? "" }}');background-size:cover;background-position:center;background-repeat:no-repeat}
.op-content{position:relative;z-index:2;padding:0 32px;width:100%}
.op-label{font-size:10px;letter-spacing:5px;text-transform:uppercase;color:var(--h-accent);margin-bottom:14px;opacity:.9}
.op-names{font-family:'{{ $fonTajuk }}',cursive,serif;font-size:52px;color:var(--h-text);line-height:1.2;margin-bottom:8px;text-shadow:var(--h-shadow)}
.op-and{font-family:'{{ $fonTajuk }}',cursive,serif;font-size:28px;color:var(--h-accent);opacity:.8;line-height:1;margin:2px 0}
.op-date{font-family:'Cormorant Garamond',serif;font-size:18px;color:var(--h-muted);letter-spacing:4px;margin-top:6px;margin-bottom:32px;text-transform:uppercase;font-weight:700;}
.open-btn{background:{{ $isDark ? 'rgba(122,79,16,0.15)' : 'rgba(201,169,110,.22)' }};border:1px solid {{ $isDark ? 'rgba(122,79,16,0.5)' : 'rgba(201,169,110,.5)' }};border-radius:50px;padding:14px 44px;color:var(--h-text);font-size:11px;letter-spacing:4px;text-transform:uppercase;cursor:pointer;transition:all .3s;font-family:'DM Sans',sans-serif;position:relative;overflow:hidden}
.open-btn:active{transform:scale(.97)}
@keyframes pulse{0%,100%{box-shadow:0 0 0 0 rgba(201,169,110,.3)}50%{box-shadow:0 0 0 12px rgba(201,169,110,0)}}
.open-btn{animation:pulse 2.5s ease-in-out infinite}
#opening.fade-out{animation:fadeOut .8s ease-out forwards}
@keyframes fadeOut{to{opacity:0;pointer-events:none}}

/* MAIN */
#invite{display:none;opacity:0;transition:opacity .8s ease}
#invite.visible{opacity:1}

/* HEADER */
.inv-header{position:relative;height:100svh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;overflow:hidden}
.inv-header-content{position:relative;z-index:2;padding:0 28px;width:100%}
.inv-header-bg{position:absolute;inset:0;background-image:url('{{ $headerImg ?? "" }}');background-size:cover;background-position:center;background-repeat:no-repeat}
.inv-header-overlay{position:absolute;inset:0;}
.h-label{font-size:10px;letter-spacing:5px;text-transform:uppercase;color:var(--h-accent);margin-bottom:14px;opacity:.9}
.h-names{font-family:'{{ $fonTajuk }}',cursive,serif;font-size:46px;color:var(--h-text);line-height:1.2;text-shadow:var(--h-shadow)}
.h-and{font-family:'{{ $fonTajuk }}',cursive,serif;font-size:24px;color:var(--h-accent);opacity:.8;margin:4px 0}
.h-date{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:700;letter-spacing:4px;color:var(--h-muted);margin-top:10px;text-transform:uppercase;}
.scroll-hint{margin-top:28px;animation:bounce 2s infinite;opacity:.4;font-size:16px;color:var(--h-text)}
@keyframes bounce{0%,100%{transform:translateY(0)}50%{transform:translateY(7px)}}

/* SECTIONS */
section{padding:48px 24px;max-width:480px;margin:0 auto}
.divider{text-align:center;color:var(--gold);opacity:.5;display:flex;align-items:center;justify-content:center;gap:14px;margin:6px 0}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border);max-width:70px}
.section-title{font-family:'{{ $fonTajuk }}',serif;font-size:26px;text-align:center;margin-bottom:4px;color:var(--gold-light)}
.section-sub{text-align:center;font-size:10px;color:var(--muted);letter-spacing:3px;text-transform:uppercase;margin-bottom:20px}
.jemputan-section{text-align:center}
.basmallah{font-size:18px;color:var(--gold);margin-bottom:16px;font-family:'Cormorant Garamond',serif;font-style:italic}
.ibu-bapa{font-family:'Cormorant Garamond',serif;font-size:20px;line-height:1.9;margin-bottom:10px;color:var(--text)}
.jemputan-text{font-size:15px;color:var(--muted);line-height:2;margin-bottom:20px}
.pengantin-name{font-family:'{{ $fonTajuk }}',cursive,serif;font-size:22px;color:var(--gold-light);line-height:1.25}

/* ===== RUMI TEXT (Pecah huruf demi huruf) ===== */
.pengantin-name.reveal-text {
    opacity: 1 !important;
    filter: none !important;
    transform: none !important;
    display: block;
}

.reveal-text span {
    display: inline-block;
    opacity: 0;
    filter: blur(8px);
    transform: translateY(30px) scale(1.2);
    transition: 
        opacity 0.8s cubic-bezier(0.22, 1, 0.36, 1),
        filter 0.8s cubic-bezier(0.22, 1, 0.36, 1),
        transform 0.8s cubic-bezier(0.22, 1, 0.36, 1);
    transition-delay: calc(var(--char-index) * 0.015s);
}

.reveal-text.is-visible span {
    opacity: 1;
    filter: blur(0);
    transform: translateY(0) scale(1);
}

/* ===== ARABIC/JAWI TEXT (Bersambung, RTL, reveal keseluruhan) ===== */
.pengantin-name.reveal-arabic {
    direction: rtl;
    unicode-bidi: bidi-override;
    opacity: 0;
    filter: blur(15px);
    transform: scale(0.9) translateY(20px);
    transition: 
        opacity 1.5s cubic-bezier(0.22, 1, 0.36, 1),
        filter 1.5s ease,
        transform 1.5s cubic-bezier(0.22, 1, 0.36, 1);
}

.pengantin-name.reveal-arabic.is-visible {
    opacity: 1;
    filter: blur(0);
    transform: scale(1) translateY(0);
}

/* INFO BOXES */
.info-boxes{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:16px}
.info-box{background:rgba(201,169,110,.06);border:1px solid var(--border);border-radius:12px;padding:14px 10px;text-align:center}
.info-box-icon{margin-bottom:6px;display:flex;align-items:center;justify-content:center}
.info-box-label{font-size:9px;letter-spacing:2px;text-transform:uppercase;color:var(--gold);margin-bottom:6px;opacity:.8}
.info-box-val{font-family:'Cormorant Garamond',serif;font-size:15px;line-height:1.6;color:var(--text)}

/* GALLERY SLIDER — premium */

.card-slider-root{padding:20px 32px 16px;position:relative}
.card-slider-stage{position:relative;height:300px;overflow:visible}
.card-slider-wrap{position:absolute;top:50%;will-change:transform,opacity;cursor:pointer}
.card-slider-card{width:220px;height:220px;border-radius:16px;overflow:hidden;background:rgba(201,169,110,.06);border:1.5px solid var(--border);display:flex;align-items:center;justify-content:center;margin-left:-110px}
.card-slider-card img{width:100%;height:100%;object-fit:cover;display:block;pointer-events:none}
.card-slider-nav{position:absolute;top:50%;transform:translateY(-50%);width:38px;height:38px;border-radius:50%;background:rgba(201,169,110,.12);border:1px solid rgba(201,169,110,.35);display:flex;align-items:center;justify-content:center;cursor:pointer;z-index:20;color:var(--gold);font-size:22px;line-height:1;transition:background .2s;padding:0}
.card-slider-nav:hover{background:rgba(201,169,110,.22)}
.card-slider-prev{left:0}
.card-slider-next{right:0}
.card-slider-dots{display:flex;justify-content:center;gap:6px;margin-top:16px}
.card-slider-dot{width:6px;height:6px;border-radius:3px;background:var(--border);cursor:pointer;transition:all .35s cubic-bezier(.34,1.56,.64,1)}
.card-slider-dot.on{width:20px;background:var(--gold)}

.slider-wrap{position:relative;overflow:hidden;width:100%;background:#000}
.slider-track{display:flex;transition:transform .6s cubic-bezier(.77,0,.18,1);align-items:stretch}
.slide{min-width:100%;max-width:100%;overflow:hidden;position:relative}
.slide img{width:100%;height:72vw;max-height:480px;object-fit:cover;display:block;cursor:zoom-in;transition:transform .6s ease}
.slide img:active{transform:scale(1.02)}
/* gradient overlay bawah untuk counter */
.slide::after{content:'';position:absolute;bottom:0;left:0;right:0;height:80px;background:linear-gradient(to top,rgba(0,0,0,.55),transparent);pointer-events:none}
.slider-nav{position:absolute;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);backdrop-filter:blur(8px);border-radius:50%;width:40px;height:40px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:white;font-size:20px;z-index:5;transition:all .2s;-webkit-backdrop-filter:blur(8px)}
.slider-nav:active{background:rgba(255,255,255,.25);transform:translateY(-50%) scale(.93)}
.slider-prev{left:14px}
.slider-next{right:14px}
/* dots — lebih elegant */
.slider-dots{display:flex;justify-content:center;align-items:center;gap:6px;margin-top:14px}
.dot{width:4px;height:4px;border-radius:50%;background:var(--border);cursor:pointer;transition:all .4s cubic-bezier(.22,1,.36,1)}
.dot.active{background:var(--gold);width:24px;border-radius:2px}
/* counter — pindah ke dalam gradient */
.slide-counter{position:absolute;bottom:14px;right:16px;font-family:'Cormorant Garamond',serif;font-size:13px;color:rgba(255,255,255,.9);z-index:3;letter-spacing:2px}
/* caption bar atas */
.slide-caption{position:absolute;top:0;left:0;right:0;padding:12px 16px;background:linear-gradient(to bottom,rgba(0,0,0,.4),transparent);font-size:9px;letter-spacing:4px;text-transform:uppercase;color:rgba(255,255,255,.6);z-index:3;font-family:'DM Sans',sans-serif}

/* TAGLINE */
.tagline-section{text-align:center;padding:32px 24px}
.tagline-text{font-family:'Cormorant Garamond',serif;font-style:italic;font-size:16px;color:var(--muted);line-height:1.9}

/* CTA */
.cta-row{display:flex;flex-direction:column;gap:10px;padding:0 24px 40px;max-width:480px;margin:0 auto}
.cta-btn{display:flex;align-items:center;justify-content:center;gap:10px;padding:15px 24px;border-radius:50px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;transition:all .2s;letter-spacing:.5px;border:none;width:100%;font-family:'DM Sans',sans-serif}
.cta-primary{background:linear-gradient(135deg,var(--gold),#A07840);color:#1A1208;font-weight:700}
.cta-outline{background:transparent;border:1px solid var(--border);color:var(--gold)}
.cta-outline:active{background:rgba(201,169,110,.1)}

/* WISHES */
.wish-item{background:rgba(201,169,110,.05);border:1px solid var(--border);border-radius:10px;padding:14px;margin-bottom:10px}
.wish-name{font-size:12px;font-weight:500;color:var(--gold);margin-bottom:4px}
.wish-text{font-size:12px;color:var(--muted);line-height:1.7}

/* BOTTOM NAV */
.bottom-nav{position:fixed;bottom:0;left:0;right:0;z-index:200;background:var(--nav-bg);backdrop-filter:blur(14px);border-top:1px solid var(--border);display:flex;padding-bottom:env(safe-area-inset-bottom,0);transform:translateZ(0);-webkit-transform:translateZ(0);will-change:transform}
.nav-tab{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:9px 4px 7px;cursor:pointer;color:var(--muted);font-size:9px;letter-spacing:.5px;text-transform:uppercase;transition:color .2s;gap:3px;border:none;background:none;font-family:'DM Sans',sans-serif}
.nav-tab:active{color:var(--gold)}
.nav-tab svg{width:20px;height:20px}

/* POPUP */
.popup-overlay{position:fixed;inset:0;background:rgba(0,0,0,.75);z-index:500;display:flex;align-items:flex-end;justify-content:center;opacity:0;pointer-events:none;transition:opacity .3s}
.popup-overlay.show{opacity:1;pointer-events:all}
.popup-sheet{background:var(--popup-bg);border-top:1px solid var(--border);border-radius:20px 20px 0 0;width:100%;max-width:540px;padding:24px 20px 40px;transform:translateY(100%);transition:transform .35s cubic-bezier(.25,.46,.45,.94);max-height:88svh;overflow-y:auto}
.popup-overlay.show .popup-sheet{transform:translateY(0)}
.popup-handle{width:36px;height:4px;background:var(--border);border-radius:2px;margin:0 auto 16px}
.popup-title{font-family:'{{ $fonTajuk }}',serif;font-size:22px;margin-bottom:16px;text-align:center;color:var(--gold-light)}

/* CONTACT */
.contact-card{background:rgba(201,169,110,.06);border:1px solid var(--border);border-radius:12px;padding:14px;margin-bottom:10px}
.contact-name{font-size:13px;font-weight:500;color:var(--text);margin-bottom:2px}
.contact-no{font-size:11px;color:var(--muted);margin-bottom:10px;font-family:monospace}
.contact-btns{display:flex;gap:8px}
.cbtn{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:11px;border-radius:8px;font-size:12px;text-decoration:none;transition:all .2s;font-family:'DM Sans',sans-serif;font-weight:500}
.cbtn-call{background:rgba(76,175,125,.12);color:#3D9E6A;border:1px solid rgba(76,175,125,.3)}
.cbtn-wa{background:rgba(37,211,102,.12);color:#1DA851;border:1px solid rgba(37,211,102,.3)}

/* INPUTS */
.inv-input{width:100%;background:var(--input-bg);border:1px solid var(--border);border-radius:10px;padding:13px 14px;color:var(--input-color);font-size:13px;outline:none;font-family:'DM Sans',sans-serif;margin-bottom:10px;transition:border-color .2s}
.inv-input:focus{border-color:var(--gold)}
.inv-input::placeholder{color:var(--muted)}
.inv-submit{width:100%;background:linear-gradient(135deg,var(--gold),#A07840);border:none;border-radius:50px;padding:15px;color:#1A1208;font-weight:700;font-size:14px;cursor:pointer;font-family:'DM Sans',sans-serif;margin-top:4px}

/* RSVP OPTIONS */
.rsvp-status-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:12px}
.rsvp-opt{background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:10px;padding:14px 6px 10px;cursor:pointer;font-size:10px;color:var(--muted);transition:all .25s;text-align:center;font-family:'DM Sans',sans-serif;letter-spacing:.3px;display:flex;flex-direction:column;align-items:center;gap:8px}
.rsvp-opt svg{width:26px;height:26px}
.rsvp-opt.selected{border-color:var(--gold);color:var(--gold);background:rgba(201,169,110,.1)}

/* CALENDAR */
.cal-box{text-align:center;background:rgba(201,169,110,.08);border:1px solid var(--border);border-radius:10px;padding:12px 4px}
.cal-num{font-family:'Cormorant Garamond',serif;font-size:28px;color:var(--gold)}
.cal-lbl{font-size:9px;color:var(--muted);text-transform:uppercase;letter-spacing:1px}
.cal-link{flex:1;display:flex;align-items:center;justify-content:center;gap:10px;padding:14px;border-radius:12px;font-size:12px;cursor:pointer;text-decoration:none;border:1px solid var(--border);color:var(--text);background:rgba(255,255,255,.03);transition:all .2s;font-family:'DM Sans',sans-serif;font-weight:500}
.cal-link:active{background:rgba(201,169,110,.08)}

/* MUSIC */
#musicBar{position:fixed;top:14px;right:14px;z-index:999;background:{{ $isDark ? 'rgba(240,232,216,0.92)' : 'rgba(10,8,4,.9)' }};border:1px solid var(--border);border-radius:50px;padding:8px 16px;display:flex;align-items:center;gap:8px;font-size:11px;color:var(--gold);cursor:pointer;backdrop-filter:blur(8px);transform:translateY(-80px);transition:transform .4s ease}
#musicBar.show{transform:translateY(0)}
.bars{display:flex;gap:2px;align-items:flex-end}
.bar{width:3px;background:var(--gold);border-radius:2px;animation:barAnim .8s ease-in-out infinite alternate}
.bar:nth-child(2){animation-delay:.15s}
.bar:nth-child(3){animation-delay:.3s}
@keyframes barAnim{from{height:4px}to{height:13px}}
.bars.paused .bar{animation-play-state:paused}

/* FADE IN */
.fade-in{opacity:0;transform:translateY(60px)}
.info-box{opacity:0;transform:translateY(50px) scale(.93)}
.wish-item{opacity:0;transform:translateX(-50px)}
.divider{opacity:0;transform:scaleX(0)}
.pengantin-name{opacity:0;transform:scale(.75) translateY(24px)}

.spacer{height:72px}

/* FULL IMG */
#fullImgWrap{display:none;position:fixed;inset:0;background:rgba(0,0,0,.94);z-index:1500;align-items:center;justify-content:center;cursor:zoom-out}
#fullImg{max-width:96vw;max-height:96vh;border-radius:6px;object-fit:contain}

/* MAP CARDS */
.map-card{display:flex;align-items:center;gap:14px;text-decoration:none;color:var(--text);background:rgba(201,169,110,.06);border:1px solid var(--border);border-radius:12px;padding:16px;margin-bottom:10px;transition:background .2s}
.map-card:active{background:rgba(201,169,110,.12)}
.map-card-icon{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.map-card-text-title{font-size:13px;font-weight:600;color:var(--text)}
.map-card-text-sub{font-size:11px;color:var(--muted);margin-top:2px}

/* ===== BUNGA ANIMATION ===== */
#bungaCanvas{position:fixed;inset:0;pointer-events:none;z-index:10;overflow:hidden;display:none;transform:translateZ(0);-webkit-transform:translateZ(0);will-change:transform}
.kelopak{position:absolute;top:-60px;opacity:0;will-change:transform,opacity;animation:jatuhBunga var(--dur) linear var(--delay) infinite}
@keyframes jatuhBunga{
    0%  {transform:translateY(-60px) translateX(0px) rotate(0deg) scale(var(--sz));opacity:0}
    5%  {opacity:1}
    25% {transform:translateY(25vh) translateX(-25px) rotate(180deg) scale(var(--sz))}
    50% {transform:translateY(50vh) translateX(20px) rotate(360deg) scale(var(--sz))}
    75% {transform:translateY(75vh) translateX(-15px) rotate(540deg) scale(var(--sz))}
    90% {opacity:.8}
    100%{transform:translateY(112vh) translateX(10px) rotate(680deg) scale(calc(var(--sz)*0.6));opacity:0}
}
/* ===== END BUNGA CSS ===== */

/* State asal (hidden) */
.reveal {
    opacity: 0;
    filter: blur(5px);
    transition: 
        opacity 1.2s cubic-bezier(0.25, 1, 0.5, 1), 
        transform 1.2s cubic-bezier(0.25, 1, 0.5, 1),
        filter 1.2s ease;
    will-change: transform, opacity;
}

/* Variasi arah */
.reveal.up { transform: translateY(80px); }
.reveal.down { transform: translateY(-80px); }
.reveal.left { transform: translateX(-80px); }
.reveal.right { transform: translateX(80px); }
.reveal.scale { transform: scale(0.8); }

/* State bila dah masuk view */
.reveal.is-visible {
    opacity: 1;
    transform: translate(0, 0) scale(1);
    filter: blur(0);
}

/* Staggered Delay */
.stagger-item {
    transition-delay: calc(var(--delay) * 100ms);
}
</style>
</head>
<body class="no-scroll">

{{-- OPENING --}}
<div id="opening">
    <div class="op-bg"></div>
    <div class="op-content">
        <div class="op-label">{{ $invitation->nama_majlis }}</div>
        <div class="op-names">{{ $invitation->nama_ringkas_lelaki }}</div>
        @if($invitation->bilangan_pengantin == 2)
        <div class="op-and">&</div>
        <div class="op-names">{{ $invitation->nama_ringkas_perempuan }}</div>
        @endif
        <div class="op-date">{{ $invitation->tarikh_majlis ? $invitation->tarikh_majlis->format('d M Y') : '—' }}</div>
        <button class="open-btn" onclick="openInvite()">✦ &nbsp;Buka&nbsp; ✦</button>
    </div>
</div>

{{-- MAIN --}}
<div id="invite">
<div id="bungaCanvas"></div>
    {{-- HEADER --}}
    <div class="inv-header">
        <div class="inv-header-bg"></div>
        <div class="inv-header-overlay"></div>
        <div class="inv-header-content fade-in">
            <div class="h-label">{{ $invitation->nama_majlis }}</div>
            <div class="h-names">{{ $invitation->nama_ringkas_lelaki }}</div>
            @if($invitation->bilangan_pengantin == 2)
            <div class="h-and">&</div>
            <div class="h-names">{{ $invitation->nama_ringkas_perempuan }}</div>
            @endif
            <div class="h-date">{{ $invitation->tarikh_majlis ? strtoupper($invitation->tarikh_majlis->format('d M Y')) : '—' }}</div>
            <div class="scroll-hint">↓</div>
        </div>
    </div>

    {{-- JEMPUTAN --}}
    <section class="jemputan-section fade-in">
        <div class="divider">✦</div><br>
        <div class="basmallah">Bismillahirrahmanirrahim</div>

        @if($invitation->nama_bapa_lelaki || $invitation->nama_ibu_lelaki)
        <p class="ibu-bapa">{{ $invitation->nama_bapa_lelaki }}@if($invitation->nama_bapa_lelaki && $invitation->nama_ibu_lelaki)<br><span style="font-size:12px;opacity:.4">&</span><br>@endif{{ $invitation->nama_ibu_lelaki }}</p>
        @endif

        @if($invitation->bilangan_pihak == 2 && ($invitation->nama_bapa_perempuan || $invitation->nama_ibu_perempuan))
        <p style="font-size:10px;color:var(--muted);letter-spacing:2px;margin-bottom:6px">BERSAMA</p>
        <p class="ibu-bapa">{{ $invitation->nama_bapa_perempuan }}@if($invitation->nama_bapa_perempuan && $invitation->nama_ibu_perempuan)<br><span style="font-size:12px;opacity:.4">&</span><br>@endif{{ $invitation->nama_ibu_perempuan }}</p>
        @endif

        @if($invitation->ayat_jemputan)
        <p class="jemputan-text">{{ $invitation->ayat_jemputan }}</p>
        @endif

        <div style="margin:24px 0">
            <div class="pengantin-name scale">{{ $invitation->nama_pengantin_lelaki }}</div>
            @if($invitation->bilangan_pengantin == 2)
            <div style="font-family:'Cormorant Garamond',serif;color:var(--gold);font-size:18px;margin:6px 0;opacity:.6">❧</div>
            <div class="pengantin-name scale">{{ $invitation->nama_pengantin_perempuan }}</div>
            @endif
        </div>

        @if($invitation->ayat_penutup)
        <p class="jemputan-text">{{ $invitation->ayat_penutup }}</p>
        @endif
    </section>

{{-- TARIKH --}}
<section class="fade-in" style="text-align:center">
    <div class="section-title">Tarikh Majlis</div>
    <div class="section-sub">Save The Date</div>

    {{-- MINI CALENDAR --}}
    @if($invitation->tarikh_majlis)
    @php
        $tM          = $invitation->tarikh_majlis;
        $firstDay    = (int) \Carbon\Carbon::parse($tM->format('Y-m-01'))->dayOfWeek;
        $daysInMonth = (int) $tM->daysInMonth;
        $targetDay   = (int) $tM->format('j');
    @endphp
    <div class="mini-cal" id="miniCal">
        <div class="mini-cal-header">
            <div class="mini-cal-month">{{ strtoupper($tM->format('F')) }}</div>
            <div class="mini-cal-year">{{ $tM->format('Y') }}</div>
        </div>
        <div class="mini-cal-body">
            <div class="mini-cal-weekdays">
                @foreach(['S','M','T','W','T','F','S'] as $wd)
                <div class="mini-cal-weekday">{{ $wd }}</div>
                @endforeach
            </div>
            <div class="mini-cal-days">
                @for($e = 0; $e < $firstDay; $e++)
                    <div class="mini-cal-day empty">·</div>
                @endfor
                @for($d = 1; $d <= $daysInMonth; $d++)
                    @php $dow = ($firstDay + $d - 1) % 7; @endphp
                    <div class="mini-cal-day
                        {{ $d == $targetDay ? 'event-day' : '' }}
                        {{ $dow == 0 && $d != $targetDay ? 'sunday' : '' }}">
                        {{ $d }}
                    </div>
                @endfor
            </div>
        </div>
    </div>
    @endif

    <div class="info-boxes">
        <div class="info-box up">
            <div class="info-box-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="18" rx="3" fill="var(--gold)" opacity=".15"/><rect x="2" y="4" width="20" height="18" rx="3" stroke="var(--gold)" stroke-width="1.5"/><rect x="2" y="4" width="20" height="6" rx="3" fill="var(--gold)" opacity=".4"/><line x1="8" y1="2" x2="8" y2="7" stroke="var(--gold)" stroke-width="2" stroke-linecap="round"/><line x1="16" y1="2" x2="16" y2="7" stroke="var(--gold)" stroke-width="2" stroke-linecap="round"/><rect x="6" y="13" width="3" height="3" rx="1" fill="var(--gold)"/><rect x="10.5" y="13" width="3" height="3" rx="1" fill="var(--gold)" opacity=".5"/><rect x="15" y="13" width="3" height="3" rx="1" fill="var(--gold)" opacity=".5"/></svg>
            </div>
            <div class="info-box-label">Tarikh</div>
            <div class="info-box-val" style="font-size:16px;line-height:1.6">
                {{ $invitation->tarikh_majlis ? $invitation->tarikh_majlis->format('d M Y') : '—' }}<br>
                <span style="font-size:13px;color:var(--muted)">{{ $invitation->tarikh_majlis ? $invitation->tarikh_majlis->format('l') : '' }}</span>
            </div>
        </div>
        <div class="info-box up">
            <div class="info-box-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="var(--gold)" opacity=".12"/><circle cx="12" cy="12" r="10" stroke="var(--gold)" stroke-width="1.5"/><circle cx="12" cy="12" r="1.5" fill="var(--gold)"/><path d="M12 7v5l3 2" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div class="info-box-label">Masa</div>
            <div class="info-box-val" style="font-size:16px;line-height:1.6">
                {{ $invitation->masa_majlis ? \Carbon\Carbon::parse($invitation->masa_majlis)->format('h:i A') : '—' }}
                @if($invitation->masa_tamat)
                    — {{ \Carbon\Carbon::parse($invitation->masa_tamat)->format('h:i A') }}
                @endif
                <br>
                <span style="font-size:13px;color:var(--muted)">
                    {{ $invitation->masa_tamat ? 'Majlis berlangsung' : 'hingga selesai' }}
                </span>
            </div>
        </div>
        <div class="info-box up" style="grid-column:1/-1">
            <div class="info-box-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="var(--gold)" opacity=".18"/><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" stroke="var(--gold)" stroke-width="1.5"/><circle cx="12" cy="9" r="2.5" fill="var(--gold)"/></svg>
            </div>
            <div class="info-box-label">Lokasi</div>
            <div class="info-box-val" style="font-size:15px;line-height:1.7">{{ $invitation->alamat_majlis ?? '—' }}</div>
        </div>
    </div>
</section>

{{-- TEMA PAKAIAN --}}
    @if($invitation->tema_pakaian)
    <section class="fade-in" style="text-align:center">
        <div class="divider">✦</div>
        <div class="section-title" style="margin-top:14px">Tema Pakaian</div>
        <div class="section-sub">Dress Code</div>
        <div style="display:flex;justify-content:center">
            <div style="background:rgba(201,169,110,.06);border:1px solid var(--border);border-radius:14px;padding:22px 24px;text-align:center;min-width:220px">
                <div style="font-size:9px;letter-spacing:3px;text-transform:uppercase;color:var(--gold);opacity:.7;margin-bottom:10px;font-family:'DM Sans',sans-serif">Tetamu dijemput hadir dengan</div>
                <div style="font-family:'Cormorant Garamond',serif;font-size:22px;color:var(--gold-light);line-height:1.5">{{ $invitation->tema_pakaian }}</div>
            </div>
        </div>
    </section>
    @endif

    {{-- ATURCARA MAJLIS --}}
    @php $aturcara = is_array($invitation->aturcara) ? $invitation->aturcara : []; @endphp
    @if($invitation->aturcara_aktif && count($aturcara) > 0)
    <section class="fade-in">
        <div class="divider">✦</div>
        <div class="section-title" style="margin-top:14px">Aturcara Majlis</div>
        <div class="section-sub">Programme</div>
        <div style="position:relative;margin-top:16px">
            <div style="position:absolute;left:58px;top:8px;bottom:8px;width:1px;background:var(--border);opacity:.6"></div>
            @foreach($aturcara as $i => $item)
            <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:{{ $loop->last ? '0' : '20px' }};position:relative">
                <div style="min-width:44px;text-align:right;flex-shrink:0;padding-top:2px">
                    <div style="font-family:'Times New Roman',serif;font-size:14px;color:var(--gold);letter-spacing:1px;line-height:1.2">{{ $item['masa'] ? \Carbon\Carbon::parse($item['masa'])->format('h:i') : '—' }}</div>
                    <div style="font-size:9px;color:var(--muted);letter-spacing:1px">{{ $item['masa'] ? \Carbon\Carbon::parse($item['masa'])->format('A') : '' }}</div>
                </div>
                <div style="flex-shrink:0;padding-top:5px;position:relative;z-index:1">
                    <div style="width:10px;height:10px;border-radius:50%;background:{{ $loop->first ? 'var(--gold)' : 'var(--border)' }}"></div>
                </div>
                <div style="font-size:14px;color:var(--text);line-height:1.5;padding-top:2px;flex:1">{{ $item['tajuk'] }}</div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

{{-- GALLERY SLIDER --}}
@if($invitation->gallery_aktif && $galleries->count() > 0)
<div class="fade-in" style="padding:32px 0">
    <div style="text-align:center;margin-bottom:20px">
        <div class="divider">✦</div>
        <div class="section-title" style="margin-top:14px">Galeri</div>
        <div class="section-sub">Gallery</div>
    </div>

    <div class="card-slider-root">
        <button class="card-slider-nav card-slider-prev" id="cardBtnL" aria-label="Previous">‹</button>
        <button class="card-slider-nav card-slider-next" id="cardBtnR" aria-label="Next">›</button>
        <div class="card-slider-stage" id="cardStage"></div>
        <div class="card-slider-dots" id="cardDots"></div>
    </div>
</div>
@endif

    {{-- TAGLINE --}}
    @if($invitation->tagline)
    <div class="tagline-section fade-in">
        <div class="divider">— ✦ —</div><br>
        <p class="tagline-text">{!! nl2br(e($invitation->tagline)) !!}</p>
    </div>
    @endif

    {{-- CTA --}}
    <div class="cta-row fade-in">
        <button onclick="openPopup('rsvpPopup')" class="cta-btn cta-primary">RSVP</button>
        @if($invitation->hadiah_aktif && ($invitation->bank_no_akaun || $invitation->qr_image))
        <button onclick="openPopup('giftPopup')" class="cta-btn cta-outline">MONEY GIFT</button>
        @endif
    </div>

    {{-- UCAPAN --}}
    <section class="fade-in">
        <div class="section-title">Ucapan Tetamu</div>
        <div class="section-sub">Guest Book</div>
        <div id="wishesList" style="margin-top:16px;max-height:300px;overflow-y:auto">
            @foreach($wishes as $w)
            <div class="wish-item left"><div class="wish-name">{{ $w->nama }}</div><div class="wish-text">{{ $w->ucapan }}</div></div>
            @endforeach
        </div>
        <button onclick="openPopup('wishPopup')" class="cta-btn cta-outline" style="margin-top:14px">Tinggalkan Ucapan</button>
    </section>



    {{-- FOOTER BRANDING --}}
    <div style="text-align:center;padding:20px 24px 32px;opacity:.45">
        <div style="display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:10px">
            <div style="height:1px;width:28px;background:var(--gold);opacity:.5"></div>
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><polygon points="6,0 7.5,4 12,4 8.5,7 9.5,12 6,9 2.5,12 3.5,7 0,4 4.5,4" fill="var(--gold)" opacity=".7"/></svg>
            <div style="height:1px;width:28px;background:var(--gold);opacity:.5"></div>
        </div>
        <div style="font-family:'DM Sans',sans-serif;font-size:9px;letter-spacing:3px;text-transform:uppercase;color:var">Digital Invitation by</div>
<a href="https://satujiwa.my" target="_blank" style="text-decoration:none;">
    <div style="font-family:'Cormorant Garamond',serif;font-size:15px;letter-spacing:2px;color:var(--gold);margin-top:2px">
        SatuJiwa
    </div>
</a>
    </div>
    
        <div class="spacer"></div>
        
</div>


{{-- BOTTOM NAV --}}
<nav class="bottom-nav" id="bottomNav" style="display:none">
    <button class="nav-tab" onclick="openPopup('contactPopup')">
        <svg viewBox="0 0 24 24" fill="none"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C10.56 21 3 13.44 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.45.57 3.58a1 1 0 01-.24 1.01L6.62 10.79z" fill="currentColor" opacity=".9"/></svg>
        Hubungi
    </button>
    <button class="nav-tab" onclick="openPopup('mapsPopup')">
        <svg viewBox="0 0 24 24" fill="none"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="currentColor" opacity=".9"/><circle cx="12" cy="9" r="2.5" fill="var(--nav-bg)"/></svg>
        Peta
    </button>
    <button class="nav-tab" onclick="openPopup('rsvpPopup')">
        <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="16" rx="2" fill="currentColor" opacity=".9"/><path d="M2 8l10 6 10-6" stroke="var(--nav-bg)" stroke-width="1.5" stroke-linecap="round"/></svg>
        RSVP
    </button>
    <button class="nav-tab" onclick="openPopup('wishPopup')">
        <svg viewBox="0 0 24 24" fill="none"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" fill="currentColor" opacity=".9"/></svg>
        Ucapan
    </button>
    <button class="nav-tab" onclick="openPopup('calendarPopup')">
        <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="17" rx="2" fill="currentColor" opacity=".9"/><rect x="3" y="4" width="18" height="6" rx="2" fill="var(--nav-bg)" opacity=".3"/><line x1="8" y1="2" x2="8" y2="6" stroke="var(--nav-bg)" stroke-width="2" stroke-linecap="round"/><line x1="16" y1="2" x2="16" y2="6" stroke="var(--nav-bg)" stroke-width="2" stroke-linecap="round"/><rect x="7" y="13" width="3" height="3" rx=".5" fill="var(--nav-bg)"/><rect x="10.5" y="13" width="3" height="3" rx=".5" fill="var(--nav-bg)" opacity=".6"/><rect x="14" y="13" width="3" height="3" rx=".5" fill="var(--nav-bg)" opacity=".6"/></svg>
        Tarikh
    </button>
</nav>

{{-- RSVP POPUP --}}
<div class="popup-overlay" id="rsvpPopup" onclick="closeOnBg(event,this)">
    <div class="popup-sheet">
        <div class="popup-handle"></div>
        <div class="popup-title">Pengesahan Kehadiran</div>
        <input class="inv-input" id="rsvpName" placeholder="Nama anda">
        <div class="rsvp-status-grid">
            <button onclick="pickRsvp(this,'hadir')" class="rsvp-opt selected">
                <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#4CAF7D" opacity=".15"/><circle cx="12" cy="12" r="10" stroke="#4CAF7D" stroke-width="1.5"/><path d="M7 12.5l3.5 3.5 6.5-7" stroke="#4CAF7D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Hadir
            </button>
            <button onclick="pickRsvp(this,'tidak_hadir')" class="rsvp-opt">
                <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#E05757" opacity=".12"/><circle cx="12" cy="12" r="10" stroke="#E05757" stroke-width="1.5"/><path d="M8 8l8 8M16 8l-8 8" stroke="#E05757" stroke-width="2" stroke-linecap="round"/></svg>
                Tidak Hadir
            </button>
            <button onclick="pickRsvp(this,'belum_tahu')" class="rsvp-opt">
                <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#F5A623" opacity=".12"/><circle cx="12" cy="12" r="10" stroke="#F5A623" stroke-width="1.5"/><path d="M9 9.5C9 8.12 10.34 7 12 7s3 1.12 3 2.5c0 1.5-1.5 2-2.5 2.5-.5.25-.5.5-.5 1" stroke="#F5A623" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="17" r="1" fill="#F5A623"/></svg>
                Belum Tahu
            </button>
        </div>
        <input class="inv-input" type="number" id="rsvpPax" placeholder="Bilangan hadir (termasuk anda)" min="1" max="20" value="1">
        <button class="inv-submit" onclick="submitRsvp()">Hantar RSVP</button>
    </div>
</div>

{{-- WISH POPUP --}}
<div class="popup-overlay" id="wishPopup" onclick="closeOnBg(event,this)">
    <div class="popup-sheet">
        <div class="popup-handle"></div>
        <div class="popup-title">Tinggalkan Ucapan</div>
        <input class="inv-input" id="wishName" placeholder="Nama anda">
        <textarea class="inv-input" id="wishText" style="min-height:88px;resize:none" placeholder="Tulis ucapan atau doa untuk pengantin..."></textarea>
        <button class="inv-submit" onclick="submitWish()">Hantar Ucapan</button>
        <div id="wishListPopup" style="margin-top:16px;max-height:220px;overflow-y:auto">
            @foreach($wishes as $w)
            <div class="wish-item left"><div class="wish-name">{{ $w->nama }}</div><div class="wish-text">{{ $w->ucapan }}</div></div>
            @endforeach
        </div>
    </div>
</div>

{{-- CONTACT POPUP --}}
<div class="popup-overlay" id="contactPopup" onclick="closeOnBg(event,this)">
    <div class="popup-sheet">
        <div class="popup-handle"></div>
        <div class="popup-title">Hubungi Kami</div>
@php
$contacts = [];

function formatMY($no) {
    $no = preg_replace('/[^0-9]/', '', $no);
    $no = ltrim($no, '0');
    return '60' . $no;
}

if($invitation->no_whatsapp) {
    $contacts[] = [
        'nama' => $invitation->nama_hubungi_1 ?? 'Kenalan 1',
        'no'   => formatMY($invitation->no_whatsapp)
    ];
}

if($invitation->no_hubungi_2) {
    $contacts[] = [
        'nama' => $invitation->nama_hubungi_2 ?? 'Kenalan 2',
        'no'   => formatMY($invitation->no_hubungi_2)
    ];
}

if($invitation->no_hubungi_3) {
    $contacts[] = [
        'nama' => $invitation->nama_hubungi_3 ?? 'Kenalan 3',
        'no'   => formatMY($invitation->no_hubungi_3)
    ];
}
@endphp
        @forelse($contacts as $c)
        <div class="contact-card">
            <div class="contact-name">{{ $c['nama'] }}</div>
            <div class="contact-no">{{ $c['no'] }}</div>
            <div class="contact-btns">
                <a href="tel:{{ $c['no'] }}" class="cbtn cbtn-call">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C10.56 21 3 13.44 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.45.57 3.58a1 1 0 01-.24 1.01L6.62 10.79z"/></svg>
                    Call
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$c['no']) }}?text={{ urlencode('Assalamualaikum, saya ingin bertanya berkenaan majlis '.$invitation->nama_ringkas_lelaki.($invitation->bilangan_pengantin==2?' & '.$invitation->nama_ringkas_perempuan:'')) }}" class="cbtn cbtn-wa" target="_blank">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    WhatsApp
                </a>
            </div>
        </div>
        @empty
        <p style="text-align:center;color:var(--muted);font-size:13px">Tiada nombor hubungi.</p>
        @endforelse
    </div>
</div>

{{-- MAPS POPUP --}}
<div class="popup-overlay" id="mapsPopup" onclick="closeOnBg(event,this)">
    <div class="popup-sheet">
        <div class="popup-handle"></div>
        <div class="popup-title">Lokasi Majlis</div>
        <p style="text-align:center;color:var(--muted);font-size:13px;line-height:1.7;margin-bottom:18px">{{ $invitation->alamat_majlis }}</p>
        @if($invitation->google_maps_url)
        <a href="{{ $invitation->google_maps_url }}" target="_blank" class="map-card">
            <div class="map-card-icon" style="background:#fff;padding:6px;border-radius:10px">
                <img src="https://maps.gstatic.com/mapfiles/maps_lite/pwa/icons/maps15_bnuw3a_round_192x192.png" width="32" height="32" style="border-radius:8px">
            </div>
            <div>
                <div class="map-card-text-title">Google Maps</div>
                <div class="map-card-text-sub">Buka dalam Google Maps</div>
            </div>
            <svg style="margin-left:auto;opacity:.4" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        @endif
        @if($invitation->waze_url)
        <a href="{{ $invitation->waze_url }}" target="_blank" class="map-card">
            <div class="map-card-icon" style="background:#05C8F7;padding:6px;border-radius:10px">
                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/waze.svg" width="32" height="32" style="object-fit:contain;filter:brightness(0) invert(1)">
            </div>
            <div>
                <div class="map-card-text-title">Waze</div>
                <div class="map-card-text-sub">Buka dalam Waze</div>
            </div>
            <svg style="margin-left:auto;opacity:.4" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        @endif
    </div>
</div>

{{-- CALENDAR POPUP --}}
<div class="popup-overlay" id="calendarPopup" onclick="closeOnBg(event,this)">
    <div class="popup-sheet">
        <div class="popup-handle"></div>
        <div class="popup-title">Simpan Tarikh</div>
        @if($invitation->tarikh_majlis)
        <div style="text-align:center;margin-bottom:18px;padding:16px;background:rgba(201,169,110,.07);border:1px solid var(--border);border-radius:12px">
            <div style="font-size:9px;letter-spacing:3px;text-transform:uppercase;color:var(--gold);opacity:.8;margin-bottom:6px">Tarikh Majlis</div>
            <div style="font-family:'Cormorant Garamond',serif;font-size:28px;color:var(--gold-light);line-height:1.2">{{ $invitation->tarikh_majlis->format('d') }}</div>
            <div style="font-family:'Cormorant Garamond',serif;font-size:16px;color:var(--gold);letter-spacing:3px;text-transform:uppercase">{{ $invitation->tarikh_majlis->format('F Y') }}</div>
            <div style="font-size:11px;color:var(--muted);margin-top:4px;letter-spacing:1px">{{ $invitation->tarikh_majlis->format('l') }}</div>
        </div>
        @endif
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:20px">
            <div class="cal-box"><div class="cal-num" id="cdD">--</div><div class="cal-lbl">Hari</div></div>
            <div class="cal-box"><div class="cal-num" id="cdH">--</div><div class="cal-lbl">Jam</div></div>
            <div class="cal-box"><div class="cal-num" id="cdM">--</div><div class="cal-lbl">Minit</div></div>
            <div class="cal-box"><div class="cal-num" id="cdS">--</div><div class="cal-lbl">Saat</div></div>
        </div>
        <div style="display:flex;flex-direction:column;gap:10px">
            @if($invitation->tarikh_majlis)
            <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text={{ urlencode('Majlis '.$invitation->nama_ringkas_lelaki.($invitation->bilangan_pengantin==2?' & '.$invitation->nama_ringkas_perempuan:'')) }}&dates={{ $invitation->tarikh_majlis->format('Ymd') }}T030000Z/{{ $invitation->tarikh_majlis->format('Ymd') }}T100000Z&location={{ urlencode($invitation->alamat_majlis??'') }}" target="_blank" class="cal-link">
                <div class="map-card-icon" style="background:#fff;padding:6px;border-radius:10px">
                    <img src="https://calendar.google.com/googlecalendar/images/favicon_v2018_256.png" width="32" height="32" style="border-radius:8px">
                </div>
                <div style="text-align:left">
                    <div style="font-size:13px;font-weight:600">Google Calendar</div>
                    <div style="font-size:11px;color:var(--muted)">Tambah ke Google Calendar</div>
                </div>
            </a>
            <a href="data:text/calendar;charset=utf-8,BEGIN:VCALENDAR%0AVERSION:2.0%0ABEGIN:VEVENT%0ADTSTART:{{ $invitation->tarikh_majlis->format('Ymd') }}T030000Z%0ADTEND:{{ $invitation->tarikh_majlis->format('Ymd') }}T100000Z%0ASUMMARY:{{ rawurlencode('Majlis '.$invitation->nama_ringkas_lelaki.($invitation->bilangan_pengantin==2?' & '.$invitation->nama_ringkas_perempuan:'')) }}%0ALOCATION:{{ rawurlencode($invitation->alamat_majlis??'') }}%0AEND:VEVENT%0AEND:VCALENDAR" download="majlis.ics" class="cal-link">
                <div class="map-card-icon" style="background:#fff;padding:6px;border-radius:10px">
                    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/apple.svg" width="32" height="32" style="object-fit:contain;filter:brightness(0)">
                </div>
                <div style="text-align:left">
                    <div style="font-size:13px;font-weight:600">Apple Calendar</div>
                    <div style="font-size:11px;color:var(--muted)">Muat turun fail .ics</div>
                </div>
            </a>
            @endif
        </div>
    </div>
</div>

{{-- GIFT POPUP --}}
@if($invitation->bank_no_akaun || $invitation->qr_image)
<div class="popup-overlay" id="giftPopup" onclick="closeOnBg(event,this)">
    <div class="popup-sheet">
        <div class="popup-handle"></div>
        <div class="popup-title">Hadiah Wang Digital</div>
        @if($invitation->bank_nama || $invitation->bank_no_akaun)
        <div style="background:rgba(201,169,110,.06);border:1px solid var(--border);border-radius:12px;padding:20px;text-align:center;margin-bottom:14px">
            <div style="font-size:12px;color:var(--muted);margin-bottom:6px">{{ $invitation->bank_nama }}</div>
            <div style="font-family:monospace;font-size:24px;color:var(--gold);margin-bottom:6px;letter-spacing:2px">{{ $invitation->bank_no_akaun }}</div>
            <div style="font-size:13px;color:var(--text)">{{ $invitation->bank_nama_akaun }}</div>
        </div>
        @endif
        @if($invitation->qr_image)
        <div style="text-align:center">
            <img src="{{ Storage::url($invitation->qr_image) }}" style="width:200px;border-radius:12px;border:1px solid var(--border)">
        </div>
        @endif
    </div>
</div>
@endif

{{-- FULL IMAGE --}}
<div id="fullImgWrap" onclick="this.style.display='none'">
    <img id="fullImg" src="" alt="">
</div>

{{-- MUSIC --}}
<div id="musicBar" onclick="toggleMusic()">
    <div class="bars" id="musicBars">
        <div class="bar"></div><div class="bar"></div><div class="bar"></div>
    </div>
    <span id="musicLbl">Muzik</span>
</div>
<div id="ytWrap" style="position:fixed;bottom:-999px;left:-999px;opacity:0;pointer-events:none"></div>

<script>
document.querySelectorAll('.mini-cal').forEach(el => {
    new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in-view'); } });
    }, { threshold: 0.1 }).observe(el);
});

let curSlide=0;
const totalSlides={{ $galleries->count() }};

function slideNav(d){goSlide((curSlide+d+totalSlides)%totalSlides);}
function goSlide(n){
    curSlide=n;
    const t=document.getElementById('sliderTrack');
    if(t) t.style.transform=`translateX(-${n*100}%)`;
    document.querySelectorAll('.dot').forEach((d,i)=>d.classList.toggle('active',i===n));
}

if(totalSlides>1) setInterval(()=>slideNav(1),4000);

let touchStartX=0;
document.addEventListener('touchstart',e=>{touchStartX=e.touches[0].clientX;},{passive:true});
document.addEventListener('touchend',e=>{
    const diff=touchStartX-e.changedTouches[0].clientX;
    if(Math.abs(diff)>50) slideNav(diff>0?1:-1);
},{passive:true});

const SLUG='{{ $invitation->slug }}';
const CSRF=document.querySelector('meta[name="csrf-token"]').content;
const TARIKH='{{ $invitation->tarikh_majlis ? $invitation->tarikh_majlis->format("Y-m-d") : "" }}';
const MASA='{{ $invitation->masa_majlis ?? "11:00:00" }}';
const YT_URL='{{ $invitation->muzik_youtube_url ?? "" }}';
const MP3_URL='{{ $invitation->muzik_mp3_url ?? "" }}';
const YT_VOL={{ $invitation->muzik_volume ?? 60 }};

let ytPlayer=null, audio=null, musicPlaying=false, rsvpStatus='hadir';

// ===== LOAD MUSIK IMMEDIATELY (JANGAN TUNGGU DOM) =====
if(MP3_URL){
    audio = new Audio(MP3_URL);
    audio.loop = true;
    audio.volume = 0;
    audio.preload = 'auto';
    audio.load();
} else if(YT_URL){
    const s=document.createElement('script');
    s.src='https://www.youtube.com/iframe_api';
    s.async = true;
    document.head.appendChild(s);
}
// ===== END EARLY MUSIC LOAD =====

// AUTO DETECT kecerahan header image → tukar warna teks
function detectHeaderBrightness() {
    const headerImg = '{{ $headerImg }}';
    if (!headerImg) return;
    const img = new Image();
    img.crossOrigin = 'Anonymous';
    img.src = headerImg;
    img.onload = function() {
        const canvas = document.createElement('canvas');
        const size = 50;
        canvas.width = size;
        canvas.height = size;
        const ctx = canvas.getContext('2d');
        const sx = (img.width / 2) - (img.width * 0.3);
        const sy = (img.height / 2) - (img.height * 0.3);
        const sw = img.width * 0.6;
        const sh = img.height * 0.6;
        ctx.drawImage(img, sx, sy, sw, sh, 0, 0, size, size);
        const data = ctx.getImageData(0, 0, size, size).data;
        let total = 0;
        for (let i = 0; i < data.length; i += 4) {
            total += (data[i] * 0.299 + data[i+1] * 0.587 + data[i+2] * 0.114);
        }
        const avg = total / (size * size);
        const isLightBg = avg > 160;
        const textColor   = isLightBg ? '#2C1A06' : '#F5EDD8';
        const mutedColor  = isLightBg ? 'rgba(44,26,6,0.7)' : 'rgba(232,213,176,0.75)';
        const accentColor = isLightBg ? '#7A4F10' : 'var(--gold)';
        const shadowStyle = isLightBg
            ? '0 1px 0 rgba(255,255,255,0.5), 0 2px 8px rgba(255,255,255,0.3)'
            : '0 2px 20px rgba(0,0,0,0.5)';
        document.querySelectorAll('.h-names, .op-names').forEach(el => {
            el.style.color = textColor;
            el.style.textShadow = shadowStyle;
        });
        document.querySelectorAll('.h-and, .op-and').forEach(el => {
            el.style.color = accentColor;
        });
        document.querySelectorAll('.h-date, .op-date, .h-label, .op-label').forEach(el => {
            el.style.color = mutedColor;
        });
        document.querySelectorAll('.scroll-hint').forEach(el => {
            el.style.color = textColor;
        });
        const btn = document.querySelector('.open-btn');
        if (btn) {
            btn.style.color = textColor;
            btn.style.borderColor = isLightBg ? 'rgba(122,79,16)' : 'rgba(201,169,110)';
        }
    };
    img.onerror = function() {
        // fallback
    };
}
detectHeaderBrightness();

// YouTube callback - load player bila YouTube API ready
window.onYouTubeIframeAPIReady=function(){
    if(!YT_URL) return;
    const m=YT_URL.match(/(?:v=|youtu\.be\/)([^&\n?#]+)/);
    if(!m) return;
    ytPlayer=new YT.Player('ytWrap',{
        height:'1',width:'1',videoId:m[1],
        playerVars:{autoplay:0,loop:1,controls:0,playlist:m[1],mute:1},
        events:{onReady:()=>{}}
    });
};

function startMusic(retryCount = 0){
    if(audio){
        audio.play().then(()=>{
            audio.volume = YT_VOL/100;
            musicPlaying = true;
            document.getElementById('musicBars').classList.remove('paused');
            document.getElementById('musicLbl').textContent = 'Muzik';
        }).catch(err=>{
            // Kalau gagal, retry dalam 500ms
            if(retryCount < 3){
                setTimeout(() => startMusic(retryCount + 1), 500);
            }
        });
    } else if(ytPlayer){
        try{
            ytPlayer.unMute();
            ytPlayer.setVolume(YT_VOL);
            ytPlayer.playVideo();
            musicPlaying = true;
        }catch(e){
            // Kalau YouTube player tak ready lagi, retry
            if(retryCount < 3){
                setTimeout(() => startMusic(retryCount + 1), 500);
            }
        }
    }
}

function toggleMusic(){
    const bars=document.getElementById('musicBars');
    const lbl=document.getElementById('musicLbl');
    if(audio){
        if(musicPlaying){ 
            audio.pause(); 
            musicPlaying=false; 
            bars.classList.add('paused'); 
            lbl.textContent='Paused'; 
        }
        else{ 
            audio.play().then(() => {
                audio.volume=YT_VOL/100; 
                musicPlaying=true; 
                bars.classList.remove('paused'); 
                lbl.textContent='Muzik'; 
            }).catch(err => {
                // Kalau gagal, log dan show message
                console.log('Audio play failed:', err);
            });
        }
    } else if(ytPlayer){
        if(musicPlaying){ 
            ytPlayer.pauseVideo(); 
            musicPlaying=false; 
            bars.classList.add('paused'); 
            lbl.textContent='Paused'; 
        }
        else{ 
            try {
                ytPlayer.unMute(); 
                ytPlayer.setVolume(YT_VOL); 
                ytPlayer.playVideo(); 
                musicPlaying=true; 
                bars.classList.remove('paused'); 
                lbl.textContent='Muzik'; 
            } catch(e) {
                console.log('YouTube play failed:', e);
            }
        }
    }
}

(function(){
    const IMGS = @json($galleries->map(fn($img) => \Storage::url($img->image_path)));
    const N = IMGS.length;
    if(!N) return;

    let cur = 0, animating = false;
    const stage = document.getElementById('cardStage');
    const dotsEl = document.getElementById('cardDots');

    IMGS.forEach((_,i)=>{
        const d = document.createElement('div');
        d.className = 'card-slider-dot' + (i===0?' on':'');
        d.onclick = ()=> goTo(i);
        dotsEl.appendChild(d);
    });

    function mod(n,m){return((n%m)+m)%m;}

    function getLayout(offset){
        const cx = (stage.offsetWidth||320)/2;
        if(offset===0)  return {x:cx, scale:1,    rot:0,   z:10, op:1,   active:true};
        if(Math.abs(offset)===1){
            const s = offset>0?1:-1;
            return {x:cx+s*190, scale:0.7, rot:s*10, z:5,  op:0.55, active:false};
        }
        const s = offset>0?1:-1;
        return {x:cx+s*300, scale:0.55, rot:s*14, z:1, op:0, active:false};
    }

    function applyLayout(el, l, animate){
        el.style.transition = animate
            ? 'transform .55s cubic-bezier(.34,1.2,.64,1), opacity .45s ease'
            : 'none';
        el.style.transform  = `translateX(${l.x}px) translateY(-50%) scale(${l.scale}) rotate(${l.rot}deg)`;
        el.style.opacity    = l.op;
        el.style.zIndex     = l.z;
        const card = el.querySelector('.card-slider-card');
        card.style.border      = l.active ? '2px solid var(--gold)' : '1.5px solid var(--border)';
        card.style.boxShadow   = l.active ? '0 8px 32px rgba(0,0,0,0.35)' : 'none';
    }

    function build(){
        stage.innerHTML = '';
        for(let i=0;i<N;i++){
            const wrap = document.createElement('div');
            wrap.className = 'card-slider-wrap';
            wrap.id = 'csw'+i;
            wrap.onclick = ()=>{ if(i!==cur) goTo(i); };

            const card = document.createElement('div');
            card.className = 'card-slider-card';

            const img = document.createElement('img');
            img.src = IMGS[i];
            img.loading = i<2?'eager':'lazy';
            img.alt = '';
            img.onclick = function(e){
                e.stopPropagation();
                if(i===cur) openFullImg(this.src);
            };

            card.appendChild(img);
            wrap.appendChild(card);
            stage.appendChild(wrap);

            const raw = (i - cur + N) % N;
            const offset = raw <= N/2 ? raw : raw - N;
            applyLayout(wrap, getLayout(offset), false);
        }
    }

    function updateDots(){
        dotsEl.querySelectorAll('.card-slider-dot').forEach((d,i)=>d.classList.toggle('on',i===cur));
    }

    function goTo(next, instant){
        if(animating && !instant) return;
        animating = true;
        cur = mod(next, N);
        for(let i=0;i<N;i++){
            const el = document.getElementById('csw'+i);
            if(!el) continue;
            const raw = (i - cur + N) % N;
            const offset = raw <= N/2 ? raw : raw - N;
            applyLayout(el, getLayout(offset), !instant);
        }
        updateDots();
        setTimeout(()=>{ animating = false; }, 560);
    }

    document.getElementById('cardBtnL').onclick = ()=> goTo(cur-1);
    document.getElementById('cardBtnR').onclick = ()=> goTo(cur+1);

    let tx=0, ty=0;
    stage.addEventListener('touchstart',e=>{tx=e.touches[0].clientX;ty=e.touches[0].clientY;},{passive:true});
    stage.addEventListener('touchend',e=>{
        const dx=tx-e.changedTouches[0].clientX;
        const dy=ty-e.changedTouches[0].clientY;
        if(Math.abs(dx)>Math.abs(dy)&&Math.abs(dx)>40) goTo(dx>0?cur+1:cur-1);
    },{passive:true});

    let mx=0, dragging=false;
    stage.addEventListener('mousedown',e=>{mx=e.clientX;dragging=true;});
    stage.addEventListener('mouseup',e=>{
        if(!dragging) return; dragging=false;
        const dx=mx-e.clientX;
        if(Math.abs(dx)>40) goTo(dx>0?cur+1:cur-1);
    });
    stage.addEventListener('mouseleave',()=>dragging=false);

    window.addEventListener('resize',()=>build());

    build();
})();

function openInvite(){
    startMusic();
    document.getElementById('opening').classList.add('fade-out');
    setTimeout(()=>{
        document.getElementById('opening').style.display='none';
        document.body.classList.remove('no-scroll');
        const inv=document.getElementById('invite');
        inv.style.display='block';
        setTimeout(()=>inv.classList.add('visible'),30);
        document.getElementById('bottomNav').style.display='flex';
        initObserver();
        startCountdown();
        @if($invitation->animation_aktif)
        initAnimation();
        @endif
    },800);
}

function openPopup(id){document.getElementById(id).classList.add('show');document.body.style.overflow='hidden';}
function closeOnBg(e,el){if(e.target===el){el.classList.remove('show');document.body.style.overflow='';}}

function pickRsvp(el,val){
    rsvpStatus=val;
    document.querySelectorAll('.rsvp-opt').forEach(b=>b.classList.remove('selected'));
    el.classList.add('selected');
}

async function submitRsvp(){
    const nama=document.getElementById('rsvpName').value.trim();
    if(!nama){showToast('Sila isi nama anda','#E05757');return;}
    try{
        const r=await fetch(`/${SLUG}/rsvp`,{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},body:JSON.stringify({nama,status:rsvpStatus,jumlah_hadir:document.getElementById('rsvpPax').value||1})});
        const d=await r.json();
        document.getElementById('rsvpPopup').classList.remove('show');
        document.body.style.overflow='';
        showToast('✓ '+d.message);
    }catch(e){showToast('Ralat. Cuba lagi.','#E05757');}
}

async function submitWish(){
    const nama=document.getElementById('wishName').value.trim();
    const ucapan=document.getElementById('wishText').value.trim();
    if(!nama||!ucapan){showToast('Sila isi nama dan ucapan','#E05757');return;}
    try{
        const r=await fetch(`/${SLUG}/wish`,{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},body:JSON.stringify({nama,ucapan})});
        if(!r.ok){ showToast('Ralat '+r.status+'. Cuba lagi.','#E05757'); return; }
        const d=await r.json();
        const html=`<div class="wish-item left"><div class="wish-name">${nama}</div><div class="wish-text">${ucapan}</div></div>`;
        document.getElementById('wishesList').insertAdjacentHTML('afterbegin',html);
        document.getElementById('wishListPopup').insertAdjacentHTML('afterbegin',html);
        document.getElementById('wishName').value='';
        document.getElementById('wishText').value='';
        showToast('✓ '+d.message);
    }catch(e){ showToast('Ralat. Cuba lagi.','#E05757'); }
}

function startCountdown(){
    if(!TARIKH) return;
    const target=new Date(`${TARIKH}T${MASA}+08:00`);
    function tick(){
        const diff=target-new Date();
        if(diff<=0){['cdD','cdH','cdM','cdS'].forEach(id=>document.getElementById(id).textContent='0');return;}
        document.getElementById('cdD').textContent=Math.floor(diff/86400000);
        document.getElementById('cdH').textContent=String(Math.floor((diff%86400000)/3600000)).padStart(2,'0');
        document.getElementById('cdM').textContent=String(Math.floor((diff%3600000)/60000)).padStart(2,'0');
        document.getElementById('cdS').textContent=String(Math.floor((diff%60000)/1000)).padStart(2,'0');
    }
    tick();setInterval(tick,1000);
}

function initObserver() {
    let lastY = window.scrollY;
    let scrollDir = 'down';

    window.addEventListener('scroll', () => {
        scrollDir = window.scrollY > lastY ? 'down' : 'up';
        lastY = window.scrollY;
    }, { passive: true });

    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            } else {
                entry.target.classList.remove('is-visible');
                
                if (scrollDir === 'up') {
                    entry.target.classList.add('up');
                    entry.target.classList.remove('down');
                } else {
                    entry.target.classList.add('down');
                    entry.target.classList.remove('up');
                }
            }
        });
    }, observerOptions);

    const selectors = '.fade-in, .info-box, .divider, .pengantin-name, .wish-item, .section-title, .cta-btn, .mini-cal';
    const elements = document.querySelectorAll(selectors);

    elements.forEach((el, i) => {
        // LOGIK KHAS: NAMA PENGANTIN (ARABIC/JAWI DETECTION)
        if (el.classList.contains('pengantin-name')) {
            const rawText = el.innerText.trim();
            
            // Regex untuk detect karakter Arab/Jawi
            const isArabic = /[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF]/.test(rawText);

            if (isArabic) {
                // Jika Arab/Jawi: Jangan pecah huruf, set RTL, apply reveal-arabic
                el.classList.add('reveal-arabic');
            } else {
                // Jika Rumi: Pecahkan kepada span (huruf demi huruf)
                el.innerHTML = rawText.split('').map((char, index) => 
                    `<span style="--char-index: ${index}">${char === ' ' ? '&nbsp;' : char}</span>`
                ).join('');
                el.classList.add('reveal-text');
            }
        }

        // LOGIK AM: REVEAL & STAGGER
        el.classList.add('reveal');
        
        if (el.classList.contains('info-box') || el.classList.contains('wish-item') || el.classList.contains('cta-btn')) {
            el.style.setProperty('--delay', (i % 6)); 
        }
        
        observer.observe(el);
    });
}

// Jalankan selepas DOM sedia
document.addEventListener('DOMContentLoaded', initObserver);

function openFullImg(src){
    document.getElementById('fullImg').src=src;
    document.getElementById('fullImgWrap').style.display='flex';
}

function showToast(msg,color){
    let t=document.getElementById('toast');
    if(!t){t=document.createElement('div');t.id='toast';t.style.cssText='position:fixed;bottom:80px;left:50%;transform:translateX(-50%) translateY(20px);background:#4CAF7D;color:#fff;padding:10px 22px;border-radius:50px;font-size:12px;opacity:0;transition:all .3s;z-index:9999;white-space:nowrap;font-family:DM Sans,sans-serif';document.body.appendChild(t);}
    t.textContent=msg;t.style.background=color||'#4CAF7D';t.style.opacity='1';t.style.transform='translateX(-50%) translateY(0)';
    setTimeout(()=>{t.style.opacity='0';t.style.transform='translateX(-50%) translateY(20px)';},3000);
}

// ===== ADVANCED ANIMATION SYSTEM =====
const ANIMATION_DATA = {
    'bunga': [
        `<svg width="14" height="18" viewBox="0 0 14 18"><ellipse cx="7" cy="9" rx="5" ry="8" fill="rgba(220,130,160,0.72)" transform="rotate(-15 7 9)"/></svg>`,
        `<svg width="15" height="15" viewBox="0 0 15 15"><ellipse cx="7.5" cy="7.5" rx="4" ry="7" fill="rgba(255,185,200,0.68)"/></svg>`,
        `<svg width="12" height="16" viewBox="0 0 12 16"><ellipse cx="6" cy="8" rx="3.5" ry="7" fill="rgba(245,237,216,0.5)"/></svg>`,
        `<svg width="8" height="8" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3.5" fill="rgba(201,169,110,0.82)"/></svg>`,
        `<svg width="11" height="11" viewBox="0 0 11 11"><polygon points="5.5,0.5 7,4 11,4 8,6.5 9,10.5 5.5,8 2,10.5 3,6.5 0,4 4,4" fill="rgba(201,169,110,0.62)"/></svg>`,
        `<svg width="13" height="17" viewBox="0 0 13 17"><ellipse cx="6.5" cy="8.5" rx="4" ry="7.5" fill="rgba(190,155,215,0.55)" transform="rotate(12 6.5 8.5)"/></svg>`,
    ],
    'bintang': [
        `<svg width="14" height="14" viewBox="0 0 24 24" fill="var(--gold)" opacity="0.9"><path d="M12 .587l3.668 7.431 8.2 1.192-5.934 5.787 1.4 8.168-7.334-3.856-7.334 3.856 1.4-8.168-5.934-5.787 8.2-1.192z"/></svg>`,
        `<svg width="10" height="10" viewBox="0 0 24 24" fill="white" opacity="0.8"><path d="M12 .587l3.668 7.431 8.2 1.192-5.934 5.787 1.4 8.168-7.334-3.856-7.334 3.856 1.4-8.168-5.934-5.787 8.2-1.192z"/></svg>`,
        `<svg width="6" height="6" viewBox="0 0 24 24" fill="white" opacity="0.6"><circle cx="12" cy="12" r="10"/></svg>`,
    ],
    'daun': [
        `<svg width="16" height="20" viewBox="0 0 24 24" fill="#4CAF50" opacity="0.7"><path d="M17,8L14,11L17,8M3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8.13,20C11.07,20 14,12.33 17,8C8,10 5.9,16.17 3.82,21.34Z"/></svg>`,
        `<svg width="16" height="20" viewBox="0 0 24 24" fill="#81C784" opacity="0.6"><path d="M17,8L14,11L17,8M3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8.13,20C11.07,20 14,12.33 17,8C8,10 5.9,16.17 3.82,21.34Z"/></svg>`,
    ],
    'hati': [
        `<svg width="16" height="16" viewBox="0 0 24 24" fill="#E91E63" opacity="0.8"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>`,
        `<svg width="12" height="12" viewBox="0 0 24 24" fill="#F48FB1" opacity="0.6"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>`,
    ]
};

let animReady = false;

function initAnimation() {
    const canvas = document.getElementById('bungaCanvas');
    const type = '{{ $invitation->animation_type ?? "bunga" }}';
    const svgSet = ANIMATION_DATA[type] || ANIMATION_DATA['bunga'];
    
    if (!canvas || animReady) return;
    canvas.style.display = 'block';
    animReady = true;
    
    const TOTAL = 18;
    const SPREAD = 120000;
    
    for (let i = 0; i < TOTAL; i++) {
        const el = document.createElement('div');
        el.className = 'kelopak';
        el.innerHTML = svgSet[Math.floor(Math.random() * svgSet.length)];
        
        const sz = (0.5 + Math.random() * 1.0).toFixed(2);
        const dur = (type === 'bintang' ? 4000 : 7000) + Math.random() * 9000;
        const delay = -(i * (SPREAD / TOTAL) + Math.random() * 2000);
        
        el.style.cssText = `left:${(Math.random()*102).toFixed(1)}%;--dur:${Math.round(dur)}ms;--delay:${Math.round(delay)}ms;--sz:${sz}`;
        canvas.appendChild(el);
    }
}
// ===== END ANIMATION SYSTEM =====

</script>
</body>
</html>