<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\WishController;

// Auth routes MESTI di atas sekali
require __DIR__.'/auth.php';

// Landing page
Route::get('/', function () {return view('welcome');})->name('home');

// Design Page
Route::get('/designs', function () {
    $category = request('category');
    $query = \App\Models\HeaderTemplate::where('aktif', true);
    if ($category) {
        $query->where('category', $category);
    }
    $templates = $query->orderBy('urutan')->get();
    return view('designs', compact('templates'));
})->name('designs');

//clear cache
Route::get('/clear-cache', function() {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    return 'Cache cleared! (View, Cache, Config, Route)';
});

//debug
Route::get('/debug-aturcara', function() {
    $invitation = auth()->user()->invitation;
    return response()->json([
        'aturcara_raw' => $invitation->getRawOriginal('aturcara'),
        'aturcara_cast' => $invitation->aturcara,
    ]);
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/store', [AdminController::class, 'store'])->name('store');
    Route::delete('/user/{user}', [AdminController::class, 'destroy'])->name('destroy');
    Route::post('/user/{user}/reset-password', [AdminController::class, 'resetPassword'])->name('reset-password');
    Route::post('/invitation/{invitation}/extend', [AdminController::class, 'extendExpiry'])->name('extend');
    Route::post('/template/upload', [AdminController::class, 'uploadTemplate'])->name('template.upload');
    Route::delete('/template/{template}', [AdminController::class, 'deleteTemplate'])->name('template.delete');

    // Vendor Management
    Route::get('/vendors', [AdminController::class, 'vendorIndex'])->name('vendors.index');
    Route::post('/vendors', [AdminController::class, 'vendorStore'])->name('vendors.store');
    Route::get('/login-as-vendor/{user}', [AdminController::class, 'loginAsVendor'])->name('loginAsVendor');
});

// Vendor routes
Route::middleware(['auth', 'vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/', [VendorController::class, 'index'])->name('index');
    Route::post('/store', [VendorController::class, 'store'])->name('store');
    Route::post('/user/{user}/reset-password', [VendorController::class, 'resetPassword'])->name('reset-password');
    
    // Profile Management
    Route::get('/profile', [VendorController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [VendorController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [VendorController::class, 'updatePassword'])->name('password.update');
});

// Buyer Dashboard routes
Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::put('/update', [DashboardController::class, 'update'])->name('update');
    Route::post('/gallery/upload', [DashboardController::class, 'uploadGallery'])->name('gallery.upload');
    Route::delete('/gallery/{gallery}', [DashboardController::class, 'deleteGallery'])->name('gallery.delete');
    Route::delete('/qr', [DashboardController::class, 'deleteQR'])->name('qr.delete');
    Route::get('/rsvp', [DashboardController::class, 'rsvpList'])->name('rsvp');
    Route::get('/wishes', [DashboardController::class, 'wishesList'])->name('wishes');
});

// Public invitation — MESTI paling bawah sekali
Route::get('/{slug}', [InvitationController::class, 'show'])->name('invitation.show');
Route::post('/{slug}/rsvp', [RsvpController::class, 'store'])->name('rsvp.store');
Route::post('/{slug}/wish', [WishController::class, 'store'])->name('wish.store');
Route::get('/{slug}/wishes', [WishController::class, 'index'])->name('wish.index');

