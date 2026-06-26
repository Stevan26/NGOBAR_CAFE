@extends('layouts.app')

@section('content')
    <div class="container-fluid px-3 px-md-4 py-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="rounded-4 shadow-sm p-3 p-md-4 bg-white border-0">
                    <div
                        class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                        <div>
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                                style="background: rgba(255,193,7,.12); border: 1px solid rgba(255,193,7,.35);">
                                <i class="bi bi-clipboard-check" style="color:#ffc107"></i>
                                <span class="fw-semibold" style="color:#ffe8a3">Riwayat Kasir</span>
                            </div>
                            <h1 class="mt-3 mb-1" style="letter-spacing:.2px;">Riwayat Transaksi</h1>
                            <p class="text-muted mb-0">Menampilkan transaksi selesai & batal.</p>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('kasir.home') }}" class="btn btn-dark rounded-pill fw-semibold px-4">
                                <i class="bi bi-arrow-left me-2"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="rounded-4 bg-white border-0 shadow-sm p-3 p-md-4">
                    <div class="row g-3 align-items-stretch">
                        <div class="col-12 col-lg-4">
                            <div class="p-3 rounded-4 h-100"
                                style="background: rgba(40,167,69,.08); border:1px solid rgba(40,167,69,.25);">
                                <div class="text-muted" style="font-size:.9rem;">Total Pendapatan Kasir Hari Ini</div>
                                <div class="fw-bold" style="font-size:1.8rem;">
                                    Rp{{ number_format((int) $totalPendapatanHariIni, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8">
                            <div class="p-3 rounded-4 h-100"
                                style="background: rgba(0,0,0,.02); border:1px solid rgba(0,0,0,.06);">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="fw-semibold">Ringkasan</div>
                                        <div class="text-muted" style="font-size:.93rem;">
                                            Total transaksi yang ditampilkan: <strong>{{ $pemesanans->count() }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4" />

                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 90px;">ID</th>
                                    <th>Pelanggan</th>
                                    <th style="width: 180px;">Tanggal</th>
                                    <th style="width: 180px;" class="text-end">Total</th>
                                    <th style="width: 160px;">Status</th>
                                    <th style="width: 160px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pemesanans as $p)
                                    <tr>
                                        <td class="text-muted">#{{ $p->id }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $p->user?->name ?? 'User #' . $p->user_id }}</div>
                                            <div class="text-muted small">{{ $p->user_id }}</div>
                                        </td>
                                        <td class="text-muted small">{{ $p->created_at?->format('d/m/Y H:i') }}</td>
                                        <td class="text-end">
                                            <div class="fw-bold">Rp{{ number_format((int) $p->total, 0, ',', '.') }}</div>
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = match ($p->status) {
                                                    'selesai' => 'text-bg-success',
                                                    'dibatalkan' => 'text-bg-danger',
                                                    default => 'text-bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge rounded-pill {{ $badgeClass }}">{{ $p->status }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('kasir.cetak-struk', $p->id) }}"
                                                class="btn btn-sm btn-outline-warning rounded-pill fw-semibold">
                                                <i class="bi bi-printer me-1"></i>
                                                Cetak
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="alert alert-light rounded-4 shadow-sm" role="alert">
                                                <div class="fw-semibold">Belum ada riwayat</div>
                                                <div class="text-muted" style="font-size:.93rem;">Transaksi selesai atau batal akan muncul di sini.</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

