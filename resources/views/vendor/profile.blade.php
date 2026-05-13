@extends('layouts.vendor')
@section('title', 'Profil Vendor')
@section('content')

<div style="max-width: 700px; margin: 0 auto;">
    <div style="margin-bottom: 24px;">
        <h2 style="font-family:'Cormorant Garamond',serif; font-size: 28px; color: var(--rose);">Profil Saya</h2>
        <p style="font-size: 13px; color: var(--text-soft);">Kemaskini maklumat peribadi dan kata laluan anda.</p>
    </div>

    {{-- KEMASKINI PROFIL --}}
    <div class="section-card">
        <div class="section-head">
            <h3><i data-lucide="user" style="width:16px; height:16px; vertical-align:middle; margin-right:8px; color:var(--rose);"></i> Maklumat Peribadi</h3>
        </div>
        <div class="section-body">
            <form method="POST" action="{{ route('vendor.profile.update') }}">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label>Nama Penuh/Syarikat</label>
                        <input class="input" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat Emel</label>
                        <input class="input" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>No. Telefon</label>
                    <input class="input" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="cth: 60123456789">
                </div>
                <div class="form-group">
                    <label>Alamat Syarikat</label>
                    <textarea class="input" name="address" rows="3" style="min-height: 80px;" placeholder="Masukkan alamat lengkap syarikat anda...">{{ old('address', $user->address) }}</textarea>
                </div>
                <button type="submit" class="btn-primary" style="margin-top: 10px; display: inline-flex; align-items: center; gap: 8px;">
                    <i data-lucide="save" style="width:16px; height:16px;"></i> Simpan Profil
                </button>
            </form>
        </div>
    </div>

    {{-- TUKAR KATA LALUAN --}}
    <div class="section-card" style="margin-top: 30px;">
        <div class="section-head">
            <h3><i data-lucide="shield-check" style="width:16px; height:16px; vertical-align:middle; margin-right:8px; color:var(--rose);"></i> Pusat Keselamatan</h3>
        </div>
        <div class="section-body">
            <form method="POST" action="{{ route('vendor.password.update') }}">
                @csrf
                <div class="form-group">
                    <label>Kata Laluan Semasa</label>
                    <input class="input" name="current_password" type="password" required>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label>Kata Laluan Baru</label>
                        <input class="input" name="password" type="password" required>
                    </div>
                    <div class="form-group">
                        <label>Sahkan Kata Laluan</label>
                        <input class="input" name="password_confirmation" type="password" required>
                    </div>
                </div>
                @if($errors->updatePassword->any())
                <div style="background: rgba(192,80,96,0.05); border: 1px solid rgba(192,80,96,0.2); border-radius: 10px; padding: 12px; margin-bottom: 15px; margin-top: 10px;">
                    @foreach($errors->updatePassword->all() as $error)
                        <div style="color: var(--red); font-size: 11px;">• {{ $error }}</div>
                    @endforeach
                </div>
                @endif
                <button type="submit" class="btn-primary" style="margin-top: 10px; background: linear-gradient(135deg, #4A3040 0%, #2A1020 100%); display: inline-flex; align-items: center; gap: 8px;">
                    <i data-lucide="key-round" style="width:16px; height:16px;"></i> Kemaskini Kata Laluan
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
