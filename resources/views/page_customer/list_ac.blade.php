    @extends('layouts.screen_customer')
    @section('css')
    @endsection
    @section('content')
        <div class="container">

            <div class="d-flex align-items-center mb-3">
                <img src="{{ asset('assets/landing/images/icon-ac.png') }}" alt="icon ac">
                <h2 class="m-0 text-primary-blue fs-2 fw-bolder">Semua AC</h2>
            </div>

            <div class="row gy-3">
                <div class="col-12">
                    <form action="{{ route('customer.list_ac') }}" method="get">
                        <div class="row gx-3 align-items-top mb-3">
                            <div class="col-6 ">
                                <select class="form-select select2" name="filter_alamat"
                                    aria-label="Default select example">
                                    <option selected>Pilih Alamat</option>
                                    @if (isset($address))
                                        @foreach ($customer->masterAddress()->orderBy('address_name')->get() as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->address_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-auto ">
                                <button class="btn btn-outline-dark-blue px-3 py-2 w-100">
                                    Filter
                                </button>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('customer.list_ac') }}" class="btn btn-dark-blue px-3 py-2">
                                    Semua
                                </a>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

            @foreach ($address as $key => $value)
                <h2 class="fw-bold fs-3 py-3  text-primary-blue">{{ $value->address_name }}</h2>
                <div class="row g-5">
                    @if ($value->ac_customer->count() > 0)
                        @foreach ($value->ac_customer as $ac)
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
                    @else
                        <div class="col-12 text-center">
                            <div class="card rounded-5 shadow border-0">
                                <div class="card-body">
                                    <h3 class="fw-bold">Belum ada AC yang di service pada alamat ini</h3>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach

        </div>
    @endsection
    @section('js')
    @endsection
