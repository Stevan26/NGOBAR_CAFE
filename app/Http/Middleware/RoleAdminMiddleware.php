<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login.admin');
        }

        $user = Auth::user();
        if (!$user || !(method_exists($user, 'isAdmin') ? $user->isAdmin() : ($user->role === 'admin'))) {
            abort(403);
        }

        return $next($request);
    }
}

