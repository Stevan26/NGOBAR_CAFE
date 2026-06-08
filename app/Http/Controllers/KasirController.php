<?php

namespace App\Http\Controllers;


use App\Models\Pemesanan;
use Illuminate\Support\Carbon;



class KasirController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $tomorrow = (clone $today)->addDay();

        // Pesanan yang sedang berjalan (kasir)
        $pemesanans = Pemesanan::query()
            ->with(['items.produk', 'user'])
            ->whereIn('status', ['menunggu', 'diproses'])
            ->orderByDesc('created_at')
            ->get();

        // Ringkasan transaksi hari ini
        $totalHariIni = Pemesanan::query()
            ->whereBetween('created_at', [$today->startOfDay(), $tomorrow->startOfDay()])
            ->sum('total');

        $jumlahStatus = [
            'menunggu' => (int) Pemesanan::query()->where('status', 'menunggu')->count(),
            'diproses' => (int) Pemesanan::query()->where('status', 'diproses')->count(),
            'selesai' => (int) Pemesanan::query()->where('status', 'selesai')->count(),
            'dibatalkan' => (int) Pemesanan::query()->where('status', 'dibatalkan')->count(),
        ];

        return view('kasir.home', compact('pemesanans', 'totalHariIni', 'jumlahStatus'));
    }
}



