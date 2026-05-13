<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VendorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isVendorOrAdmin()) {
            abort(403, 'Akses ditolak. Anda bukan Vendor atau Admin.');
        }
        return $next($request);
    }
}
