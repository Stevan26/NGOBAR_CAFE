<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukControler extends Controller
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

        $qty = $validated['qty'] ?? 1;
        $produk = Produk::find($validated['produk_id']);

        if (!$produk) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        if ((int) $produk->stok <= 0) {
            return back()->with('error', 'Stok produk habis.');
        }

        // Buat pesanan langsung (auto kirim ke tabel pemesanan_items), lalu redirect ke page kasir.
        $total = (int) $produk->harga * $qty;

        return \Illuminate\Support\Facades\DB::transaction(function () use ($produk, $qty, $total) {
            if ((int) $produk->stok < $qty) {
                throw new \Exception('Stok tidak cukup');
            }

            $pemesanan = Pemesanan::create([
                'user_id' => Auth::id(),
                'total' => (int) $total,
                'status' => 'menunggu',
            ]);

            // Kurangi stok sekarang.
            $produk->stok = (int) $produk->stok - (int) $qty;
            $produk->save();

            $harga = (int) $produk->harga;
            $subtotal = $harga * $qty;

            PemesananItem::create([
                'pemesanan_id' => $pemesanan->id,
                'produk_id' => $produk->id,
                'qty' => (int) $qty,
                'harga_saat_pesan' => $harga,
                'subtotal' => (int) $subtotal,
            ]);

            // (Opsional) kalau sebelumnya item sudah masuk keranjang, tidak mengganggu.
            return redirect()->route('kasir.home')
                ->with('success', 'Pesanan berhasil dibuat. Silakan diproses oleh kasir.');
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

        $keranjang->delete();

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
            // Muncul di riwayat setelah dikonfirmasi kasir: 'diproses' atau 'selesai'
            ->whereIn('status', ['diproses', 'selesai'])
            ->latest()
            ->get();


        return view('customer.riwayat', compact('pemesanans'));
    }
}
