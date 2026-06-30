<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\PemesananItem;
use App\Models\Produk;
use Carbon\Carbon;
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

        // ---- Data real: 7 hari terakhir ----
        $start = Carbon::today()->subDays(6)->startOfDay();


        // Urutan hari: Senin..Minggu
        $labels = [];
        $revenueByDay = [];
        $ordersByDay = [];
        $productsSoldByDay = [];

        for ($i = 0; $i < 7; $i++) {
            $day = Carbon::today()->subDays(6 - $i);

            // Nama hari dalam format Indonesia (agar sesuai dummy di view)
            // Carbon: 0=Sun,1=Mon,2=Tue,3=Wed,4=Thu,5=Fri,6=Sat
            $labels[] = match ($day->dayOfWeek) {
                0 => 'Minggu',
                1 => 'Senin',
                2 => 'Selasa',
                3 => 'Rabu',
                4 => 'Kamis',
                5 => 'Jumat',
                6 => 'Sabtu',
                default => $day->format('l'),
            };



            $revenueByDay[] = 0;
            $ordersByDay[] = 0;
            $productsSoldByDay[] = 0;
        }

        // Revenue (Rp): sum total pemesanan status selesai per tanggal
        $revenueRows = Pemesanan::selectRaw('DATE(created_at) as dt, SUM(total) as total')
            ->where('status', 'selesai')
            ->whereBetween('created_at', [$start, Carbon::today()->endOfDay()])
            ->groupByRaw('DATE(created_at)')
            ->get();

        // Orders (Pesanan): jumlah pemesanan per tanggal (unik berdasarkan pemesanan id)
        $orderRows = Pemesanan::selectRaw('DATE(created_at) as dt, COUNT(*) as cnt')
            ->whereBetween('created_at', [$start, Carbon::today()->endOfDay()])
            ->groupByRaw('DATE(created_at)')
            ->get();

        // Produk Terjual: total qty dari pemesanan_items per tanggal (join ke pemesanan)
        $productRows = PemesananItem::selectRaw('DATE(pemesanans.created_at) as dt, SUM(pemesanan_items.qty) as qty')
            ->join('pemesanans', 'pemesanans.id', '=', 'pemesanan_items.pemesanan_id')
            ->whereBetween('pemesanans.created_at', [$start, Carbon::today()->endOfDay()])
            ->groupByRaw('DATE(pemesanans.created_at)')
            ->get();


        // Map rows ke indeks labels
        $labelIndex = [];
        for ($i = 0; $i < 7; $i++) {
            $d = Carbon::today()->subDays(6 - $i)->toDateString();
            $labelIndex[$d] = $i;
        }

        foreach ($revenueRows as $row) {
            $key = Carbon::parse($row->dt)->toDateString();
            if (isset($labelIndex[$key])) {
                $revenueByDay[$labelIndex[$key]] = (int) $row->total;
            }
        }

        foreach ($orderRows as $row) {
            $key = Carbon::parse($row->dt)->toDateString();
            if (isset($labelIndex[$key])) {
                $ordersByDay[$labelIndex[$key]] = (int) $row->cnt;
            }
        }

        foreach ($productRows as $row) {
            $key = Carbon::parse($row->dt)->toDateString();
            if (isset($labelIndex[$key])) {
                $productsSoldByDay[$labelIndex[$key]] = (int) $row->qty;
            }
        }

        return view('admin.home', compact(
            'totalProduk',
            'stokHabis',
            'pesananHariIni',
            'revenueHariIni',
            'labels',
            'revenueByDay',
            'ordersByDay',
            'productsSoldByDay'
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


