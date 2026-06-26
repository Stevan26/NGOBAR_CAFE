<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Struk Kasir #{{ $pemesanan->id }}</title>

    <style>
        @media print {
            @page {
                size: 58mm auto;
                margin: 0;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        body {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New",
                monospace;
            color: #000;
            background: #fff;
            padding: 10px 12px;
            max-width: 58mm;
        }

        .center {
            text-align: center;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .hr {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .small {
            font-size: 12px;
        }

        .bold {
            font-weight: 700;
        }

        .items {
            margin-top: 6px;
        }

        .items .line {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 12px;
            margin: 2px 0;
        }

        .items .name {
            flex: 1;
            word-break: break-word;
        }

        .items .meta {
            white-space: nowrap;
        }

        .footer {
            margin-top: 10px;
            font-size: 11.5px;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="center">
        <div class="bold" style="font-size:16px;">Ngobar Cafe</div>
        <div class="small">JL. Contoh No. 1</div>
        <div class="small">Telp: 08xxxxxxxx</div>
        <div class="hr"></div>

        <div class="small">Struk Kasir</div>
        <div class="bold">#{{ $pemesanan->id }}</div>
        <div class="small">{{ $pemesanan->created_at?->format('d/m/Y H:i') }}</div>
        <div class="hr"></div>

        <div class="row small">
            <div>Pelanggan</div>
            <div>{{ $pemesanan->user?->name ?? ('User #' . $pemesanan->user_id) }}</div>
        </div>
    </div>

    <div class="hr"></div>

    <div class="items">
        @foreach ($pemesanan->items as $item)
            <div class="line">
                <div class="name">
                    <div class="small" style="font-weight:700;">{{ $item->produk?->nama_produk ?? '-' }}</div>
                    <div class="small">x{{ (int) ($item->qty ?? 0) }} @ Rp{{ number_format((int) ($item->harga_saat_pesan ?? 0), 0, ',', '.') }}</div>
                </div>
                <div class="meta small">Rp{{ number_format((int) ($item->subtotal ?? ((int) ($item->harga_saat_pesan ?? 0) * (int) ($item->qty ?? 0))), 0, ',', '.') }}</div>
            </div>
        @endforeach
    </div>

    <div class="hr"></div>

    <div class="row small">
        <div>Total</div>
        <div class="bold">Rp{{ number_format((int) $pemesanan->total, 0, ',', '.') }}</div>
    </div>

    <div class="footer small">
        <div class="center">Terima kasih telah berbelanja.</div>
        <div class="center">Status: {{ $pemesanan->status }}</div>
    </div>

    {{-- Tombol agar kasir bisa kembali saat tidak print otomatis --}}
    <div class="center small" style="margin-top:10px; display:none;">
        <button onclick="window.close()">Tutup</button>
    </div>
</body>

</html>

