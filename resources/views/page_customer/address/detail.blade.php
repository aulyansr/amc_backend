@extends('layouts.screen_customer')
@section('css')
@endsection
@section('content')
    <div class="container">

        <div class="card rounded-5 border-0 shadow">
            <div class="card-body">
                <h2 class="fs-2 text-primary-blue mb-3">
                    {{ $address->address_name }}
                </h2>
                <div class="row g-3">

                    <div class="col-12">
                        <div class="row g-2 align-items-center">
                            <div class="col-auto">
                                <label for="name">Alamat Lengkap : </label>
                            </div>
                            <div class="col-auto">
                                <p class="text-primary-blue">{{ $address->completedAddress }}</p>
                            </div>
                        </div>
                    </div>
                    @if ($address->time_open && $address->time_close)
                        <div class="col-12">
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <label for="name">Jam Buka : </label>
                                </div>
                                <div class="col-auto">
                                    <p class="text-primary-blue">{{ $address->time_open }} - {{ $address->time_close }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($address->jumlah_ac)
                        <div class="col-12">
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <label for="name">Jumlah AC : </label>
                                </div>
                                <div class="col-auto">
                                    <p class="text-primary-blue">{{ $address->jumlah_ac }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-12 col-md-2">
                        <a href="{{ route('customer.create_order') }}" class="btn btn-blue px-3 py-2 w-100">
                            Order Service Baru
                        </a>
                    </div>
                </div>

            </div>
        </div>



        @if ($address->ac_customer->count() > 0)
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-block">
                    <h2 class="fw-bold fs-3 py-3  text-primary-blue">Semua AC</h2>
                </div>
                <p class="fw-bold fs-3">{{ $address->ac_customer->count() }} Unit AC</p>
            </div>

            <div class="row g-5">

                @foreach ($address->ac_customer as $ac)
                    @php
                        $last_service = $ac->last_service != null ? \Carbon\Carbon::parse($ac->last_service)->format('d F Y') : '-';
                        $next_service =
                            $ac->last_service != null
                                ? \Carbon\Carbon::parse($ac->last_service)
                                    ->addMonths(2)
                                    ->format('d F Y')
                                : '-';
                    @endphp
                    <div class="col-12 col-md-4">
                        <div class="card rounded-5 shadow border-0">

                            <div class="card-body">
                                <span class="text-secondary-blue">{{ $ac->ac->model }}</span>
                                <h3 class="fw-bold">{{ $ac->ac->ac_full_name }}</h3>
                                <p>
                                    {{ $ac->room_name }}
                                </p>
                                <div class="mb-2">
                                    <p class="mb-0">
                                        Last Service
                                    </p>
                                    <p class="text-primary-blue">
                                        {{ $last_service }}
                                    </p>

                                </div>
                                <div class="mb-3">
                                    <p class="mb-0">
                                        Next Service
                                    </p>
                                    <p class="text-primary-blue">
                                        {{ $next_service }}
                                    </p>

                                </div>
                                <a href="{{ route('customer.alamat.detail_ac', $ac->master_qr->url_unique) }}"
                                    class="btn btn-blue w-100 px-3 py-2">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
        @endif
    </div>

@endsection
@section('js')
    <script>
        $('.main-button').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: `Kamu akan Mengubah Alamat Utama ke Alamat Baru.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Saya Yakin!',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('.form-main').submit();
                }
            })
        });
    </script>
@endsection
