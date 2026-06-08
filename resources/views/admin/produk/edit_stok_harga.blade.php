@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div
            class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Atur Stok & Harga</h1>
                <p class="text-muted mb-0">{{ $produk->nama_produk }}</p>
            </div>
            <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-secondary rounded-3 fw-semibold">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        @if (session('error'))
            <div class="alert alert-danger rounded-4 shadow-sm">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger rounded-4 shadow-sm">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <div class="bg-white rounded-4 shadow-sm border p-3 p-md-4">
                    <form method="POST" action="{{ route('admin.produk.update_stok_harga', $produk) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Harga</label>
                            <input type="number" name="harga" class="form-control rounded-3" min="0"
                                value="{{ old('harga', $produk->harga) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Stok</label>
                            <input type="number" name="stok" class="form-control rounded-3" min="0"
                                value="{{ old('stok', $produk->stok) }}" required>
                            <div class="form-text">Jika stok 0, produk dianggap habis.</div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button class="btn btn-warning rounded-3 fw-semibold" type="submit">
                                <i class="bi bi-save me-2"></i>Simpan
                            </button>
                            <a href="{{ route('admin.produk.index') }}"
                                class="btn btn-outline-secondary rounded-3 fw-semibold">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="bg-white rounded-4 shadow-sm border p-3 p-md-4">
                    <div class="fw-semibold mb-2">Ringkasan</div>
                    <div class="text-muted" style="font-size:.95rem;">
                        <div class="mb-2"><span class="fw-semibold">Nama:</span> {{ $produk->nama_produk }}</div>
                        <div class="mb-2"><span class="fw-semibold">Harga saat ini:</span>
                            Rp{{ number_format((int) $produk->harga, 0, ',', '.') }}</div>
                        <div class="mb-0"><span class="fw-semibold">Stok saat ini:</span> {{ (int) $produk->stok }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
