@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div
            class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Riwayat Pemesanan</h1>
                <p class="text-muted mb-0">Kelola & konfirmasi berdasarkan stok produk.</p>
            </div>

            <div class="d-flex gap-2">
                <form method="POST" action="{{ route('admin.pemesanan.konfirmasi_stok_habis') }}">
                    @csrf
                    <button class="btn btn-outline-danger rounded-3 fw-semibold" type="submit"
                        onclick="return confirm('Batalkan pesanan yang tidak bisa dipenuhi karena stok habis?')">
                        <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Stok Habis
                    </button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-4 shadow-sm">{{ session('success') }}</div>
        @endif

        @if ($pemesanans->isEmpty())
            <div class="alert alert-light rounded-4 shadow-sm py-5 text-center">
                <div class="fs-1">🧾</div>
                <h4 class="mt-3 mb-0">Belum ada pesanan</h4>
                <p class="mb-0 text-muted">Pesanan akan muncul di sini setelah checkout.</p>
            </div>
        @else
            @foreach ($pemesanans as $p)
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div
                            class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-3">
                            <div>
                                <div class="fw-bold">#{{ $p->id }} <span class="text-muted fw-normal">•
                                        {{ $p->created_at->format('d/m/Y H:i') }}</span></div>
                                <div class="text-muted" style="font-size:.95rem;">User ID: {{ $p->user_id }} • Status saat
                                    ini: <span class="fw-semibold">{{ $p->status }}</span></div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span
                                    class="badge rounded-pill {{ $p->status === 'selesai' ? 'text-bg-success' : ($p->status === 'dibatalkan' ? 'text-bg-danger' : 'text-bg-warning text-dark') }}">
                                    {{ $p->status }}
                                </span>
                                <div class="fw-bold">Total: Rp{{ number_format((int) $p->total, 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th style="width:90px;" class="text-end">Qty</th>
                                        <th style="width:150px;">Harga saat pesan</th>
                                        <th style="width:160px;" class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($p->items as $it)
                                        <tr>
                                            <td class="fw-semibold">
                                                {{ $it->produk?->nama_produk ?? 'Produk tidak ditemukan' }}</td>
                                            <td class="text-end">{{ (int) $it->qty }}</td>
                                            <td>Rp{{ number_format((int) $it->harga_saat_pesan, 0, ',', '.') }}</td>
                                            <td class="text-end">Rp{{ number_format((int) $it->subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
