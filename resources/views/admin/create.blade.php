@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 720px;">
    <div class="mb-3">
        <h1 class="fw-bold" style="letter-spacing:.2px;">Tambah Produk (Admin)</h1>
        <p class="text-muted mb-0">Masukkan data produk dan unggah gambar.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 18px; overflow:hidden;">
        <div class="card-body" style="background: #0b1220; color: #fff;">
            <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="nama_produk" class="form-label text-white-50">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="{{ old('nama_produk') }}" required>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label text-white-50">Harga</label>
                    <input type="number" name="harga" id="harga" class="form-control" value="{{ old('harga') }}" required min="0">
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label text-white-50">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label text-white-50">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control" value="{{ old('stok') }}" required min="0">
                </div>

                <div class="mb-4">
                    <label for="gambar" class="form-label text-white-50">Gambar Produk</label>
                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" required>
                    <div class="form-text text-white-50">Format: jpg, jpeg, png, webp, avif (max 5MB)</div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-warning rounded-3 fw-semibold">Simpan</button>
                    <a href="{{ route('admin.home') }}" class="btn btn-outline-light rounded-3 fw-semibold">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

