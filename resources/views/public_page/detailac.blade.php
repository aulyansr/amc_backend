@extends('layouts.screenqr')
@section('css')
@endsection
@section('content')
    <section class="content-tch">
        <div class="container">
            <div class="d-block">
                <a href="">
                    <img src="{{ asset('assets/landing/images/Logo AMC Fixed.png') }}" alt="amc"
                        class="logo mw-100 m-auto d-block mb-3">
                </a>
            </div>
            <div class="row gy-3">
                <div class="col-12">
                    <p class="text-primary-blue ">Customer</p>
                    <div class="card card-homepage">
                        <div class="card-body">
                            <div class="row g-2 mb-2 align-items-center">
                                <div class="col-12">
                                    <h1 class="text-primary-blue fs-3 mb-0">ZIPKOS Zsuite Tanjung Duren</h1>
                                </div>
                            </div>
                            <hr>
                            <ul class="fa-ul mb-3">
                                <li class="my-2">
                                    <span class="fa-li">
                                        <i class="fas fa-map-marker-alt text-primary-blue"></i>
                                    </span>
                                    <p style="font-size: 18px;font-weight: 700;">
                                        Jl. Taman Daan Mogot Raya No.17, RT.2/RW.1, Tj. Duren Utara, Kec. Grogol
                                        petamburan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11470
                                    </p>
                                </li>
                                <li class="my-2">
                                    <span class="fa-li">

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-primary-blue ">Detail AC</p>
                    <div class="card card-homepage">
                        <div class="card-body">

                            <div class="d-flex justify-content-between">
                                <p class="text-primary-blue">Brand</p>
                                <p class="fw-bold">SHARP</p>
                            </div>

                            <div class="d-flex justify-content-between">
                                <p class="text-primary-blue">Produk SKU</p>
                                <p class="fw-bold">AH-A5BEY</p>
                            </div>

                            <div class="d-flex justify-content-between">
                                <p class="text-primary-blue">Jenis AC</p>
                                <p class="fw-bold">Split Wall</p>
                            </div>

                            <div class="d-flex justify-content-between">
                                <p class="text-primary-blue">Daya PK</p>
                                <p class="fw-bold">1,5 PK</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-primary-blue">Tipe Refrigrant</p>
                                <p class="fw-bold">R-34</p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-primary-blue ">History Perawatan</p>
                    <div class="card card-homepage">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0 text-primary-blue">Total Service: </h3>
                                <h3 class="mb-0 fw-bold">2</h3>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <p class="text-primary-blue">Cuci AC</p>
                                <p class="fw-bold">29 April 2023 </p>
                            </div>

                            <div class="d-flex justify-content-between">
                                <p class="text-primary-blue">Penambahan Freon</p>
                                <p class="fw-bold">2 Mei 2023</p>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="container">
                        <p>
                            AC ini telah dirawat oleh <span class="fw-bold text-primary-blue">AMC</span>. Untuk kamu
                            yang
                            ingin merasakan kesejukan AC seperti
                            ini atau
                            konsultasi perawatan AC dapat menghubungi <span class="fw-bold text-primary-blue">Admin
                                AMC</span>
                            dengan klik tombol di bawah
                            <br>
                            <a href="https://wa.me/6285210632227?text=Halo%20AMC,%20Saya%20ingin%20Service%20AC"
                                class="btn btn-dark-blue w-100 my-3">
                                Service Sekarang
                            </a>
                            Dapatkan Layanan Menarik seperti:

                        <ul style="list-style: circle; padding-left: 20px;">

                            <li>
                                <p class="text-primary-blue">Garansi Dingin </p>
                            </li>

                            <li>
                                <p class="text-primary-blue">Diskon 20% Untuk Service Pertama Kali </p>
                            </li>
                        </ul>

                        </p>


                        <a href="https://beta.acmaintenance.id/teknisi/login" target="_blank"
                            class="text-primary-blue fs-6 text-center d-block mt-5" style="font-size: 10px !important;">
                            Update Detail Perawatan
                        </a>
                    </div>
                </div>



            </div>
        </div>
    </section>
@endsection
@section('js')
@endsection
