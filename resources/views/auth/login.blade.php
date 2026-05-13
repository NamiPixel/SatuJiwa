<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SatuJiwa — Log Masuk</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Nunito:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent
        }

        :root {
            --rose: #C9788A;
            --rose-light: #E8B4BE;
            --rose-pale: #F5D9DE;
            --rose-blush: #FDF0F2;
            --gold: #C9A06A;
            --gold-light: #E8D0A0;
            --cream: #FDF8F3;
            --warm-white: #FFFAF7;
            --text-dark: #4A3040;
            --text-mid: #7A5868;
            --text-soft: rgba(74, 48, 64, 0.5);
            --border: rgba(201, 120, 138, 0.18);
            --border-rose: rgba(201, 120, 138, 0.38);
            --input-bg: rgba(255, 255, 255, 0.65);
            --error: #C0505A;
            --success: #4A8C6A;
        }

        html,
        body {
            height: 100%;
            font-family: 'Nunito', sans-serif;
            font-weight: 300;
            overflow: hidden;
        }

        /* ── PASTEL GRADIENT BACKGROUND ── */
        .bg-wrap {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 80% 55% at 5% 0%, rgba(232, 180, 190, 0.42) 0%, transparent 60%),
                radial-gradient(ellipse 55% 50% at 95% 8%, rgba(201, 160, 106, 0.22) 0%, transparent 55%),
                radial-gradient(ellipse 65% 55% at 85% 95%, rgba(232, 180, 190, 0.30) 0%, transparent 60%),
                radial-gradient(ellipse 45% 40% at 2% 88%, rgba(201, 160, 106, 0.15) 0%, transparent 55%),
                linear-gradient(155deg, #FFF5F7 0%, #FDF8F3 45%, #FFF0F3 72%, #FFFAF5 100%);
        }

        /* ── FLORAL DECORATIONS ── */
        .floral-deco {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        /* ── FLOATING PETALS ── */
        .petals {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }

        .petal {
            position: absolute;
            opacity: 0;
            animation: petalFall linear infinite;
            border-radius: 50% 0 50% 0;
        }

        @keyframes petalFall {
            0% {
                opacity: 0;
                transform: translateY(-40px) rotate(0deg) scale(0.7);
            }

            8% {
                opacity: 0.45;
            }

            88% {
                opacity: 0.2;
            }

            100% {
                opacity: 0;
                transform: translateY(105vh) rotate(400deg) scale(1.1);
            }
        }

        /* ── LAYOUT ── */
        .page {
            position: relative;
            z-index: 2;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        /* ── CARD ── */
        .card {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid rgba(201, 120, 138, 0.2);
            border-radius: 24px;
            padding: 48px 40px;
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            box-shadow:
                0 0 0 1px rgba(201, 120, 138, 0.08),
                0 32px 80px rgba(201, 120, 138, 0.14),
                0 8px 24px rgba(201, 120, 138, 0.08);
            animation: cardIn .8s cubic-bezier(.22, .68, 0, 1.2) both;
            position: relative;
            overflow: hidden;
        }

        /* Top shimmer line */
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--rose-light), var(--gold-light), var(--rose-light), transparent);
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(28px) scale(.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ── LOGO / HEADER ── */
        .logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, rgba(201, 120, 138, 0.12), rgba(201, 120, 138, 0.04));
            border: 1px solid var(--border-rose);
            border-radius: 16px;
            margin-bottom: 16px;
            position: relative;
        }

        .logo-icon svg {
            width: 26px;
            height: 26px;
        }

        .logo-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 28px;
            font-weight: 400;
            letter-spacing: 2px;
            line-height: 1;
            margin-bottom: 6px;
            color: var(--text-dark);
        }

        .logo-name span {
            font-style: italic;
            color: var(--gold);
        }

        .logo-sub {
            font-size: 10px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--text-soft);
        }

        .divider-line {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }

        .divider-line::before,
        .divider-line::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .divider-line span {
            color: var(--rose-light);
            font-size: 16px;
            font-family: 'Cormorant Garamond', serif;
        }

        /* ── FORM ── */
        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--text-mid);
            margin-bottom: 8px;
            font-weight: 500;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--rose);
            opacity: 0.45;
            pointer-events: none;
            transition: opacity .2s;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 13px 14px 13px 44px;
            color: var(--text-dark);
            font-size: 13px;
            font-family: 'Nunito', sans-serif;
            font-weight: 400;
            outline: none;
            transition: border-color .25s, background .25s, box-shadow .25s;
            -webkit-appearance: none;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--rose);
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 0 0 3px rgba(201, 120, 138, 0.12);
        }

        input[type="email"]:focus+.input-icon,
        input[type="password"]:focus+.input-icon {
            opacity: 1;
        }

        input::placeholder {
            color: rgba(74, 48, 64, 0.3);
        }

        /* Password toggle */
        .pwd-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-soft);
            cursor: pointer;
            padding: 4px;
            transition: color .2s;
            display: flex;
            align-items: center;
        }

        .pwd-toggle:hover {
            color: var(--rose);
        }

        /* ── REMEMBER + FORGOT ── */
        .row-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember input[type="checkbox"] {
            width: 16px;
            height: 16px;
            appearance: none;
            -webkit-appearance: none;
            background: rgba(255, 255, 255, 0.8);
            border: 1.5px solid var(--border-rose);
            border-radius: 5px;
            cursor: pointer;
            position: relative;
            transition: all .2s;
            flex-shrink: 0;
        }

        .remember input[type="checkbox"]:checked {
            background: var(--rose);
            border-color: var(--rose);
        }

        .remember input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            left: 4px;
            top: 1px;
            width: 5px;
            height: 9px;
            border: 2px solid #fff;
            border-top: none;
            border-left: none;
            transform: rotate(45deg);
        }

        .remember span {
            font-size: 12px;
            color: var(--text-mid);
        }

        .forgot {
            font-size: 12px;
            color: var(--rose);
            text-decoration: none;
            opacity: .7;
            transition: opacity .2s;
        }

        .forgot:hover {
            opacity: 1;
        }

        /* ── SUBMIT BTN ── */
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #C9788A 0%, #B05A70 100%);
            border: none;
            border-radius: 50px;
            padding: 15px;
            color: #fff;
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            cursor: pointer;
            font-family: 'Nunito', sans-serif;
            transition: all .3s;
            position: relative;
            overflow: hidden;
            box-shadow: 0 6px 24px rgba(201, 120, 138, 0.3);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.18), transparent);
            opacity: 0;
            transition: opacity .2s;
        }

        .btn-login:hover::before {
            opacity: 1;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(201, 120, 138, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 4px 12px rgba(201, 120, 138, 0.3);
        }

        .btn-login.loading {
            pointer-events: none;
            opacity: .75;
        }

        /* ── ALERTS ── */
        .alert-error {
            background: rgba(192, 80, 90, 0.07);
            border: 1px solid rgba(192, 80, 90, 0.22);
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 12px;
            color: var(--error);
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            line-height: 1.6;
        }

        .alert-success {
            background: rgba(74, 140, 106, 0.07);
            border: 1px solid rgba(74, 140, 106, 0.22);
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 12px;
            color: var(--success);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── FOOTER ── */
        .card-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 22px;
            border-top: 1px solid var(--border);
        }

        .card-footer p {
            font-size: 11px;
            color: var(--text-soft);
            letter-spacing: .5px;
        }

        .card-footer a {
            color: var(--rose);
            text-decoration: none;
            transition: opacity .2s;
        }

        .card-footer a:hover {
            opacity: .75;
        }

        /* ── BACK LINK ── */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            position: fixed;
            top: 24px;
            left: 28px;
            z-index: 10;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-mid);
            text-decoration: none;
            padding: 8px 16px;
            border: 1px solid var(--border);
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(8px);
            transition: all .3s;
        }

        .back-link:hover {
            color: var(--rose);
            border-color: var(--border-rose);
            background: rgba(255, 255, 255, 0.85);
            transform: translateY(-1px);
        }

        /* ── RESPONSIVE ── */
        @media(max-width:480px) {
            .card {
                padding: 36px 24px;
            }

            html,
            body {
                overflow: auto;
            }

            .page {
                align-items: flex-start;
                padding-top: 60px;
            }

            .back-link {
                top: 16px;
                left: 16px;
            }
        }
    </style>
