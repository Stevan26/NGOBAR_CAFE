@extends('layouts.app')

@section('content')
    <div class="container-fluid px-3 px-md-4 py-4">
        <div class="rounded-4 border-0 overflow-hidden" style="background:
            radial-gradient(1200px circle at 10% 10%, rgba(255,193,7,.35), transparent 35%),
            radial-gradient(900px circle at 90% 20%, rgba(13,202,240,.25), transparent 40%),
            linear-gradient(135deg, #0b1220, #151f33);
            box-shadow: 0 14px 40px rgba(0,0,0,.35);">

            <div class="row g-0 align-items-center">
                <div class="col-lg-7 p-4 p-md-5">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill" style="background: rgba(255,193,7,.12); border: 1px solid rgba(255,193,7,.35);">
                        <i class="bi bi-shield-lock" style="color:#ffc107"></i>
                        <span class="fw-semibold" style="color:#ffe8a3">Admin Dashboard</span>
                    </div>

                    <h1 class="text-white mt-3 mb-2" style="letter-spacing:.2px;">Kontrol cepat operasional kafe</h1>
                    <p class="text-white-50 mb-4" style="max-width: 60ch;">
                        Kelola produk, stok & harga, serta monitor status pesanan. Tampilan ini sengaja dibuat menarik agar fokus admin
                        langsung ke aksi penting.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-warning rounded-pill fw-semibold px-4" style="border:0;">
                            <i class="bi bi-basket me-2"></i>
                            Kelola Produk
                        </a>
                        <a href="{{ route('admin.pemesanan.index') }}" class="btn btn-outline-light rounded-pill fw-semibold px-4">
                            <i class="bi bi-receipt me-2"></i>
                            Pesanan
                        </a>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-outline-warning rounded-pill fw-semibold px-4" style="border-width:2px;">
                            <i class="bi bi-person-plus me-2"></i>
                            Tambah User
                        </a>
                    </div>
                </div>

                <div class="col-lg-5 p-4 p-md-5">
                    <div class="bg-white bg-opacity-10 rounded-4 p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="text-white-50">Snapshot hari ini</div>
                            <div class="badge text-bg-warning rounded-pill">Live</div>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-3 rounded-4" style="background: rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.08);">
                                    <div class="text-white-50" style="font-size:.9rem;">Produk</div>
                                    <div class="text-white fw-bold" style="font-size:1.6rem;">—</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-4" style="background: rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.08);">
                                    <div class="text-white-50" style="font-size:.9rem;">Pesanan</div>
                                    <div class="text-white fw-bold" style="font-size:1.6rem;">—</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-4" style="background: rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.08);">
                                    <div class="text-white-50" style="font-size:.9rem;">Stok Habis</div>
                                    <div class="text-white fw-bold" style="font-size:1.6rem;">—</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-4" style="background: rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.08);">
                                    <div class="text-white-50" style="font-size:.9rem;">Revenue</div>
                                    <div class="text-white fw-bold" style="font-size:1.6rem;">Rp —</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 text-white-50" style="font-size:.9rem;">
                            Placeholder (nantinya bisa diintegrasikan ke query/aggregation database).
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-4 mt-2 mt-md-4">
            <div class="col-12 col-lg-8">
                <div class="rounded-4 bg-white border-0 shadow-sm p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3 class="h5 mb-0"><i class="bi bi-graph-up-arrow me-2 text-warning"></i>Ringkasan cepat</h3>
                        <span class="text-muted" style="font-size:.92rem;">Multi-role ready</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 rounded-4" style="background: rgba(13,110,253,.06); border:1px solid rgba(13,110,253,.15);">
                                <div class="fw-semibold">Produk</div>
                                <div class="text-muted" style="font-size:.93rem;">Atur stok, harga, dan gambar.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-4" style="background: rgba(255,193,7,.06); border:1px solid rgba(255,193,7,.18);">
                                <div class="fw-semibold">Pesanan</div>
                                <div class="text-muted" style="font-size:.93rem;">Konfirmasi dan audit status.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-4" style="background: rgba(25,135,84,.06); border:1px solid rgba(25,135,84,.18);">
                                <div class="fw-semibold">Akun</div>
                                <div class="text-muted" style="font-size:.93rem;">Tambah user untuk admin/kasir.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="rounded-4 bg-white border-0 shadow-sm p-3 p-md-4 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h3 class="h5 mb-0"><i class="bi bi-lightning-charge me-2 text-warning"></i>Next action</h3>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-warning rounded-3 fw-semibold">
                            <i class="bi bi-basket me-2"></i>
                            Audit stok
                        </a>
                        <a href="{{ route('admin.pemesanan.index') }}" class="btn btn-outline-dark rounded-3 fw-semibold">
                            <i class="bi bi-receipt me-2"></i>
                            Lihat pesanan
                        </a>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-outline-warning rounded-3 fw-semibold">
                            <i class="bi bi-person-plus me-2"></i>
                            Kelola user
                        </a>
                    </div>
                    <div class="text-muted mt-3" style="font-size:.92rem;">
                        Halaman ini dibuat sebagai target view baru role admin: <code>admin.dashboard</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

