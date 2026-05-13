@extends('layouts.dashboard')
@section('title', 'RSVP')
@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
    <div>
        <h2 style="font-family:'Cormorant Garamond',serif;font-size:26px">Senarai RSVP</h2>
        <p style="color:var(--muted);font-size:13px">{{ $rsvps->count() }} respons diterima</p>
    </div>
</div>

{{-- SUMMARY CARDS --}}
@php
    $hadir       = $rsvps->where('status','hadir');
    $tidakHadir  = $rsvps->where('status','tidak_hadir');
    $belumTahu   = $rsvps->where('status','belum_tahu');
    $totalPax    = $hadir->sum('jumlah_hadir');
@endphp

<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px">
    <div style="background:rgba(201,169,110,0.06);border:1px solid var(--border);border-radius:12px;padding:16px;text-align:center">
        <div style="font-size:28px;font-family:'Cormorant Garamond',serif;color:var(--gold)">{{ $rsvps->count() }}</div>
        <div style="font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-top:4px">Jumlah Respons</div>
    </div>
    <div style="background:rgba(76,175,125,0.06);border:1px solid rgba(76,175,125,0.2);border-radius:12px;padding:16px;text-align:center">
        <div style="font-size:28px;font-family:'Cormorant Garamond',serif;color:#4CAF7D">{{ $hadir->count() }}</div>
        <div style="font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-top:4px">Hadir</div>
        <div style="font-size:11px;color:#4CAF7D;margin-top:4px">{{ $totalPax }} pax</div>
    </div>
    <div style="background:rgba(224,87,87,0.06);border:1px solid rgba(224,87,87,0.2);border-radius:12px;padding:16px;text-align:center">
        <div style="font-size:28px;font-family:'Cormorant Garamond',serif;color:#E05757">{{ $tidakHadir->count() }}</div>
        <div style="font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-top:4px">Tidak Hadir</div>
    </div>
    <div style="background:rgba(201,169,110,0.06);border:1px solid rgba(201,169,110,0.2);border-radius:12px;padding:16px;text-align:center">
        <div style="font-size:28px;font-family:'Cormorant Garamond',serif;color:#C9A96E">{{ $belumTahu->count() }}</div>
        <div style="font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-top:4px">Belum Tahu</div>
    </div>
</div>

<div class="section-card">
    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr>
                <th style="padding:10px 16px;text-align:left;font-size:10px;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border)">#</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border)">Nama</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border)">Status</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border)">Pax</th>
                <th style="padding:10px 16px;text-align:left;font-size:10px;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border)">Masa</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rsvps as $i => $r)
            <tr>
                <td style="padding:12px 16px;font-size:13px;border-bottom:1px solid rgba(201,169,110,0.06);color:var(--muted)">{{ $i+1 }}</td>
                <td style="padding:12px 16px;font-size:13px;border-bottom:1px solid rgba(201,169,110,0.06)">{{ $r->nama }}</td>
                <td style="padding:12px 16px;font-size:13px;border-bottom:1px solid rgba(201,169,110,0.06)">
                    @if($r->status == 'hadir')
                        <span style="background:rgba(76,175,125,0.15);color:#4CAF7D;padding:2px 8px;border-radius:20px;font-size:11px">Hadir</span>
                    @elseif($r->status == 'tidak_hadir')
                        <span style="background:rgba(224,87,87,0.15);color:#E05757;padding:2px 8px;border-radius:20px;font-size:11px">Tidak Hadir</span>
                    @else
                        <span style="background:rgba(201,169,110,0.15);color:#C9A96E;padding:2px 8px;border-radius:20px;font-size:11px">Belum Tahu</span>
                    @endif
                </td>
                <td style="padding:12px 16px;font-size:13px;border-bottom:1px solid rgba(201,169,110,0.06)">{{ $r->jumlah_hadir }}</td>
                <td style="padding:12px 16px;font-size:11px;color:var(--muted);border-bottom:1px solid rgba(201,169,110,0.06)">{{ $r->created_at->format('d M, H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="padding:32px;text-align:center;color:var(--muted)">Tiada RSVP lagi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection