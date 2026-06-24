<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pemesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PemesananItem;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function produk()
    {
        $data_produk = Produk::all();

        return view('customer.produk', compact('data_produk'));
    }

    public function keranjang()
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login.kasir')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $keranjang = Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->get();

        return view('customer.keranjang', compact('keranjang'));
    }

    public function keranjangStore(Request $request)
    {
        if (!Auth::check()) {
            return back()->with('error', 'Silakan login terlebih dahulu.');
        }

        $validated = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'qty'       => 'nullable|integer|min:1',
        ]);

        $qty = (int) ($validated['qty'] ?? 1);
        $produk = Produk::findOrFail($validated['produk_id']);

        $stokSaatIni = (int) $produk->stok;
        if ($stokSaatIni <= 0) {
            return back()->with('error', 'Stok produk habis.');
        }

        if ($qty > $stokSaatIni) {
            return back()->with('error', 'Stok tidak mencukupi. Maksimum: ' . $stokSaatIni . ' pcs.');
        }

        // Simpan ke tabel keranjangs (keranjang), bukan langsung membuat Pemesanan.
        return \Illuminate\Support\Facades\DB::transaction(function () use ($produk, $qty) {
            $userId = Auth::id();

            $keranjang = Keranjang::firstOrNew([
                'user_id' => $userId,
                'produk_id' => $produk->id,
            ]);

            // Jika item sudah ada, akumulasikan qty (tetap validasi stok).
            $existingQty = (int) ($keranjang->qty ?? 0);
            $newQty = $existingQty + $qty;

            if ($newQty > (int) $produk->stok) {
                throw new \Exception('Stok tidak mencukupi untuk penambahan qty. Maksimum: ' . (int) $produk->stok . ' pcs.');
            }

            $keranjang->qty = $newQty;
            $keranjang->save();

            return redirect()->route('keranjang')
                ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
        });
    }

    public function keranjangUpdate(Request $request, Keranjang $keranjang)
    {
        if (!Auth::check()) {
            abort(401);
        }

        $validated = $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        if ($keranjang->user_id != Auth::id()) {
            abort(403);
        }

        $keranjang->update([
            'qty' => $validated['qty'],
        ]);

        return back()->with(
            'success',
            'Jumlah di keranjang berhasil diperbarui.'
        );
    }

    public function keranjangDestroy(Keranjang $keranjang)
    {
        if (!Auth::check()) {
            abort(401);
        }

        if ($keranjang->user_id != Auth::id()) {
            abort(403);
        }

        Keranjang::destroy($keranjang->id);

        return back()->with(
            'success',
            'Item berhasil dihapus dari keranjang.'
        );
    }

    public function riwayat()
    {
        if (!Auth::check()) {
            return redirect()
                ->route('login.kasir')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $pemesanans = Pemesanan::with('items.produk')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['menunggu', 'diproses', 'selesai', 'dibatalkan'])
            ->latest()
            ->get();


        return view('customer.riwayat', compact('pemesanans'));
    }
}
