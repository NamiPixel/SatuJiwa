@extends('layouts.vendor')
@section('title', 'Panel Vendor')
@section('content')

@php $activeTab = request('tab', 'pelanggan'); @endphp

{{-- Copy Mesej Modal --}}
@if(session('new_slug'))
<div id="copyMsgModal" style="display:flex;position:fixed;inset:0;background:rgba(0,0,0,.7);backdrop-filter:blur(8px);z-index:2000;align-items:center;justify-content:center;padding:16px">
    <div class="section-card" style="width:100%;max-width:500px;max-height:90vh;overflow-y:auto;background:#fff;padding:28px">
        <h3 style="font-family:'Cormorant Garamond',serif;font-size:22px;margin-bottom:6px;color:var(--rose)">
            <i data-lucide="check-circle-2" style="width:24px; height:24px; vertical-align:middle; margin-right:8px;"></i> Akaun Berjaya Dibuat!
        </h3>
        <p style="font-size:13px;color:var(--text-soft);margin-bottom:16px">Salin mesej di bawah dan hantar kepada pelanggan:</p>
        <div id="msgBox" style="background:var(--rose-blush);border:1px solid var(--border-rose);border-radius:10px;padding:16px;font-size:13px;line-height:2;color:var(--text-dark);white-space:pre-line">Assalamualaikum 👋

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
            <button onclick="document.getElementById('copyMsgModal').style.display='none'" style="flex:1;background:none;border:1px solid var(--border);border-radius:50px;padding:10px;color:var(--text-soft);cursor:pointer;font-family:'Nunito',sans-serif">Tutup</button>
        </div>
    </div>
</div>
@endif

{{-- PAGE HEADER --}}
<div style="margin-bottom: 24px;">
    <h2 style="font-family:'Cormorant Garamond',serif; font-size: 28px; color: var(--rose);">Panel Vendor</h2>
    <p style="font-size: 13px; color: var(--text-soft);">Selamat datang, uruskan pelanggan dan pendaftaran anda di sini.</p>
</div>

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-val">{{ $stats['total'] }}</div>
        <div class="stat-lbl">Pelanggan</div>
    </div>
    <div class="stat-card">
        <div class="stat-val" style="color: var(--green)">{{ $stats['aktif'] }}</div>
        <div class="stat-lbl">Aktif</div>
    </div>
    <div class="stat-card">
        <div class="stat-val" style="color: var(--red)">{{ $stats['tamat'] }}</div>
        <div class="stat-lbl">Tamat</div>
    </div>
    <div class="stat-card">
        <div class="stat-val" style="color: var(--gold)">{{ $stats['pending'] }}</div>
        <div class="stat-lbl">Pending</div>
    </div>
</div>

