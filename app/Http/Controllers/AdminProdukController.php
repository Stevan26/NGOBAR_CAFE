<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class AdminProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::query()->orderByDesc('updated_at')->get();

        return view('admin.produk.index', compact('produks'));
    }

    public function edit($produk)
    {
        $produk = Produk::findOrFail($produk);

        return view('admin.produk.edit_stok_harga', compact('produk'));
    }



    public function updateStokHarga(Request $request, $produk)
    {
        $id = $produk; // Menegaskan bahwa variabel ini berisi ID string
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
            'stok' => ['required', 'integer', 'min:0'],
            'harga' => ['required', 'integer', 'min:0'],
        ]);

        $produk->update([
            'stok' => $validated['stok'],
            'harga' => $validated['harga'],
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Stok & harga berhasil diperbarui.');
    }

    public function delete(Produk $produk)
    {
        // Hati-hati: bila ada foreign key dari pemesanan_items, delete produk bisa gagal.
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}

