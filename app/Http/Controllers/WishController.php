<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class WishController extends Controller
{
    public function store(Request $request, $slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        $request->validate([
            'nama' => 'required|string|max:100',
            'ucapan' => 'required|string|max:500',
        ]);

        $wish = $invitation->wishes()->create([
            'nama' => $request->nama,
            'ucapan' => $request->ucapan,
        ]);

        return response()->json([
            'message' => 'Ucapan berjaya dihantar!',
            'wish' => $wish,
        ]);
    }

    public function index($slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();
        $wishes = $invitation->wishes()->latest()->get();
        return response()->json($wishes);
    }
}