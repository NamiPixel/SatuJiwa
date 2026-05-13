@extends('layouts.admin')
@section('title', 'Admin')
@section('content')

    @php $activeTab = request('tab', 'pelanggan'); @endphp

    {{-- Copy Mesej Modal --}}
    @if(session('new_slug'))
        <div id="copyMsgModal"
            style="display:flex;position:fixed;inset:0;background:rgba(0,0,0,.88);z-index:2000;align-items:center;justify-content:center;padding:16px">
            <div
                style="background:var(--card);border:1px solid var(--border);border-radius:16px;padding:28px;width:100%;max-width:500px;max-height:90vh;overflow-y:auto">
                <h3 style="font-family:'Cormorant Garamond',serif;font-size:22px;margin-bottom:6px;color:var(--gold)">
                    <i data-lucide="check-circle" style="color:var(--green); margin-right:8px;"></i> Akaun Berjaya Dibuat!
                </h3>
                <p style="font-size:13px;color:var(--muted);margin-bottom:16px">Salin mesej di bawah dan hantar kepada
                    pelanggan:</p>
                <div id="msgBox"
                    style="background:rgba(255,255,255,0.04);border:1px solid var(--border);border-radius:10px;padding:16px;font-size:13px;line-height:2;color:var(--text);white-space:pre-line">
                    Assalamualaikum 👋

                    Akaun undangan digital anda telah berjaya dicipta di *SatuJiwa*!

                    🔗 *Link Undangan:*
                    satujiwa.my/{{ session('new_slug') }}

                    🔐 *Maklumat Login Dashboard:*
                    Email: {{ session('new_email') }}
                    Password: {{ session('new_password') }}

                    📱 *Cara Setup:*
                    1. Pergi ke satujiwa.my/login
                    2. Login dengan email dan password di atas
                    3. Isi semua maklumat majlis anda
                    4. Klik *Simpan Perubahan*
                    5. Kongsi link undangan kepada tetamu anda

                    Selamat menggunakan SatuJiwa! 🌸
                    Hubungi kami jika ada sebarang pertanyaan.</div>
                <div style="display:flex;gap:10px;margin-top:16px">
                    <button onclick="copyMsg(this)" class="btn-primary" style="flex:1">📋 Salin Mesej</button>
                    <button onclick="document.getElementById('copyMsgModal').style.display='none'"
                        style="flex:1;background:none;border:1px solid var(--border);border-radius:8px;padding:10px;color:var(--text);cursor:pointer;font-family:'Nunito',sans-serif">Tutup</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Reset Password Success Modal --}}
    @if(session('reset_user'))
        <div id="resetSuccessModal"
            style="display:flex;position:fixed;inset:0;background:rgba(0,0,0,.88);z-index:2000;align-items:center;justify-content:center;padding:16px">
            <div
                style="background:var(--card);border:1px solid var(--border);border-radius:16px;padding:28px;width:100%;max-width:400px;text-align:center;">
                <i data-lucide="key" style="width:48px;height:48px;color:var(--gold);margin-bottom:16px;"></i>
                <h3 style="font-family:'Cormorant Garamond',serif;font-size:22px;margin-bottom:6px;color:var(--gold)">Password
                    Berjaya Ditukar!</h3>
                <p style="font-size:13px;color:var(--muted);margin-bottom:20px">Akaun:
                    <b>{{ session('reset_user') }}</b><br>Password Baru: <span
                        style="font-family:monospace; font-size:16px; color:var(--pink);">{{ session('reset_password') }}</span>
                </p>
                <button onclick="document.getElementById('resetSuccessModal').style.display='none'" class="btn-primary"
                    style="width:100%">Mantap!</button>
            </div>
        </div>
    @endif

    {{-- PAGE HEADER --}}
    <div class="adm-page-header">
        <div>
            <h2>Panel Admin</h2>
            <p>SatuJiwa · Urus pelanggan & undangan</p>
        </div>
    </div>

    {{-- STATS --}}
    <div class="adm-stats">
        <div class="adm-stat">
            <div class="adm-stat-icon"><i data-lucide="users"></i></div>
            <div>
                <div class="adm-stat-val">{{ $stats['total'] }}</div>
                <div class="adm-stat-lbl">Pelanggan</div>
            </div>
        </div>
        <div class="adm-stat adm-stat--green">
            <div class="adm-stat-icon"><i data-lucide="check-circle-2"></i></div>
            <div>
                <div class="adm-stat-val">{{ $stats['aktif'] }}</div>
                <div class="adm-stat-lbl">Aktif</div>
            </div>
        </div>
        <div class="adm-stat adm-stat--red">
            <div class="adm-stat-icon"><i data-lucide="alert-circle"></i></div>
            <div>
                <div class="adm-stat-val">{{ $stats['tamat'] }}</div>
                <div class="adm-stat-lbl">Tamat</div>
            </div>
        </div>
        <div class="adm-stat adm-stat--gold">
            <div class="adm-stat-icon"><i data-lucide="clock"></i></div>
            <div>
                <div class="adm-stat-val">{{ $stats['pending'] }}</div>
                <div class="adm-stat-lbl">Pending</div>
            </div>
        </div>
    </div>

    {{-- ══ TAB: PELANGGAN ══ --}}
    @if($activeTab == 'pelanggan')
        <div class="adm-card">
            <div class="adm-card-header">
                <h3>Senarai Pelanggan</h3>
                <span class="adm-badge">{{ $users->total() }} akaun</span>
            </div>

            {{-- ── CARIAN & FILTER ── --}}
            <div class="search-bar-wrap"
                style="padding: 15px 20px; border-bottom: 1px solid var(--border); background: rgba(232,103,138,0.02);">
                <div style="display:flex; gap:10px; flex-wrap:wrap">
                    <div style="position:relative; flex:1; min-width:200px">
                        <span
                            style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--muted); opacity:0.6;">
                            <i data-lucide="search" style="width:16px; height:16px;"></i>
                        </span>
                        <input type="text" id="searchInput" class="input" style="padding-left:40px"
                            placeholder="Cari nama, email atau slug..." oninput="filterPelanggan()">
                    </div>
                    <div style="display:flex; align-items:center; gap:8px">
                        <form method="GET" style="display:flex; gap:8px">
                            <input type="hidden" name="tab" value="pelanggan">
                            <select name="vendor_id" class="select" style="width: 180px;" onchange="this.form.submit()">
                                <option value="">Semua Vendor</option>
                                @foreach($vendors as $v)
                                    <option value="{{ $v->id }}" {{ request('vendor_id') == $v->id ? 'selected' : '' }}>{{ $v->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="limit" class="select" style="width: 80px;" onchange="this.form.submit()">
                                <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                                <option value="30" {{ request('limit') == 30 ? 'selected' : '' }}>30</option>
                                <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div style="display:flex; gap:8px; margin-top:12px; flex-wrap:wrap">
                    <button class="btn-sm active" data-filter="semua" onclick="setFilter('semua', this)"
                        style="border-radius:20px">Semua</button>
                    <button class="btn-sm" data-filter="aktif" onclick="setFilter('aktif', this)"
                        style="border-radius:20px">Aktif</button>
                    <button class="btn-sm" data-filter="tamat" onclick="setFilter('tamat', this)"
                        style="border-radius:20px">Tamat</button>
                    <button class="btn-sm" data-filter="pending" onclick="setFilter('pending', this)"
                        style="border-radius:20px">Pending</button>
                </div>
            </div>

            <div class="pelanggan-list" id="pelangganList">
                @forelse($users as $user)
                    @php
                        $status = !$user->invitation ? 'pending' : ($user->invitation->isExpired() ? 'tamat' : 'aktif');
                    @endphp
                    <div class="pelanggan-item" data-status="{{ $status }}" data-name="{{ strtolower($user->name) }}"
                        data-email="{{ strtolower($user->email) }}" data-slug="{{ strtolower($user->invitation->slug ?? '') }}">
                        <div class="pelanggan-top">
                            <div class="pelanggan-info">
                                <div class="pelanggan-name">{{ $user->name }}</div>
                                <div class="pelanggan-email">{{ $user->email }}</div>
                                @if($user->invitation)
                                    <div style="margin-top:4px">
                                        <a href="https://satujiwa.my/{{ $user->invitation->slug }}" target="_blank"
                                            style="font-size:11px; color:var(--pink); text-decoration:none; font-family:monospace; font-weight:600; display:inline-flex; align-items:center; gap:4px;">
                                            <i data-lucide="external-link" style="width:12px; height:12px;"></i>
                                            satujiwa.my/{{ $user->invitation->slug }}
                                        </a>
                                        @if($user->vendor)
                                            <div
                                                style="font-size:10px;color:var(--gold);margin-top:2px; display:inline-flex; align-items:center; gap:4px; margin-left:10px;">
                                                <i data-lucide="briefcase" style="width:10px; height:10px;"></i> Vendor:
                                                {{ $user->vendor->name }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px">
                                @if(!$user->invitation)
                                    <span class="badge badge-pending">Pending</span>
                                @elseif($user->invitation->isExpired())
                                    <span class="badge badge-expired">Tamat</span>
                                @else
                                    <span class="badge badge-active">Aktif</span>
                                @endif
                                @if($user->invitation)
                                    <div style="font-size:10px;color:var(--muted)">Tamat:
                                        {{ $user->invitation->expires_at?->format('d/m/Y') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div style="display:flex; gap:8px; border-top:1px dashed var(--border); padding-top:12px; margin-top:12px">
                            <button class="btn-sm"
                                onclick="openResetModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}')">
                                <i data-lucide="key" style="width:12px; height:12px;"></i> Reset PW
                            </button>
                            @if($user->invitation)
                                <form method="POST" action="{{ route('admin.extend', $user->invitation) }}" style="display:inline">
                                    @csrf
                                    <input type="hidden" name="bulan" value="12">
                                    <button type="submit" class="btn-sm">
                                        <i data-lucide="calendar-plus" style="width:12px; height:12px;"></i> +1 Tahun
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.destroy', $user) }}"
                                onsubmit="return confirm('Padam akaun {{ addslashes($user->name) }}?')" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">
                                    <i data-lucide="trash-2" style="width:12px; height:12px;"></i> Padam
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center;color:var(--muted);padding:40px;font-size:13px">
                        <i data-lucide="inbox" style="width:24px; height:24px; display:block; margin:0 auto 10px; opacity:0.3;"></i>
                        Tiada pelanggan dijumpai.
                    </div>
                @endforelse
            </div>

            @if($users->hasPages())
                <div style="padding: 20px; border-top: 1px solid var(--border); display: flex; justify-content: center;">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    @endif

    {{-- ══ TAB: BUAT AKAUN ══ --}}
    @if($activeTab == 'buat')
        <div class="adm-card" style="max-width: 600px; margin: 0 auto;">
            <div class="adm-card-header">
                <h3><i data-lucide="user-plus"
                        style="width:18px; height:18px; color:var(--pink); vertical-align:middle; margin-right:8px;"></i> Buat
                    Akaun Baru</h3>
            </div>
            <div style="padding:20px">
                <form method="POST" action="{{ route('admin.store') }}">
                    @csrf
                    <div class="form-group">
                        <label>Nama Pengantin 1</label>
                        <input class="input" name="nama_lelaki" placeholder="cth: Akif" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Pengantin 2 (Opsional)</label>
                        <input class="input" name="nama_perempuan" placeholder="cth: Aliya">
                    </div>
                    <div class="form-group">
                        <label>Slug URL</label>
                        <div style="position:relative">
                            <input class="input" name="slug" id="slugInput" placeholder="akif-aliya" required
                                pattern="[a-z0-9\-]+">
                        </div>
                        <div style="font-size:11px;color:var(--gold);margin-top:6px;font-family:monospace;background:rgba(201,169,110,0.06);padding:8px 12px;border-radius:6px"
                            id="slugPreview">satujiwa.my/—</div>
                    </div>
                    <div class="form-group">
                        <label>Email Login</label>
                        <input class="input" name="email" type="email" placeholder="email@example.com" required>
                    </div>
                    <div class="form-group">
                        <label>Kata Laluan</label>
                        <div style="display:flex;gap:8px">
                            <input class="input" name="password" id="pwInput" type="text" required style="flex:1">
                            <button type="button" onclick="genPw()"
                                style="background:rgba(201,169,110,0.1);border:1px solid var(--border);border-radius:10px;padding:0 14px;color:var(--gold);cursor:pointer;font-size:16px;flex-shrink:0">
                                <i data-lucide="refresh-cw" style="width:16px; height:16px;"></i>
                            </button>
                        </div>
                    </div>
                    @if($errors->any())
                        <div
                            style="background:rgba(224,112,112,0.08);border:1px solid rgba(224,112,112,0.25);border-radius:8px;padding:12px;margin-bottom:16px">
                            @foreach($errors->all() as $error)
                                <div style="color:#E07070;font-size:12px">• {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <button type="submit" class="btn-primary" style="width:100%;margin-top:4px">✨ Buat Akaun</button>
                </form>
            </div>
        </div>
    @endif

    {{-- ══ TAB: VENDOR ══ --}}
    @if($activeTab == 'vendor')
        {{-- CHANGED: grid-template-columns 1fr 2fr (1/3 + 2/3) --}}
        <div class="adm-grid-2-1" style="grid-template-columns: 1fr 2fr;">

            {{-- Daftar Vendor Baru (1/3) --}}
            <div class="adm-card">
                <div class="adm-card-header">
                    <h3>Daftar Vendor Baru</h3>
                </div>
                <div style="padding:20px">
                    <form method="POST" action="{{ route('admin.vendors.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Nama Syarikat / Vendor</label>
                            <input class="input" name="name" placeholder="cth: Dewan Seri Melati" required>
                        </div>
                        <div class="form-group">
                            <label>Email Rasmi</label>
                            <input class="input" name="email" type="email" placeholder="vendor@example.com" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <div style="display:flex; gap:8px">
                                <input class="input" name="password" id="vendorPwInput" type="text" required style="flex:1">
                                <button type="button" onclick="genVendorPw()"
                                    style="background:rgba(232,103,138,0.1); border:1px solid var(--border); border-radius:10px; padding:0 14px; color:var(--pink); cursor:pointer; font-size:16px; flex-shrink:0">
                                    <i data-lucide="refresh-cw" style="width:16px; height:16px;"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn-primary" style="width:100%; margin-top:10px">✨ Daftar Vendor</button>
                    </form>
                </div>
            </div>

            {{-- Senarai Vendor (2/3) --}}
            <div class="adm-card">
                <div class="adm-card-header">
                    <h3>Senarai Vendor Berdaftar</h3>
                    <span class="adm-badge">{{ $vendors->count() }} vendor</span>
                </div>
                <div class="pelanggan-list">
                    @forelse($vendors as $vendor)
                        <div class="pelanggan-item">
                            <div class="pelanggan-top">
                                <div class="pelanggan-info">
                                    <div class="pelanggan-name">{{ $vendor->name }}</div>
                                    <div class="pelanggan-email">{{ $vendor->email }}</div>
                                    <div
                                        style="font-size:10px; color:var(--muted); margin-top:4px; display:inline-flex; align-items:center; gap:4px;">
                                        <i data-lucide="calendar" style="width:10px; height:10px;"></i> Daftar pada:
                                        {{ $vendor->created_at->format('d M Y') }}
                                    </div>
                                </div>
                                <div style="text-align:right">
                                    <div
                                        style="font-size:24px; font-family:'Cormorant Garamond', serif; font-weight:700; color:var(--pink); line-height:1;">
                                        {{ $vendor->customers_count }}
                                    </div>
                                    <div
                                        style="font-size:9px; color:var(--muted); text-transform:uppercase; letter-spacing:1px; margin-top:4px;">
                                        Pelanggan</div>
                                    <div
                                        style="font-size:10px; color:var(--green); margin-top:6px; background:rgba(74,140,106,0.08); padding:2px 8px; border-radius:50px; display:inline-flex; align-items:center; gap:4px;">
                                        <i data-lucide="check" style="width:10px; height:10px;"></i> Aktif:
                                        {{ $vendor->active_customers }}
                                    </div>
                                </div>
                            </div>
                            <div
                                style="display:flex; gap:8px; border-top:1px dashed var(--border); padding-top:12px; margin-top:12px">
                                <a href="{{ route('admin.loginAsVendor', $vendor) }}" class="btn-sm"
                                    style="color:var(--pink); border-color:var(--pink);">
                                    <i data-lucide="log-in" style="width:12px; height:12px;"></i> Login sebagai Vendor
                                </a>
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center; padding:40px; color:var(--muted); font-size:13px">
                            Belum ada vendor berdaftar.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    @endif

    {{-- ══ TAB: TEMPLATE ══ --}}
    @if($activeTab == 'template')
        {{-- CHANGED: grid-template-columns 1fr 2fr (1/3 + 2/3) --}}
        <div class="adm-grid-2-1" style="grid-template-columns: 1fr 2fr;">

            {{-- Muat Naik Template (1/3) --}}
            <div class="adm-card">
                <div class="adm-card-header">
                    <h3>Muat Naik Template</h3>
                </div>
                <div style="padding:20px">
                    <form id="uploadForm" method="POST" action="{{ route('admin.template.upload') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Pilih Gambar</label>
                            <input type="file" name="templates[]" id="templateFiles" multiple class="input" style="padding:8px" required>
                            <p style="font-size:10px; color:var(--muted); margin-top:8px;">Boleh pilih banyak serentak. Nama
                                fail automatik NP0001, NP0002...</p>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            {{-- CHANGED: vintage → arts --}}
                            <select name="category" class="select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="floral">1. Floral</option>
                                <option value="minimalist">2. Minimalist</option>
                                <option value="classic">3. Classic</option>
                                <option value="modern">4. Modern</option>
                                <option value="elegant">5. Elegant</option>
                                <option value="arts">6. Arts</option>
                                <option value="islamic">7. Islamic</option>
                            </select>
                        </div>

                        {{-- UPLOAD PROGRESS UI --}}
                        <div id="uploadProgress" style="display:none; margin-bottom:16px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; font-size:11px; color:var(--muted); margin-bottom:8px;">
                                <span id="uploadStatusText" style="font-weight:600;">Menghantar fail...</span>
                                <span id="uploadPct" style="font-family:monospace; font-size:13px; color:var(--pink); font-weight:700;">0%</span>
                            </div>
                            {{-- Progress Bar --}}
                            <div style="background:rgba(255,255,255,0.06); border-radius:50px; height:10px; overflow:hidden; border:1px solid var(--border); position:relative;">
                                <div id="uploadBar"
                                    style="height:100%; width:0%; border-radius:50px; transition:width 0.25s ease;
                                           background:linear-gradient(90deg, var(--pink), var(--gold));
                                           position:relative; overflow:hidden;">
                                    {{-- Shimmer effect --}}
                                    <div style="position:absolute;inset:0;background:linear-gradient(90deg,transparent 0%,rgba(255,255,255,0.3) 50%,transparent 100%);animation:shimmer 1.2s infinite;"></div>
                                </div>
                            </div>
                            {{-- File Counter --}}
                            <div style="display:flex; justify-content:space-between; margin-top:8px;">
                                <span id="uploadFileCount" style="font-size:10px; color:var(--muted);">0 / 0 fail</span>
                                <span id="uploadSize" style="font-size:10px; color:var(--muted);"></span>
                            </div>
                            {{-- Status Pills --}}
                            <div id="uploadStage" style="margin-top:10px; display:flex; align-items:center; gap:6px;">
                                <span id="pill-upload" style="font-size:9px; padding:2px 8px; border-radius:50px; background:rgba(232,103,138,0.15); color:var(--pink); border:1px solid rgba(232,103,138,0.3); font-weight:600;">
                                    📤 Menghantar
                                </span>
                                <span style="font-size:10px; color:var(--muted);">→</span>
                                <span id="pill-process" style="font-size:9px; padding:2px 8px; border-radius:50px; background:rgba(255,255,255,0.04); color:var(--muted); border:1px solid var(--border);">
                                    ⚙️ Memproses
                                </span>
                                <span style="font-size:10px; color:var(--muted);">→</span>
                                <span id="pill-done" style="font-size:9px; padding:2px 8px; border-radius:50px; background:rgba(255,255,255,0.04); color:var(--muted); border:1px solid var(--border);">
                                    ✅ Selesai
                                </span>
                            </div>
                        </div>

                        <button type="submit" id="uploadBtn" class="btn-primary" style="width:100%">🚀 Muat Naik</button>
                    </form>
                </div>
            </div>

            {{-- Senarai Template (2/3) --}}
            <div class="adm-card">
                <div class="adm-card-header">
                    <h3>Senarai Template</h3>
                    <span class="adm-badge">{{ $templates->count() }} keping</span>
                </div>
                <div style="padding:20px; display:grid; grid-template-columns:repeat(auto-fill, minmax(140px, 1fr)); gap:16px;">
                    @forelse($templates as $tmp)
                        <div
                            style="position:relative; border-radius:12px; overflow:hidden; border:1px solid var(--border); aspect-ratio:3/4; background:#f0f0f0;">
                            <img src="{{ asset('storage/' . $tmp->image_path) }}"
                                style="width:100%; height:100%; object-fit:cover;">
                            <div
                                style="position:absolute; bottom:0; left:0; right:0; padding:8px; background:linear-gradient(transparent, rgba(0,0,0,0.8)); display:flex; justify-content:space-between; align-items:flex-end;">
                                <div style="display:flex; flex-direction:column; gap:2px;">
                                    <span style="color:#fff; font-size:10px; font-weight:700;">{{ $tmp->nama }}</span>
                                    @if($tmp->category)
                                        <span
                                            style="color:var(--gold-light); font-size:8px; text-transform:uppercase; letter-spacing:0.5px; font-weight:600;">{{ $tmp->category }}</span>
                                    @endif
                                </div>
                                <form method="POST" action="{{ route('admin.template.delete', $tmp) }}"
                                    onsubmit="return confirm('Padam template {{ $tmp->nama }}?')">
                                    @csrf @method('DELETE')
                                    <button
                                        style="background:rgba(255,255,255,0.2); border:none; border-radius:6px; width:24px; height:24px; color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                                        <i data-lucide="trash-2" style="width:14px; height:14px;"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column:1/-1; text-align:center; padding:40px; color:var(--muted); font-size:13px;">Belum
                            ada template.</div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Shimmer keyframe + Upload XHR Script --}}
        <style>
            @keyframes shimmer {
                0%   { transform: translateX(-100%); }
                100% { transform: translateX(200%); }
            }
        </style>
        <script>
        document.getElementById('uploadForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const form      = this;
            const files     = document.getElementById('templateFiles').files;
            if (!files.length) return;

            const btn           = document.getElementById('uploadBtn');
            const progressWrap  = document.getElementById('uploadProgress');
            const bar           = document.getElementById('uploadBar');
            const pctLabel      = document.getElementById('uploadPct');
            const statusText    = document.getElementById('uploadStatusText');
            const fileCountEl   = document.getElementById('uploadFileCount');
            const sizeEl        = document.getElementById('uploadSize');
            const pillUpload    = document.getElementById('pill-upload');
            const pillProcess   = document.getElementById('pill-process');
            const pillDone      = document.getElementById('pill-done');

            // Calculate total size
            let totalBytes = 0;
            for (let f of files) totalBytes += f.size;
            const totalMB = (totalBytes / 1024 / 1024).toFixed(1);

            // Show progress UI
            btn.disabled = true;
            btn.innerHTML = '⏳ Menghantar...';
            progressWrap.style.display = 'block';
            sizeEl.textContent = `Jumlah: ${totalMB} MB`;
            fileCountEl.textContent = `0 / ${files.length} fail`;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', form.action);
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('input[name=_token]').value);

            // Track upload progress
            xhr.upload.addEventListener('progress', function (e) {
                if (!e.lengthComputable) return;
                const percent = Math.round((e.loaded / e.total) * 100);

                bar.style.width = percent + '%';
                pctLabel.textContent = percent + '%';

                const approxDone = Math.min(Math.floor((percent / 100) * files.length), files.length);
                fileCountEl.textContent = `~${approxDone} / ${files.length} fail`;

                const sentMB = (e.loaded / 1024 / 1024).toFixed(1);
                sizeEl.textContent = `${sentMB} / ${totalMB} MB`;

                if (percent >= 100) {
                    // Switch to "processing" stage
                    statusText.textContent = 'Server sedang memproses...';
                    bar.style.background = 'linear-gradient(90deg, var(--gold), #C9A06A)';
                    pillUpload.style.opacity = '0.4';
                    pillProcess.style.background = 'rgba(201,160,106,0.15)';
                    pillProcess.style.color = 'var(--gold)';
                    pillProcess.style.borderColor = 'rgba(201,160,106,0.4)';
                    fileCountEl.textContent = `${files.length} / ${files.length} fail — memproses...`;
                }
            });

            // On complete
            xhr.addEventListener('load', function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    bar.style.width = '100%';
                    pctLabel.textContent = '100%';
                    statusText.textContent = 'Berjaya dimuat naik!';
                    bar.style.background = 'linear-gradient(90deg, #4A8C6A, #6dbf8a)';
                    fileCountEl.textContent = `${files.length} / ${files.length} fail selesai ✓`;

                    // Activate done pill
                    pillProcess.style.opacity = '0.4';
                    pillDone.style.background = 'rgba(74,140,106,0.15)';
                    pillDone.style.color = '#4A8C6A';
                    pillDone.style.borderColor = 'rgba(74,140,106,0.4)';

                    btn.innerHTML = '✅ Selesai! Memuat semula...';
                    btn.style.background = 'var(--green)';

                    setTimeout(() => window.location.reload(), 1400);
                } else {
                    // Error state
                    statusText.textContent = '❌ Ralat berlaku. Cuba lagi.';
                    bar.style.background = '#E05555';
                    bar.style.width = '100%';
                    pctLabel.textContent = '!';
                    btn.disabled = false;
                    btn.innerHTML = '🚀 Cuba Semula';
                    btn.style.background = '';
                }
            });

            xhr.addEventListener('error', function () {
                statusText.textContent = '❌ Sambungan gagal.';
                bar.style.background = '#E05555';
                btn.disabled = false;
                btn.innerHTML = '🚀 Cuba Semula';
            });

            const formData = new FormData(form);
            xhr.send(formData);
        });
        </script>
    @endif

    {{-- ══ TAB: LAPORAN ══ --}}
    @if($activeTab == 'report')
        @php
            $aktifPct = $stats['total'] > 0 ? round(($stats['aktif'] / $stats['total']) * 100) : 0;
            $tamatPct = $stats['total'] > 0 ? round(($stats['tamat'] / $stats['total']) * 100) : 0;
            $pendingPct = $stats['total'] > 0 ? round(($stats['pending'] / $stats['total']) * 100) : 0;
        @endphp

        {{-- Filter Laporan --}}
        <div class="adm-card" style="margin-bottom: 24px;">
            <div
                style="padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div style="display: flex; align-items:center; gap: 10px;">
                    <i data-lucide="filter" style="width:20px; height:20px; color:var(--pink);"></i>
                    <h4 style="font-family:'Cormorant Garamond', serif; font-size:18px; color:var(--text-dark);">Tapis Data</h4>
                </div>
                <form method="GET" action="{{ route('admin.index') }}"
                    style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <input type="hidden" name="tab" value="report">
                    <select name="month" class="select" style="width: 130px;">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('month', now()->month) == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                            </option>
                        @endforeach
                    </select>
                    <select name="year" class="select" style="width: 90px;">
                        @foreach(range(now()->year - 2, now()->year) as $y)
                            <option value="{{ $y }}" {{ request('year', now()->year) == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-primary" style="padding: 8px 16px; font-size: 13px;">Tapis</button>
                </form>
            </div>
            <div class="adm-grid-stats"
                style="background: rgba(232,103,138,0.03); padding: 20px; border-top: 1px solid var(--border);">
                <div style="padding: 16px; border: 1px solid var(--border); border-radius:12px; background:#fff;">
                    <div
                        style="font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">
                        Pendaftaran {{ $stats['analytics']['period_label'] }}</div>
                    <div style="display: flex; align-items: baseline; gap: 8px;">
                        <div style="font-size: 24px; font-weight: 700; color: var(--rose);">
                            {{ $stats['analytics']['monthly_total'] }}
                        </div>
                        <div
                            style="font-size: 12px; font-weight: 600; color: {{ $stats['analytics']['growth'] >= 0 ? '#4A8C6A' : '#E05555' }};">
                            {{ $stats['analytics']['growth'] >= 0 ? '↑' : '↓' }} {{ abs($stats['analytics']['growth']) }}%
                            <span style="font-size: 10px; font-weight: 400; color: var(--muted); opacity: 0.7;">vs bln
                                lalu</span>
                        </div>
                    </div>
                </div>
                <div style="padding: 16px; border: 1px solid var(--border); border-radius:12px; background:#fff;">
                    <div
                        style="font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">
                        Kadar Penukaran</div>
                    <div style="font-size: 24px; font-weight: 700; color: var(--gold);">{{ $stats['analytics']['conversion'] }}%
                    </div>
                    <div style="font-size: 10px; color: var(--muted); line-height: 1;">Akaun vs Invitation</div>
                </div>
                <div style="padding: 16px; border: 1px solid var(--border); border-radius:12px; background:#fff;">
                    <div
                        style="font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">
                        Jumlah Keseluruhan</div>
                    <div style="font-size: 24px; font-weight: 700; color: var(--text);">{{ $stats['total'] }}</div>
                    <div style="font-size: 10px; color: var(--muted); line-height: 1;">Pelanggan Berdaftar</div>
                </div>
                <div style="padding: 16px; border: 1px solid var(--border); border-radius:12px; background:#fff;">
                    <div
                        style="font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">
                        Status Majlis</div>
                    <div style="font-size: 13px; font-weight: 600; color: #4A8C6A;">{{ $stats['aktif'] }} Aktif</div>
                    <div style="font-size: 13px; font-weight: 600; color: #E05555;">{{ $stats['tamat'] }} Tamat</div>
                </div>
            </div>
        </div>

        <div class="adm-report-grid">
            {{-- Left Column: Charts --}}
            <div>
                <div class="adm-card">
                    <div class="adm-card-header">
                        <h3><i data-lucide="line-chart"
                                style="width:16px; height:16px; vertical-align:middle; margin-right:8px; color:var(--rose);"></i>
                            Pendaftaran Bulanan</h3>
                    </div>
                    <div style="padding:20px">
                        <canvas id="dualLineChart" height="250"></canvas>
                    </div>
                </div>

                <div class="adm-card">
                    <div class="adm-card-header">
                        <h3><i data-lucide="bar-chart-3"
                                style="width:16px; height:16px; vertical-align:middle; margin-right:8px; color:var(--rose);"></i>
                            Prestasi Pelanggan Setiap Vendor</h3>
                    </div>
                    <div style="padding:20px">
                        <canvas id="vendorBarChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            {{-- Right Column: Side Stats & Performance Table --}}
            <div>
                <div class="adm-card">
                    <div class="adm-card-header">
                        <h3><i data-lucide="pie-chart"
                                style="width:16px; height:16px; vertical-align:middle; margin-right:8px; color:var(--rose);"></i>
                            Status Pelanggan</h3>
                    </div>
                    <div style="padding:20px;display:flex;flex-direction:column;align-items:center;gap:14px">
                        <canvas id="donutChart" width="180" height="180"></canvas>
                        <div style="width:100%;">
                            <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:5px;">
                                <span><span
                                        style="display:inline-block; width:8px; height:8px; background:#E8678A; border-radius:50%; margin-right:5px;"></span>
                                    Aktif</span>
                                <span style="font-weight:600">{{ $stats['aktif'] }} ({{ $aktifPct }}%)</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:5px;">
                                <span><span
                                        style="display:inline-block; width:8px; height:8px; background:#E05555; border-radius:50%; margin-right:5px;"></span>
                                    Tamat</span>
                                <span style="font-weight:600">{{ $stats['tamat'] }} ({{ $tamatPct }}%)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="adm-card">
                    <div class="adm-card-header">
                        <h3><i data-lucide="trophy"
                                style="width:16px; height:16px; vertical-align:middle; margin-right:8px; color:var(--rose);"></i>
                            Kedudukan Vendor</h3>
                    </div>
                    <div style="padding:0; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                        <table style="width:100%; border-collapse:collapse; font-size:13px;">
                            <thead style="background:rgba(232,103,138,0.03);">
                                <tr>
                                    <th
                                        style="padding:10px 15px; text-align:left; font-size:10px; color:var(--muted); text-transform:uppercase;">
                                        Vendor</th>
                                    <th
                                        style="padding:10px 15px; text-align:right; font-size:10px; color:var(--muted); text-transform:uppercase;">
                                        Akaun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vendorPerformance as $vp)
                                    <tr style="border-bottom: 1px solid var(--border);">
                                        <td style="padding:12px 15px; font-weight:600; color:var(--text); line-height:1.2;">
                                            {{ $vp->name }}<br>
                                            <span style="font-size:9px; color:var(--muted); font-weight:400;">Bulan Ini</span>
                                        </td>
                                        <td style="padding:12px 15px; text-align:right; color:var(--pink); font-weight:700;">
                                            {{ $vp->customers_count }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
        <script>
            (function () {
                const pink = '#E8678A';
                const gold = '#C9A06A';
                const green = '#4A8C6A';
                const red = '#E05555';

                // 1. Dual Line Chart
                new Chart(document.getElementById('dualLineChart'), {
                    type: 'line',
                    data: {
                        labels: @json(array_column($monthsTrend, 'label')),
                        datasets: [
                            {
                                label: 'Pelanggan',
                                data: @json(array_column($monthsTrend, 'buyers')),
                                borderColor: pink,
                                backgroundColor: 'rgba(232, 103, 138, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Vendor',
                                data: @json(array_column($monthsTrend, 'vendors')),
                                borderColor: gold,
                                backgroundColor: 'rgba(201, 160, 106, 0.1)',
                                tension: 0.4,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' },
                            title: { display: true, text: 'Tren 6 Bulan (Sehingga {{ $stats['analytics']['period_label'] }})', font: { size: 10 } }
                        },
                        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                    }
                });

                // 2. Vendor Bar Chart
                new Chart(document.getElementById('vendorBarChart'), {
                    type: 'bar',
                    data: {
                        labels: @json($vendorPerformance->pluck('name')),
                        datasets: [{
                            label: 'Akaun Baru ({{ $stats['analytics']['period_label'] }})',
                            data: @json($vendorPerformance->pluck('customers_count')),
                            backgroundColor: pink,
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            title: { display: true, text: 'Prestasi Vendor ({{ $stats['analytics']['period_label'] }})', font: { size: 10 } }
                        },
                        scales: { y: { beginAtZero: true } }
                    }
                });

                // 3. Donut Chart
                new Chart(document.getElementById('donutChart'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Aktif', 'Tamat', 'Pending'],
                        datasets: [{
                            data: [{{ $stats['aktif'] }}, {{ $stats['tamat'] }}, {{ $stats['pending'] }}],
                            backgroundColor: [green, red, pink],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        cutout: '70%',
                        plugins: { legend: { display: false } }
                    }
                });
            })();
        </script>
    @endif

    {{-- Reset Password Modal --}}
    <div id="resetModal"
        style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.8);z-index:1000;align-items:center;justify-content:center;padding:16px">
        <div
            style="background:var(--card);border:1px solid var(--border);border-radius:14px;padding:28px;width:100%;max-width:380px">
            <h3 style="font-family:'Cormorant Garamond',serif;font-size:20px;margin-bottom:6px;color:var(--gold-light)">
                Reset Password</h3>
            <p id="resetModalName" style="color:var(--muted);font-size:12px;margin-bottom:16px"></p>
            <form method="POST" id="resetForm">
                @csrf
                <div class="form-group">
                    <label>Password Baru</label>
                    <div style="display:flex;gap:8px">
                        <input class="input" name="password" type="text" id="resetPwInput" required style="flex:1">
                        <button type="button" onclick="genResetPw()"
                            style="background:rgba(201,169,110,0.1);border:1px solid var(--border);border-radius:10px;padding:0 14px;color:var(--gold);cursor:pointer;font-size:16px;flex-shrink:0">
                            <i data-lucide="refresh-cw" style="width:16px; height:16px;"></i>
                        </button>
                    </div>
                </div>
                <div style="display:flex;gap:10px;margin-top:16px">
                    <button type="button" onclick="closeResetModal()"
                        style="flex:1;background:none;border:1px solid var(--border);border-radius:8px;padding:12px;color:var(--text);cursor:pointer;font-family:'Nunito',sans-serif">Batal</button>
                    <button type="submit" class="btn-primary" style="flex:1">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function genPw() {
            const c = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
            const pw = Array.from({ length: 8 }, () => c[Math.floor(Math.random() * c.length)]).join('');
            document.getElementById('pwInput').value = pw;
        }
        function genVendorPw() {
            const c = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
            const pw = Array.from({ length: 8 }, () => c[Math.floor(Math.random() * c.length)]).join('');
            document.getElementById('vendorPwInput').value = pw;
        }
        function genResetPw() {
            const c = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
            const pw = Array.from({ length: 8 }, () => c[Math.floor(Math.random() * c.length)]).join('');
            document.getElementById('resetPwInput').value = pw;
        }
        function copyMsg(btn) {
            const box = document.getElementById('msgBox');
            navigator.clipboard.writeText(box.innerText).then(() => {
                const oldTxt = btn.innerText;
                btn.innerText = '✅ Berjaya Disalin';
                setTimeout(() => btn.innerText = oldTxt, 2000);
            });
        }
        function filterPelanggan() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('.pelanggan-item').forEach(el => {
                const text = el.dataset.name + ' ' + el.dataset.email + ' ' + el.dataset.slug;
                const matches = text.includes(q);
                el.style.display = matches ? '' : 'none';
            });
        }
        function setFilter(status, btn) {
            document.querySelectorAll('.search-bar-wrap .btn-sm').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.pelanggan-item').forEach(el => {
                if (status == 'semua' || el.dataset.status == status) el.style.display = '';
                else el.style.display = 'none';
            });
        }
        function openResetModal(id, name, email) {
            document.getElementById('resetModal').style.display = 'flex';
            document.getElementById('resetModalName').innerText = name + ' (' + email + ')';
            document.getElementById('resetForm').action = '/admin/user/' + id + '/reset-password';
            genResetPw();
        }
        function closeResetModal() {
            document.getElementById('resetModal').style.display = 'none';
        }
        if (document.getElementById('slugInput')) {
            document.getElementById('slugInput').addEventListener('input', e => {
                document.getElementById('slugPreview').textContent = 'satujiwa.my/' + (e.target.value.toLowerCase().replace(/[^a-z0-9\-]/g, '-') || '—');
            });
        }
        @if($activeTab == 'buat') genPw(); @endif
    </script>

@endsection