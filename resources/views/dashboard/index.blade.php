@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')

@php $tab = request('tab', 'info'); @endphp

@if(!$invitation)
    <div class="info-banner">⚠ Akaun anda belum disediakan oleh admin. Sila hubungi admin.</div>
@else

<div class="info-banner">
    <strong id="inviteLink" style="color:var(--gold)">
        satujiwa.my/{{ $invitation->slug }}
          <span class="copy-btn" onclick="copyLink()" title="Copy Link">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                    <rect x="7" y="7" width="10" height="13" rx="2" ry="2"></rect>
                    <rect x="2" y="2" width="10" height="13" rx="2" ry="2"></rect>
                </svg>
                Copy
            </span>
    </strong>
    &nbsp;|&nbsp; Tamat: <strong>{{ $invitation->expires_at?->format('d M Y') ?? '—' }}</strong>
</div>

<form method="POST" action="{{ route('dashboard.update') }}" enctype="multipart/form-data" id="mainForm">
    @csrf @method('PUT')

    {{-- ALWAYS-PRESENT TOGGLE STATES (fixes cross-tab toggle reset bug) --}}
    @if($tab != 'media')
        <input type="hidden" name="gallery_aktif" value="{{ $invitation->gallery_aktif ? '1' : '0' }}">
    @endif
    @if($tab != 'hadiah')
        <input type="hidden" name="hadiah_aktif" value="{{ $invitation->hadiah_aktif ? '1' : '0' }}">
    @endif
    @if($tab != 'pranikah')
        <input type="hidden" name="pranikah_aktif" value="{{ $invitation->pranikah_aktif ? '1' : '0' }}">
    @endif
    @if($tab != 'aturcara')
        <input type="hidden" name="aturcara_aktif" value="{{ $invitation->aturcara_aktif ? '1' : '0' }}">
    @endif
    @if($tab != 'reka')
        <input type="hidden" name="animation_aktif" value="{{ $invitation->animation_aktif ? '1' : '0' }}">
    @endif

    {{-- TAB: INFO MAJLIS --}}
    @if($tab == 'info')
    <div class="section-card">
        <div class="section-head"><h3>Maklumat Majlis</h3></div>
        <div class="section-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Majlis</label>
                    <input class="input" name="nama_majlis" value="{{ $invitation->nama_majlis }}" placeholder="Walimatul Urus">
                </div>
                <div class="form-group">
                    <label>Jenis Majlis</label>
                    <select class="select" name="jenis_majlis">
                        @foreach(['Perkahwinan','Akikah','Pertunangan','Kenduri','Lain-lain'] as $j)
                            <option {{ $invitation->jenis_majlis == $j ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Bilangan Nama Pengantin</label>
                <div style="display:flex;gap:10px">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;text-transform:none;letter-spacing:0;font-size:13px;color:var(--text-dark)">
                        <input type="radio" name="bilangan_pengantin" value="1" {{ $invitation->bilangan_pengantin == 1 ? 'checked' : '' }} onchange="togglePengantin(1)"> 1 Nama (cth: Akikah)
                    </label>
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;text-transform:none;letter-spacing:0;font-size:13px;color:var(--text-dark)">
                        <input type="radio" name="bilangan_pengantin" value="2" {{ $invitation->bilangan_pengantin != 1 ? 'checked' : '' }} onchange="togglePengantin(2)"> 2 Nama (cth: Perkahwinan)
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label id="labelPengantin1">Nama Pengantin 1 (penuh)</label>
                    <input class="input" name="nama_pengantin_lelaki" value="{{ $invitation->nama_pengantin_lelaki }}" placeholder="Muhammad Akif bin Ahmad">
                </div>
                <div class="form-group" id="pengantin2Field" style="{{ $invitation->bilangan_pengantin == 1 ? 'display:none' : '' }}">
                    <label>Nama Pengantin 2 (penuh)</label>
                    <input class="input" name="nama_pengantin_perempuan" value="{{ $invitation->nama_pengantin_perempuan }}" placeholder="Nur Aliya binti Razali">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label id="labelRingkas1">Nama Ringkas Pengantin 1</label>
                    <input class="input" name="nama_ringkas_lelaki" value="{{ $invitation->nama_ringkas_lelaki }}" placeholder="Akif">
                </div>
                <div class="form-group" id="ringkas2Field" style="{{ $invitation->bilangan_pengantin == 1 ? 'display:none' : '' }}">
                    <label>Nama Ringkas Pengantin 2</label>
                    <input class="input" name="nama_ringkas_perempuan" value="{{ $invitation->nama_ringkas_perempuan }}" placeholder="Aliya">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tarikh Majlis</label>
                    <input class="input" type="date" name="tarikh_majlis" value="{{ $invitation->tarikh_majlis?->format('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label>Masa Mula</label>
                    <input class="input" type="time" name="masa_majlis" value="{{ $invitation->masa_majlis }}">
                </div>
                <div class="form-group">
                    <label>Masa Tamat <span style="font-size:11px;color:var(--muted)">(pilihan)</span></label>
                    <input class="input" type="time" name="masa_tamat" value="{{ $invitation->masa_tamat }}">
                </div>
            </div>
            <div class="form-group">
                <label>Alamat Majlis</label>
                <textarea class="textarea" name="alamat_majlis">{{ $invitation->alamat_majlis }}</textarea>
            </div>

            <div class="separator"></div>
            <div style="margin-bottom:10px;font-size:12px;color:var(--muted)">Nombor untuk dihubungi (max 3)</div>
            @foreach([1,2,3] as $n)
            <div class="form-row" style="margin-bottom:10px">
                <div class="form-group" style="margin-bottom:0">
                    <label>Nama Kenalan {{ $n }}</label>
                    <input class="input" name="nama_hubungi_{{ $n }}"
                        value="{{ $invitation->{'nama_hubungi_'.$n} }}"
                        placeholder="{{ $n == 1 ? 'cth: Bapa Pengantin' : ($n == 2 ? 'cth: Ibu Pengantin' : 'cth: Pengapit') }}">
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label>No. {{ $n == 1 ? '(WhatsApp & Call)' : 'Telefon' }}</label>
                    <input class="input" name="{{ $n == 1 ? 'no_whatsapp' : 'no_hubungi_'.$n }}"
                        value="{{ $n == 1 ? $invitation->no_whatsapp : $invitation->{'no_hubungi_'.$n} }}"
                        placeholder="01xxxxxxxx">
                </div>
            </div>
            @endforeach

            <div class="form-group">
                <label>Tagline / Doa / Kata-kata Aluan</label>
                <textarea class="textarea" name="tagline" placeholder="cth: Dengan penuh kesyukuran... atau Doa buat pengantin..." style="min-height:100px">{{ $invitation->tagline }}</textarea>
                <div style="font-size:11px;color:var(--muted);margin-top:5px">💡 Boleh masukkan doa atau kata-kata aluan. Sokong baris baharu.</div>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-head"><h3>Maklumat Ibu Bapa</h3></div>
        <div class="section-body">
            <div class="form-group">
                <label>Bilangan Pihak</label>
                <div style="display:flex;gap:10px">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;text-transform:none;letter-spacing:0;font-size:13px;color:var(--text-dark)">
                        <input type="radio" name="bilangan_pihak" value="1" {{ $invitation->bilangan_pihak == 1 ? 'checked' : '' }} onchange="togglePihak(1)"> 1 Pihak
                    </label>
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;text-transform:none;letter-spacing:0;font-size:13px;color:var(--text-dark)">
                        <input type="radio" name="bilangan_pihak" value="2" {{ $invitation->bilangan_pihak != 1 ? 'checked' : '' }} onchange="togglePihak(2)"> 2 Pihak
                    </label>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Bapa (Pihak 1)</label>
                    <input class="input" name="nama_bapa_lelaki" value="{{ $invitation->nama_bapa_lelaki }}">
                </div>
                <div class="form-group">
                    <label>Nama Ibu (Pihak 1)</label>
                    <input class="input" name="nama_ibu_lelaki" value="{{ $invitation->nama_ibu_lelaki }}">
                </div>
            </div>
            <div id="pihak2Fields" style="{{ $invitation->bilangan_pihak == 1 ? 'display:none' : '' }}">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Bapa (Pihak 2)</label>
                        <input class="input" name="nama_bapa_perempuan" value="{{ $invitation->nama_bapa_perempuan }}">
                    </div>
                    <div class="form-group">
                        <label>Nama Ibu (Pihak 2)</label>
                        <input class="input" name="nama_ibu_perempuan" value="{{ $invitation->nama_ibu_perempuan }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- TAB: REKA BENTUK --}}
    @if($tab == 'reka')
    <div class="section-card">
        <div class="section-head"><h3>Pilih Template Header</h3></div>
        <div class="section-body">
            @php
                $categories = [
                    'all' => 'Semua',
                    'floral' => 'Floral',
                    'minimalist' => 'Minimalist',
                    'classic' => 'Classic',
                    'modern' => 'Modern',
                    'elegant' => 'Elegant',
                    'Arts' => 'Arts',
                    'islamic' => 'Islamic'
                ];
                $activeCat = request('category', 'all');
            @endphp
            <div style="display:flex; gap:8px; margin-bottom:16px; flex-wrap:wrap;">
                @foreach($categories as $id => $label)
                <a href="?tab=reka&category={{ $id == 'all' ? '' : $id }}" 
                   style="padding:6px 14px; border-radius:50px; font-size:11px; text-decoration:none; border:1px solid {{ $activeCat == $id ? 'var(--gold)' : 'var(--border)' }}; background:{{ $activeCat == $id ? 'var(--gold)' : 'transparent' }}; color:{{ $activeCat == $id ? '#fff' : 'var(--text-soft)' }}; transition:all 0.2s;">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            @if($templates->count() == 0)
                <div class="info-banner">Tiada template tersedia. Sila hubungi admin.</div>
            @else
            @php $perPage = 8; $page = request('tpage', 1); $total = $templates->count(); $totalPages = ceil($total/$perPage); $start = ($page-1)*$perPage; $currentTemplates = $templates->slice($start, $perPage); @endphp
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:14px">
                @foreach($currentTemplates as $t)
                <div onclick="selectTemplate('{{ Storage::url($t->image_path) }}', this)"
                    style="border-radius:10px;overflow:hidden;border:2px solid {{ $invitation->header_image == $t->image_path ? 'var(--gold)' : 'var(--border)' }};cursor:pointer;transition:all .2s;position:relative"
                    class="template-opt {{ $invitation->header_image == $t->image_path ? 'selected' : '' }}">
                    <img src="{{ Storage::url($t->image_path) }}" style="width:100%;aspect-ratio:9/16;object-fit:cover">
                    @if($invitation->header_image == $t->image_path)
                    <div style="position:absolute;top:6px;right:6px;background:var(--gold);border-radius:50%;width:22px;height:22px;display:flex;align-items:center;justify-content:center;font-size:12px;color:#fff">✓</div>
                    @endif
                </div>
                @endforeach
            </div>
            @if($totalPages > 1)
            <div style="display:flex;align-items:center;justify-content:center;gap:10px">
                @if($page > 1)
                <a href="?tab=reka&category={{ request('category') }}&tpage={{ $page-1 }}" style="background:rgba(201,169,110,0.1);border:1px solid var(--border);border-radius:8px;padding:7px 16px;color:var(--gold);text-decoration:none;font-size:13px">← Sebelum</a>
                @endif
                <span style="font-size:12px;color:var(--muted)">{{ $page }} / {{ $totalPages }}</span>
                @if($page < $totalPages)
                <a href="?tab=reka&category={{ request('category') }}&tpage={{ $page+1 }}" style="background:rgba(201,169,110,0.1);border:1px solid var(--border);border-radius:8px;padding:7px 16px;color:var(--gold);text-decoration:none;font-size:13px">Seterusnya →</a>
                @endif
            </div>
            @endif
            @endif
            <input type="hidden" name="header_image" id="headerImageInput" value="{{ $invitation->header_image }}">
        </div>
    </div>

    <div class="section-card">
        <div class="section-head">
            <h3>Animasi Background</h3>
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="display:flex; flex-direction:column; align-items:flex-end">
                    <select class="select" name="animation_type" style="padding:1px 6px; height:24px; font-size:11px; margin-top:2px; width:auto">
                        <option value="bunga" {{ $invitation->animation_type == 'bunga' ? 'selected' : '' }}>Bunga Gugur</option>
                        <option value="bintang" {{ $invitation->animation_type == 'bintang' ? 'selected' : '' }}>Bintang Sparkling</option>
                        <option value="daun" {{ $invitation->animation_type == 'daun' ? 'selected' : '' }}>Daun Hijau</option>
                        <option value="hati" {{ $invitation->animation_type == 'hati' ? 'selected' : '' }}>Hati Kecil</option>
                    </select>
                </div>
                <label class="switch">
                    <input type="checkbox" name="animation_aktif" value="1" {{ $invitation->animation_aktif ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>
    
    <div class="section-card">
        <div class="section-head">
            <h3>Tema Warna</h3>
        </div>
        <div class="section-body">
            <div class="theme-grid">
                @php
                $themes = [
                    ['id'=>'emas-klasik','label'=>'Emas Klasik','bg'=>'linear-gradient(135deg,#1A1208,#C9A96E)'],
                    ['id'=>'hijau-sage','label'=>'Hijau Sage','bg'=>'linear-gradient(135deg,#0D1F1A,#B8D4C4)'],
                    ['id'=>'ros-lembut','label'=>'Ros Lembut','bg'=>'linear-gradient(135deg,#1A0D14,#E8B4C8)'],
                    ['id'=>'biru-sendu','label'=>'Biru Sendu','bg'=>'linear-gradient(135deg,#0D1525,#A4C3E8)'],
                    ['id'=>'krim-coklat','label'=>'Krim & Coklat','bg'=>'linear-gradient(135deg,#F5EDD8,#8B6914)'],
                    ['id'=>'hitam-putih','label'=>'Hitam Putih','bg'=>'linear-gradient(135deg,#1A1A1A,#E8E8E8)'],
                    ['id'=>'tembaga','label'=>'Tembaga','bg'=>'linear-gradient(135deg,#2C1A0A,#D4956A)'],
                    ['id'=>'putih-mutiara','label'=>'Putih Mutiara','bg'=>'linear-gradient(135deg,#FFFFFF,#E8E8E8)'],
                    ['id'=>'kuning-pastel','label'=>'Kuning Pastel','bg'=>'linear-gradient(135deg,#FFF9E3,#FDF4CD)'],
                    ['id'=>'biru-awan','label'=>'Biru Awan','bg'=>'linear-gradient(135deg,#F0F7FF,#D1E5FF)'],
                    ['id'=>'pink-rose-gold','label'=>'Pink Rose Gold','bg'=>'linear-gradient(135deg,#FFF0F5,#FADADD)'],
                    ['id'=>'hijau-mint','label'=>'Hijau Mint','bg'=>'linear-gradient(135deg,#F5FFFA,#E0FFF0)'],
                    ['id'=>'ungu-lilac','label'=>'Ungu Lilac','bg'=>'linear-gradient(135deg,#F8F4FF,#E6E0FF)'],
                    ['id'=>'coklat-latte','label'=>'Coklat Latte','bg'=>'linear-gradient(135deg,#FAF5EF,#F0E6D6)'],
                    ['id'=>'custom','label'=>'Custom','bg'=>'conic-gradient(from 0deg,#f00,#ff0,#0f0,#0ff,#00f,#f0f,#f00)'],
                ];
                @endphp
                @foreach($themes as $t)
                <div class="theme-opt {{ $invitation->tema_warna == $t['id'] ? 'selected' : '' }}" onclick="selectTheme('{{ $t['id'] }}')">
                    <div class="theme-swatch" style="background:{{ $t['bg'] }}"></div>
                    {{ $t['label'] }}
                </div>
                @endforeach
            </div>
            <input type="hidden" name="tema_warna" id="temaInput" value="{{ $invitation->tema_warna }}">
            <div id="customColors" style="{{ $invitation->tema_warna == 'custom' ? '' : 'display:none' }}">
                <div class="separator"></div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Warna Latar</label>
                        <input class="input" type="color" name="warna_bg" value="{{ $invitation->warna_bg }}" style="height:44px;padding:4px">
                    </div>
                    <div class="form-group">
                        <label>Warna Aksen</label>
                        <input class="input" type="color" name="warna_aksen" value="{{ $invitation->warna_aksen }}" style="height:44px;padding:4px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-head"><h3>Fon</h3></div>
        <div class="section-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Fon Tajuk</label>
                    <select class="select" name="fon_tajuk" onchange="previewFonts(this.value, null)">
                        @foreach(['Allura', 'Cormorant Garamond','Playfair Display','Imperial Script','Suranna','Great Vibes','Cinzel','Italiana','Libre Baskerville'] as $f)
                            <option {{ $invitation->fon_tajuk == $f ? 'selected' : '' }}>{{ $f }}</option>
                        @endforeach
                    </select>
                    <div style="margin-top:10px;padding:12px;background:rgba(255,255,255,0.04);border-radius:8px;border:1px solid var(--border)">
                        <span id="fontTitleSample" style="font-size:24px;color:var(--gold)">
                            {{ $invitation->nama_ringkas_lelaki ?? 'Nama' }}{{ $invitation->bilangan_pengantin == 2 ? ' & '.($invitation->nama_ringkas_perempuan ?? '') : '' }}
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Fon Badan</label>
                    <select class="select" name="fon_badan" onchange="previewFonts(null, this.value)">
                        @foreach(['DM Sans','Lato','Raleway','Nunito','Poppins','Open Sans'] as $f)
                            <option {{ $invitation->fon_badan == $f ? 'selected' : '' }}>{{ $f }}</option>
                        @endforeach
                    </select>
                    <div style="margin-top:10px;padding:12px;background:rgba(255,255,255,0.04);border-radius:8px;border:1px solid var(--border)">
                        <span id="fontBodySample" style="font-size:13px;color:var(--text-dark)">Dengan penuh rasa syukur, kami menjemput kehadiran anda ke majlis perkahwinan kami.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- TAB: JEMPUTAN --}}
    @if($tab == 'jemputan')
    <div class="section-card">
        <div class="section-head"><h3>Teks Jemputan</h3></div>
        <div class="section-body">
            <div class="form-group">
                <label>Ayat Jemputan</label>
                <textarea class="textarea" name="ayat_jemputan" style="min-height:100px">{{ $invitation->ayat_jemputan ?? 'Dengan penuh rasa syukur ke hadrat Allah S.W.T., kami sekeluarga menjemput Dato\'/Datin/Tuan/Puan/Encik/Cik ke majlis perkahwinan anakanda kami yang tersayang.' }}</textarea>
            </div>
            <div class="form-group">
                <label>Ayat Penutup</label>
                <textarea class="textarea" name="ayat_penutup">{{ $invitation->ayat_penutup ?? 'Kehadiran tuan/puan amat kami harapkan sebagai meraikan kebahagiaan anak kami.' }}</textarea>
            </div>
        </div>
    </div>
    @endif

    {{-- TAB: MEDIA --}}
    @if($tab == 'media')
    <div class="section-card">
        <div class="section-head">
            <h3>Galeri Gambar</h3>
            <div style="display:flex; align-items:center; gap:15px;">
                <span style="font-size:12px; color:var(--muted)" id="galleryCount">{{ $invitation->galleryImages->count() }} gambar</span>
                <label class="switch">
                    <input type="checkbox" name="gallery_aktif" value="1" {{ $invitation->gallery_aktif ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        <div class="section-body">
            <div class="upload-zone" id="galleryUploadZone" onclick="document.getElementById('galleryInput').click()">
                <input type="file" id="galleryInput" accept="image/*" multiple style="display:none" onchange="uploadGallery(this, 'gallery')">
                <div style="font-size:24px" id="galleryUploadIcon">📸</div>
                <div class="upload-text" id="galleryUploadText">Klik untuk muat naik gambar galeri</div>
                <div class="upload-hint">Boleh pilih berbilang • Max 5 gambar • Max 15MB/fail</div>
            </div>
            <div id="galleryProgress" style="display:none;margin-top:10px">
                <div style="background:var(--border);border-radius:4px;height:4px;overflow:hidden">
                    <div id="galleryProgressBar" style="background:var(--gold);height:100%;width:0%;transition:width .3s"></div>
                </div>
                <div style="font-size:12px;color:var(--muted);margin-top:6px;text-align:center" id="galleryProgressText">Sedang muat naik...</div>
            </div>
            <div class="images-grid" id="galleryGrid" style="margin-top:14px">
                @foreach($invitation->galleryImages as $img)
                <div class="img-thumb" id="img-{{ $img->id }}">
                    <img src="{{ Storage::url($img->image_path) }}">
                    <button class="img-remove" type="button" data-id="{{ $img->id }}" data-elem="img-{{ $img->id }}" onclick="deleteImage(this)">✕</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- TAB: MUZIK --}}
    @if($tab == 'muzik')
    <div class="section-card">
        <div class="section-head"><h3>Muzik Latar</h3></div>
        <div class="section-body">
            <div class="info-banner">🎵 Muzik akan dimainkan apabila tetamu klik "Buka Undangan". Hanya audio sahaja.</div>
            <div class="form-group">
                <label>Link YouTube</label>
                <input class="input" name="muzik_youtube_url" value="{{ $invitation->muzik_youtube_url }}" placeholder="https://www.youtube.com/watch?v=...">
            </div>
            <div class="form-group">
                <label>Kelantangan</label>
                <div style="display:flex;align-items:center;gap:12px">
                    <span style="font-size:13px">🔇</span>
                    <input type="range" name="muzik_volume" min="0" max="100" value="{{ $invitation->muzik_volume }}" oninput="this.nextElementSibling.textContent=this.value+'%'">
                    <span style="font-size:13px">🔊</span>
                    <span style="font-size:12px;color:var(--text-dark);width:36px">{{ $invitation->muzik_volume }}%</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- TAB: HADIAH --}}
    @if($tab == 'hadiah')
    <div class="section-card">
        <div class="section-head">
            <h3>Hadiah Wang Digital</h3>
            <label class="switch">
                <input type="checkbox" name="hadiah_aktif" value="1" {{ $invitation->hadiah_aktif ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
        </div>
        <div class="section-body">
            <div class="form-group">
                <label>Nama Akaun</label>
                <input class="input" name="bank_nama_akaun" value="{{ $invitation->bank_nama_akaun }}">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Bank</label>
                    <select class="select" name="bank_nama">
                        @foreach(['Maybank','CIMB','Public Bank','RHB','BSN','Bank Islam','AmBank','Hong Leong'] as $b)
                            <option {{ $invitation->bank_nama == $b ? 'selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Nombor Akaun</label>
                    <input class="input" name="bank_no_akaun" value="{{ $invitation->bank_no_akaun }}">
                </div>
            </div>
            <div class="form-group">
                <label>QR DuitNow</label>
                <div id="qrCurrentWrap" style="{{ $invitation->qr_image ? '' : 'display:none' }}">
                    <div style="position:relative;display:inline-block;margin-bottom:10px">
                        <img id="qrCurrentImg" src="{{ $invitation->qr_image ? Storage::url($invitation->qr_image) : '' }}" style="width:160px;border-radius:8px;display:block;border:1px solid var(--border)">
                        <div style="margin-top:6px;font-size:11px;color:var(--muted);text-align:center">Gambar semasa</div>
                        <button type="button" onclick="deleteQR(this)"
                            id="deleteQRBtn"
                            style="margin-top:8px;width:160px;padding:7px;background:rgba(192,80,96,0.1);border:1px solid rgba(192,80,96,0.3);color:#C05060;border-radius:8px;font-size:12px;cursor:pointer;font-family:'Nunito',sans-serif;transition:all .2s"
                            onmouseover="this.style.background='rgba(192,80,96,0.2)'"
                            onmouseout="this.style.background='rgba(192,80,96,0.1)'">
                            🗑 Padam QR
                        </button>
                    </div>
                </div>
                <div id="qrPreviewWrap" style="display:none;margin-bottom:10px">
                    <div style="position:relative;display:inline-block">
                        <img id="qrPreviewImg" style="width:160px;border-radius:8px;display:block;border:2px solid var(--gold)">
                        <div style="position:absolute;top:-8px;right:-8px;background:var(--gold);color:#fff;border-radius:50%;width:20px;height:20px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:bold">✓</div>
                    </div>
                    <div style="margin-top:6px;font-size:11px;color:var(--gold);font-weight:500">✓ Gambar baru dipilih — klik Simpan untuk muat naik</div>
                </div>
                <div class="upload-zone" onclick="document.getElementById('qrFileInput').click()" style="cursor:pointer">
                    <input type="file" id="qrFileInput" name="qr_image" accept="image/*" style="display:none" onchange="previewQR(this)">
                    <div style="font-size:24px" id="qrUploadIcon">💳</div>
                    <div class="upload-text" id="qrUploadText">{{ $invitation->qr_image ? 'Klik untuk tukar QR DuitNow' : 'Klik untuk muat naik QR DuitNow' }}</div>
                    <div class="upload-hint">PNG / JPG • Max 5MB</div>
                </div>
                <div id="qrSavingIndicator" style="display:none;margin-top:10px">
                    <div style="background:var(--border);border-radius:4px;height:4px;overflow:hidden">
                        <div id="qrSavingBar" style="background:var(--gold);height:100%;width:0%;transition:width 1.5s ease"></div>
                    </div>
                    <div style="font-size:12px;color:var(--muted);margin-top:6px;text-align:center">⏳ Sedang menyimpan QR...</div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- TAB: LOKASI --}}
    @if($tab == 'lokasi')
    <div class="section-card">
        <div class="section-head"><h3>Maklumat Lokasi</h3></div>
        <div class="section-body">
            <div class="form-group">
                <label>Alamat Penuh</label>
                <textarea class="textarea" name="alamat_majlis">{{ $invitation->alamat_majlis }}</textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Link Google Maps</label>
                    <input class="input" name="google_maps_url" value="{{ $invitation->google_maps_url }}" placeholder="https://maps.google.com/...">
                </div>
                <div class="form-group">
                    <label>Link Waze</label>
                    <input class="input" name="waze_url" value="{{ $invitation->waze_url }}" placeholder="https://waze.com/ul/...">
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- TAB: PRA-NIKAH --}}
    @if($tab == 'pranikah')
    <div class="section-card">
        <div class="section-head">
            <h3>Seksyen Pra-Nikah / Cerita</h3>
            <label class="switch">
                <input type="checkbox" name="pranikah_aktif" value="1" {{ $invitation->pranikah_aktif ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
        </div>
        <div class="section-body">
            <div class="form-group">
                <label>Tajuk Seksyen</label>
                <input class="input" name="pranikah_tajuk" value="{{ $invitation->pranikah_tajuk }}" placeholder="Kisah Kita">
            </div>
            <div class="form-group">
                <label>Cerita Ringkas</label>
                <textarea class="textarea" name="pranikah_cerita">{{ $invitation->pranikah_cerita }}</textarea>
            </div>
        </div>
    </div>
    <div class="section-card">
        <div class="section-head">
            <h3>Gambar Pra-Nikah</h3>
            <span style="font-size:12px;color:var(--muted)">{{ $invitation->pranikahImages->count() }} gambar</span>
        </div>
        <div class="section-body">
            <div class="upload-zone" onclick="document.getElementById('pranikahInput').click()">
                <input type="file" id="pranikahInput" accept="image/*" multiple style="display:none" onchange="uploadGallery(this, 'pranikah')">
                <div style="font-size:24px" id="pranikahUploadIcon">💑</div>
                <div class="upload-text" id="pranikahUploadText">Klik untuk muat naik gambar Pra-Nikah</div>
                <div class="upload-hint">Max 5 gambar • Akan dipapar sebagai slider • Max 15MB/fail</div>
            </div>
            <div id="pranikahProgress" style="display:none;margin-top:10px">
                <div style="background:var(--border);border-radius:4px;height:4px;overflow:hidden">
                    <div id="pranikahProgressBar" style="background:var(--gold);height:100%;width:0%;transition:width .3s"></div>
                </div>
                <div style="font-size:12px;color:var(--muted);margin-top:6px;text-align:center" id="pranikahProgressText">Sedang muat naik...</div>
            </div>
            <div class="images-grid" id="pranikahGrid" style="margin-top:14px">
                @foreach($invitation->pranikahImages as $img)
                <div class="img-thumb" id="img-{{ $img->id }}">
                    <img src="{{ Storage::url($img->image_path) }}">
                    <button class="img-remove" type="button" data-id="{{ $img->id }}" data-elem="img-{{ $img->id }}" onclick="deleteImage(this)">✕</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- TAB: TEMA PAKAIAN --}}
    @if($tab == 'pakaian')
    <div class="section-card">
        <div class="section-head">
            <h3>Tema Pakaian</h3>
        </div>
        <div class="section-body">
            <div class="info-banner">
                👗 Maklumat tema pakaian akan dipaparkan kepada tetamu dalam kad jemputan digital.
            </div>
            <div class="form-group">
                <label>Tema / Kod Warna Pakaian</label>
                <input class="input"
                       name="tema_pakaian"
                       value="{{ $invitation->tema_pakaian }}"
                       placeholder="cth: Biru Muda / Dusty Blue / Warna Pastel">
                <div style="font-size:11px;color:var(--muted);margin-top:7px;line-height:1.6">
                    💡 Tulis ikut kehendak anda — warna, tema, atau arahan pakaian kepada tetamu.
                    <br>Contoh: <em>"Biru Dusty & Putih"</em>, <em>"Warna Pastel Lembut"</em>, <em>"Formal — Baju Melayu / Baju Kurung"</em>
                </div>
            </div>
            <div class="separator"></div>
            <div style="font-size:11px;color:var(--muted);margin-bottom:10px;letter-spacing:1px;text-transform:uppercase">Pratonton dalam kad jemputan</div>
            <div style="background:rgba(10,8,4,0.85);border-radius:14px;padding:22px;text-align:center;border:1px solid rgba(201,169,110,0.2)">
                <div style="font-size:9px;letter-spacing:3px;text-transform:uppercase;color:rgba(201,169,110,0.7);margin-bottom:8px;font-family:'Nunito',sans-serif">Tetamu dijemput hadir dengan</div>
                <div id="pakaianPreview" style="font-family:'Cormorant Garamond',serif;font-size:22px;color:#E8D5B0;line-height:1.4;min-height:30px">
                    {{ $invitation->tema_pakaian ?? '—' }}
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- TAB: ATURCARA --}}
    @if($tab == 'aturcara')
    @php
        $raw = $invitation->aturcara;
        $aturcara = is_array($raw) ? $raw : (is_string($raw) && $raw ? json_decode($raw, true) ?? [] : []);
    @endphp
    <div class="section-card">
        <div class="section-head">
            <h3>Aturcara Majlis</h3>
            <div style="display:flex; align-items:center; gap:15px;">
                <span style="font-size:12px;color:var(--muted)" id="aturcaraCount">{{ count($aturcara) }} item</span>
                <label class="switch">
                    <input type="checkbox" name="aturcara_aktif" value="1" {{ $invitation->aturcara_aktif ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        <div class="section-body">
            <div class="info-banner">
                📋 Aturcara akan dipaparkan kepada tetamu mengikut susunan masa secara automatik.
            </div>

            <div id="aturcaraList">
                @forelse($aturcara as $i => $item)
                <div class="aturcara-row" id="aturcara-{{ $i }}" style="margin-bottom:10px">
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="color:var(--muted);cursor:grab;padding:0 4px;font-size:16px;flex-shrink:0">⠿</div>
                        <div style="flex-shrink:0;width:110px">
                            <input class="input aturcara-masa" type="time"
                                   value="{{ $item['masa'] }}"
                                   style="text-align:center;font-family:'Nunito',monospace">
                        </div>
                        <div style="flex:1">
                            <input class="input aturcara-tajuk"
                                   value="{{ $item['tajuk'] }}"
                                   placeholder="cth: Ketibaan Tetamu">
                        </div>
                        <button type="button" onclick="removeAturcara({{ $i }})"
                            style="flex-shrink:0;background:rgba(192,80,96,0.1);border:1px solid rgba(192,80,96,0.25);color:#C05060;border-radius:8px;padding:9px 12px;cursor:pointer;font-size:13px;line-height:1;transition:all .2s"
                            onmouseover="this.style.background='rgba(192,80,96,0.2)'"
                            onmouseout="this.style.background='rgba(192,80,96,0.1)'">✕</button>
                    </div>
                </div>
                @empty
                @endforelse
            </div>

            <button type="button" onclick="addAturcara()"
                style="width:100%;margin-top:10px;padding:13px;border:1.5px dashed rgba(201,120,138,0.3);border-radius:10px;background:rgba(201,120,138,0.03);color:var(--rose);font-size:13px;cursor:pointer;font-family:'Nunito',sans-serif;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:8px"
                onmouseover="this.style.borderColor='var(--rose)';this.style.background='rgba(201,120,138,0.07)'"
                onmouseout="this.style.borderColor='rgba(201,120,138,0.3)';this.style.background='rgba(201,120,138,0.03)'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Aturcara
            </button>

            <input type="hidden" name="aturcara" id="aturcaraJson" value="{{ json_encode($aturcara) }}">

            @if(count($aturcara) > 0)
            <div class="separator"></div>
            <div style="font-size:11px;color:var(--muted);margin-bottom:12px;letter-spacing:1px;text-transform:uppercase">Pratonton dalam kad jemputan</div>
            <div style="background:rgba(10,8,4,0.85);border-radius:14px;padding:20px;border:1px solid rgba(201,169,110,0.2)">
                <div style="position:relative;padding-left:20px">
                    <div style="position:absolute;left:8px;top:0;bottom:0;width:1px;background:rgba(201,169,110,0.25)"></div>
                    @foreach($aturcara as $i => $item)
                    <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:{{ $loop->last ? '0' : '14px' }};position:relative">
                        <div style="position:absolute;left:-16px;top:4px;width:8px;height:8px;border-radius:50%;background:{{ $loop->first ? '#C9A96E' : 'rgba(201,169,110,0.35)' }};flex-shrink:0"></div>
                        <div style="min-width:52px;font-family:'Cormorant Garamond',serif;font-size:13px;color:#C9A96E;letter-spacing:1px;flex-shrink:0">
                            {{ \Carbon\Carbon::parse($item['masa'])->format('h:i') }}
                            <span style="font-size:10px;opacity:.7">{{ \Carbon\Carbon::parse($item['masa'])->format('A') }}</span>
                        </div>
                        <div style="font-size:13px;color:#E8D5B0;line-height:1.5">{{ $item['tajuk'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

</form>
@endif

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

document.getElementById('mainForm')?.addEventListener('submit', function(e) {
    const jsonInput = document.getElementById('aturcaraJson');
    if (jsonInput) {
        const rows = document.querySelectorAll('.aturcara-row');
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
});

function copyLink() {
    const text = document.getElementById("inviteLink").innerText.replace(/\s*Copy\s*/g, '').trim();
    navigator.clipboard.writeText(text).then(function() {
        alert("Link berjaya disalin!");
    }, function() {
        alert("Gagal copy link");
    });
}

function togglePengantin(n) {
    const show = n == 2;
    document.getElementById('pengantin2Field').style.display = show ? '' : 'none';
    document.getElementById('ringkas2Field').style.display = show ? '' : 'none';
    document.getElementById('labelPengantin1').textContent = show ? 'Nama Pengantin 1 (penuh)' : 'Nama Penuh';
    document.getElementById('labelRingkas1').textContent = show ? 'Nama Ringkas Pengantin 1' : 'Nama Ringkas';
}

function togglePihak(n) {
    document.getElementById('pihak2Fields').style.display = n == 2 ? '' : 'none';
}

function selectTemplate(url, el) {
    document.querySelectorAll('.template-opt').forEach(t => {
        t.style.borderColor = 'var(--border)';
        t.classList.remove('selected');
    });
    el.style.borderColor = 'var(--gold)';
    el.classList.add('selected');
    const urlObj = new URL(url);
    const cleanPath = urlObj.pathname.replace('/storage/', '');
    document.getElementById('headerImageInput').value = cleanPath;
}

function selectTheme(id) {
    document.querySelectorAll('.theme-opt').forEach(t => t.classList.remove('selected'));
    event.currentTarget.classList.add('selected');
    document.getElementById('temaInput').value = id;
    document.getElementById('customColors').style.display = id === 'custom' ? 'block' : 'none';
}

const fontLinks = {};
function previewFonts(title, body) {
    const titleFont = title || document.querySelector('[name="fon_tajuk"]')?.value;
    const bodyFont  = body  || document.querySelector('[name="fon_badan"]')?.value;
    [titleFont, bodyFont].filter(Boolean).forEach(f => {
        if (!fontLinks[f]) {
            const link = document.createElement('link');
            link.rel  = 'stylesheet';
            if (f !== 'Amoresa Aged') {
                link.href = `https://fonts.googleapis.com/css2?family=${f.replace(/ /g,'+')}:wght@400;600&display=swap`;
                document.head.appendChild(link);
            }
            fontLinks[f] = true;
        }
    });
    if (title && document.getElementById('fontTitleSample'))
        document.getElementById('fontTitleSample').style.fontFamily = `'${titleFont}', serif`;
    if (body && document.getElementById('fontBodySample'))
        document.getElementById('fontBodySample').style.fontFamily = `'${bodyFont}', sans-serif`;
}
previewFonts('{{ $invitation->fon_tajuk ?? "Cormorant Garamond" }}', '{{ $invitation->fon_badan ?? "DM Sans" }}');

document.querySelector('[name="tema_pakaian"]')?.addEventListener('input', function() {
    const preview = document.getElementById('pakaianPreview');
    if (preview) preview.textContent = this.value || '—';
});

let aturcaraCount = {{ isset($aturcara) ? count($aturcara) : 0 }};

function addAturcara() {
    const list = document.getElementById('aturcaraList');
    if (!list) return;
    const idx = aturcaraCount++;
    const div = document.createElement('div');
    div.className = 'aturcara-row';
    div.id = 'aturcara-' + idx;
    div.style.marginBottom = '10px';
    div.innerHTML = `
        <div style="display:flex;align-items:center;gap:8px">
            <div style="color:var(--muted);cursor:grab;padding:0 4px;font-size:16px;flex-shrink:0">⠿</div>
            <div style="flex-shrink:0;width:110px">
                <input class="input aturcara-masa" type="time" style="text-align:center;font-family:'Nunito',monospace">
            </div>
            <div style="flex:1">
                <input class="input aturcara-tajuk" placeholder="cth: Ketibaan Tetamu">
            </div>
            <button type="button" onclick="removeAturcara(${idx})"
                style="flex-shrink:0;background:rgba(192,80,96,0.1);border:1px solid rgba(192,80,96,0.25);color:#C05060;border-radius:8px;padding:9px 12px;cursor:pointer;font-size:13px;line-height:1;transition:all .2s"
                onmouseover="this.style.background='rgba(192,80,96,0.2)'"
                onmouseout="this.style.background='rgba(192,80,96,0.1)'">✕</button>
        </div>`;
    list.appendChild(div);
    updateAturcaraCount();
    div.querySelector('.aturcara-tajuk').focus();
}

function removeAturcara(idx) {
    const el = document.getElementById('aturcara-' + idx);
    if (el) {
        el.style.opacity = '0';
        el.style.transform = 'translateX(-10px)';
        el.style.transition = 'all .2s';
        setTimeout(() => { el.remove(); updateAturcaraCount(); }, 200);
    }
}

function updateAturcaraCount() {
    const count = document.querySelectorAll('.aturcara-row').length;
    const el = document.getElementById('aturcaraCount');
    if (el) el.textContent = count + ' item';
}

async function uploadGallery(input, jenis) {
    if (!input.files.length) return;
    const progressDiv  = document.getElementById(jenis + 'Progress');
    const progressBar  = document.getElementById(jenis + 'ProgressBar');
    const progressText = document.getElementById(jenis + 'ProgressText');
    const grid = document.getElementById(jenis + 'Grid');
    const icon = document.getElementById(jenis + 'UploadIcon');
    const text = document.getElementById(jenis + 'UploadText');

    progressDiv.style.display = 'block';
    icon.textContent = '⏳';
    text.textContent = 'Sedang muat naik...';

    const formData = new FormData();
    formData.append('_token', CSRF);
    formData.append('jenis', jenis);
    Array.from(input.files).forEach(f => formData.append('images[]', f));

    try {
        progressBar.style.width = '30%';
        progressText.textContent = 'Menghantar fail...';
        const response = await fetch('{{ route("dashboard.gallery.upload") }}', {
            method: 'POST', body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        progressBar.style.width = '80%';
        const data = await response.json();
        if (data.success) {
            progressBar.style.width = '100%';
            progressText.textContent = '✓ Berjaya dimuat naik!';
            data.images.forEach(img => {
                const div = document.createElement('div');
                div.className = 'img-thumb';
                div.id = 'img-' + img.id;
                div.innerHTML = `<img src="${img.url}"><button class="img-remove" type="button" data-id="${img.id}" data-elem="img-${img.id}" onclick="deleteImage(this)">✕</button>`;
                grid.appendChild(div);
            });
            setTimeout(() => {
                progressDiv.style.display = 'none';
                progressBar.style.width = '0%';
                icon.textContent = jenis == 'gallery' ? '📸' : '💑';
                text.textContent = jenis == 'gallery' ? 'Klik untuk muat naik gambar galeri' : 'Klik untuk muat naik gambar Pra-Nikah';
            }, 2000);
        } else {
            errorMsg = data.message || 'Gagal memuat naik fail.';
            throw new Error(errorMsg);
        }
    } catch(e) {
        progressText.textContent = '❌ ' + (e.message || 'Ralat. Cuba lagi.');
        alert(e.message || 'Berlaku ralat semasa memuat naik gambar. Sila cuba lagi.');
        icon.textContent = jenis == 'gallery' ? '📸' : '💑';
        text.textContent = jenis == 'gallery' ? 'Klik untuk muat naik gambar galeri' : 'Klik untuk muat naik gambar Pra-Nikah';
        progressDiv.style.display = 'none';
    }
    input.value = '';
}

async function deleteImage(btn) {
    const id     = btn.dataset.id;
    const elemId = btn.dataset.elem;
    if (!id || !elemId) {
        alert('Ralat: ID gambar tidak dijumpai.');
        return;
    }
    if (!confirm('Padam gambar ini?')) return;

    btn.disabled = true;
    btn.textContent = '...';

    try {
        const response = await fetch(`/dashboard/gallery/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            const err = await response.json().catch(() => ({}));
            alert('Ralat server: ' + (err.message || response.status));
            btn.disabled = false;
            btn.textContent = '✕';
            return;
        }

        const data = await response.json();
        if (data.success) {
            const el = document.getElementById(elemId);
            if (el) {
                el.style.opacity = '0';
                el.style.transform = 'scale(0.8)';
                el.style.transition = 'all .2s';
                setTimeout(() => el.remove(), 200);
            }
        } else {
            alert('Gagal memadam: ' + (data.message || 'Cuba lagi.'));
            btn.disabled = false;
            btn.textContent = '✕';
        }
    } catch(e) {
        alert('Ralat rangkaian. Cuba lagi.');
        btn.disabled = false;
        btn.textContent = '✕';
    }
}

function previewQR(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    if (file.size > 5 * 1024 * 1024) { alert('Saiz fail terlalu besar. Maksimum 5MB.'); input.value = ''; return; }
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('qrPreviewImg').src = e.target.result;
        document.getElementById('qrPreviewWrap').style.display = 'block';
        const cw = document.getElementById('qrCurrentWrap');
        if (cw) cw.style.opacity = '0.4';
        document.getElementById('qrUploadIcon').textContent = '🔄';
        document.getElementById('qrUploadText').textContent  = 'Klik untuk pilih gambar lain';
    };
    reader.readAsDataURL(file);
}

async function deleteQR(btn) {
    if (!confirm('Padam QR DuitNow ini?')) return;

    btn.disabled = true;
    btn.textContent = '⏳ Sedang memadam...';

    try {
        const response = await fetch('{{ route("dashboard.qr.delete") }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            document.getElementById('qrCurrentWrap').style.display = 'none';
            document.getElementById('qrCurrentImg').src = '';
            document.getElementById('qrPreviewWrap').style.display = 'none';
            document.getElementById('qrPreviewImg').src = '';
            document.getElementById('qrUploadIcon').textContent = '💳';
            document.getElementById('qrUploadText').textContent = 'Klik untuk muat naik QR DuitNow';
            document.getElementById('qrFileInput').value = '';
        } else {
            alert('Gagal memadam: ' + (data.message || 'Cuba lagi.'));
            btn.disabled = false;
            btn.textContent = '🗑 Padam QR';
        }

    } catch(e) {
        alert('Ralat rangkaian. Cuba lagi.');
        btn.disabled = false;
        btn.textContent = '🗑 Padam QR';
    }
}
</script>

<style>
.copy-btn { display:inline-flex;align-items:center;gap:6px;margin-left:10px;cursor:pointer;font-weight:500;opacity:.9; }
.copy-btn:hover { opacity:1; }
</style>
@endsection