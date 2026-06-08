<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranFormController extends Controller
{
    public function form(Request $request, Pemesanan $pemesanan)
    {
        if (!Auth::check()) {
            return redirect()->route('login.kasir')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($pemesanan->user_id !== Auth::id()) {
            abort(403);
        }

        $items = $pemesanan->items()->with('produk')->get();
        $total = $pemesanan->total ?? 0;

        return view('customer.pembayaran', compact('pemesanan', 'items', 'total'));
    }
}

