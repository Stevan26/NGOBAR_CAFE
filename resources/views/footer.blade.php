<footer class="bg-dark text-white pt-5 pb-3 mt-5">

    <div class="container">

        <div class="row">

            <div class="col-md-4 mb-4">
                <h3 class="fw-bold">NgopiBareng(NgoBar)</h3>
                <p class="text-light">
                    Tempat nongkrong modern dengan kopi terbaik,
                    dan suasana nyaman untuk anak muda.
                </p>
            </div>

            <div class="col-md-2 mb-4">
                <h5 class="fw-bold mb-3">Menu</h5>
                <ul class="list-unstyled">
                    <li>
                        <a href="{{ route('home') }}" class="text-decoration-none text-light">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('produk') }}" class="text-decoration-none text-light">Produk</a>
                    </li>
                    <li>
                        <a href="{{ route('keranjang') }}" class="text-decoration-none text-light">Keranjang</a>
                    </li>
                    <li>
                        @auth
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.home') }}" class="text-decoration-none text-light">Dashboard Admin</a>
                            @elseif (auth()->user()->isKasir())
                                <a href="{{ route('kasir.home') }}" class="text-decoration-none text-light">Dashboard Kasir</a>
                            @else
                                <a href="{{ route('riwayat') }}" class="text-decoration-none text-light">Riwayat Pesanan</a>
                            @endif
                        @else
                            <a href="{{ route('login.kasir') }}" class="text-decoration-none text-light">Login</a>
                        @endauth
                    </li>
                </ul>
            </div>

            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Kontak</h5>
                <p>📍 Medan, Indonesia</p>
                <p>📞 +62 812-6015-4550</p>
                <p>✉ Ngobar@gmail.com</p>
            </div>

            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Follow Us</h5>
                <div class="d-flex gap-3">
                    <a href="#" class="text-light fs-4"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-light fs-4"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-light fs-4"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-light fs-4"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>

        </div>

        <hr class="border-light">

        <div class="text-center">
            <p class="mb-0">© 2026 NgopiBareng(NgoBar). All Rights Reserved.</p>
        </div>

    </div>

</footer>

