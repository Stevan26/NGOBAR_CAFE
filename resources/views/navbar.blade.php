  <!-- ======fixed-top== untuk memebuat navabar selalu kelihatan di atas tetapi menimpa kata pertama paragaraf===== -->

  <!-- ======sticky-top== untuk memebuat navabar selalu kelihatan di atas namun tidak menimpa kaata pertama pargaraf===== -->
  <nav class="navbar navbar-expand-lg bg-dark navbar-dark sticky-top">
      <div class="container-fluid">
          <a class="navbar-brand" href="http://google.com">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-shop"
                  viewBox="0 0 16 16">
                  <path
                      d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
              </svg>
          </a>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
              aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>


          <!-- me(margin end) == membuat margin dari ujung yang ditentukan -->
          <!-- ms(margin start)== membuat margin dari awal  -->
          <!-- ms-auto== membuat margin start mentok sampai ke kanan -->
          <!-- mx == memnbuat margin kiri dan kanan -->
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mb-2 mb-lg-0">
                  <li class="nav-item mx-3">
                      <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" aria-current="page"
                          href="{{ route('home') }}">Home</a>
                  </li>
                  <li class="nav-item mx-3">
                      <a class="nav-link {{ request()->routeIs('produk') ? 'active' : '' }}"
                          href="{{ route('produk') }}">Product</a>
                  </li>

                  <li class="nav-item mx-3">
                      <a class="nav-link {{ request()->routeIs('keranjang') || request()->routeIs('keranjang.*') ? 'active' : '' }}"
                          href="{{ route('keranjang') }}">keranjang</a>
                  </li>


                  <li class="nav-item mx-3">
                      <a class="nav-link {{ request()->routeIs('riwayat') ? 'active' : '' }}"
                          href="{{ route('riwayat') }}">Riwayat Pesanan</a>
                  </li>
              </ul>
              <div class="d-flex ms-auto align-items-center">

    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
    <button class="btn btn-outline-success me-2" type="button">Search</button>

    @auth
        <span class="navbar-text text-white me-2">
            {{ Auth::user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button class="btn btn-outline-light" type="submit">
                Logout
            </button>
        </form>
    @else
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle me-2"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                Login
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('login.admin') }}">
                        <i class="bi bi-person-gear me-2"></i>
                        Login Admin
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" href="{{ route('login.kasir') }}">
                        <i class="bi bi-cash-coin me-2"></i>
                        Login Kasir
                    </a>
                </li>
            </ul>
        </div>
    @endauth

</div>

          </div>
      </div>
  </nav>
