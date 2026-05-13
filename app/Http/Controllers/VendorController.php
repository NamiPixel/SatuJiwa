<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invitation;
use App\Models\HeaderTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('limit', 10);
        $vendorId = auth()->id();
        
        $query = User::where('role', 'buyer')
            ->where('vendor_id', $vendorId)
            ->with('invitation')
            ->latest();

        $users = $query->paginate($perPage)->withQueryString();

        $stats = [
            'total' => User::where('role', 'buyer')->where('vendor_id', $vendorId)->count(),
            'aktif' => User::where('role', 'buyer')->where('vendor_id', $vendorId)
                ->whereHas('invitation', fn($q) => $q->where('expires_at', '>', now()))->count(),
            'tamat' => User::where('role', 'buyer')->where('vendor_id', $vendorId)
                ->whereHas('invitation', fn($q) => $q->where('expires_at', '<=', now()))->count(),
            'pending' => User::where('role', 'buyer')->where('vendor_id', $vendorId)
                ->whereDoesntHave('invitation')->count(),
        ];

        // Vendors can only VIEW templates, not upload/delete
        $templates = HeaderTemplate::where('aktif', true)->orderBy('urutan')->get();

        return view('vendor.index', compact('users', 'stats', 'templates'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('vendor.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $user->update($request->only('name', 'email', 'phone', 'address'));

        return back()->with('success', 'Profil berjaya dikemaskini!');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => 'required|string|min:6|confirmed',
        ]);

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Kata laluan berjaya ditukar!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lelaki'    => 'required|string|max:100',
            'nama_perempuan' => 'nullable|string|max:100',
            'slug'           => 'required|string|unique:invitations,slug|regex:/^[a-z0-9\-]+$/',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'      => $request->nama_lelaki . ($request->nama_perempuan ? ' & ' . $request->nama_perempuan : ''),
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'buyer',
            'vendor_id' => auth()->id(), // Linked to vendor
        ]);

        Invitation::create([
            'user_id'                => $user->id,
            'slug'                   => $request->slug,
            'nama_ringkas_lelaki'    => $request->nama_lelaki,
            'nama_ringkas_perempuan' => $request->nama_perempuan,
            'bilangan_pengantin'     => $request->nama_perempuan ? 2 : 1,
            'expires_at'             => now()->addYear(),
        ]);

        return back()
            ->with('success',      'Akaun pelanggan berjaya dibuat!')
            ->with('new_slug',     $request->slug)
            ->with('new_password', $request->password)
            ->with('new_email',    $request->email);
    }

    public function resetPassword(Request $request, User $user)
    {
        // Security check: Vendor can only reset password for their own customers
        if ($user->vendor_id !== auth()->id() || $user->role !== 'buyer') {
            abort(403);
        }

        $request->validate(['password' => 'required|min:6']);
        $user->update(['password' => Hash::make($request->password)]);

        return back()
            ->with('success',        'Password pelanggan berjaya ditukar.')
            ->with('reset_user',     $user->name)
            ->with('reset_password', $request->password);
    }
}
