@extends('layouts.app')

@section('content')
    <div class="container-fluid px-3 px-md-4 py-4">
        {{-- Hero --}}
        <div class="rounded-4 border-0 overflow-hidden"
            style="background:
        radial-gradient(1200px circle at 10% 10%, rgba(255,193,7,.35), transparent 35%),
        radial-gradient(900px circle at 90% 20%, rgba(13,202,240,.25), transparent 40%),
        linear-gradient(135deg, #0b1220, #151f33);
        box-shadow: 0 14px 40px rgba(0,0,0,.35);
    ">
            <div class="row g-0 align-items-center">
                <div class="col-lg-7 p-4 p-md-5">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                        style="background: rgba(255,193,7,.12); border: 1px solid rgba(255,193,7,.35);">
                        <i class="bi bi-shield-lock" style="color:#ffc107"></i>
                        <span class="fw-semibold" style="color:#ffe8a3">Admin Dashboard</span>
                    </div>

                    <h1 class="text-white mt-3 mb-2" style="letter-spacing:.2px;">
                        Selamat datang, Admin
                    </h1>
                    <p class="text-white-50 mb-4" style="max-width: 55ch;">
                        Pantau stok produk, cek performa penjualan, dan kelola menu kopi Anda dengan tampilan yang rapi dan
                        cepat.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('admin.create') }}" class="btn btn-warning rounded-pill fw-semibold px-4"
                            style="border:0;">
                            <i class="bi bi-plus-circle me-2"></i>
                            Tambah Produk
                        </a>
                        <a href="{{ route('produk') }}" class="btn btn-outline-light rounded-pill fw-semibold px-4">
                            <i class="bi bi-bag-check me-2"></i>
                            Lihat Menu
                        </a>
                        <a href="#" class="btn btn-outline-warning rounded-pill fw-semibold px-4"
                            style="border-width:2px;">
                            <i class="bi bi-graph-up me-2"></i>
                            Laporan
                        </a>
                    </div>
                </div>

                <div class="col-lg-5 p-4 p-md-5">
                    <div class="bg-white bg-opacity-10 rounded-4 p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="text-white-50">Ringkasan Hari Ini</div>
                            <div class="badge text-bg-warning rounded-pill">Live</div>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-3 rounded-4"
                                    style="background: rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.08);">
                                    <div class="text-white-50" style="font-size:.9rem;">Produk</div>
                                    <div class="text-white fw-bold" style="font-size:1.6rem;">—</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-4"
                                    style="background: rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.08);">
                                    <div class="text-white-50" style="font-size:.9rem;">Stok Habis</div>
                                    <div class="text-white fw-bold" style="font-size:1.6rem;">—</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-4"
                                    style="background: rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.08);">
                                    <div class="text-white-50" style="font-size:.9rem;">Pesanan</div>
                                    <div class="text-white fw-bold" style="font-size:1.6rem;">—</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-4"
                                    style="background: rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.08);">
                                    <div class="text-white-50" style="font-size:.9rem;">Revenue</div>
                                    <div class="text-white fw-bold" style="font-size:1.6rem;">Rp —</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 text-white-50" style="font-size:.9rem;">
                            * Angka masih placeholder. Nanti bisa dihubungkan ke database.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content grid --}}
        <div class="row g-4 mt-2 mt-md-4">
            {{-- Quick actions --}}
            <div class="col-12 col-lg-4">
                <div class="rounded-4 bg-white border-0 shadow-sm p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3 class="h5 mb-0"><i class="bi bi-lightning-charge me-2 text-warning"></i>Quick Actions</h3>
                        <span class="text-muted" style="font-size:.92rem;">Admin Tools</span>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-warning rounded-3 fw-semibold py-3">
                            <i class="bi bi-basket me-2"></i>Kelola Produk
                        </a>
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-dark rounded-3 fw-semibold py-3">
                            <i class="bi bi-box-seam me-2"></i>Atur Stok & Harga
                        </a>

                        <a href="{{ route('admin.users.create') }}" class="btn btn-outline-dark rounded-3 fw-semibold py-3">
                            <i class="bi bi-person-plus me-2"></i>Tambah User
                        </a>

                        <a href="{{ route('admin.pemesanan.index') }}"
                            class="btn btn-outline-dark rounded-3 fw-semibold py-3">
                            <i class="bi bi-receipt me-2"></i>Riwayat Pesanan
                        </a>

                        <form method="POST" action="{{ route('admin.pemesanan.konfirmasi_stok_habis') }}">
                            @csrf
                            <button class="btn btn-outline-danger rounded-3 fw-semibold py-3" type="submit"
                                onclick="return confirm('Batalkan pesanan menunggu yang tidak bisa dipenuhi karena stok habis?')">
                                <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Stok Habis
                            </button>
                        </form>
                    </div>

                    <hr class="my-4" />

                    <div class="d-flex gap-3 align-items-start">
                        <div class="rounded-4"
                            style="width:44px; height:44px; background: rgba(13,110,253,.12); display:flex; align-items:center; justify-content:center; border:1px solid rgba(13,110,253,.25);">
                            <i class="bi bi-stars text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Tip</div>
                            <div class="text-muted" style="font-size:.93rem;">
                                Gunakan halaman ini untuk cek perubahan stok cepat tanpa mengganggu tampilan user.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Latest products table --}}
            <div class="col-12 col-lg-8">
                <div class="rounded-4 bg-white border-0 shadow-sm p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3 class="h5 mb-0"><i class="bi bi-table me-2 text-warning"></i>Produk Terbaru</h3>
                        <div class="text-muted" style="font-size:.92rem;">(contoh tampilan)</div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 46px;">#</th>
                                    <th>Produk</th>
                                    <th style="width: 140px;">Stok</th>
                                    <th style="width: 170px;">Harga</th>
                                    <th style="width: 160px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-muted">1</td>
                                    <td class="fw-semibold">Americano</td>
                                    <td><span class="badge text-bg-success rounded-pill">Ready</span> </td>
                                    <td class="fw-semibold">Rp 18.000</td>
                                    <td>
                                        <span class="text-success fw-semibold"><i
                                                class="bi bi-check-circle me-1"></i>Aman</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">2</td>
                                    <td class="fw-semibold">Latte</td>
                                    <td><span class="badge text-bg-warning rounded-pill">Hati-hati</span></td>
                                    <td class="fw-semibold">Rp 25.000</td>
                                    <td>
                                        <span class="text-warning fw-semibold"><i
                                                class="bi bi-exclamation-triangle me-1"></i>Perlu restock</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">3</td>
                                    <td class="fw-semibold">Matcha Latte</td>
                                    <td><span class="badge text-bg-danger rounded-pill">Habis</span></td>
                                    <td class="fw-semibold">Rp 30.000</td>
                                    <td>
                                        <span class="text-danger fw-semibold"><i
                                                class="bi bi-x-circle me-1"></i>Stop</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mt-3">
                        <div class="text-muted" style="font-size:.93rem;">
                            Nanti bisa dihubungkan ke data tabel `produks`.
                        </div>
                        <a href="#" class="btn btn-dark rounded-3 fw-semibold">
                            Lihat semua
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Chart placeholder --}}
            <div class="col-12">
                <div class="rounded-4 bg-white border-0 shadow-sm p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3 class="h5 mb-0"><i class="bi bi-bar-chart me-2 text-warning"></i>Performa Penjualan</h3>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary btn-sm rounded-pill" type="button"
                                onclick="return false;">7 hari</button>
                            <button class="btn btn-outline-secondary btn-sm rounded-pill" type="button"
                                onclick="return false;">30 hari</button>
                            <button class="btn btn-outline-secondary btn-sm rounded-pill" type="button"
                                onclick="return false;">All</button>
                        </div>
                    </div>

                    <div class="rounded-4"
                        style="background: linear-gradient(180deg, rgba(255,193,7,.10), rgba(13,110,253,.06)); border:1px dashed rgba(0,0,0,.12); padding:18px;">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-6">
                                <div class="fw-semibold">Grafik placeholder</div>
                                <div class="text-muted" style="font-size:.95rem;">
                                    Belum ada integrasi chart. Cocok untuk diisi library seperti Chart.js atau disiapkan
                                    dari endpoint.
                                </div>
                                <div class="mt-3 d-flex gap-2 flex-wrap">
                                    <span class="badge text-bg-warning rounded-pill">Revenue</span>
                                    <span class="badge text-bg-primary rounded-pill">Pesanan</span>
                                    <span class="badge text-bg-success rounded-pill">Produk Terjual</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-white rounded-4 p-3 shadow-sm"
                                    style="min-height: 140px; border:1px solid rgba(0,0,0,.06);">
                                    <div class="d-flex justify-content-between align-items-end h-100 gap-2">
                                        <div
                                            style="width: 12%; height: 35%; background: rgba(255,193,7,.45); border-radius: 10px;">
                                        </div>
                                        <div
                                            style="width: 12%; height: 55%; background: rgba(13,110,253,.35); border-radius: 10px;">
                                        </div>
                                        <div
                                            style="width: 12%; height: 70%; background: rgba(25,135,84,.35); border-radius: 10px;">
                                        </div>
                                        <div
                                            style="width: 12%; height: 45%; background: rgba(255,193,7,.45); border-radius: 10px;">
                                        </div>
                                        <div
                                            style="width: 12%; height: 85%; background: rgba(13,110,253,.35); border-radius: 10px;">
                                        </div>
                                        <div
                                            style="width: 12%; height: 60%; background: rgba(25,135,84,.35); border-radius: 10px;">
                                        </div>
                                        <div
                                            style="width: 12%; height: 78%; background: rgba(255,193,7,.45); border-radius: 10px;">
                                        </div>
                                    </div>
                                    <div class="text-muted mt-3" style="font-size:.9rem;">Ilustrasi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
