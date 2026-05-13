@extends('layouts.admin')
@section('title', 'Urus Vendor')
@section('content')

{{-- PAGE HEADER --}}
<div class="adm-page-header">
    <div>
        <h2>Pengurusan Vendor</h2>
        <p>SatuJiwa · Daftar dan pantau prestasi vendor rangkaian anda</p>
    </div>
</div>

{{-- Tabs removed --}}


<div style="display:grid; grid-template-columns: 1fr 350px; gap: 20px; align-items: start;">
    {{-- Senarai Vendor --}}
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
                        <div style="font-size:10px; color:var(--muted); margin-top:4px">Daftar pada: {{ $vendor->created_at->format('d M Y') }}</div>
                    </div>
                    <div style="text-align:right">
                        <div style="font-size:24px; font-family:'Cormorant Garamond', serif; font-weight:700; color:var(--pink); line-height:1;">{{ $vendor->customers_count }}</div>
                        <div style="font-size:9px; color:var(--muted); text-transform:uppercase; letter-spacing:1px; margin-top:4px;">Pelanggan</div>
                        <div style="font-size:10px; color:var(--green); margin-top:6px; background:rgba(74,140,106,0.08); padding:2px 8px; border-radius:50px; display:inline-block;">Aktif: {{ $vendor->active_customers }}</div>
                    </div>
                </div>
                <div style="display:flex; gap:8px; border-top:1px dashed var(--border); padding-top:12px; margin-top:12px">
                    <a href="{{ route('admin.loginAsVendor', $vendor) }}" class="btn-sm" style="color:var(--pink); border-color:var(--pink);">
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

    {{-- Daftar Vendor Baru --}}
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
                        <input class="input" name="password" id="pwInput" type="text" required style="flex:1">
                        <button type="button" onclick="genPw()" style="background:rgba(232,103,138,0.1); border:1px solid var(--border); border-radius:10px; padding:0 14px; color:var(--pink); cursor:pointer; font-size:16px; flex-shrink:0">🔄</button>
                    </div>
                </div>
                <button type="submit" class="btn-primary" style="width:100%; margin-top:10px">✨ Daftar Vendor</button>
            </form>
        </div>
    </div>
</div>

<script>
function genPw() {
    const c = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
    const pw = Array.from({length: 8}, () => c[Math.floor(Math.random() * c.length)]).join('');
    document.getElementById('pwInput').value = pw;
}
genPw();
</script>

@endsection
