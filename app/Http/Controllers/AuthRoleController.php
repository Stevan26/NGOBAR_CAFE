<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthRoleController extends Controller
{
    public function showLoginAdmin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $isAdmin = method_exists($user, 'isAdmin') ? $user->isAdmin() : ($user->role === 'admin');
            if ($isAdmin) {
                return redirect()->route('admin.home');
            }
            // method isKasir() may not exist; if not, fallback to role checks by 'role' column.
            if ($user) {
                $isKasir = method_exists($user, 'isKasir') ? $user->isKasir() : ($user->role === 'kasir');
                if ($isKasir) {
                    return redirect()->route('kasir.home');
                }
            }
        }

        return view('login.admin');
    }

    public function showLoginKasir()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $isKasir = method_exists($user, 'isKasir') ? $user->isKasir() : ($user->role === 'kasir');
            if ($isKasir) {
                return redirect()->route('kasir.home');
            }

            $isAdmin = method_exists($user, 'isAdmin') ? $user->isAdmin() : ($user->role === 'admin');
            if ($isAdmin) {
                return redirect()->route('admin.home');
            }
        }

        return view('login.kasir');
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Email atau password salah.')->withInput();
        }

        $user = Auth::user();

        // Cek apakah user memiliki role admin
        $isAdmin = method_exists($user, 'isAdmin') ? $user->isAdmin() : ($user->role === 'admin');
        if (!$user || !$isAdmin) {
            Auth::logout();
            return back()->with('error', 'Akun ini bukan Admin.')->withInput();
        }

        return redirect()->route('admin.home');
    }

    public function loginKasir(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Email atau password salah.')->withInput();
        }

        $user = Auth::user();

        // Cek apakah user memiliki role kasir
        $isKasir = method_exists($user, 'isKasir') ? $user->isKasir() : ($user->role === 'kasir');
        if (!$user || !$isKasir) {
            Auth::logout();
            return back()->with('error', 'Akun ini bukan Kasir.')->withInput();
        }

        return redirect()->route('kasir.home');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Buang semua data session yang mungkin tersisa
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Setelah logout, arahkan ke halaman awal
        return redirect()->route('home');

    }
}



