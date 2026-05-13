<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    public function store(Request $request, $slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        $request->validate([
            'nama' => 'required|string|max:100',
            'status' => 'required|in:hadir,tidak_hadir,belum_tahu',
            'jumlah_hadir' => 'integer|min:1|max:20',
        ]);

        if ($invitation->rsvp_tutup && now()->isAfter($invitation->rsvp_tutup)) {
            return response()->json(['message' => 'RSVP telah ditutup.'], 422);
        }

        $invitation->rsvpResponses()->create([
            'nama' => $request->nama,
            'status' => $request->status,
            'jumlah_hadir' => $request->jumlah_hadir ?? 1,
        ]);

        return response()->json(['message' => 'RSVP anda telah direkodkan!']);
    }
}