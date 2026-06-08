<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    // Customer menekan tombol konfirmasi pembayaran (manual)
    // Status akan tetap menunggu sampai admin/kasir mengubahnya.
    public function konfirmasiCustomer(Request $request, Pemesanan $pemesanan)
    {
        if (!Auth::check()) {
            return redirect()->route('login.kasir')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($pemesanan->user_id !== Auth::id()) {
            abort(403);
        }

        // Flow baru:
        // - Customer mengonfirmasi pembayaran, tapi status pesanan tetap 'menunggu'.
        // - Kasir mengubah 'menunggu' -> 'diproses' (inilah momen "dikonfirmasi oleh kasir").
        if (!in_array($pemesanan->status, ['menunggu'], true)) {
            return back()->with('error', 'Status pesanan tidak dapat dikonfirmasi.');
        }

        // Tetap simpan status pesanan sebagai 'menunggu' sampai kasir mengubahnya.
        // Setelah konfirmasi, tampilkan halaman tunggu khusus customer.
        return redirect()->route('customer.menunggu', $pemesanan->id)
            ->with('success', 'Konfirmasi pembayaran berhasil. Silakan menunggu kasir memproses pesananmu.');
    }
}

