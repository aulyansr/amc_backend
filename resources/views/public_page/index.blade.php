@extends('layouts.landing')
@section('css')
@endsection
@section('content')
    <!-- hero -->
    <section id="hero" class="hero hero-index ">
        <div class="container-xxl">
            <div class="row justify-content-end align-item-center g-0">
                <div class="col-xl-6">
                    <h1 class="text-white">
                        Kami hadir untuk anda dan AC anda
                    </h1>
                    <p class="fw-lighter">
                        AMC menyediakan layanan yang lebih professional dan berstandar, demi ketenangan dan kesejukan diri
                        anda.
                    </p>

                    <a href="{{ route('customer.showlogin') }}" class="btn btn-outline-white">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- hero -->
    {{-- promo --}}
    {{-- <section id="promo" class="my-3 my-lg-5">
    <div class="container">
        <h2 class="fw-bold text-primary-blue mb-3 text-center">Promo</h2>
        <div class="swiper sw-promo2">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="{{ asset('assets/landing/images/promo-2.png') }}" class="w-100" />
</div>
<div class="swiper-slide">
    <img src="{{ asset('assets/landing/images/promo-3.png') }}" class="w-100" />
</div>
<div class="swiper-slide">
    <img src="{{ asset('assets/landing/images/promo-4.png') }}" class="w-100" />
</div>
</div>
<div class="swiper-button-next"></div>
<div class="swiper-button-prev"></div>
</div>
<div thumbsSlider="" class="swiper sw-promo my-3 my-lg-5">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <img src="{{ asset('assets/landing/images/promo-2.png') }}" class="w-100" />
        </div>
        <div class="swiper-slide">
            <img src="{{ asset('assets/landing/images/promo-3.png') }}" class="w-100" />
        </div>
        <div class="swiper-slide">
            <img src="{{ asset('assets/landing/images/promo-4.png') }}" class="w-100" />
        </div>
    </div>
</div>
</div>
</section> --}}
    {{-- promo --}}

    <!-- service list -->
    <section id="service-list">
        <div class="container-xl">
            <h2 class="fw-bold">Layanan Kami</h2>
            <div class="card  border-0">
                <div class="card-body text-center text-md-start">
                    <div class="row justify-content-between align-items-center g-5">
                        <div class="col-md-6">
                            <img src="{{ asset('assets/landing/images/service1.png') }}" alt="amc service"
                                class="rounded-5 w-100">
                        </div>
                        <div class="col-md-6">
                            <h3 class="fw-bold text-primary-blue">Cleaning / Reparasi / Bongkar Pasang AC </h3>
                            <p class="text-primary-blue fw-lighter my-3" style="line-height: 1.5">
                                Kami menyediakan layanan berupa Perawatan dan pembersihan rutin AC, Perbaikan untuk AC yang
                                sudah tidak dingin atau bermalfungsi & Pemasangan AC baru, atau pemindahan AC lama. Dapatkan
                                harga dan pelayanan terbaik hanya dari kami.
                            </p>
                            <a href="{{ route('customer.create_order') }}" class="btn btn-outline-blue w-100 ">Pesan
                                Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- service list -->

    <!-- selling-point -->
    <section id="selling-point">
        <div class="container-xl">
            <h2 class="fw-bold text-white">Mengapa kami?</h2>
            <div class="swiper sw-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="card card-sp">
                            <img src="{{ asset('assets/landing/images/sp-1.png') }}" alt="amc">
                            <div class="card-body">
                                <h3 class="fw-bold same-height">Penyedia terpercaya</h3>
                                <p>
                                    Dengan tim yang besar dan layanan customer service kami, anda dapat lebih tenang dalam
                                    menerima teknisi dalam rumah anda.
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card card-sp">
                            <img src="{{ asset('assets/landing/images/sp-2.png') }}" alt="amc">
                            <div class="card-body">
                                <h3 class="fw-bold same-height">
                                    Teknisi terlatih
                                </h3>
                                <p>
                                    Teknisi kami menempuh berbulan-bulan pelatihan intensif, untuk memastikan kualitas
                                    layanan kami.
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card card-sp">
                            <img src="{{ asset('assets/landing/images/sp-3.png') }}" alt="amc">
                            <div class="card-body">
                                <h3 class="fw-bold same-height">
                                    Jadwal fleksibel
                                </h3>
                                <p>
                                    Anda tidak lagi harus menyesuaikan jadwal anda sesuai adanya teknisi AC, karena kami
                                    akan menyesuaikan dengan kebutuhan anda.
                                </p>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>

            </div>

        </div>
    </section>
    <!-- selling-point -->

    <!-- out client -->
    <section id="our-client">
        <div class="container-xl">
            <h2 class="fw-bold text-primary-blue text-center">Klien Kami</h2>
            <div class="row justify-content-center">
                <div class="col text-center">
                    <img src="{{ asset('assets/landing/images/logo-fore.png') }}" alt="amc" class="mw-100 m-auto">
                </div>
                <div class="col text-center">
                    <img src="{{ asset('assets/landing/images/logorelax.png') }}" alt="amc" class="mw-100 m-auto">
                </div>
                <div class="col text-center">
                    <img src="{{ asset('assets/landing/images/logozipkos.png') }}" alt="amc" class="mw-100 m-auto">
                </div>
                <div class="col text-center">
                    <img src="{{ asset('assets/landing/images/logoprima.png') }}" alt="amc" class="mw-100 m-auto">
                </div>
            </div>

        </div>
    </section>
    <!-- out client -->

    {{-- <!-- welcome text -->
<section id="about">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('assets/landing/images/bgwelcome.png') }}" alt="amc" class="mw-100 m-auto">
</div>
<div class="col-md-8">
    <h2 class="fw-bold">Selamat Datang di AMC</h2>
    <p>
        AMC bukan merupakan servis AC biasa, dan kami berkomitmen untuk memberikan anda lebih dari yang
        lain. Anda
        akan bertemu dengan teknisi yang lebih ramah dan berpengalaman, dengan fleksibilitas dan kapasitas
        yang anda
        butuhkan.
    </p>
    <a href="{{ route('landing.about') }}" class="btn btn-outline-white">
        Selengkapnya
    </a>
</div>
</div>
</div>
</section> --}}
    <!-- welcome text -->

@section('modal_order')
    @include('public_page/order_modal')
@endsection
@endsection
@section('js')
@endsection