{{-- ══ TAB: PELANGGAN ══ --}}
@if($activeTab == 'pelanggan')
<div class="section-card">
    <div class="section-head">
        <h3>Senarai Pelanggan</h3>
        <span class="badge badge-active">{{ $users->total() }} akaun</span>
    </div>
    
    <div style="padding: 16px; border-bottom: 1px solid var(--border);">
        <div style="display:flex; gap:10px; flex-wrap:wrap">
            <div style="position: relative; flex: 1; min-width: 250px;">
                <i data-lucide="search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-soft); width: 16px; height: 16px;"></i>
                <input type="text" id="searchInput" class="input" placeholder="Cari nama, email atau slug..." oninput="filterPelanggan()" style="padding-left: 38px;">
            </div>
            <form method="GET" style="display:flex; gap:10px">
                <input type="hidden" name="tab" value="pelanggan">
                <select name="limit" class="input" style="padding: 8px 12px; font-size: 12px; width: 80px;" onchange="this.form.submit()">
                    <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                    <option value="30" {{ request('limit') == 30 ? 'selected' : '' }}>30</option>
                    <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
                </select>
            </form>
        </div>
        <div style="margin-top:12px; display:flex; gap:8px; flex-wrap:wrap">
            <button class="filter-pill active" onclick="setFilter('semua', this)">Semua</button>
            <button class="filter-pill" onclick="setFilter('aktif', this)">Aktif</button>
            <button class="filter-pill" onclick="setFilter('tamat', this)">Tamat</button>
            <button class="filter-pill" onclick="setFilter('pending', this)">Pending</button>
        </div>
    </div>

    <div class="section-body" style="padding: 0; overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table style="width: 100%; min-width: 600px; border-collapse: collapse; font-size: 13px;">

            <thead>
                <tr style="text-align: left; background: rgba(201,120,138,0.03);">
                    <th style="padding: 12px 20px; font-weight: 600; color: var(--text-soft); font-size: 10px; text-transform: uppercase;">Pelanggan</th>
                    <th style="padding: 12px 20px; font-weight: 600; color: var(--text-soft); font-size: 10px; text-transform: uppercase;">Status</th>
                    <th style="padding: 12px 20px; font-weight: 600; color: var(--text-soft); font-size: 10px; text-transform: uppercase; text-align: right;">Tindakan</th>
                </tr>
            </thead>
            <tbody id="pelangganList">
                @forelse($users as $user)
                @php
                    $status = !$user->invitation ? 'pending' : ($user->invitation->isExpired() ? 'tamat' : 'aktif');
                @endphp
                <tr class="pelanggan-item" 
                    data-status="{{ $status }}"
                    data-name="{{ strtolower($user->name) }}" 
                    data-email="{{ strtolower($user->email) }}" 
                    data-slug="{{ strtolower($user->invitation->slug ?? '') }}"
                    style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 16px 20px;">
                        <div style="font-weight: 600; color: var(--text-dark);">{{ $user->name }}</div>
                        <div style="font-size: 11px; color: var(--text-soft);">{{ $user->email }}</div>
                        @if($user->invitation)
                        <div style="margin-top: 4px; font-family: monospace; font-size: 11px;">
                            <a href="https://satujiwa.my/{{ $user->invitation->slug }}" target="_blank" style="color: var(--rose); text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                <i data-lucide="external-link" style="width:12px; height:12px;"></i> satujiwa.my/{{ $user->invitation->slug }}
                            </a>
                        </div>
                        @endif
                    </td>
                    <td style="padding: 16px 20px;">
                        @if(!$user->invitation)
                            <span class="badge badge-pending">Pending</span>
                        @elseif($user->invitation->isExpired())
                            <span class="badge badge-expired" style="background:rgba(192,80,96,0.1); color:#C05060">Tamat</span>
                        @else
                            <span class="badge badge-active">Aktif</span>
                        @endif
                        @if($user->invitation)
                        <div style="font-size: 10px; color: var(--text-soft); margin-top: 4px;">Tamat: {{ $user->invitation->expires_at?->format('d/m/Y') }}</div>
                        @endif
                    </td>
                    <td style="padding: 16px 20px; text-align: right;">
                        <button class="btn-logout" style="font-size: 10px; padding: 6px 12px; display: inline-flex; align-items: center; gap: 4px;" onclick="openResetModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}')">
                            <i data-lucide="key" style="width:12px; height:12px;"></i> Reset Pass
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="padding: 40px; text-align: center; color: var(--text-soft);">
                        Tiada pelanggan ditemui.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
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
<div style="max-width: 600px; margin: 0 auto;">
    <div class="section-card">
        <div class="section-head">
            <h3>Daftar Pelanggan Baru</h3>
        </div>
        <div class="section-body">
            <form method="POST" action="{{ route('vendor.store') }}">
                @csrf
                <div class="form-group">
                    <label>Nama Pengantin 1</label>
                    <input class="input" name="nama_lelaki" placeholder="cth: Adam" required>
                </div>
                <div class="form-group">
                    <label>Nama Pengantin 2 (Opsional)</label>
                    <input class="input" name="nama_perempuan" placeholder="cth: Hawa">
                </div>
                <div class="form-group">
                    <label>Slug URL (Pautan Undangan)</label>
                    <input class="input" name="slug" id="slugInput" placeholder="adam-hawa" required pattern="[a-z0-9\-]+">
                    <div style="font-size: 11px; color: var(--rose); margin-top: 6px; font-style: italic;" id="slugPreview">satujiwa.my/—</div>
                </div>
                <div class="form-group">
                    <label>Email Login</label>
                    <input class="input" name="email" type="email" placeholder="pelanggan@email.com" required>
                </div>
                <div class="form-group">
                    <label>Kata Laluan</label>
                    <div style="display:flex; gap: 8px;">
                        <input class="input" name="password" id="pwInput" type="text" required style="flex:1">
                        <button type="button" onclick="genPw()" style="background: var(--rose-blush); border: 1px solid var(--border-rose); border-radius: 10px; padding: 0 15px; color: var(--rose); cursor: pointer;">
                            <i data-lucide="refresh-cw" style="width:16px; height:16px;"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn-primary" style="width: 100%; margin-top: 10px;">Cipta Akaun</button>
            </form>
        </div>
    </div>
