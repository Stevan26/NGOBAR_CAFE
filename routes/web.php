<?php

use App\Http\Controllers\AdminPemesananController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AuthRoleController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\AdmindController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;




// Halaman untuk customer

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('produk', [ProdukController::class, 'produk'])
    ->name('produk');
Route::get('keranjang', [ProdukController::class, 'keranjang'])
    ->name('keranjang');
Route::get('riwayat', [ProdukController::class, 'riwayat'])
    ->name('riwayat');

Route::post('checkout', [CheckoutController::class, 'checkout'])
    ->name('checkout');

// Form Pemesanan & Pembayaran (manual konfirmasi)
Route::get('pembayaran/{pemesanan}', [\App\Http\Controllers\PembayaranFormController::class, 'form'])
    ->name('pembayaran.form');

Route::post('pembayaran/{pemesanan}/konfirmasi', [\App\Http\Controllers\PembayaranController::class, 'konfirmasiCustomer'])
    ->name('pembayaran.konfirmasi');

// Halaman tunggu customer + endpoint status (untuk polling status)
Route::middleware(['auth','role.customer'])->group(function () {
    Route::get('customer/pemesanan/{pemesanan}/menunggu', function (\Illuminate\Http\Request $request, \App\Models\Pemesanan $pemesanan) {
        abort_unless($pemesanan->user_id === $request->user()->id, 403);
        return view('customer.menunggu', compact('pemesanan'));
    })->name('customer.menunggu');

    Route::get('customer/pemesanan/{pemesanan}/status', function (\Illuminate\Http\Request $request, \App\Models\Pemesanan $pemesanan) {
        abort_unless($pemesanan->user_id === $request->user()->id, 403);
        return response()->json([
            'status' => $pemesanan->status,
        ]);
    })->name('customer.pemesanan.status');
});


// Keranjang actions
Route::post('keranjang', [ProdukController::class, 'keranjangStore'])
    ->name('keranjang.store');
Route::patch('keranjang/{keranjang}', [ProdukController::class, 'keranjangUpdate'])
    ->name('keranjang.update');
Route::delete('keranjang/{keranjang}', [ProdukController::class, 'keranjangDestroy'])
    ->name('keranjang.destroy');


// Halaman untuk Admin (role-based)
Route::middleware(['auth','role.admin'])->group(function () {


    Route::get('admin/home', function () {
        $user = Auth::user();
        abort_unless($user && $user->isAdmin(), 403);
        return app(\App\Http\Controllers\AdmindController::class)->index();
    })->name('admin.home');



    Route::get('admin/create', function () {
        $user = Auth::user();
        abort_unless($user && $user->isAdmin(), 403);
        return app(\App\Http\Controllers\AdmindController::class)->create();
    })->name('admin.create');

    Route::post('admin/produk', [AdmindController::class, 'store'])->name('admin.produk.store');


    // Kelola Produk (stok & harga)
    Route::get('admin/produks', function () {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) abort(403);
        return app(\App\Http\Controllers\AdminProdukController::class)->index();
    })->name('admin.produk.index');

    Route::get('admin/produks/{produk}/edit', function ($produk) {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) abort(403);
        return app(\App\Http\Controllers\AdminProdukController::class)->edit($produk);
    })->name('admin.produk.edit');

    Route::put('admin/produks/{produk}/update-stok-harga', function (\Illuminate\Http\Request $request, $produk) {
        $user = Auth::user();
        abort_unless($user && $user->isAdmin(), 403);

        return app(\App\Http\Controllers\AdminProdukController::class)->updateStokHarga($request, $produk);
    })->name('admin.produk.update_stok_harga');

    // Hapus Produk
    Route::delete('admin/produks/{produk}', function ($produk) {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) abort(403);
        return app(\App\Http\Controllers\AdminProdukController::class)->delete($produk);
    })->name('admin.produk.destroy');

    // Riwayat Pemesanan
    Route::get('admin/pemesanan', function () {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) abort(403);
        return app(\App\Http\Controllers\AdminPemesananController::class)->index();
    })->name('admin.pemesanan.index');

    // Konfirmasi stok habis
    Route::post('admin/pemesanan/konfirmasi-stok-habis', function (\Illuminate\Http\Request $request) {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) abort(403);
        return app(\App\Http\Controllers\AdminPemesananController::class)->konfirmasiStokHabis($request);
    })->name('admin.pemesanan.konfirmasi_stok_habis');
});



// Halaman untuk kasir (role-based)
Route::middleware(['auth','role.kasir'])->group(function () {


    Route::get('kasir/home', function () {
        $user = Auth::user();
        if (!$user || !$user->isKasir()) abort(403);
        return app(\App\Http\Controllers\KasirController::class)->index();
    })->name('kasir.home');

    Route::post('kasir/pemesanan/{pemesanan}/status', function (\Illuminate\Http\Request $request, \App\Models\Pemesanan $pemesanan) {
        $user = Auth::user();
        if (!$user || !$user->isKasir()) abort(403);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:diproses,selesai,dibatalkan'],
        ]);

        // Kasir hanya boleh memproses pesanan yang masih aktif.
        if (!in_array($pemesanan->status, ['menunggu', 'diproses'], true)) {
            abort(422, 'Status pesanan tidak dapat diubah.');
        }

        // Validasi transisi sederhana
        $target = $validated['status'];
        if ($pemesanan->status === 'menunggu' && !in_array($target, ['diproses', 'dibatalkan'], true)) {
            abort(422, 'Transisi status tidak valid.');
        }
        if ($pemesanan->status === 'diproses' && $target !== 'selesai') {
            abort(422, 'Transisi status tidak valid.');
        }

        $pemesanan->update(['status' => $target]);

        return back()->with('success', 'Status pesanan diperbarui: ' . $target);
    })->name('kasir.pemesanan.status');
});



// Halaman untuk login

Route::get('/login/admin', [AuthRoleController::class, 'showLoginAdmin'])
    ->name('login.admin');
Route::post('/login/admin', [AuthRoleController::class, 'loginAdmin'])
    ->name('login.admin.submit');

Route::get('/login/kasir', [AuthRoleController::class, 'showLoginKasir'])
    ->name('login.kasir');
Route::post('/login/kasir', [AuthRoleController::class, 'loginKasir'])
    ->name('login.kasir.submit');

Route::post('/logout', [AuthRoleController::class, 'logout'])
    ->name('logout');

// Admin: kelola user
Route::middleware(['auth','role.admin'])->group(function () {

    Route::get('admin/users/create', function () {
        $user = Auth::user();
        abort_unless($user && $user->isAdmin(), 403);
        return app(\App\Http\Controllers\AdminUsersController::class)->create();
    })->name('admin.users.create');

    Route::post('admin/users', function (\Illuminate\Http\Request $request) {
        $user = Auth::user();
        abort_unless($user && $user->isAdmin(), 403);
        return app(\App\Http\Controllers\AdminUsersController::class)->store($request);
    })->name('admin.users.store');
});
