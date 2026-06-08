<?php
use App\Http\Controllers\ProdukController;  
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('produk', [ProdukController::class, 'produk'])
    ->name('produk');
Route::get('keranjang', [ProdukController::class, 'keranjang'])
    ->name('keranjang');
Route::get('riwayat', [ProdukController::class, 'riwayat'])
    ->name('riwayat');