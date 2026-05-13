<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SatuJiwa — Set Semula Kata Laluan</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Nunito:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent }
        :root {
            --rose: #C9788A; --rose-light: #E8B4BE; --rose-pale: #F5D9DE; --rose-blush: #FDF0F2;
            --gold: #C9A06A; --gold-light: #E8D0A0; --cream: #FDF8F3; --warm-white: #FFFAF7;
            --text-dark: #4A3040; --text-mid: #7A5868; --text-soft: rgba(74, 48, 64, 0.5);
            --border: rgba(201, 120, 138, 0.18); --border-rose: rgba(201, 120, 138, 0.38);
            --input-bg: rgba(255, 255, 255, 0.65); --error: #C0505A; --success: #4A8C6A;
        }
        html, body { height: 100%; font-family: 'Nunito', sans-serif; font-weight: 300; overflow: hidden; }
        .bg-wrap { position: fixed; inset: 0; z-index: 0; background: radial-gradient(ellipse 80% 55% at 5% 0%, rgba(232, 180, 190, 0.42) 0%, transparent 60%), radial-gradient(ellipse 55% 50% at 95% 8%, rgba(201, 160, 106, 0.22) 0%, transparent 55%), radial-gradient(ellipse 65% 55% at 85% 95%, rgba(232, 180, 190, 0.30) 0%, transparent 60%), linear-gradient(155deg, #FFF5F7 0%, #FDF8F3 45%, #FFF0F3 72%, #FFFAF5 100%); }
        .page { position: relative; z-index: 2; height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .card { width: 100%; max-width: 440px; background: rgba(255, 255, 255, 0.78); border: 1px solid rgba(201, 120, 138, 0.2); border-radius: 24px; padding: 48px 40px; backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); box-shadow: 0 32px 80px rgba(201, 120, 138, 0.14); animation: cardIn .8s cubic-bezier(.22, .68, 0, 1.2) both; position: relative; overflow: hidden; }
        .card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, transparent, var(--rose-light), var(--gold-light), var(--rose-light), transparent); }
        @keyframes cardIn { from { opacity: 0; transform: translateY(28px) scale(.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
        .logo { text-align: center; margin-bottom: 24px; }
        .logo-name { font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 400; letter-spacing: 2px; color: var(--text-dark); }
        .logo-name span { font-style: italic; color: var(--gold); }
        .divider-line { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; justify-content:center; }
        .divider-line::before, .divider-line::after { content: ''; width: 40px; height: 1px; background: var(--border); }
        .divider-line span { color: var(--rose-light); font-size: 16px; font-family: 'Cormorant Garamond', serif; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 10px; letter-spacing: 3px; text-transform: uppercase; color: var(--text-mid); margin-bottom: 8px; font-weight: 500; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--rose); opacity: 0.45; pointer-events: none; transition: opacity .2s; }
        input[type="email"], input[type="password"] { width: 100%; background: var(--input-bg); border: 1px solid var(--border); border-radius: 12px; padding: 13px 14px 13px 44px; color: var(--text-dark); font-size: 13px; font-family: 'Nunito', sans-serif; font-weight: 400; outline: none; transition: all .25s; }
        input[type="email"]:focus, input[type="password"]:focus { border-color: var(--rose); background: rgba(255, 255, 255, 0.92); box-shadow: 0 0 0 3px rgba(201, 120, 138, 0.12); }
        .btn-submit { width: 100%; background: linear-gradient(135deg, #C9788A 0%, #B05A70 100%); border: none; border-radius: 50px; padding: 15px; color: #fff; font-weight: 700; font-size: 12px; letter-spacing: 2px; text-transform: uppercase; cursor: pointer; transition: all .3s; box-shadow: 0 6px 24px rgba(201, 120, 138, 0.3); margin-top: 10px; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(201, 120, 138, 0.4); }
        .alert-error { background: rgba(192, 80, 90, 0.07); border: 1px solid rgba(192, 80, 90, 0.22); border-radius: 12px; padding: 12px 14px; font-size: 12px; color: var(--error); margin-bottom: 20px; text-align:center; }
        .form-desc { font-size: 13px; color: var(--text-soft); text-align: center; margin-bottom: 24px; line-height: 1.6; }
        
        .petals { position: fixed; inset: 0; pointer-events: none; z-index: 1; overflow: hidden; }
        .petal { position: absolute; opacity: 0; animation: petalFall linear infinite; border-radius: 50% 0 50% 0; }
        @keyframes petalFall { 0% { opacity: 0; transform: translateY(-40px) rotate(0deg) scale(0.7); } 8% { opacity: 0.45; } 88% { opacity: 0.2; } 100% { opacity: 0; transform: translateY(105vh) rotate(400deg) scale(1.1); } }
    </style>
</head>
<body>
    <div class="bg-wrap"></div>
    <div class="petals" id="petals"></div>
    <div class="page">
        <div class="card">
            <div class="logo">
                <div class="logo-name">Satu<span>Jiwa</span></div>
            </div>
            <div class="divider-line"><span>✿</span></div>
            <h2 style="font-family:'Cormorant Garamond', serif; font-size: 22px; color: var(--text-dark); margin-bottom: 8px; text-align: center;">Set Semula Kata Laluan</h2>
            <p class="form-desc">Sila masukkan emel anda dan tetapkan kata laluan baru yang lebih selamat.</p>

            @if($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                {{-- EMAIL --}}
                <div class="form-group">
                    <label>Emel</label>
                    <div class="input-wrap">
                        <input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus readonly>
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="4" width="20" height="16" rx="2" /><path d="M2 8l10 6 10-6" /></svg>
                        </span>
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div class="form-group">
                    <label>Kata Laluan Baru</label>
                    <div class="input-wrap">
                        <input type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="11" width="18" height="11" rx="2" /><path d="M7 11V7a5 5 0 0110 0v4" /></svg>
                        </span>
                    </div>
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="form-group">
                    <label>Sahkan Kata Laluan Baru</label>
                    <div class="input-wrap">
                        <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Simpan Kata Laluan</button>
            </form>
        </div>
    </div>
    <script>
        const petalContainer = document.getElementById('petals');
        const COLORS = ['#E8B4BE', '#F5D9DE', '#C9A06A', '#E8D0A0', '#FADADD'];
        for (let i = 0; i < 15; i++) {
            const p = document.createElement('div');
            p.className = 'petal';
            const size = Math.random() * 10 + 6;
            p.style.cssText = `width:${size}px;height:${size*1.5}px;background:${COLORS[Math.floor(Math.random()*COLORS.length)]};left:${Math.random()*100}%;animation-duration:${Math.random()*15+10}s;animation-delay:${Math.random()*10}s;opacity:0;`;
            petalContainer.appendChild(p);
        }
    </script>
</body>
</html>
