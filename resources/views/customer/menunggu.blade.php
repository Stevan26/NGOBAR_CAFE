@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div
            class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Menunggu Proses Pesanan</h1>
                <p class="text-muted mb-0">Halaman ini akan berubah saat kasir menyelesaikan pesanan kamu.</p>
            </div>
            <a href="{{ route('riwayat') }}" class="btn btn-outline-secondary">Lihat Riwayat</a>
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
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-4 d-flex align-items-center justify-content-center"
                                style="width:52px; height:52px; background: rgba(255,193,7,.12); border: 1px solid rgba(255,193,7,.35);">
                                <i class="bi bi-hourglass-split" style="font-size:1.4rem; color:#ffc107"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="h5 fw-bold mb-1">Status Pesanan</h3>
                                <div id="statusText" class="text-muted" style="font-size:1.02rem;">Memuat status...</div>
                                <div id="progressNote" class="text-muted mt-2" style="font-size:.92rem;">
                                    Mohon tunggu sebentar.
                                </div>
                            </div>
                        </div>

                        <hr class="my-4" />

                        <div id="thankYouWrap" class="d-none">
                            <div class="alert alert-success rounded-4 shadow-sm mb-0" role="alert">
                                <div class="fw-bold">Permintaan anda telah disetujui</div>
                                <div class="text-muted">Pesanan kamu sedang diproses oleh kasir.</div>
                            </div>
                        </div>

                        <div id="waitingWrap" class="mt-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-muted" style="font-size:.92rem;">Mohon tunggu sebentar...
                                </div>
                                <div id="lastUpdated" class="text-muted" style="font-size:.92rem;">-</div>
                            </div>
                            <div class="progress mt-2" style="height:10px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                    role="progressbar" style="width: 50%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold mb-3"><i class="bi bi-receipt me-2 text-warning"></i>Detail Singkat</h3>
                        <div class="d-flex justify-content-between">
                            <div class="text-muted">ID Pesanan</div>
                            <div class="fw-semibold">#{{ $pemesanan->id }}</div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div class="text-muted">Total</div>
                            <div class="fw-semibold">Rp{{ number_format((int) ($pemesanan->total ?? 0), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div class="text-muted">Status terakhir</div>
                            <div class="fw-semibold" id="statusBadge">{{ $pemesanan->status }}</div>
                        </div>

                        <div class="alert alert-light mt-4 mb-0">
                            <div class="fw-semibold">Catatan</div>
                            <div class="text-muted" style="font-size:.92rem;">
                                Saat kasir mengubah status menjadi <strong>diproses</strong>, halaman ini akan berubah
                                otomatis.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const statusUrl = '{{ route('customer.pemesanan.status', $pemesanan->id) }}';

            const statusText = document.getElementById('statusText');
            const statusBadge = document.getElementById('statusBadge');
            const lastUpdated = document.getElementById('lastUpdated');
            const thankYouWrap = document.getElementById('thankYouWrap');
            const waitingWrap = document.getElementById('waitingWrap');

            function setUpdated() {
                try {
                    lastUpdated.textContent = new Date().toLocaleTimeString('id-ID');
                } catch (e) {
                    lastUpdated.textContent = '-';
                }
            }

            function showThankYou() {
                if (!thankYouWrap) return;
                thankYouWrap.classList.remove('d-none');
                if (waitingWrap) waitingWrap.classList.add('d-none');
            }

            async function poll() {
                try {
                    const res = await fetch(statusUrl, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        cache: 'no-store'
                    });

                    if (!res.ok) return true;
                    const data = await res.json();

                    const status = data.status || '-';
                    if (statusText) statusText.textContent = 'Status saat ini: ' + status;
                    if (statusBadge) statusBadge.textContent = status;

                    setUpdated();

                    if (status === 'diproses') {
                        // sesuai permintaan: ketika kasir sudah "memproses" maka tampilkan persetujuan
                        showThankYou();
                        return false; // stop polling
                    }
                } catch (e) {
                    // ignore
                }

                return true;
            }

            let timer = setInterval(async () => {
                const keep = await poll();
                if (!keep && timer) {
                    clearInterval(timer);
                }
            }, 3000);

            // initial poll
            poll();
        })();
    </script>
@endsection
