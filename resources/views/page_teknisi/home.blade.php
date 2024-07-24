    @extends('layouts.screen_technician')
    @section('css')
    @endsection
    @section('content')
        <section class="content-tch">
            <div class="container">
                <div class="row gy-3">
                    <div class="col-12">
                        <div class="card card-homepage">
                            <div class="card-body">
                                <div class="row g-2 mb-2 align-items-center">
                                    <div class="col-3">
                                        <img src="https://placehold.co/47x47/E2F4FF/284F9E?text={{ substr(auth()->guard('technician')->user()->fullname,0,1) }}"
                                            alt="" class="w-100 profile-picture">
                                    </div>
                                    <div class="col-9">
                                        <h1 class="text-primary-blue fs-3">
                                            {{ auth()->guard('technician')->user()->fullname }}
                                            {{ auth()->guard('technician')->user()->teams->first()->id }}
                                        </h1>

                                        <p class="text-muted">
                                            {{ auth()->guard('technician')->user()->technician_level->name }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-2 align-items-center">
                                    <div class="col-6 text-center border-end">
                                        <h2>{{ $orders['today']->count() }}</h2>
                                        <p class="text-muted">Order Hari Ini</p>
                                    </div>
                                    <div class="col-6 text-center">
                                        <h2>{{ $orders['tomorrow']->count() }}</h2>
                                        <p class="text-muted">Order Besok</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card card-homepage">
                            <div class="card-body">
                                <div class="row gx-2 gy-3 align-items-center">
                                    <div class="col-9">
                                        <p class="mb-2 text-muted">Total Penghasilan Teknisi</p>
                                        <h2>{{ thousand_rupiah($totalCommission) }}</h2>
                                    </div>
                                    <div class="col-3">
                                        <img src="{{ asset('assets/landing/images/ic_income.png') }}" alt="amc"
                                            class="mw-100">
                                    </div>
                                    <div class="col-12">
                                        <a href="" class="btn btn-dark-blue w-100">
                                            Lihat Semua
                                        </a>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row gx-2 gy-3 align-items-center mb-3">
                            <div class="col-1">
                                <img src="{{ asset('assets/landing/images/ic_todo.png') }}" alt="amc" class="mw-100">
                            </div>
                            <div class="col-5">
                                <p class="mb-0 text-muted">Daftar Pekerjaan</p>
                            </div>
                            <div class="col-6 text-end">
                                <ul class="nav nav-pills justify-content-end" id="orders" role="tablist">
                                    <li class="nav-item me-3" role="presentation">
                                        <button class="nav-link active" id="order-today" data-bs-toggle="tab"
                                            data-bs-target="#order-today-pane" type="button" role="tab"
                                            aria-controls="order-today-pane" aria-selected="true">Hari Ini</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="order-tomorow" data-bs-toggle="tab"
                                            data-bs-target="#order-tomorow-pane" type="button" role="tab"
                                            aria-controls="order-tomorow-pane" aria-selected="false">Besok</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="">
                            <div class="card-body">
                                <div class="tab-content" id="ordersContent">
                                    <div class="tab-pane fade show active" id="order-today-pane" role="tabpanel"
                                        aria-labelledby="order-today" tabindex="0">
                                        <div class="d-block">
                                            <ul>
                                                @foreach ($orders['today'] as $order)
                                                    <li>
                                                        <a
                                                            href="{{ route('technician.orderDetail', ['id' => $order->id]) }}">
                                                            <div class="card card-homepage">
                                                                <div class="card-body">
                                                                    <!-- Display order details such as time, distance, location, and buttons -->
                                                                    <div class=" d-flex justify-content-between">
                                                                        <div>
                                                                            <i class="far fa-clock"></i>
                                                                            {{ \Carbon\Carbon::parse($order->booked_date)->format('H:i') }}
                                                                        </div>
                                                                        <div
                                                                            class="badge {{ $statusorder[$order->order_status][1] }}">
                                                                            {{ $statusorder[$order->order_status][0] }}
                                                                        </div>
                                                                    </div>
                                                                    <!-- Display location details -->
                                                                    <div class="row gy-2 gx-1 align-items-center">
                                                                        <div class="col-12">
                                                                            <ul class="fa-ul mb-3 text-primary-blue">
                                                                                <li class="my-2">
                                                                                    <span class="fa-li">
                                                                                        <i
                                                                                            class="fas fa-map-marker-alt text-primary-blue"></i>
                                                                                    </span>
                                                                                    <p class="text-primary-blue"
                                                                                        style="font-size: 18px;font-weight: 700;">
                                                                                        {{ $order->address->address_detail }}
                                                                                    </p>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Display service buttons -->
                                                                    <div class="col-12">
                                                                        <div class="d-flex">
                                                                            @foreach ($order->serviceCounts as $service)
                                                                                <button
                                                                                    class="btn btn-outline-dark-blue me-1"
                                                                                    style="font-size: 12px;">
                                                                                    {{ $service['service_name'] }} -
                                                                                    {{ $service['count'] }} unit
                                                                                </button>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="order-tomorow-pane" role="tabpanel"
                                        aria-labelledby="order-tomorow" tabindex="0">
                                        <div class="d-block">
                                            <ul>
                                                @foreach ($orders['tomorrow'] as $order)
                                                    <li>
                                                        <a
                                                            href="{{ route('technician.orderDetail', ['id' => $order->id]) }}">
                                                            <div class="card card-homepage">
                                                                <div class="card-body">
                                                                    <!-- Display order details such as time, distance, location, and buttons -->
                                                                    <div class=" d-flex justify-content-between">
                                                                        <div>
                                                                            <i class="far fa-clock"></i>
                                                                            {{ \Carbon\Carbon::parse($order->booked_order)->locale('id')->isoFormat('dddd, DD MMMM YYYY [pukul] HH:mm') }}
                                                                        </div>
                                                                    </div>
                                                                    <!-- Display location details -->
                                                                    <div class="row gy-2 gx-1 align-items-center">
                                                                        <div class="col-12">
                                                                            <ul class="fa-ul mb-3 text-primary-blue">
                                                                                <li class="my-2">
                                                                                    <span class="fa-li">
                                                                                        <i
                                                                                            class="fas fa-map-marker-alt text-primary-blue"></i>
                                                                                    </span>
                                                                                    <p class="text-primary-blue"
                                                                                        style="font-size: 18px;font-weight: 700;">
                                                                                        {{ $order->address->address_detail }}
                                                                                    </p>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Display service buttons -->
                                                                    <div class="col-12">
                                                                        <div class="d-flex">
                                                                            @foreach ($order->serviceCounts as $service)
                                                                                <button
                                                                                    class="btn btn-outline-dark-blue me-1"
                                                                                    style="font-size: 12px;">
                                                                                    {{ $service['service_name'] }} -
                                                                                    {{ $service['count'] }} unit
                                                                                </button>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    @endsection
    @section('js')
    @endsection
