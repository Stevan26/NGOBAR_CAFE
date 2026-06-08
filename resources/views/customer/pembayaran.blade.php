@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Form Pemesanan & Pembayaran</h1>
                <p class="text-muted mb-0">Silakan cek ringkasan pesanan sebelum melakukan konfirmasi pembayaran.</p>
            </div>
            <a href="{{ route('keranjang') }}" class="btn btn-outline-secondary">Kembali ke Keranjang</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-4 shadow-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger rounded-4 shadow-sm">{{ session('error') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-12 col-lg-7">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-3">Ringkasan Pesanan</h4>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="text-muted">
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $it)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $it->produk?->nama_produk ?? 'Produk tidak ditemukan' }}</div>
                                                <div class="text-muted small">ID Produk: {{ $it->produk_id }}</div>
                                            </td>
                                            <td class="text-end">Rp{{ number_format($it->harga_saat_pesan ?? 0, 0, ',', '.') }}</td>
                                            <td class="text-center">{{ $it->qty }}</td>
                                            <td class="text-end"><strong>Rp{{ number_format($it->subtotal ?? 0, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-muted">Total</div>
                            <div class="fs-4 fw-bold">Rp{{ number_format($total, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-3">Pembayaran (Manual - Konfirmasi)</h4>
                        <p class="text-muted mb-4">
                            Klik tombol di bawah untuk mengirim konfirmasi pembayaran.
                            Pesanan akan masuk ke riwayat dengan status menunggu sampai admin/kasir mengonfirmasi.
                        </p>

                        <form method="POST" action="{{ route('pembayaran.konfirmasi', $pemesanan->id) }}">
                            @csrf

                            <button class="btn btn-warning w-100 py-2" type="submit">
                                Konfirmasi Pembayaran
                            </button>
                        </form>

                        <div class="mt-3">
                            <a href="{{ route('riwayat') }}" class="btn btn-outline-secondary w-100 py-2">
                                Lihat Riwayat
                            </a>
                        </div>

                        <div class="alert alert-light mt-4 mb-0">
                            <div class="fw-semibold">Status saat ini:</div>
                            <div>{{ $pemesanan->status }}</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

