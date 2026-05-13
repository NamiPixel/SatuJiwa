<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Invitation;
use App\Models\HeaderTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('limit', 10);
        $vendorFilter = $request->get('vendor_id');
        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);

        $query = User::where('role', 'buyer')
            ->with(['invitation', 'vendor'])
            ->latest();

        if ($vendorFilter) {
            $query->where('vendor_id', $vendorFilter);
        }

        $users = $query->paginate($perPage)->withQueryString();

        // ══════════════════════════════════════════════════════════════
        // ══ ADVANCED ANALYTICS (Filtered by Month/Year)
        // ══════════════════════════════════════════════════════════════
        
        $selectedDate = \Carbon\Carbon::create($year, $month, 1);
        $prevMonthDate = $selectedDate->copy()->subMonth();

        // Current Month Stats
        $currentMonthBuyers = User::where('role', 'buyer')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->count();

        // Prev Month Stats (for Growth calculation)
        $prevMonthBuyers = User::where('role', 'buyer')
            ->whereMonth('created_at', $prevMonthDate->month)
            ->whereYear('created_at', $prevMonthDate->year)
            ->count();

        $growth = $prevMonthBuyers > 0 
            ? round((($currentMonthBuyers - $prevMonthBuyers) / $prevMonthBuyers) * 100, 1)
            : ($currentMonthBuyers > 0 ? 100 : 0);

        // General Stats (Lifetime)
        $totalBuyers = User::where('role', 'buyer')->count();
        $publishedCount = Invitation::count();
        $conversionRate = $totalBuyers > 0 ? round(($publishedCount / $totalBuyers) * 100, 1) : 0;

        $stats = [
            'total'   => $totalBuyers,
            'aktif'   => Invitation::where('expires_at', '>', now())->count(),
            'tamat'   => Invitation::where('expires_at', '<=', now())->count(),
            'pending' => User::where('role', 'buyer')->whereDoesntHave('invitation')->count(),
            'analytics' => [
                'monthly_total' => $currentMonthBuyers,
                'growth'        => $growth,
                'conversion'    => $conversionRate,
                'period_label'  => $selectedDate->format('F Y'),
            ]
        ];

        // ══════════════════════════════════════════════════════════════
        // ══ TREND DATA (6 Months window leading to selected date)
        // ══════════════════════════════════════════════════════════════
        $monthsTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = $selectedDate->copy()->subMonths($i);
            $bCount = User::where('role', 'buyer')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $vCount = User::where('role', 'vendor')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            
            $monthsTrend[] = [
                'label'   => $date->format('M Y'),
                'buyers'  => $bCount,
                'vendors' => $vCount,
            ];
        }

        // ══════════════════════════════════════════════════════════════
        // ══ VENDOR PERFORMANCE (Acquisition within selected period)
        // ══════════════════════════════════════════════════════════════
        $vendorPerformance = User::where('role', 'vendor')
            ->withCount(['customers' => function($q) use ($month, $year) {
                $q->whereMonth('created_at', $month)->whereYear('created_at', $year);
            }])
            ->orderByDesc('customers_count')
            ->get();

        $templates = HeaderTemplate::orderBy('urutan')->get();
        $vendors = User::where('role', 'vendor')->orderBy('name')->get();

        return view('admin.index', compact(
            'users', 
            'stats', 
            'templates', 
            'monthsTrend', 
            'vendorPerformance', 
            'vendors'
        ));
    }

    public function vendorIndex()
    {
        $vendors = User::where('role', 'vendor')
            ->withCount('customers')
            ->latest()
            ->get();

        // Calculate some performance stats for each vendor
        foreach ($vendors as $vendor) {
            $vendor->active_customers = $vendor->customers()
                ->whereHas('invitation', fn($q) => $q->where('expires_at', '>', now()))
                ->count();
        }

        return view('admin.vendors.index', compact('vendors'));
    }

    public function vendorStore(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'vendor',
        ]);

        return back()->with('success', 'Akaun Vendor berjaya dibuat!');
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
            'name'     => $request->nama_lelaki . ($request->nama_perempuan ? ' & ' . $request->nama_perempuan : ''),
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'buyer',
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
            ->with('success',      'Akaun berjaya dibuat!')
            ->with('new_slug',     $request->slug)
            ->with('new_password', $request->password)
            ->with('new_email',    $request->email);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Akaun berjaya dipadam.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate(['password' => 'required|min:6']);
        $user->update(['password' => Hash::make($request->password)]);
        return back()
            ->with('success',        'Password berjaya ditukar.')
            ->with('reset_user',     $user->name)
            ->with('reset_password', $request->password);
    }

    public function extendExpiry(Request $request, Invitation $invitation)
    {
        $bulan = $request->bulan ?? 12;
        $invitation->update([
            'expires_at' => $invitation->expires_at
                ? $invitation->expires_at->addMonths($bulan)
                : now()->addMonths($bulan),
        ]);
        return back()->with('success', 'Tempoh berjaya dilanjutkan.');
    }

    public function uploadTemplate(Request $request)
    {
        $request->validate([
            'templates.*' => 'image|max:5120',
            'category'    => 'required|string|max:50',
        ]);

        foreach ($request->file('templates') as $file) {

            // Cari nombor NP tertinggi dalam database
            $latest = HeaderTemplate::where('nama', 'LIKE', 'NP%')
                ->orderByRaw('CAST(SUBSTRING(nama, 3) AS UNSIGNED) DESC')
                ->first();

            $nextNum = $latest ? ((int) substr($latest->nama, 2)) + 1 : 1;

            // Pastikan nama unik (elak race condition)
            do {
                $nama = 'NP' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
                $nextNum++;
            } while (HeaderTemplate::where('nama', $nama)->exists());

            $path = $file->store('header-templates', 'public');

            HeaderTemplate::create([
                'nama'       => $nama,
                'image_path' => $path,
                'category'   => $request->category,
                'urutan'     => HeaderTemplate::max('urutan') + 1,
            ]);
        }

        return back()->with('success', 'Template berjaya dimuat naik!');
    }

    public function deleteTemplate(HeaderTemplate $template)
    {
        Storage::disk('public')->delete($template->image_path);
        $template->delete();
        return back()->with('success', 'Template berjaya dipadam.');
    }

    public function loginAsVendor(User $user)
    {
        if ($user->role !== 'vendor') {
            return back()->with('error', 'User bukan vendor.');
        }

        auth()->login($user);
        return redirect()->route('vendor.index');
    }
}