@extends('layouts.screen_customer')
@section('css')
@endsection
@section('content')
    <div class="container">
        <div class="row g-3 justify-content-center">
            @php
                $last_service = $ac->last_service != null ? \Carbon\Carbon::parse($ac->last_service)->format('d F Y') : '-';
                $next_service =
                    $ac->last_service != null
                        ? \Carbon\Carbon::parse($ac->last_service)
                            ->addMonths(2)
                            ->format('d F Y')
                        : '-';
            @endphp
            <div class="col-12">
                <h3 class="text-primary-blue mb-3">Detail AC</h3>
                <div class="card rounded-5 border-0 shadow">
                    <div class="card-body">
                        <span>{{ $qr->qr_name }}</span>
                        <h2 class="fs-2 text-primary-blue mb-3">{{ $ac->ac->acFullName }}</h2>
                        <div class="row g-3">

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Kode AC</h5>
                                    <p class="text-primary-blue">{{ $qr->qr_name }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Brand</h5>
                                    <p class="text-primary-blue">{{ $ac->ac->acFullName }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Daya PK</h5>
                                    <p class="text-primary-blue">{{ $ac->ac->pk }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Tipe Refrigrant</h5>
                                    <p class="text-primary-blue">{{ $ac->ac->freon_type }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <h5>Lokasi Ruangan</h5>
                                    <p class="text-primary-blue">{{ $ac->room_name }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Last Service</h5>
                                    <p class="text-primary-blue">
                                        {{ $last_service }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Next Service</h5>
                                    <p class="text-primary-blue">
                                        {{ $next_service }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <a href="{{ route('customer.create_order') }}" class="btn btn-blue px-3 py-2 w-100">
                                    Order Service Baru
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <p class="text-primary-blue fs-3 mb-3">History Perawatan</p>
                <div class="card border-0 rounded-5 shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="mb-0 text-primary-blue">Total Service: </h3>
                            <h3 class="mb-0 fw-bold">{{ $history->count() }}</h3>
                        </div>
                        <hr>
                        @foreach ($history as $h)
                            <div class="d-block mb-5">
                                <div class="d-flex justify-content-between">
                                    <p class="text-primary-blue">{{ $h->service->name }}
                                        {{ $h->warranty && date('Y-m-d', strtotime($h->warranty)) <= date('Y-m-d') ? '(Garansi sampai ' . date('d F Y', strtotime($h->warranty)) . ')' : '' }}
                                    </p>
                                    <p class="fw-bold">{{ date('d F Y', strtotime($h->updated_at)) }} </p>
                                </div>
                                <p class="fw-bold">Keluhan:</p>
                                <p class="text-primary-blue">{{ $h->order->reason }}</p>
                                <div class="row">
                                    <div class="col-12 col-md-2">
                                        <a href="{{ route('customer.order_detail', hash_id($h->order->id)) }}"
                                            class="btn btn-blue w-100 px-3 py-2">
                                            Lihat Detail Order
                                        </a>
                                    </div>
                                    @if (!empty($h->warranty) && date('Y-m-d', strtotime($h->warranty)) <= date('Y-m-d'))
                                        <div class="col-12 col-md-2">
                                            <form action="{{ route('customer.claim_warranty', hash_id($h->id)) }}"
                                                method="POST" class="form-claim">

                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $h->order->id }}">

                                                <button type="submit"
                                                    class="btn btn-warning claim-button text-black w-100 px-3 py-2">
                                                    Klaim Garansi
                                                </button>

                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
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
        $('.claim-button').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: `Kamu akan klaim garansi untuk service ini.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Saya Yakin!',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('.form-claim').submit();
                }
            })
        });
    </script>
@endsection
