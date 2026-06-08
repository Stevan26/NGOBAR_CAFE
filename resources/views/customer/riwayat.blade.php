@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Riwayat Pemesanan</h1>
                <p class="text-muted mb-0">Daftar pesanan yang pernah kamu buat.</p>
            </div>
            <a href="{{ route('produk') }}" class="btn btn-outline-secondary">Lanjutkan Belanja</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-4 shadow-sm">{{ session('success') }}</div>
        @endif

        @if ($pemesanans->isEmpty())
            <div class="alert alert-light rounded-4 shadow-sm py-4 text-center">
                <div class="fs-1">🧾</div>
                <h4 class="mt-3">Belum ada pesanan</h4>
                <p class="mb-0 text-muted">Buat pesanan dari keranjang terlebih dahulu.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-borderless align-middle">
                    <thead class="text-muted border-bottom">
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemesanans as $p)
                            <tr class="border-bottom">
                                <td class="py-3">#{{ $p->id }}</td>
                                <td class="py-3">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-3">
                                    <span class="badge rounded-pill {{ $p->status === 'selesai' ? 'bg-success' : ($p->status === 'dibatalkan' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="text-end py-3"><strong>Rp{{ number_format($p->total, 0, ',', '.') }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