</head>

<body>

    {{-- PASTEL BACKGROUND --}}
    <div class="bg-wrap"></div>

    {{-- FLORAL DECORATIONS --}}
    <div class="floral-deco">
        {{-- Top-left large floral --}}
        <svg style="position:absolute;top:-40px;left:-40px;width:320px;opacity:0.13;" viewBox="0 0 220 220" fill="none">
            <g transform="translate(110,100)">
                <ellipse rx="12" ry="45" fill="#C9788A" transform="rotate(0)" />
                <ellipse rx="12" ry="45" fill="#E8B4BE" transform="rotate(45)" />
                <ellipse rx="12" ry="45" fill="#C9788A" transform="rotate(90)" />
                <ellipse rx="12" ry="45" fill="#E8B4BE" transform="rotate(135)" />
                <ellipse rx="10" ry="38" fill="#C9788A" opacity=".5" transform="rotate(22)" />
                <ellipse rx="10" ry="38" fill="#E8B4BE" opacity=".5" transform="rotate(67)" />
                <ellipse rx="10" ry="38" fill="#C9788A" opacity=".5" transform="rotate(112)" />
                <ellipse rx="10" ry="38" fill="#E8B4BE" opacity=".5" transform="rotate(157)" />
                <circle r="14" fill="#C9A06A" opacity=".75" />
            </g>
        </svg>
        {{-- Bottom-right floral --}}
        <svg style="position:absolute;bottom:-30px;right:-30px;width:260px;opacity:0.1;transform:rotate(200deg);"
            viewBox="0 0 220 220" fill="none">
            <g transform="translate(110,100)">
                <ellipse rx="12" ry="42" fill="#C9788A" transform="rotate(0)" />
                <ellipse rx="12" ry="42" fill="#E8B4BE" transform="rotate(60)" />
                <ellipse rx="12" ry="42" fill="#C9788A" transform="rotate(120)" />
                <ellipse rx="10" ry="36" fill="#E8B4BE" opacity=".5" transform="rotate(30)" />
                <ellipse rx="10" ry="36" fill="#C9788A" opacity=".5" transform="rotate(90)" />
                <ellipse rx="10" ry="36" fill="#E8B4BE" opacity=".5" transform="rotate(150)" />
                <circle r="12" fill="#C9A06A" opacity=".8" />
            </g>
        </svg>
        {{-- Small accent top-right --}}
        <svg style="position:absolute;top:8%;right:5%;width:100px;opacity:0.09;" viewBox="0 0 100 100" fill="none">
            <g transform="translate(50,50)">
                <ellipse rx="7" ry="28" fill="#C9A06A" transform="rotate(0)" />
                <ellipse rx="7" ry="28" fill="#C9A06A" transform="rotate(60)" />
                <ellipse rx="7" ry="28" fill="#C9A06A" transform="rotate(120)" />
                <circle r="8" fill="#C9A06A" />
            </g>
        </svg>
        {{-- Small accent bottom-left --}}
        <svg style="position:absolute;bottom:10%;left:4%;width:80px;opacity:0.1;" viewBox="0 0 100 100" fill="none">
            <g transform="translate(50,50)">
                <ellipse rx="6" ry="26" fill="#C9788A" transform="rotate(0)" />
                <ellipse rx="6" ry="26" fill="#C9788A" transform="rotate(72)" />
                <ellipse rx="6" ry="26" fill="#C9788A" transform="rotate(144)" />
                <ellipse rx="6" ry="26" fill="#C9788A" transform="rotate(216)" />
                <ellipse rx="6" ry="26" fill="#C9788A" transform="rotate(288)" />
                <circle r="7" fill="#C9788A" />
            </g>
        </svg>
    </div>

    {{-- FLOATING PETALS --}}
    <div class="petals" id="petals"></div>

    {{-- BACK TO HOME --}}
    <a href="{{ url('/') }}" class="back-link">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5M12 5l-7 7 7 7" />
        </svg>
        Kembali
    </a>

    <div class="page">
        <div class="card">

            {{-- LOGO --}}
            <div class="logo">
                <div class="logo-icon">
                    {{-- Rose floral icon --}}
                    <svg viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g transform="translate(14,13)">
                            <ellipse rx="3" ry="10" fill="#C9788A" transform="rotate(0)" opacity=".9" />
                            <ellipse rx="3" ry="10" fill="#E8B4BE" transform="rotate(45)" opacity=".85" />
                            <ellipse rx="3" ry="10" fill="#C9788A" transform="rotate(90)" opacity=".9" />
                            <ellipse rx="3" ry="10" fill="#E8B4BE" transform="rotate(135)" opacity=".85" />
                            <circle r="3.5" fill="#C9A06A" />
                        </g>
                    </svg>
                </div>
                <div class="logo-name">Satu<span>Jiwa</span></div>
                <div class="logo-sub">Sistem Undangan Digital</div>
            </div>

            <div class="divider-line"><span>✿</span></div>

            {{-- SESSION STATUS --}}
            @if(session('status'))
                <div class="alert-success">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- ERRORS --}}
            @if($errors->any())
                <div class="alert-error">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        style="flex-shrink:0;margin-top:1px">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            {{-- FORM --}}
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                {{-- EMAIL --}}
                <div class="form-group">
                    <label for="email">Emel</label>
                    <div class="input-wrap">
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="nama@email.com" required autofocus autocomplete="username">
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="2" />
                                <path d="M2 8l10 6 10-6" />
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div class="form-group">
                    <label for="password">Kata Laluan</label>
                    <div class="input-wrap">
                        <input type="password" id="password" name="password" placeholder="••••••••" required
                            autocomplete="current-password">
                        <span class="input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" />
                                <path d="M7 11V7a5 5 0 0110 0v4" />
                            </svg>
                        </span>
                        <button type="button" class="pwd-toggle" onclick="togglePwd()" id="pwdToggle"
                            aria-label="Tunjuk/Sembunyi kata laluan">
                            <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- REMEMBER + FORGOT --}}
                <div class="row-options">
                    <label class="remember">
                        <input type="checkbox" name="remember" id="remember_me" {{ old('remember') ? 'checked' : '' }}>
                        <span>Ingat saya</span>
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot">Lupa kata laluan?</a>
                    @endif
                </div>

                {{-- SUBMIT --}}
                <button type="submit" class="btn-login" id="loginBtn">
                    Log Masuk
                </button>

            </form>

            {{-- FOOTER --}}
            <div class="card-footer">
                <p>© {{ date('Y') }} SatuJiwa &nbsp;·&nbsp; <a href="{{ url('/') }}">Undangan Digital Malaysia</a></p>
            </div>

        </div>
    </div>

    <script>
        // ── PASSWORD TOGGLE ──
        function togglePwd() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }

        // ── LOADING STATE ──
        document.getElementById('loginForm').addEventListener('submit', function () {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('loading');
            btn.textContent = 'Sedang log masuk...';
        });

        // ── FLOATING PETALS ──
        const petalContainer = document.getElementById('petals');
        const COLORS = ['#E8B4BE', '#F5D9DE', '#C9A06A', '#E8D0A0', '#F0C8D0', '#FADADD'];
        for (let i = 0; i < 18; i++) {
            const p = document.createElement('div');
            p.className = 'petal';
            const size = Math.random() * 10 + 6;
            p.style.cssText = `width:${size}px;height:${size * 1.5}px;background:${COLORS[Math.floor(Math.random() * COLORS.length)]};left:${Math.random() * 100}%;animation-duration:${Math.random() * 18 + 12}s;animation-delay:${Math.random() * 16}s;opacity:0;`;
            petalContainer.appendChild(p);
        }
    </script>

</body>

</html>