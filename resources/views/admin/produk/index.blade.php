@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div
            class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Kelola Produk</h1>
                <p class="text-muted mb-0">Atur stok & harga untuk setiap produk.</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.create') }}" class="btn btn-warning rounded-3 fw-semibold">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Produk
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-4 shadow-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger rounded-4 shadow-sm">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Produk</th>
                        <th style="width:130px;">Harga</th>
                        <th style="width:130px;">Stok</th>
                        <th style="width:180px;">Status</th>
                        <th style="width:240px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produks as $i => $produk)
                        @php
                            $stok = (int) ($produk->stok ?? 0);
                            $status = $stok <= 0 ? 'Habis' : 'Ready';
                        @endphp
                        <tr>
                            <td class="text-muted">{{ $i + 1 }}</td>
                            <td>
                                <div class="fw-semibold">{{ $produk->nama_produk }}</div>
                                @if (!empty($produk->gambar))
                                    <div class="text-muted" style="font-size:.9rem;">Gambar: {{ $produk->gambar }}</div>
                                @endif
                            </td>
                            <td class="fw-semibold">Rp{{ number_format((int) $produk->harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge rounded-pill {{ $stok <= 0 ? 'text-bg-danger' : 'text-bg-success' }}">
                                    {{ $stok }}
                                </span>
                            </td>
                            <td>
                                @if ($stok <= 0)
                                    <span class="text-danger fw-semibold"><i
                                            class="bi bi-x-circle me-1"></i>{{ $status }}</span>
                                @else
                                    <span class="text-success fw-semibold"><i
                                            class="bi bi-check-circle me-1"></i>{{ $status }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('admin.produk.edit', $produk) }}"
                                        class="btn btn-outline-dark btn-sm rounded-pill fw-semibold">
                                        <i class="bi bi-sliders me-2"></i>Atur Stok & Harga
                                    </a>

                                    <form method="POST" action="{{ route('admin.produk.destroy', $produk) }}"
                                        onsubmit="return confirm('Hapus produk ini? Data terkait pemesanan mungkin ikut terhapus.' )">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-outline-danger btn-sm rounded-pill fw-semibold">
                                            <i class="bi bi-trash me-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">Belum ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
