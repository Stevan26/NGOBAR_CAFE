<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function showLoginCustomer()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $isAdmin = method_exists($user, 'isAdmin') ? $user->isAdmin() : ($user->role === 'admin');
            $isKasir = method_exists($user, 'isKasir') ? $user->isKasir() : ($user->role === 'kasir');

            if ($isAdmin) {
                return redirect()->route('admin.home');
            }

            if ($isKasir) {
                return redirect()->route('kasir.home');
            }

            return redirect()->intended('/produk');
        }

        return view('login.customer');
    }

    public function showRegisterCustomer()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $isAdmin = method_exists($user, 'isAdmin') ? $user->isAdmin() : ($user->role === 'admin');
            $isKasir = method_exists($user, 'isKasir') ? $user->isKasir() : ($user->role === 'kasir');

            if ($isAdmin) {
                return redirect()->route('admin.home');
            }

            if ($isKasir) {
                return redirect()->route('kasir.home');
            }

            return redirect()->intended('/produk');
        }

        return view('login.register');
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

        $isKasir = method_exists($user, 'isKasir') ? $user->isKasir() : ($user->role === 'kasir');
        if (!$user || !$isKasir) {
            Auth::logout();
            return back()->with('error', 'Akun ini bukan Kasir.')->withInput();
        }

        return redirect()->route('kasir.home');
    }

    public function loginCustomer(Request $request)
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

        $isAdmin = method_exists($user, 'isAdmin') ? $user->isAdmin() : ($user->role === 'admin');
        $isKasir = method_exists($user, 'isKasir') ? $user->isKasir() : ($user->role === 'kasir');

        // Pastikan user yang login adalah customer
        if (!$user || $isAdmin || $isKasir) {
            Auth::logout();
            return back()->with('error', 'Akun ini bukan Customer.')->withInput();
        }

        return redirect()->intended(route('home'));
    }

    public function registerCustomer(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'customer',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}







