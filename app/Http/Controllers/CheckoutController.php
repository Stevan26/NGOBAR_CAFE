<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pemesanan;
use App\Models\PemesananItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $userId = Auth::check() ? Auth::id() : null;
        if (!$userId) {
            return back()->with('error', 'Silakan login terlebih dahulu.');
        }

        $keranjang = Keranjang::with('produk')
            ->where('user_id', $userId)
            ->get();

        if ($keranjang->isEmpty()) {
            return back()->with('error', 'Keranjang kosong.');
        }

        return DB::transaction(function () use ($keranjang, $userId) {
            $total = 0;
            foreach ($keranjang as $item) {
                $total += ($item->produk?->harga ?? 0) * $item->qty;
            }

            // Buat pesanan: status menunggu sampai customer konfirmasi pembayaran
            $pemesanan = Pemesanan::create([
                'user_id' => $userId,
                'total' => (int) $total,
                'status' => 'menunggu',
            ]);

            foreach ($keranjang as $item) {
                $produk = $item->produk;
                if (!$produk) {
                    continue;
                }

                // Kurangi stok sekarang karena pesanan sudah dibuat.
                if ($produk->stok !== null) {
                    $qty = (int) $item->qty;
                    $stokSekarang = (int) $produk->stok;

                    if ($stokSekarang < $qty) {
                        throw new \Exception('Stok tidak cukup');
                    }

                    $produk->decrement('stok', $qty);
                }

                $harga = (int) $produk->harga;
                $subtotal = $harga * (int) $item->qty;

                PemesananItem::create([
                    'pemesanan_id' => $pemesanan->id,
                    'produk_id' => $produk->id,
                    'qty' => (int) $item->qty,
                    'harga_saat_pesan' => $harga,
                    'subtotal' => (int) $subtotal,
                ]);
            }

            // Clear keranjang user
            Keranjang::where('user_id', $userId)->delete();

            // Setelah checkout, customer diarahkan ke halaman form pembayaran (agar tombol konfirmasi pembayaran muncul).
            // Setelah customer menekan tombol konfirmasi, status tetap 'menunggu' sampai kasir mengubahnya.
            return redirect()->route('pembayaran.form', $pemesanan->id)
                ->with('success', 'Pesanan berhasil dibuat. Status: menunggu. Silakan konfirmasi pembayaran.');
        });
    }
}