</div>
@endif

{{-- ══ TAB: LAPORAN ══ --}}
@if($activeTab == 'report')
@php
    $months = [];
    for($i = 11; $i >= 0; $i--){
        $m = \Carbon\Carbon::now()->subMonths($i);
        $count = \App\Models\User::whereMonth('created_at', $m->month)
                    ->whereYear('created_at', $m->year)
                    ->where('vendor_id', auth()->id())
                    ->count();
        $months[] = ['label' => $m->format('M'), 'count' => $count];
    }
    $expiringSoon = \App\Models\Invitation::where('expires_at', '>', now())
        ->where('expires_at', '<=', now()->addDays(30))
        ->whereHas('user', fn($q) => $q->where('vendor_id', auth()->id()))
        ->with('user')
        ->orderBy('expires_at')
        ->get();
@endphp

<div class="vdr-report-grid">
    <div>
        <div class="section-card">
            <div class="section-head">
                <h3><i data-lucide="line-chart" style="width:16px; height:16px; vertical-align:middle; margin-right:8px; color:var(--rose);"></i> Prestasi Pendaftaran</h3>
            </div>
            <div class="section-body">
                <canvas id="lineChart" height="250"></canvas>
            </div>
        </div>
    </div>
    <div>
        @if($expiringSoon->count() > 0)
        <div class="section-card">
            <div class="section-head">
                <h3 style="color: var(--red)"><i data-lucide="clock" style="width:16px; height:16px; vertical-align:middle; margin-right:8px;"></i> Akan Tamat (30 Hari)</h3>
            </div>
            <div style="padding: 16px;">
                @foreach($expiringSoon as $inv)
                <div style="padding: 12px; border-radius: 12px; background: rgba(192,80,96,0.04); margin-bottom: 10px; border: 1px solid var(--border);">
                    <div style="font-weight: 600; font-size: 13px; color: var(--text-dark);">{{ $inv->user->name }}</div>
                    <div style="font-size: 11px; color: var(--red); display: flex; align-items: center; gap: 4px; margin-top: 4px;">
                        <i data-lucide="calendar-x" style="width:12px; height:12px;"></i> Tamat: {{ $inv->expires_at->format('d M Y') }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <div class="section-card">
            <div class="section-head"><h3><i data-lucide="pie-chart" style="width:16px; height:16px; vertical-align:middle; margin-right:8px; color:var(--rose);"></i> Status Keseluruhan</h3></div>
            <div style="padding:28px 20px; display:flex; flex-direction:column; align-items:center; gap:20px">
                <canvas id="donutChart" width="180" height="180"></canvas>
                <div style="width: 100%;">
                    <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid var(--border);">
                        <span><span style="display:inline-block; width: 8px; height: 8px; background: #4A8C6A; border-radius: 50%; margin-right: 8px;"></span> Aktif</span>
                        <span style="font-weight: 700; color: var(--green);">{{ $stats['aktif'] }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid var(--border);">
                        <span><span style="display:inline-block; width: 8px; height: 8px; background: #C05060; border-radius: 50%; margin-right: 8px;"></span> Tamat</span>
                        <span style="font-weight: 700; color: var(--red);">{{ $stats['tamat'] }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 12px;">
                        <span><span style="display:inline-block; width: 8px; height: 8px; background: var(--rose); border-radius: 50%; margin-right: 8px;"></span> Pending</span>
                        <span style="font-weight: 700; color: var(--rose);">{{ $stats['pending'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
(function() {
    const rose = '#C9788A';
    // Line Chart
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: @json(array_column($months, 'label')),
            datasets: [{
                label: 'Akaun Baru',
                data: @json(array_column($months, 'count')),
                borderColor: rose,
                backgroundColor: 'rgba(201, 120, 138, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });
    // Donut Chart
    new Chart(document.getElementById('donutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Aktif', 'Tamat', 'Pending'],
            datasets: [{
                data: [{{ $stats['aktif'] }}, {{ $stats['tamat'] }}, {{ $stats['pending'] }}],
                backgroundColor: ['#4A8C6A', '#C05060', rose],
                borderWidth: 0
            }]
        },
        options: { cutout: '70%', plugins: { legend: { display: false } } }
    });
})();
</script>
@endif

{{-- Reset Password Modal --}}
<div id="resetModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);backdrop-filter:blur(4px);z-index:1000;align-items:center;justify-content:center;padding:16px">
    <div class="section-card" style="background:#fff; width:100%; max-width:380px; padding:28px;">
        <h3 style="font-family:'Cormorant Garamond',serif;font-size:20px;margin-bottom:6px;color:var(--rose)">Reset Kata Laluan</h3>
        <p id="resetModalName" style="color:var(--text-soft);font-size:12px;margin-bottom:16px"></p>
        <form method="POST" id="resetForm" action="">
            @csrf
            <div class="form-group">
                <label>Kata Laluan Baru</label>
                <div style="display:flex;gap:8px">
                    <input class="input" name="password" type="text" id="resetPwInput" required style="flex:1">
                    <button type="button" onclick="genResetPw()" style="background:var(--rose-blush);border:1px solid var(--border-rose);border-radius:10px;padding:0 14px;color:var(--rose);cursor:pointer;">
                        <i data-lucide="refresh-cw" style="width:16px; height:16px;"></i>
                    </button>
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:20px">
                <button type="button" onclick="closeResetModal()" style="flex:1;background:none;border:1px solid var(--border);border-radius:50px;padding:10px;color:var(--text-soft);cursor:pointer;font-family:'Nunito',sans-serif">Batal</button>
                <button type="submit" class="btn-primary" style="flex:1">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function genPw() {
    const c = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
    const pw = Array.from({length: 8}, () => c[Math.floor(Math.random() * c.length)]).join('');
    document.getElementById('pwInput').value = pw;
}
function genResetPw() {
    const c = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
    const pw = Array.from({length: 8}, () => c[Math.floor(Math.random() * c.length)]).join('');
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
        el.style.display = text.includes(q) ? '' : 'none';
    });
}
function setFilter(status, btn) {
    document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.pelanggan-item').forEach(el => {
        if(status == 'semua' || el.dataset.status == status) el.style.display = '';
        else el.style.display = 'none';
    });
}
function openResetModal(id, name, email) {
    document.getElementById('resetModal').style.display='flex';
    document.getElementById('resetModalName').innerText = name + ' (' + email + ')';
    document.getElementById('resetForm').action = '/vendor/user/' + id + '/reset-password';
    genResetPw();
}
function closeResetModal() {
    document.getElementById('resetModal').style.display='none';
}
if(document.getElementById('slugInput')) {
    document.getElementById('slugInput').addEventListener('input', e => {
        document.getElementById('slugPreview').textContent = 'satujiwa.my/' + (e.target.value.toLowerCase().replace(/[^a-z0-9\-]/g, '-') || '—');
    });
}
@if($activeTab == 'buat') genPw(); @endif
</script>

<style>
.filter-pill {
    padding:6px 16px; border-radius:20px; border:1px solid var(--border); background:#fff; font-size:11px; color:var(--text-soft); cursor:pointer; transition:all 0.2s;
}
.filter-pill:hover { border-color:var(--rose); color:var(--rose); }
.filter-pill.active { background:var(--rose); color:#fff; border-color:var(--rose); box-shadow:0 3px 10px rgba(201,120,138,0.25); }

.pagination { display:flex; gap:5px; align-items:center; list-style:none; }
.pagination li a, .pagination li span { padding:6px 12px; border-radius:8px; border:1px solid var(--border); font-size:12px; color:var(--rose); text-decoration:none; transition:all 0.2s; background:#fff; }
.pagination li.active span { background:var(--rose); color:#fff; border-color:var(--rose); }
.pagination li.disabled span { color:var(--text-soft); opacity:0.5; }

.tab i, .input i, .search-input-wrap i { margin-bottom: -2px; margin-right: 4px; vertical-align: middle; }
</style>

@endsection