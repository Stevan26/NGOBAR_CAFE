# TODO - Refactor Multi-Role (Admin/Kasir/Customer)

- [ ] Cek/mastikan blade role yang diminta ada:
  - [x] resources/views/admin/dashboard.blade.php (buat bila belum ada)
  - [x] resources/views/kasir/detail-pesanan.blade.php (buat bila belum ada)

- [x] Refactor `routes/web.php`:

  - [ ] Public routes tetap di luar auth
  - [ ] Customer routes dibungkus `auth` + `role.customer`
  - [ ] KHUSUS: `keranjang` (GET + actions POST/PATCH/DELETE) wajib masuk grup customer auth
  - [ ] Admin routes dibungkus `auth` + `role.admin`
  - [ ] Kasir routes dibungkus `auth` + `role.kasir`
  - [ ] Pastikan route name tidak rusak
  - [ ] Pastikan semua view path memakai dot-notation bila ada `return view()` langsung
- [x] Koreksi controller jika ada `return view()` yang masih mengarah ke path lama
- [ ] Testing cepat:
  - [x] `php artisan route:list`
  - [x] `php artisan view:clear`
  - [ ] Manual check akses role sesuai requirement



