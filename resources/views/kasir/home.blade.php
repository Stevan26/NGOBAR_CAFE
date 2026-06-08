@extends('layouts.app')

@section('content')
    <div class="container-fluid px-3 px-md-4 py-4">
        <div class="row g-4">
            {{-- Header --}}
            <div class="col-12">
                <div class="rounded-4 shadow-sm p-3 p-md-4 bg-white border-0">
                    <div
                        class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                        <div>
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                                style="background: rgba(255,193,7,.12); border: 1px solid rgba(255,193,7,.35);">
                                <i class="bi bi-cash-coin" style="color:#ffc107"></i>
                                <span class="fw-semibold" style="color:#ffe8a3">Kasir Dashboard</span>
                            </div>
                            <h1 class="mt-3 mb-1" style="letter-spacing:.2px;">Halaman Kasir</h1>
                            <p class="text-muted mb-0">Kelola pesanan masuk: proses, selesai, atau batal.</p>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('kasir.home') }}" class="btn btn-dark rounded-pill fw-semibold px-4">
                                <i class="bi bi-arrow-repeat me-2"></i>
                                Refresh
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main content --}}
            <div class="col-12 col-lg-7">
                <div class="rounded-4 bg-white border-0 shadow-sm p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3 class="h5 mb-0"><i class="bi bi-clipboard-check me-2 text-warning"></i>Pesanan Berjalan</h3>
                        <span class="text-muted" style="font-size:.92rem;">Menunggu & Diproses</span>
                    </div>

                    @if ($pemesanans->isEmpty())
                        <div class="alert alert-light rounded-4 shadow-sm" role="alert">
                            <div class="fw-semibold">Belum ada pesanan</div>
                            <div class="text-muted" style="font-size:.93rem;">Pesanan akan muncul setelah customer checkout.
                            </div>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 90px;">ID</th>
                                        <th>Pelanggan</th>
                                        <th style="width: 220px;">Item</th>
                                        <th style="width: 180px;" class="text-end">Total</th>
                                        <th style="width: 160px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pemesanans as $p)
                                        <tr>
                                            <td class="text-muted">#{{ $p->id }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ $p->user?->name ?? 'User #' . $p->user_id }}
                                                </div>
                                                <div class="text-muted small">{{ $p->created_at->format('d/m/Y H:i') }}
                                                </div>
                                            </td>
                                            <td>
                                                @foreach ($p->items as $it)
                                                    <div class="d-flex justify-content-between gap-3">
                                                        <div class="fw-semibold">{{ $it->produk?->nama_produk ?? '-' }}
                                                        </div>
                                                        <div class="text-muted small">x{{ (int) $it->qty }}</div>
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td class="text-end">
                                                <div class="fw-bold">Rp{{ number_format((int) $p->total, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $badgeClass = match ($p->status) {
                                                        'menunggu' => 'text-bg-primary',
                                                        'diproses' => 'text-bg-warning text-dark',
                                                        'selesai' => 'text-bg-success',
                                                        'dibatalkan' => 'text-bg-danger',
                                                        default => 'text-bg-secondary',
                                                    };
                                                @endphp
                                                <div class="d-flex flex-column gap-2">
                                                    <span class="badge rounded-pill {{ $badgeClass }}">
                                                        {{ $p->status }}
                                                    </span>

                                                    @if ($p->status === 'menunggu')
                                                        <form method="POST"
                                                            action="{{ url('kasir/pemesanan/' . $p->id . '/status') }}">
                                                            @csrf
                                                            <input type="hidden" name="status" value="diproses" />
                                                            <button class="btn btn-sm btn-warning rounded-pill fw-semibold"
                                                                type="submit">Proses</button>
                                                        </form>

                                                        <form method="POST"
                                                            action="{{ url('kasir/pemesanan/' . $p->id . '/status') }}">
                                                            @csrf
                                                            <input type="hidden" name="status" value="dibatalkan" />
                                                            <button
                                                                class="btn btn-sm btn-outline-danger rounded-pill fw-semibold"
                                                                type="submit"
                                                                onclick="return confirm('Batal pesanan ini?')">Batal</button>
                                                        </form>
                                                    @elseif ($p->status === 'diproses')
                                                        <form method="POST"
                                                            action="{{ url('kasir/pemesanan/' . $p->id . '/status') }}">
                                                            @csrf
                                                            <input type="hidden" name="status" value="selesai" />
                                                            <button class="btn btn-sm btn-success rounded-pill fw-semibold"
                                                                type="submit">Selesai</button>
                                                        </form>
                                                    @else
                                                        <button class="btn btn-sm btn-secondary rounded-pill" type="button"
                                                            disabled>Non-aktif</button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-lg-5">
                <div class="rounded-4 bg-white border-0 shadow-sm p-3 p-md-4 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3 class="h5 mb-0"><i class="bi bi-cpu me-2 text-warning"></i>Ringkasan</h3>
                        <span class="text-muted" style="font-size:.92rem;">hari ini</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 rounded-4"
                                style="background: rgba(255,255,255,.06); border:1px solid rgba(0,0,0,.06);">
                                <div class="text-muted" style="font-size:.9rem;">Pesanan</div>
                                <div class="fw-bold" style="font-size:1.6rem;">
                                    {{ (int) ($jumlahStatus['menunggu'] + $jumlahStatus['diproses']) }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-4"
                                style="background: rgba(255,255,255,.06); border:1px solid rgba(0,0,0,.06);">
                                <div class="text-muted" style="font-size:.9rem;">Total Transaksi</div>
                                <div class="fw-bold" style="font-size:1.6rem;">Rp
                                    {{ number_format((int) $totalHariIni, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 rounded-4"
                                style="background: rgba(255,193,7,.08); border:1px solid rgba(255,193,7,.25);">
                                <div class="d-flex align-items-start gap-2">
                                    <div class="rounded-4 d-flex align-items-center justify-content-center"
                                        style="width:40px; height:40px; background: rgba(255,193,7,.18); border:1px solid rgba(255,193,7,.35);">
                                        <i class="bi bi-lightning-charge" style="color:#ffc107"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Ringkasan Status</div>
                                        <div class="text-muted" style="font-size:.93rem;">
                                            Menunggu: <strong>{{ (int) ($jumlahStatus['menunggu'] ?? 0) }}</strong> •
                                            Diproses: <strong>{{ (int) ($jumlahStatus['diproses'] ?? 0) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4" />

                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-dark rounded-3 fw-semibold" style="pointer-events:none;"
                            onclick="return false;">
                            <i class="bi bi-clock-history me-2"></i>
                            Riwayat Transaksi
                        </a>
                        <a href="#" class="btn btn-outline-warning rounded-3 fw-semibold"
                            style="pointer-events:none;" onclick="return false;">
                            <i class="bi bi-receipt-cutoff me-2"></i>
                            Cetak Struk
                        </a>
                        <a href="{{ route('kasir.home') }}" class="btn btn-dark rounded-3 fw-semibold">
                            <i class="bi bi-geo-alt me-2"></i>
                            Refresh Halaman
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
