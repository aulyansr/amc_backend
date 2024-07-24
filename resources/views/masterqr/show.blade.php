@extends('layouts.admin')
@section('title', 'Detail Qr')
@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h1>Customer and detail AC</h1>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <h5>Nama Customer</h5>
                            <p>{{ $ac->customerName }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <h5>Nama Alamat</h5>
                            <p>{{ $ac->address->address_name }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <h5>Alamat Lengkap</h5>
                            <p>{{ $ac->addressCompleted }}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <h3>Detail AC</h3>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <h5>Brand</h5>
                            <p>{{ $ac->ac->acFullName }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <h5>Kode QR</h5>
                            <p>{{ $qr->qr_name }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <h5>Daya PK</h5>
                            <p>{{ $ac->ac->pk }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <h5>Tipe Refrigrant</h5>
                            <p>{{ $ac->ac->freon_type }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <h5>Lokasi Ruangan</h5>
                            <p>{{ $ac->room_name }}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-primary-blue ">History Perawatan</p>
                        <div class="card card-homepage">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h3 class="mb-0 text-primary-blue">Total Service: </h3>
                                    <h3 class="mb-0 fw-bold">{{ $history->count() }}</h3>
                                </div>
                                <hr>
                                @foreach ($history as $h)
                                    <div class="d-flex justify-content-between">
                                        <p class="text-primary-blue">{{ $h->service->name }}</p>
                                        <p class="fw-bold">{{ date('d F Y', strtotime($h->updated_at)) }} </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
