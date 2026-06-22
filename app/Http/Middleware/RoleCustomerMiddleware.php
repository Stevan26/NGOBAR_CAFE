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
            // gunakan login kasir/admin tergantung role, tapi untuk customer lebih aman arahkan ke login kasir (route tersedia)
            return redirect()->route('login.kasir');
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


