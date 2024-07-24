@extends('layouts.landing')
@section('css')
@endsection
@section('content')
    <!-- hero -->
    <section id="hero" class="hero hero-contact ">
        <div class="container-xxl">
            <div class="row justify-content-start g-0">
                <div class="col-lg-8 col-xl-6">
                    <h1 class="text-white">
                        Contact Us
                    </h1>

                </div>
            </div>
        </div>
    </section>
    <!-- emd hero -->
    {{-- Form Contact --}}
    <section id="form-contact">
        <div class="container-xl">
            <h3 class="my-lg-4 my-xl-5 my-3">Get in Touch</h3>
            <div class="my-lg-4 my-xl-5 my-3">
                <form action="#" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama" class="ps-3 mb-2">Nama</label>
                                <input type="text" class="form-control" name="nama">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email" class="ps-3 mb-2">Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="telepon" class="ps-3 mb-2">Telepon</label>
                                <input type="text" class="form-control" name="telepon"
                                    oninput="return numberInput(this)">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama" class="ps-3 mb-2">Subjek</label>
                                <input type="text" class="form-control" name="nama">
                            </div>
                        </div>
                        <div class="col-lg-6 order-xl-1 order-2">
                            <div class="my-3">
                                <h4>Informasi Kontak</h4>
                                <div class="mt-3">
                                    <p><i class="fas fa-phone pe-3"></i>+62 852-1063-2227</p>
                                    <p><i class="fas fa-envelope pe-3"></i> hello@acmaintenance.id</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h4>Lokasi</h4>
                                <h6><i class="fas fa-map-pin pe-3"></i>Aircon Management Company</h6>
                                <div class="mt-2">
                                    <p class="ps-lg-4 col-lg-8 col-xl-6">
                                        Jl. Taman Daan Mogot Raya No.17, RT.2/RW.1, Tj. Duren Utara, Kec. Grogol petamburan,
                                        Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11470
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 order-lg-2 order-1">
                            <div class="form-group">
                                <label for="pesan" class="ps-3 mb-2">Pesan</label>
                                <textarea name="" class="form-control" name="pesan" id="pesan" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="col-12 text-lg-end text-center order-lg-2 order-1">
                            <button class="btn btn-blue col-lg-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    {{-- End Form Contact --}}
@endsection
@section('js')
@endsection
