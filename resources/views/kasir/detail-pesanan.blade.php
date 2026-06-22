@extends('layouts.app')

@section('content')
    <div class="container-fluid px-3 px-md-4 py-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="rounded-4 shadow-sm p-3 p-md-4 bg-white border-0">
                    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                        <div>
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                                style="background: rgba(255,193,7,.12); border: 1px solid rgba(255,193,7,.35);">
                                <i class="bi bi-receipt" style="color:#ffc107"></i>
                                <span class="fw-semibold" style="color:#ffe8a3">Detail Pesanan</span>
                            </div>
                            <h1 class="mt-3 mb-1" style="letter-spacing:.2px;">Detail & Status Pesanan</h1>
                            <p class="text-muted mb-0">Tampilkan item, total, serta kontrol status untuk kasir.</p>
                        </div>

                        @if (isset($pemesanan))
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge text-bg-primary rounded-pill px-3 py-2">
                                    Pesanan #{{ $pemesanan->id }}
                                </span>
                                <span class="badge rounded-pill {{
                                    $pemesanan->status === 'menunggu' ? 'text-bg-primary' :
                                    ($pemesanan->status === 'diproses' ? 'text-bg-warning text-dark' :
                                    ($pemesanan->status === 'selesai' ? 'text-bg-success' : 'text-bg-danger'))
                                }}">
                                    {{ $pemesanan->status }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="rounded-4 bg-white border-0 shadow-sm p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3 class="h5 mb-0"><i class="bi bi-list-check me-2 text-warning"></i>Item Pesanan</h3>
                        @if (isset($pemesanan))
                            <span class="text-muted" style="font-size:.92rem;">{{ $pemesanan->items->count() }} item</span>
                        @endif
                    </div>

                    @if (!isset($pemesanan) || $pemesanan->items->isEmpty())
                        <div class="alert alert-light rounded-4 shadow-sm" role="alert">
                            <div class="fw-semibold">Belum ada item</div>
                            <div class="text-muted" style="font-size:.93rem;">Pesanan ini kosong atau data belum tersedia.</div>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th style="width:130px;" class="text-center">Qty</th>
                                        <th style="width:180px;" class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pemesanan->items as $item)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-semibold">{{ $item->produk->nama_produk ?? '-' }}</div>
                                                <div class="text-muted small">Harga saat pesan: Rp{{ number_format((int) ($item->harga_saat_pesan ?? 0), 0, ',', '.') }}</div>
                                            </td>
                                            <td class="text-center">x{{ (int) $item->qty }}</td>
                                            <td class="text-end">Rp{{ number_format((int) ($item->subtotal ?? ((int)$item->harga_saat_pesan * (int)$item->qty)), 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <div class="card rounded-4 shadow-sm p-4" style="min-width: 320px;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Total</span>
                                    <strong class="fs-4">Rp{{ number_format((int) $pemesanan->total, 0, ',', '.') }}</strong>
                                </div>
                                <div class="text-muted" style="font-size:.93rem;">Dibuat: {{ $pemesanan->created_at?->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-lg-5">
                <div class="rounded-4 bg-white border-0 shadow-sm p-3 p-md-4 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3 class="h5 mb-0"><i class="bi bi-gear-wide-connected me-2 text-warning"></i>Kontrol Status</h3>
                    </div>

                    @if (isset($pemesanan))
                        <div class="alert alert-light rounded-4 shadow-sm">
                            <div class="fw-semibold">Transisi cepat</div>
                            <div class="text-muted" style="font-size:.93rem;">Aturan status menyesuaikan flow pesanan.</div>
                        </div>

                        @if ($pemesanan->status === 'menunggu')
                            <div class="d-grid gap-2">
                                <form method="POST" action="{{ url('kasir/pemesanan/' . $pemesanan->id . '/status') }}">
                                    @csrf
                                    <input type="hidden" name="status" value="diproses" />
                                    <button class="btn btn-warning rounded-3 fw-semibold" type="submit">Proses Pesanan</button>
                                </form>

                                <form method="POST" action="{{ url('kasir/pemesanan/' . $pemesanan->id . '/status') }}">
                                    @csrf
                                    <input type="hidden" name="status" value="dibatalkan" />
                                    <button class="btn btn-outline-danger rounded-3 fw-semibold" type="submit"
                                        onclick="return confirm('Batalkan pesanan ini?')">Batalkan</button>
                                </form>
                            </div>
                        @elseif ($pemesanan->status === 'diproses')
                            <div class="d-grid gap-2">
                                <form method="POST" action="{{ url('kasir/pemesanan/' . $pemesanan->id . '/status') }}">
                                    @csrf
                                    <input type="hidden" name="status" value="selesai" />
                                    <button class="btn btn-success rounded-3 fw-semibold" type="submit">Selesaikan</button>
                                </form>
                            </div>
                        @else
                            <div class="d-grid gap-2">
                                <button class="btn btn-secondary rounded-3 fw-semibold" type="button" disabled>
                                    Status tidak dapat diubah
                                </button>
                            </div>
                        @endif

                        <hr class="my-4" />

                        <a href="{{ route('kasir.home') }}" class="btn btn-dark rounded-3 fw-semibold w-100">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard Kasir
                        </a>
                    @else
                        <div class="alert alert-warning rounded-4 shadow-sm">
                            <div class="fw-semibold">Data pesanan belum tersedia</div>
                            <div class="text-muted" style="font-size:.93rem;">Konten ini membutuhkan variabel <code>$pemesanan</code>.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

