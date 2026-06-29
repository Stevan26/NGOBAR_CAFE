<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Produk;
use Illuminate\Http\Request;


class AdmindController extends Controller
{
    public function index()
    {
        $totalProduk = Produk::count();
        $stokHabis = Produk::where('stok', 0)->count();

        $pesananHariIni = Pemesanan::whereDate('created_at', today())->count();
        $revenueHariIni = Pemesanan::where('status', 'selesai')
            ->whereDate('created_at', today())
            ->sum('total');

        return view('admin.home', compact(
            'totalProduk',
            'stokHabis',
            'pesananHariIni',
            'revenueHariIni'
        ));
    }


    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer'],
            'deskripsi' => ['nullable', 'string'],
            'stok' => ['required', 'integer', 'min:0'],
            'gambar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create([
            'nama_produk' => $validated['nama_produk'],
            'harga' => $validated['harga'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'stok' => $validated['stok'],
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.home')->with('success', 'Produk berhasil ditambahkan');
    }
}


