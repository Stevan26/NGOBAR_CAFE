<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleCustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Customer belum login: requirement menyatakan customer tetap bisa akses halaman publik.
            // Untuk endpoint customer yang memang butuh auth, middleware 'auth' akan menanganinya.
            return $next($request);
        }

        $user = Auth::user();


        // Project ini tidak punya isCustomer(). Fallback ke aturan praktis:
        // Customer = bukan admin & bukan kasir.
        $isAdmin = method_exists($user, 'isAdmin') ? $user->isAdmin() : ($user->role === 'admin');
        $isKasir = method_exists($user, 'isKasir') ? $user->isKasir() : ($user->role === 'kasir');

        if ($isAdmin || $isKasir) {
            abort(403);
        }

        return $next($request);
    }
}


