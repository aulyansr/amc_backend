<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        AMC - Maintenance AC dengan Teknisi Professional
    </title>
    @if (env('APP_ENV') === 'production')
        <meta name="description"
            content="AMC bukan merupakan servis AC biasa, dan kami berkomitmen untuk memberikan anda lebih dari yang lain. Anda">
        <meta name="keywords" content="perbaikan AC, Servis AC, indonesia">
        <meta name="author" content="AMC | Aircon Management Company">

        {{-- google analytic --}}
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-RYGJYH5244"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-RYGJYH5244');
        </script>

        <!-- Open Graph Meta Tags for Social Sharing -->
        <meta property="og:title" content="AMC | Aircon Management Company">
        <meta property="og:site" content="@AMC">
        <meta property="og:site_name" content="AMC | Aircon Management Company">
        <meta property="og:description"
            content="            akan bertemu dengan teknisi yang lebih ramah dan berpengalaman, dengan fleksibilitas dan kapasitas yang anda">
        <meta property="og:image" content="{{ asset('assets/image/logo.png') }}">
        <meta property="og:url" content="https://www.acmaintenance.id">
        <meta property="og:type" content="website">

        <!-- Twitter Card Meta Tags for Social Sharing -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="amc">
        <meta name="twitter:site" content="@amc">
        <meta name="twitter:site_name" content="AMC | Aircon Management Company">
        <meta name="twitter:description" content="            butuhkan.">
        <meta name="twitter:image" content="{{ asset('assets/image/logo.png') }}">
        <meta name="twitter:creator" content="@amc">
        <!-- Canonical Link to Avoid Duplicate Content -->
        <link rel="canonical" href="https://www.acmaintenance.id/kelebihan_kami">

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="57x57" href="{{ 'assetassets/>favico/apple-icon-57x57.png' }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/favico/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/favico/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/favico/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/favico/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/favico/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/favico/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/favico/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favico/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"
            href="{{ asset('assets/favico/android-icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favico/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favico/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favico/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('assets/favico/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#0077B6">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#0077B6">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&family=Poppins:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/lnd-amc/css/main.css?v=1.0') }}">
    <link rel="stylesheet" href="{{ asset('assets/lnd-amc/css/responsive.css?v=1.0') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top" style="background-color: white;">
        <div class="container">
            <a class="navbar-brand me-0" href="{{ url('/') }}">
                <img src="{{ asset('assets/lnd-amc/image/Logo AMC Fixed 1.png') }}" alt="">
            </a>
            <div class="d-block d-md-none">
                <a href="https://wa.me/6285210632227" class="btn btn-light-blue" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25"
                        fill="none">
                        <path
                            d="M6.67974 4.29548L7.29302 3.6822C7.68354 3.29168 8.3167 3.29168 8.70723 3.6822L11.293 6.26799C11.6835 6.65852 11.6835 7.29168 11.293 7.6822L9.5006 9.47462C9.20172 9.7735 9.12762 10.2301 9.31665 10.6082C10.4094 12.7937 12.1815 14.5658 14.3671 15.6586C14.7451 15.8476 15.2017 15.7735 15.5006 15.4746L17.293 13.6822C17.6835 13.2917 18.3167 13.2917 18.7072 13.6822L21.293 16.268C21.6835 16.6585 21.6835 17.2917 21.293 17.6822L20.6797 18.2955C18.5684 20.4068 15.2258 20.6444 12.8371 18.8528L11.6287 17.9465C9.88516 16.6389 8.33634 15.0901 7.02869 13.3465L6.12239 12.1381C4.33084 9.74939 4.56839 6.40683 6.67974 4.29548Z"
                            fill="white" />
                    </svg>
                    0852-1063-2227
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav m-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link" href="#why">Kenapa Memilih Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#service">Layanan Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#subscribe">Langganan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#amc-for-business">AMC for Business</a>
                    </li>
                </ul>
                <div class="d-block">
                    <a href="https://wa.me/6285210632227" class="btn btn-main py-2 px-3 fs-5">
                        <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        0852-1063-2227
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="d-flex align-items-center position-relative" id="hero">
        <div class="container">
            <div class="hero position-relative animate__animated animate__fadeIn"
                style="background-image: url('{{ asset('assets/images/img-hero.png') }}'); ">
                <div class="row position-relative align-items-center" style="z-index: 2;height: 70vh;">
                    <div class="col-12 col-lg-8 animate__fadeInLeft">
                        <div class="mx-5">
                            <p class="text-white">Apa itu AMC ?</p>
                            <h1 class="fw-bold text-white">
                                AMC adalah perusahaan profesional yang bergerak dalam layanan
                                perawatan dan servis untuk sistem AC, dengan kantor pusat yang berlokasi di Tanjung
                                Duren
                            </h1>
                            <a href="{{ route('customer.create_order') }}"
                                class="btn btn-light-blue mb-4 py-2 px-4 fs-4">
                                Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>
                <div class="bg-hero animate__animated animate__fadeInLeft"></div>
            </div>

        </div>

    </section>


    <section class="why-us" id="why">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 text-center">
                    <h2 class="fw-bold text-main mb-5">Kenapa Memilih Kami</h2>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card-why">
                        <img src="{{ asset('assets/lnd-amc/image/star 1.png') }}"
                            alt="High Quality Service Guarantee Icon" class="mw-100 mb-3">
                        <h3 class="text-main">Garansi Pengerjaan</h3>
                        <p>Kami komitmen memberikan layanan berkualitas dan dapat dipercaya. Jika Anda tidak puas, kami
                            siap untuk memberikan layanan ulang.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card-why">
                        <img src="{{ asset('assets/lnd-amc/image/star 2.png') }}" alt="Flexible Schedule Icon"
                            class="mw-100 mb-3">
                        <h3 class="text-main">Jadwal Fleksibel</h3>
                        <p>Anda tidak lagi harus menyesuaikan jadwal anda sesuai adanya teknisi AC, karena kami akan
                            menyesuaikan dengan kebutuhan anda.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card-why">
                        <img src="{{ asset('assets/lnd-amc/image/star 3.png') }}" alt="Trained Technicians Icon"
                            class="mw-100 mb-3">
                        <h3 class="text-main">Teknisi Terlatih</h3>
                        <p>Teknisi kami telah menempuh pelatihan intensif, untuk memastikan kualitas layanan kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="technician" id="technician">
        <div class="container">
            <div class="row align-items-center ">
                <div class="col-md-4 order-sm-0 order-1">
                    <img src="{{ asset('assets/images/img-technician.png') }}" alt="amc"
                        class="mw-100 img-technician">
                </div>
                <div class="col-md-8 order-sm-1 order-0">
                    <h2 class="tech-desc">Teknisi Berpengalaman</h2>
                    <p class="tech-desc">
                        Bersama GREE, kami telah mengikuti ujian untuk meningkatkan kompetensi kami. Dalam sepuluh tahun
                        terakhir, kami telah secara konsisten memberikan jasa maintenance AC yang handal. Tim kami
                        terampil dalam menangani beragam jenis AC, termasuk split, cassette, dan central.
                    </p>
                    <div class="row g-5 mb-3 mb-lg-0 tech-desc">
                        <div class="col-auto counter">
                            <h3>15+</h3>
                            <p>Team</p>
                        </div>
                        <div class="col-auto counter">
                            <h3>30+</h3>
                            <p>Teknisi</p>
                        </div>
                        <div class="col-auto counter">
                            <h3>7+</h3>
                            <p>Kota</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="scanqr" id="scanqr">
        <div class="container">
            <h2>
                SCAN QR code <br>
                untuk memudahkan kamu
            </h2>
            <div class="row gx-0 justify-content-center d-none d-lg-flex">
                <div class="col-auto img-howto">
                    <img src="{{ asset('assets/images/scan-1.png') }}" alt="amc" class="mw-100">
                </div>
                <div class="col-auto img-howto">
                    <img src="{{ asset('assets/images/scan-2.png') }}" alt="amc" class="mw-100">
                </div>
                <div class="col-auto img-howto">
                    <img src="{{ asset('assets/images/scan-3.png') }}" alt="amc" class="mw-100">
                </div>
                <div class="col-auto img-howto">
                    <img src="{{ asset('assets/images/scan-4.png') }}" alt="amc" class="mw-100">
                </div>
                <div class="col-auto img-howto">
                    <img src="{{ asset('assets/images/scan-5.png') }}" alt="amc" class="mw-100">
                </div>

            </div>
            <div class="col-12 d-block d-lg-none">
                <img src="{{ asset('assets/images/how to.png') }}" alt="amc" class="w-100">
            </div>
        </div>
    </section>

    <section class="warranty">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <h2>Dapatkan Garansi 1 Bulan Penuh</h2>
                    <p>
                        Hanya kami yang berani memberikan garansi pencucian 1 bulan, jika AC kamu bermasalah setelah
                        pembersihan silahkan laporkan ke admin kami segera!
                    </p>
                    <a href="" class="btn btn-main">
                        Klaim Garansi Kamu Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="services">
        <h2>
            Layanan Kami
        </h2>
        <div class="row g-5">
            <div class="col-md-4">
                <div class="card card-services">
                    <img src="{{ asset('assets/images/cleaning 1.png') }}" alt="amc" class="mw-100">

                    <div class="card-body">
                        <h3>Cleaning AC</h3>
                        <p>Tingkatkan Kualitas Udara di Rumah kamu dengan Layanan Pembersihan AC Profesional!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-services">
                    <img src="{{ asset('assets/images/maintenis 1.png') }}" alt="amc" class="mw-100">

                    <div class="card-body">
                        <h3>Maintenance AC</h3>
                        <p>Dapatkan perbaikan terbaik dengan teknisi kami yang professional dan bersertifikat.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-services">
                    <img src="{{ asset('assets/images/instalasi 1.png') }}" alt="amc" class="mw-100">

                    <div class="card-body">
                        <h3>Instalasi AC</h3>
                        <p>Nikmati Udara Sejuk Tanpa Gangguan dengan Layanan Bongkar Pasang AC Kami!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="subscribe" id="subscribe">
        <div class="container">
            <div class="row justify-content-center">
                <div class="header col-12 col-md-6">
                    <h2 class="mb-2 fw-bold text-main">Subscribe Untuk Harga Terbaik</h2>
                    <p class="mb-5 text-center">
                        Kami menawarkan layanan berlangganan untuk memastikan AC tetap dingin dengan harga terbaik.
                    </p>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-md-5">
                    <div class="card card-package ">
                        <div class="card-body">
                            <h4>Paket</h4>
                            <h3>Basic</h3>
                            <p class="mb-2 fw-bold">Kamu akan Mendapat :</p>
                            <ul class="check-list">
                                <li>
                                    <p class="mb-3">
                                        Bebas Cleaning AC Sebanyak 6x dalam 1 Tahun
                                    </p>
                                </li>
                                <li>
                                    <p class="mb-3">
                                        Bebas Biaya Transport
                                    </p>
                                </li>
                                <li>
                                    <p class="mb-3">
                                        Garansi Dingin selama 1 Bulan
                                    </p>
                                </li>
                            </ul>
                            <p class="mb-3">Harga</p>
                            <div class="d-flex price">
                                <sup>Rp</sup>
                                <p>
                                    360.000
                                </p>
                            </div>
                            <a href="{{ route('customer.create_order') }}" class="btn btn-main w-100">Pesan
                                Sekarang</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card card-package selected">
                        <div class="card-body">
                            <h4>Paket</h4>
                            <h3>Premium</h3>
                            <p class="mb-2">Kamu akan Mendapat :</p>
                            <ul class="check-list">
                                <li>
                                    <p class="mb-3">
                                        Bebas Cleaning AC Sebanyak 12x dalam 1 Tahun
                                    </p>
                                </li>
                                <li>
                                    <p class="mb-3">
                                        Bebas Biaya Transport
                                    </p>
                                </li>
                                <li>
                                    <p class="mb-3">
                                        Garansi Pengerjaan selama 1 Bulan
                                    </p>
                                </li>
                                <li>
                                    <p class="mb-3">
                                        Merchandise Disetiap Pesanan
                                    </p>
                                </li>
                            </ul>
                            <p class="mb-3">Harga</p>
                            <div class="d-flex price">
                                <sup>Rp</sup>
                                <p>
                                    660.000
                                </p>
                            </div>
                            <a href="{{ route('customer.create_order') }}" class="btn btn-main w-100">Pesan
                                Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="amc-for-business position-relative" id="amc-for-business">
        <div class="container position-relative">
            <div class="row justify-content-end mb-3 mb-lg-0">
                <div class="col-md-10">
                    <img src="{{ asset('assets/images/contact-center.png') }}" alt="amc" class="w-100">
                </div>
            </div>
            <div class="row info-container ">
                <div class="col-md-7">
                    <div class="card card-amc-business">
                        <div class="card-body">
                            <div class="amc-busines-label">
                                AMC for Business
                            </div>
                            <h2>
                                Optimalkan Kinerja AC Bisnis Anda Sekarang!
                            </h2>
                            <p>
                                Dapatkan solusi AC B2B yang disesuaikan untuk meningkatkan efisiensi, kenyamanan, dan
                                produktivitas bisnis Anda. Temukan layanan perawatan, pemeliharaan, dan pemantauan
                                terbaik
                                untuk sistem HVAC Anda hari ini.
                            </p>
                            <a href="https://wa.me/6285210632227" target="_blank" class="btn btn-main mb-4">
                                Konsultasi Sekarang
                            </a>
                            <h4>
                                Our Happy Clients
                            </h4>
                            <div class="row g-3 align-items-center">
                                <div class="col col-auto">
                                    <img src="{{ asset('assets/images/logozipkos.png') }}" alt="amc"
                                        class="mw-100 m-auto">
                                </div>
                                <div class="col col-auto">
                                    <img src="{{ asset('assets/landing/images/logo-fore.png') }}" alt="amc"
                                        class="mw-100 m-auto">
                                </div>
                                <div class="col col-md-2">
                                    <img src="{{ asset('assets/landing/images/logorelax.png') }}" alt="amc"
                                        class="mw-100 m-auto">
                                </div>

                                <div class="col col-md-2">
                                    <img src="{{ asset('assets/lnd-amc/image/logoemados.png') }}" alt="amc"
                                        class="mw-100 m-auto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <div class="py-5" style="background-color: #09557F;">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-7">
                    <h3 class="fw-bold text-white">
                        Cuci AC Bergaransi, Ya AMC Yang Pasti
                    </h3>
                    <p class="text-white mb-0">Dapatkan Garansi pengerjaan selama 1 Bulan, Apabila ada pertanyaan kami
                        siap
                        membantu</p>
                </div>
                <div class="col-auto">
                    <a href="https://wa.me/6285210632227" class="btn btn-light-blue mb-4">
                        Konsultasi Sekarang
                    </a>
                </div>

            </div>

        </div>
    </div> --}}

    <footer>
        <iframe title="Lokasi AMC"
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15866.854692772391!2d106.7842532!3d-6.169082!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f7e5cbc5774d%3A0x3024d6fcc45deec2!2sPT%20Aircon%20Manajemen%20Corpora!5e0!3m2!1sen!2sid!4v1707998630833!5m2!1sen!2sid"
            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>

        <div class="container ">
            <div class="row align-items-start justify-content-between footer g-3">
                <div class="col-md-4">
                    <img src="https://acmaintenance.id/assets/landing/images/logo-amc-putih.png" class="mw-100"
                        alt="amc">
                    <div class="d-flex">
                        <div class="d-bloc">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25"
                                viewBox="0 0 24 25" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12.398 20.7791C13.881 20.0099 19 16.9914 19 11.9751C19 8.1091 15.866 4.9751 12 4.9751C8.13401 4.9751 5 8.1091 5 11.9751C5 16.9914 10.119 20.0099 11.602 20.7791C11.8548 20.9102 12.1452 20.9102 12.398 20.7791ZM12 14.9751C13.6569 14.9751 15 13.632 15 11.9751C15 10.3182 13.6569 8.9751 12 8.9751C10.3431 8.9751 9 10.3182 9 11.9751C9 13.632 10.3431 14.9751 12 14.9751Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <p class="text-white ms-3">
                            Jl. Taman Daan Mogot Raya No.17, RT.2/RW.1, Tj. Duren Utara, Kec. Grogol
                            petamburan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11470
                        </p>
                    </div>

                </div>
                <div class="col-12 col-lg-auto">
                    <h3>Layanan Kami</h3>
                    <ul class="list-unstyled">
                        <li>
                            <a href="">Cleaning AC</a>
                        </li>
                        <li>
                            <a href="">Maintenance AC</a>
                        </li>
                        <li>
                            <a href="">Instalasi AC</a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-lg-auto">
                    <h3>Langganan</h3>
                    <ul class="list-unstyled">
                        <li>
                            <a href="">Paket Basic</a>
                        </li>
                        <li>
                            <a href="">Paket Premium</a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-lg-auto">
                    <h3>Social Media</h3>
                    <a href="https://www.instagram.com/acmaintenance.id" class="d-block">
                        <div class="d-fle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25"
                                viewBox="0 0 24 25" fill="none">
                                <path
                                    d="M3.00012 11.9751C3.00012 8.20386 3.00012 6.31824 4.17169 5.14667C5.34327 3.9751 7.22889 3.9751 11.0001 3.9751H13.0001C16.7714 3.9751 18.657 3.9751 19.8285 5.14667C21.0001 6.31824 21.0001 8.20386 21.0001 11.9751V13.9751C21.0001 17.7463 21.0001 19.632 19.8285 20.8035C18.657 21.9751 16.7714 21.9751 13.0001 21.9751H11.0001C7.22889 21.9751 5.34327 21.9751 4.17169 20.8035C3.00012 19.632 3.00012 17.7463 3.00012 13.9751V11.9751Z"
                                    stroke="white" stroke-width="2" />
                                <circle cx="16.5001" cy="8.4751" r="1.5" fill="white" />
                                <circle cx="12.0001" cy="12.9751" r="3" stroke="white" stroke-width="2" />
                            </svg>
                            <span>@amc_idn</span>
                        </div>
                    </a>
                    <a href="https://wa.me/6285210632227" class="btn btn-light-blue" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25"
                            fill="none">
                            <path
                                d="M6.67974 4.29548L7.29302 3.6822C7.68354 3.29168 8.3167 3.29168 8.70723 3.6822L11.293 6.26799C11.6835 6.65852 11.6835 7.29168 11.293 7.6822L9.5006 9.47462C9.20172 9.7735 9.12762 10.2301 9.31665 10.6082C10.4094 12.7937 12.1815 14.5658 14.3671 15.6586C14.7451 15.8476 15.2017 15.7735 15.5006 15.4746L17.293 13.6822C17.6835 13.2917 18.3167 13.2917 18.7072 13.6822L21.293 16.268C21.6835 16.6585 21.6835 17.2917 21.293 17.6822L20.6797 18.2955C18.5684 20.4068 15.2258 20.6444 12.8371 18.8528L11.6287 17.9465C9.88516 16.6389 8.33634 15.0901 7.02869 13.3465L6.12239 12.1381C4.33084 9.74939 4.56839 6.40683 6.67974 4.29548Z"
                                fill="white" />
                        </svg>
                        Customer Service AMC
                    </a>
                </div>
            </div>
        </div>
        <div class="pb-3" style="background: #273B4A;">
            <hr>
            <p class="text-center copyright text-white mb-0">
                © 2024 Copyright by Aircon Management Company. All rights reserved
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/lnd-amc/js/main.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Define a function to handle animations
            function animateOnScroll(elements, animationClass, threshold = 0.0001, delayMultiplier = 0.5) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const index = [...elements].indexOf(entry.target);
                            const delay = index * delayMultiplier;
                            entry.target.style.animationDelay = `${delay}s`;
                            entry.target.classList.add('animate__animated', animationClass);
                            observer.unobserve(entry.target); // Stop observing after animation
                        }
                    });
                }, {
                    threshold
                });

                // Observe all elements
                elements.forEach((el) => {
                    observer.observe(el);
                });
            }

            // Animate the h2 element
            const h2Element = document.querySelector('.why-us h2');
            animateOnScroll([h2Element], 'animate__fadeInUp');

            // Animate the card-why elements
            const cardWhyElements = document.querySelectorAll('.card-why');
            animateOnScroll(cardWhyElements, 'animate__fadeInUp');

            // Animate the card-why elements
            const imgTechnician = document.querySelectorAll('.img-technician');
            animateOnScroll(imgTechnician, 'animate__fadeInUp');

            const techDesc = document.querySelectorAll('.tech-desc');
            animateOnScroll(techDesc, 'animate__fadeInRight');

            const imgHowto = document.querySelectorAll('.img-howto');
            animateOnScroll(imgHowto, 'animate__fadeInRight');
        });
    </script>
    @if (env('APP_ENV') === 'production')
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "ProfessionalService",
            "name": "AMC | Aircon Management Company",
            "image": "https://acmaintenance.id/assets/landing/images/Logo%20AMC%20Fixed.png",
            "@id": "https://acmaintenance.id/",
            "url": "https://acmaintenance.id/",
            "telephone": "085210632227",
            "priceRange": "95000",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "2, Jl. Taman Daan Mogot Raya No.17, RT.2/RW.1",
                "addressLocality": "Jakarta Barat",
                "postalCode": "11470",
                "addressCountry": "ID"
            },
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": -6.168973899718714,
                "longitude": 106.78427530312827
            },
            "openingHoursSpecification": {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                    "Monday",
                    "Tuesday",
                    "Wednesday",
                    "Thursday",
                    "Friday",
                    "Saturday"
                ],
                "opens": "08:00",
                "closes": "18:00"
            }
        }

    </script>
    @endif


</body>

</html>
