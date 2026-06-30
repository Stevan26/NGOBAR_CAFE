@extends('layouts.app')

@section('content')
    <div class="container-fluid banner">
        <div class="container banner-content col-lg-6">
            <div class="text-center">
                <p class="fs-1">Selamat Datang di NgoBar</p>
                <p class="d-none d-sm-block">
                    Selamat datang di website kami, tempat di mana rasa bertemu dengan selera. Jelajahi menu kami dan temukan
                    keajaiban rasa yang akan memanjakan lidah Anda. Terima kasih telah memilih NgoBar sebagai tujuan coffe anda!
                </p>

                

                <a href="{{ route('produk') }}" class="btn btn-warning mt-3">Lihat Menu</a>
                <br>
            </div>
        </div>
    </div>

    <!-- Informasi Singkat -->
    <div class="my-5 container col-6">
        <h2 class="text-center mb-5">Kenapa Harus Belanja di Kami?</h2>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        Harga Terjangkau
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Produk kami menawarkan berbagai menu terbaik dengan harga yang terjangkau.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                        aria-expanded="false" aria-controls="collapseTwo">
                        Kualitas Terbaik
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Toko kami memiliki barista berpengalaman dengan kualitas bahan yang baik.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                        aria-expanded="false" aria-controls="collapseThree">
                        Pelayanan Terbaik
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Kami siap membantu dari awal pemesanan sampai pesanan selesai.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                        aria-expanded="false" aria-controls="collapseFour">
                        Promo Terbaik
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Nikmati promo menarik dari kami.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel (placeholder) -->
    <div class="container-fluid carousel-content bg-dark py-5">
        <div class="container">
            <h2 class="text-center mb-5 text-white">Produk Andalan Kami</h2>

            <div id="carouselExampleIndicators" class="carousel slide col-lg-8 offset-lg-2">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true"
                        aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('image/americano.webp') }}" class="d-block w-100" alt="Americano">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Kopi Americano</h5>
                            <p>Rasa klasik yang nikmat.</p>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="{{ asset('image/latte.jpg') }}" class="d-block w-100" alt="Latte">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Coffee Latte</h5>
                            <p>Perpaduan espresso dan susu.</p>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="{{ asset('image/matcha.webp') }}" class="d-block w-100" alt="Matcha">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Matcha Latte</h5>
                            <p>Segar dan menenangkan.</p>
                        </div>
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
@endsection

