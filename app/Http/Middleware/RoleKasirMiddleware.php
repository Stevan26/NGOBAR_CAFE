<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleKasirMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login.kasir');
        }

        $user = Auth::user();
        if (!$user || !(method_exists($user, 'isKasir') ? $user->isKasir() : ($user->role === 'kasir'))) {
            abort(403);
        }

        return $next($request);
    }
}

