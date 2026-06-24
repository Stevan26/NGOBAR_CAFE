@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1" style="letter-spacing: .2px;">Menu Produk</h1>
                <p class="text-muted mb-0">Pilih kopi favoritmu dan nikmati rasanya.</p>
            </div>

            <div class="d-flex gap-2">
                <div class="input-group" style="max-width: 360px;">
                    <span class="input-group-text bg-white">🔎</span>
                    <input type="text" id="produkSearch" class="form-control" placeholder="Cari produk...">
                </div>
            </div>
        </div>

        <div class="row g-4" id="produkGrid">
            @forelse($data_produk as $produk)
                @php
                    $gambar = $produk->gambar;

                    // Deteksi sumber gambar dari nilai kolom `gambar`.
                    // - Jika kolom berisi path yang mengandung `storage/` => gunakan asset('storage/...')
                    // - Jika kolom berisi hanya nama file (mis. latte.jpg) => gunakan asset('image/...') sesuai folder public/image
                    // - Jika kosong => placeholder
                    if (!empty($gambar)) {
                        $gambar = trim($gambar);

                        if (str_contains($gambar, 'storage/')) {
                            $imgUrl = asset($gambar); // mis. storage/produk/xxx.jpg
                        } elseif (str_contains($gambar, 'image/')) {
                            // mis. image/latte.jpg
                            $imgUrl = asset($gambar);
                        } else {
                            // anggap nama file relatif di folder public/image
                            $imgUrl = asset('image/' . ltrim($gambar, '/'));
                        }
                    } else {
                        $imgUrl = asset('image/placeholder.jpg');
                    }
                @endphp

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm"
                        style="border-radius: 18px; overflow: hidden; background: #0b1220;">
                        <div class="position-relative"
                            style="height: 190px; background: radial-gradient(circle at top, rgba(255,193,7,.25), transparent 55%), #0b1220;">
                            <img src="{{ $imgUrl }}" class="w-100 h-100"
                                style="object-fit: cover; transform: scale(1.01);" alt="{{ $produk->nama_produk }}"
                                loading="lazy"
                                onerror="this.onerror=null; this.src='{{ asset('image/placeholder.jpg') }}'; this.style.objectFit='cover';">

                            <div class="position-absolute top-0 start-0 p-2">
                                <span class="badge text-bg-warning rounded-pill" style="font-size: .78rem;">
                                    {{ $produk->stok > 0 ? 'Ready' : 'Habis' }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 16px 16px 14px;">
                            <h5 class="card-title text-white fw-bold mb-2" style="min-height: 44px;">
                                {{ $produk->nama_produk }}
                            </h5>

                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-white-50" style="font-size: .9rem;">Stok</span>
                                <span class="text-warning fw-semibold" style="font-size: .95rem;">{{ $produk->stok }}</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="text-white-50" style="font-size: .9rem;">Harga</span>
                                <span class="text-white fw-bold" style="font-size: 1.1rem;">
                                    Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                </span>
                            </div>

                            @if (!empty($produk->deskripsi))
                                <p class="text-white-50 mb-3"
                                    style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $produk->deskripsi }}
                                </p>
                            @endif

                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-light w-100" style="border-radius: 12px;"
                                    onclick="return false;">
                                    Detail
                                </a>
                                <button type="button" class="btn btn-warning w-100 beli-btn" style="border-radius: 12px;"
                                    {{ $produk->stok <= 0 ? 'disabled' : '' }} data-produk-id="{{ $produk->id }}"
                                    data-produk-stok="{{ $produk->stok }}" data-produk-harga="{{ $produk->harga }}">
                                    Beli
                                </button>

                                <div class="modal fade" id="orderModal-{{ $produk->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content" style="border-radius: 16px;">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Pemesanan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <div>
                                                        <div class="fw-semibold">{{ $produk->nama_produk }}</div>
                                                        <div class="text-muted small">Stok: {{ $produk->stok }}</div>
                                                    </div>
                                                    <div class="text-warning fw-bold">
                                                        Rp{{ number_format($produk->harga, 0, ',', '.') }} / pcs
                                                    </div>
                                                </div>

                                                <form action="{{ route('keranjang.store') }}" method="post"
                                                    class="mt-3">
                                                    @csrf
                                                    <input type="hidden" name="produk_id" value="{{ $produk->id }}" />

                                                    <label class="form-label mb-1">Jumlah (qty)</label>
                                                    <input type="number" name="qty" value="1" min="1"
                                                        class="form-control qty-input"
                                                        {{ $produk->stok <= 0 ? 'disabled' : '' }} />

                                                    <div class="d-flex align-items-center justify-content-between mt-3">
                                                        <span class="text-muted small">Total bayar</span>
                                                        <span class="text-warning fw-bold"
                                                            data-total-bayar-for="{{ $produk->id }}">Rp{{ number_format($produk->harga * 1, 0, ',', '.') }}</span>
                                                    </div>

                                                    <div class="text-muted small mt-2">
                                                        Jika stok habis, sistem akan menolak pembelian.
                                                    </div>

                                                    <div class="modal-footer" style="padding-left:0; padding-right:0;">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-warning"
                                                            style="border-radius: 12px;"
                                                            {{ $produk->stok <= 0 ? 'disabled' : '' }}>
                                                            Konfirmasi Beli
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light shadow-sm" style="border-radius: 16px;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="fs-3">☕</div>
                            <div>
                                <h5 class="mb-1">Produk belum tersedia</h5>
                                <p class="text-muted mb-0">Belum ada data produk di database.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        (function() {
            const input = document.getElementById('produkSearch');
            const cols = document.querySelectorAll('#produkGrid .col-12');
            if (!input) return;

            input.addEventListener('input', function() {
                const q = this.value.trim().toLowerCase();
                cols.forEach((col) => {
                    const text = col.innerText.toLowerCase();
                    col.style.display = text.includes(q) ? '' : 'none';
                });
            });
        })();

        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.beli-btn');

            function formatRupiah(n) {
                try {
                    return 'Rp' + new Intl.NumberFormat('id-ID', {
                        maximumFractionDigits: 0
                    }).format(n);
                } catch (e) {
                    return 'Rp' + n.toString();
                }
            }

            buttons.forEach((btn) => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-produk-id');
                    const modalEl = document.getElementById('orderModal-' + id);
                    if (!modalEl) return;

                    const qtyInput = modalEl.querySelector('input[name="qty"]');
                    const stok = parseInt(this.getAttribute('data-produk-stok') || '0', 10);
                    const harga = parseInt(this.getAttribute('data-produk-harga') || '0', 10);

                    const totalEl = modalEl.querySelector('[data-total-bayar-for="' + id + '"]');

                    function recalcTotal() {
                        if (!qtyInput || !totalEl) return;
                        const qty = parseInt(qtyInput.value || '1', 10);
                        const safeQty = qty > 0 ? qty : 1;
                        const total = harga * safeQty; // total bayar responsif terhadap qty
                        totalEl.textContent = formatRupiah(total);
                    }

                    if (qtyInput) {
                        qtyInput.max = stok > 0 ? stok : 1;
                        if (qtyInput.value < 1) qtyInput.value = 1;

                        const confirmBtn = modalEl.querySelector('button[type="submit"]');
                        let warnEl = modalEl.querySelector('[data-stock-warning-for="' + id + '"]');
                        if (!warnEl) {
                            warnEl = document.createElement('div');
                            warnEl.setAttribute('data-stock-warning-for', id);
                            warnEl.className = 'text-danger fw-semibold small mt-2';
                            // sisipkan setelah total
                            if (totalEl && totalEl.parentElement) {
                                totalEl.parentElement.parentElement.appendChild(warnEl);
                            } else {
                                modalEl.querySelector('.modal-body').appendChild(warnEl);
                            }
                        }

                        function recalcTotalAndValidate() {
                            if (!qtyInput || !totalEl) return;
                            let qty = parseInt(qtyInput.value || '1', 10);
                            if (Number.isNaN(qty) || qty < 1) qty = 1;

                            const hargaAngka = Number(harga) || 0;
                            const stokAngka = Number(stok) || 0;
                            const total = hargaAngka * qty;

                            totalEl.textContent = formatRupiah(total);

                            // Validasi stok
                            if (qty > stokAngka) {
                                if (confirmBtn) confirmBtn.disabled = true;
                                if (warnEl) {
                                    warnEl.textContent = 'Stok tidak mencukupi. Maksimum: ' + stokAngka + ' pcs.';
                                    warnEl.style.display = '';
                                }
                            } else {
                                if (confirmBtn) {
                                    // Konfirmasi bisa enabled bila stok produk tersedia
                                    confirmBtn.disabled = !(stokAngka > 0);
                                }
                                if (warnEl) {
                                    warnEl.textContent = '';
                                    warnEl.style.display = 'none';
                                }
                            }
                        }

                        // trigger ulang setiap perubahan qty
                        qtyInput.addEventListener('input', recalcTotalAndValidate);
                        qtyInput.addEventListener('change', recalcTotalAndValidate);

                        // initial
                        recalcTotalAndValidate();
                    }

                    if (window.bootstrap && window.bootstrap.Modal) {
                        new window.bootstrap.Modal(modalEl).show();
                    }
                });
            });
        });
    </script>
@endsection
