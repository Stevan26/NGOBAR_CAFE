<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminPemesananController extends Controller
{
    public function index()
    {
        $pemesanans = Pemesanan::query()
            ->with(['items.produk'])
            ->orderByDesc('created_at')
            ->get();

        return view('admin.pemesanan.index', compact('pemesanans'));
    }

    public function konfirmasiStokHabis(Request $request)
    {
        // Konsep: batalkan pesanan berstatus `menunggu` jika stok saat ini < qty item saat pesan.
        // Catatan: qty yang dipakai adalah qty pada `pemesanan_items`.

        $candidates = Pemesanan::query()

            ->where('status', 'menunggu')
            ->with(['items.produk'])
            ->get();

        $dibatalkanCount = 0;

        DB::transaction(function () use ($candidates, &$dibatalkanCount) {
            foreach ($candidates as $pemesanan) {
                $perluDibatalkan = $pemesanan->items->contains(function ($item) {
                    $produk = $item->produk;
                    if (!$produk) return true;

                    return (int) $produk->stok < (int) $item->qty;
                });

                if ($perluDibatalkan) {
                    $pemesanan->update(['status' => 'dibatalkan']);
                    $dibatalkanCount++;
                }
            }
        });

        return redirect()->route('admin.pemesanan.index')
            ->with('success', 'Konfirmasi stok habis selesai. Pesanan dibatalkan: ' . $dibatalkanCount);
    }
}

