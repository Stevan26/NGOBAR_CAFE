@extends('layouts.app')
@section('content')
    <div class="container-fluid banner">
        <div class="container banner-content col-lg-6">
            <div class="text-center">
                <!-- fs(fons size)=== class bawaan boostrap sama seperrtiu heading 1 sampai 6 -->
                <p class="fs-1">
                    Selamat Datang di NgoBar
                </p>
                <!-- d-none=== UNTUK MENYEMBUNYKKAN GAMBAR APBILA LAYAR KECIL -->
                <!-- d-sm-block === UTNUK MENAMPILKAN PARAGRAPH KETIKA  UKKURAN LAYAR MULAI DARI SMAAL -->
                <P class="d-none d-sm-block">
                    Selamat datang di website kami, tempat di mana rasa bertemu dengan selera. Jelajahi menu
                    kami dan temukan keajaiban rasa yang akan memanjakan lidah Anda. Terima kasih telah memilih NgoBar
                    sebagai tujuan coffe anda!
                </P>
                <!-- data-bs-toggle="modal" data-bs-target="#exampleModal" == untuk modal -->
                <button type="button" class="btn btn-warning mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Reservasi
                </button><br>
                <!-- BUTTON OUTLINE== DIGUNAKAN UNTUK MEMBERI GARIS TEPI PADA BUTTON, NAMUN WARNA
                     AKAN NAMPAK SAAT CURSOR DIBUAT DIATAS -->
                <a href="{{ route('produk') }}" class="btn btn-outline-primary mt-3">Lihat Menu</a><br>

            </div>
        </div>
    </div>



    <!-- ACORDION -->
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
                        Dengan membawa uang sebesar Rp 10.000 anda dapat memesan salah satu menu kami yang memiliki cita
                        rasa terbaik dengan harga yang sangat terjangkau.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Kualitas Terbaik
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Toko kami memiliki berbagai barista yang berpengalaman dalam membuat kopi
                        serta mengintegrasikan berbagai teknik yang dimiliki untuk membuat kopi
                        yang memiliki cita rasa terbaik dengan kualitas premium.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Pelayanan Terbaik
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Pegawai kami dilatih menajadi pegawai yang profesonal dalam melayani anda
                        sehingga anda akan merasa nyaman ketika berbelanja di cafe kami. Kami juga menyediakan layanan
                        pesan antar untuk memudahkan anda dalam berbelanja di cafe kami.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Promo Terbaik
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Toko kami menyediankan berbagia promo untuk anda sehingga
                        anda akan merasa puas ketika berbelanja di toko kami. Promo yang kami sediakan juga sangat
                        beragam mulai dari promo diskon hingga promo beli 1 gratis 1 untuk menu tertentu.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- AKHIR ACORDION -->



    <!-- CAROUSEL -->
    <div class="container-fluid carousel-content bg-dark py-5">
        <div class="container">
            <h2 class="text-center mb-5">Produk Andalan Kami</h2>
            <!-- OFFSET-LG-3=== MEMBUAT TIGA KOLOM DARI SAMPING KIRI DAN KANAN -->
            <!-- OFFSET BISA MENYESUAIKAN DENGAN JUMLAH KOLOM YANG SUDAH DIPAKAI -->
            <div id="carouselExampleIndicators" class="carousel slide col-lg-8 offset-lg-2">

                <!-- membuat penanda slide berapa -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <!-- =========== -->

                <div class="carousel-inner ">
                    <div class="carousel-item active">
                        <img src="{{ asset('image/americano.webp') }}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Kopi Ameriacano</h5>
                            <p>Kemurnian rasa yang jujur tanpa rahasia. Dibuat dari biji kopi pilihan untuk kamu yang
                                menghargai setiap tetes fokus dan inspirasi .</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('image/latte.jpg') }}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Coffee Latte</h5>
                            <p>Mahakarya dalam secangkir gelas. Perpaduan esensial espresso yang tangguh dan kelembutan susu
                                yang menghangatkan suasana hatimu.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('image/matcha.webp') }}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Matcha Latte</h5>
                            <p>Sisi hijau yang menenangkan hati. Sebuah pelarian sempurna dari penatnya hari, tanpa perlu
                                secangkir kopi.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    <!-- AKHIR CAOURSEL -->



    <!-- === BLOCKQUETE -->
    <div class="container-fluid py-5 bg-dark text-white">
        <div class="container ">
            <h2 class="text-center mb-5">Apa Kata Customer Kami</h2>


            <!-- Blokquete berada dalam typografi -->
            <div class="col-12  mb-3">
                <!-- ==TEXT CENTER UNTUK KETENGAH=== -->
                <!-- == TEXT-END UNTUK KE KANAN== -->
                <!-- UNTUK DI KIRI TIDAK USAH TAMBAHKAN APA-APA -->
                <!-- ==TEXT-MD-START = AKAN BERADA DI AWAL KETIKA UKURAN LAAYR MEDIUM (BERLAKU UNTUK END DAN CENTER)-->
                <figure class="text-center text-md-start">
                    <blockquote class="blockquote">
                        <p>Kopinya sangata enak dan rasanya pas di kantong.</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        Jack manurung
                    </figcaption>
                </figure>
            </div>
            <div class="col-12 mb-3">
                <figure class="text-center text-md-end">
                    <blockquote class="blockquote">
                        <p>Pelayanannya Sangat bagus.</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        boys
                    </figcaption>
                </figure>
            </div>
            <div class="col-12  mb-3">
                <figure class="text-center text-md-start">
                    <blockquote class="blockquote">
                        <p>Tempatnya bersih.</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        Oleo sinaga
                    </figcaption>
                </figure>
            </div>
            <div class="col-12  ">
                <figure class="text-center text-md-end">
                    <blockquote class="blockquote">
                        <p>Makanannya is the best.</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        Mariam Sembiring
                    </figcaption>
                </figure>
            </div>
        </div>
    </div>
    <!-- ==END BLOCKQUETE=== -->
@endsection
