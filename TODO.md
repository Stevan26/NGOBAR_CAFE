# TODO - Middleware RLE Kasir/Admin/Customer

- [x] Buat middleware: RoleAdminMiddleware, RoleKasirMiddleware, RoleCustomerMiddleware
- [x] Daftarkan alias middleware di `bootstrap/app.php`
- [x] Refactor `routes/web.php`: gunakan `role.admin`, `role.kasir`, `role.customer` menggantikan pengecekan manual

- [x] Jalankan `php artisan route:list` untuk validasi middleware terdaftar
- [ ] Validasi manual via browser: login admin/kasir/customer dan akses route yang sesuai

