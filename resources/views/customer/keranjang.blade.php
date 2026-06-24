@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Keranjang Belanja</h1>
                <p class="text-muted mb-0">Periksa pesananmu sebelum melakukan checkout.</p>
            </div>
            <a href="{{ route('produk') }}" class="btn btn-outline-light">Lanjutkan Belanja</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-4 shadow-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger rounded-4 shadow-sm">{{ session('error') }}</div>
        @endif

        @if ($keranjang->isEmpty())
            <div class="alert alert-dark rounded-4 shadow-sm py-4 text-center" style="border:1px solid rgba(255,255,255,.08)">
                <div class="fs-1">🛒</div>
                <h4 class="mt-3">Keranjang kosong</h4>
                <p class="mb-0 text-muted">Tambahkan produk terlebih dahulu untuk dapat melihat ringkasannya di sini.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle" style="color:#e9ecef; background:transparent;">
                    <thead style="border-bottom: 1px solid rgba(255,255,255,.15)">
                        <tr class="text-muted">
                            <th>Produk</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($keranjang as $item)
                            <tr style="border-bottom: 1px solid rgba(255,255,255,.08)">
                                <td class="py-3">
                                    <strong class="text-white">{{ $item->produk?->nama_produk ?? 'Produk tidak ditemukan' }}</strong>
                                    <div class="text-muted small">Stok: {{ $item->produk?->stok ?? '-' }}</div>
                                </td>
                                <td class="text-end py-3">Rp{{ number_format($item->produk?->harga ?? 0, 0, ',', '.') }}</td>
                                <td class="text-center py-3" style="min-width: 170px;">
                                    <form action="{{ route('keranjang.update', $item) }}" method="post"
                                        class="d-flex gap-2 justify-content-center align-items-center">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="qty" value="{{ $item->qty }}" min="1"
                                            class="form-control form-control-sm text-center" style="max-width: 90px; background: rgba(255,255,255,.04); color:#e9ecef; border:1px solid rgba(255,255,255,.12)" />
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                    </form>
                                </td>
                                <td class="text-end py-3">Rp{{ number_format($item->sub_total, 0, ',', '.') }}</td>
                                <td class="py-3 text-end">
                                    <form action="{{ route('keranjang.destroy', $item) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-end gap-3 mt-4">
                <div class="card rounded-4 shadow-sm p-4" style="min-width: 320px; background:#0b1220; border:1px solid rgba(255,255,255,.08)">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total</span>
                        <strong class="text-warning">
                            Rp{{ number_format($keranjang->sum(fn($i) => $i->sub_total), 0, ',', '.') }}
                        </strong>
                    </div>

                    <form method="POST" action="{{ route('checkout') }}">
                        @csrf
                        <button class="btn btn-warning w-100" type="submit">Checkout</button>
                    </form>

                    <div class="text-muted small mt-3">
                        Checkout akan membuat pesanan dan mengurangi stok.
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection


