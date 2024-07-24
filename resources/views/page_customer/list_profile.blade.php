@extends('layouts.screen_customer')
@section('css')
@endsection
@section('content')
    <div class="container">
        <div class="row g-3">
            <div class="col-12 col-lg-6">
                <div class="card rounded-3">
                    <div class="card-body bg-gradient-blue rounded-3">
                        <div class="row g-3 align-items-center ">
                            <div class="col-3">
                                <img src="https://placehold.co/47x47/E2F4FF/284F9E?text={{ substr(auth()->guard('customer')->user()->nama,0,1) }}"
                                    alt="" class="w-100 profile-picture rounded-5">
                            </div>
                            <div class="col-9 text-white">
                                <h3 class="mb-0">
                                    {{ Auth::guard('customer')->user()->type == 1 ? Auth::guard('customer')->user()->company_name : Auth::guard('customer')->user()->name }}
                                </h3>
                                <p class="mt-0">{{ auth()->guard('customer')->user()->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                @php
                    $address = $customer
                        ->masterAddress()
                        ->where('is_main', true)
                        ->first();
                @endphp
                @if ($customer->masterAddress()->count() > 0 && $address)
                    <div class="card rounded-3 w-100 bg-info h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <h4 class="mb-0"> <i class="fas fa-map-marker-alt me-1"></i></i>
                                    {{ $address->address_name }}</h4>
                            </div>

                            <p>
                                {{ $address->completedAddress }}
                                <span class="badge text-bg-info text-white">Utama</span>
                            </p>
                        </div>
                    </div>
                @else
                    <div class="card rounded-3 w-100 bg-info mb-4 border-danger h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h4 class="mb-0"> <i class="fas fa-map-marker-alt me-1"></i></i> Alamat Pengerjaan belum
                                    tersedia</h4>
                                <a href="{{ route('customer.alamat.create') }}"><i class="fas fa-edit me-1"></i>Buat
                                    Alamat</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-12">
                <div class="card border-blue">
                    <div class="card-body">
                        <a href="{{ route('customer.profile.change') }}" class="fs-5 text-primary-blue">Ubah Data Profil</a>
                        <hr class="border-blue">
                        <a href="{{ route('customer.profile.pin') }}" class="fs-5 text-primary-blue">Ubah PIN</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
