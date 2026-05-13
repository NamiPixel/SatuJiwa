<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function show($slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        if ($invitation->isExpired()) {
            return view('invitation.expired', compact('invitation'));
        }

        $galleries = $invitation->galleryImages;
        $pranikahImages = $invitation->pranikahImages;
        $wishes = $invitation->wishes()->latest()->take(10)->get();

        return view('invitation.show', compact('invitation', 'galleries', 'pranikahImages', 'wishes'));
    }
}