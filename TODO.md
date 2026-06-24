# TODO - Ngobar Cafe (Customer Flow Overhaul)

## Status
- [x] Auth customer: register sukses -> redirect ke login customer + flash message
- [x] Auth customer: login sukses -> redirect ke `route('home')`
- [x] ProdukController::keranjangStore: simpan item ke tabel `keranjangs` (bukan membuat Pemesanan langsung)
- [x] ProdukController::riwayat: tampilkan semua status (menunggu, diproses, selesai, dibatalkan)
- [x] resources/views/customer/keranjang.blade.php: dark mode Bootstrap rapi
- [ ] (Opsional) Pastikan modal produk memiliki elemen tambah/kurang (sesuai requirement). Saat ini qty via input number + realtime total + disable saat stok tidak cukup.
- [ ] Verifikasi bahwa route `login` dan flash message benar-benar ter-render di view login customer.
- [ ] Smoke test flow: register -> login -> buka produk (publik) -> tambah ke keranjang -> checkout -> riwayat menampilkan semua status.

