git# TODO

- [x] Verifikasi & sesuaikan filter “Pesanan Berjalan” di `KasirController@index` hanya status `menunggu` dan `diproses`.
- [x] Tambah route `GET /kasir/cetak-struk/{id}` dan handler `KasirController@cetakStruk` + view `resources/views/kasir/cetak_struk.blade.php` (style thermal + auto print).

- [x] Tambah route `GET /kasir/riwayat` dan handler `KasirController@riwayat` + view `resources/views/kasir/riwayat.blade.php` (tabel selesai/batal + widget total pendapatan hari ini).

- [x] Update `resources/views/kasir/home.blade.php` agar tombol “Cetak Struk”:

  - [ ] Menggunakan tombol per baris transaksi menuju `kasir.cetak-struk`.
  - [ ] Tombol sidebar “Cetak Struk” diarahkan ke `kasir.riwayat`.
- [x] Jalankan `php artisan route:clear` dan `php artisan view:clear`.

- [x] Jalankan basic test: `php artisan` tidak error (minimal: composer/autoload sudah benar).


