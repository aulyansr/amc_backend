@extends('layouts.landing')
@section('css')
@endsection
@section('content')
<!-- hero -->
<section id="hero" class="hero hero-service">
    <div class="container-xxl">
        <div class="row justify-content-end  g-0">
            <div class="col-xl-6">
                <h1 class="text-white fs-2 mb-5">
                    Layanan-layanan kami
                </h1>
            </div>
        </div>
    </div>
</section>
<!-- hero -->

<!-- service list -->
<section id="service-list">
    <div class="container-xl">
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="card card-service border-0">
                    <img src="{{ asset('assets/landing/images/service1.png') }}" alt="amc service" class="rounded-5">
                    <div class="card-body"></div>
                    <h3 class="fw-bold text-primary-blue">Cleaning AC</h3>
                    <p class="text-primary-blue fw-lighter">
                        Perawatan dan pembersihan rutin AC
                    </p>
                    <button type="button" class="btn btn-outline-blue" data-bs-toggle="modal"
                        data-bs-target="#orderModal" data-bs-whatever="Cuci AC">Cuci AC</button>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-service border-0">
                    <img src="{{ asset('assets/landing/images/service2.png') }}" alt="amc service" class="rounded-5">
                    <div class="card-body"></div>
                    <h3 class="fw-bold text-primary-blue">Reparasi</h3>
                    <p class="text-primary-blue fw-lighter">
                        Perbaikan untuk AC yang sudah tidak dingin atau bermalfungsi
                    </p>
                    <button type="button" class="btn btn-outline-blue" data-bs-toggle="modal"
                        data-bs-target="#orderModal" data-bs-whatever="Service AC">Service AC</button>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-service border-0">
                    <img src="{{ asset('assets/landing/images/service2.png') }}" alt="amc service" class="rounded-5">
                    <div class="card-body"></div>
                    <h3 class="fw-bold text-primary-blue">Bongkar Pasang</h3>
                    <p class="text-primary-blue fw-lighter">
                        Pemasangan AC baru, atau pemindahan AC lama
                    </p>
                    <button type="button" class="btn btn-outline-blue" data-bs-toggle="modal"
                        data-bs-target="#orderModal" data-bs-whatever="Bongkar pasang AC">Bongkar pasang AC</button>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-service border-0">
                    <img src="{{ asset('assets/landing/images/service2.png') }}" alt="amc service" class="rounded-5">
                    <div class="card-body"></div>
                    <h3 class="fw-bold text-primary-blue">Cari AC baru</h3>
                    <p class="text-primary-blue fw-lighter">
                        Dapatkan harga terbaik dari rekanan kami
                    </p>
                    <button type="button" class="btn btn-outline-blue" data-bs-toggle="modal"
                        data-bs-target="#orderModal" data-bs-whatever="Beli AC">Beli AC</button>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- service list -->

<!-- select-package -->
{{-- <section id="select-package">
    <div class="container-xl">
        <h2>Harga Paket</h2>
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <p class="description">
                    Lorem ipsum dolor sit amet, cons ectetuer adipiscing elit, sed diam nonummy nibh euismod
                    tincidunt ut
                    laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci
                    tation
                    ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                </p>
            </div>
        </div>

        <div class="swiper sw-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="card card-package">
                        <div class="card-body">
                            <h4 class="fs-4">Paket</h4>
                            <h3>Deluxe 1</h3>
                            <p>Rincian</p>
                            <ul>
                                <li>
                                    <p>
                                        Bebas Cleaning AC Selama 1 Bulan
                                    </p>
                                </li>
                            </ul>
                            <p class="mb-3">Harga</p>
                            <div class="d-flex price">
                                <sup>Rp</sup>
                                <p>
                                    900.000
                                </p>
                            </div>
                            <a href="" class="btn btn-action">Pesan Sekarang</a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="card card-package">
                        <div class="card-body">
                            <h4 class="fs-4">Paket</h4>
                            <h3>Deluxe 2</h3>
                            <p>Rincian</p>
                            <ul>
                                <li>
                                    <p>
                                        Bebas Cleaning AC Selama 1 Bulan
                                    </p>
                                </li>
                            </ul>
                            <p class="mb-3">Harga</p>
                            <div class="d-flex price">
                                <sup>Rp</sup>
                                <p>
                                    900.000
                                </p>
                            </div>
                            <a href="" class="btn btn-action">Pesan Sekarang</a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="card card-package">
                        <div class="card-body">
                            <h4 class="fs-4">Paket</h4>
                            <h3>Deluxe 3</h3>
                            <p>Rincian</p>
                            <ul>
                                <li>
                                    <p>
                                        Bebas Cleaning AC Selama 1 Bulan
                                    </p>
                                </li>
                            </ul>
                            <p class="mb-3">Harga</p>
                            <div class="d-flex price">
                                <sup>Rp</sup>
                                <p>
                                    900.000
                                </p>
                            </div>
                            <a href="" class="btn btn-action">Pesan Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>
        </div>

    </div>

</section> --}}
<!-- select-package -->
@endsection
@section('modal_order')
@include('public_page/order_modal')
@endsection
@section('js')
@endsection
