@extends('layouts.dashboard')
@section('title', 'Ucapan')
@section('content')

<div style="margin-bottom:16px">
    <h2 style="font-family:'Cormorant Garamond',serif;font-size:26px">Ucapan Tetamu</h2>
    <p style="color:var(--muted);font-size:13px">{{ $wishes->count() }} ucapan diterima</p>
</div>

<div style="display:grid;gap:10px">
    @forelse($wishes as $w)
    <div class="section-card">
        <div class="section-body" style="padding:16px">
            <div style="font-size:13px;font-weight:500;color:var(--gold);margin-bottom:6px">{{ $w->nama }}</div>
            <div style="font-size:13px;color:var(--muted);line-height:1.7">{{ $w->ucapan }}</div>
            <div style="font-size:11px;color:var(--muted);margin-top:8px;opacity:.6">{{ $w->created_at->format('d M Y, H:i') }}</div>
        </div>
    </div>
    @empty
    <div class="section-card">
        <div class="section-body" style="text-align:center;color:var(--muted);padding:32px">Tiada ucapan lagi.</div>
    </div>
    @endforelse
</div>
@endsection