    @extends('layouts.screen_customer')
    @section('css')
    @endsection
    @section('content')
        <div class="container">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card shadow rounded-5 border-0">
                        <div class="card-body">
                            <h4 class="fw-semibold text-primary-blue">Alamat</h4>
                            <div class="d-block">
                                <div class="row align-items-center justify-between mb-3">
                                    <div class="col-4">
                                        <i class="fas fa-map-marker-alt fs-1" style="color:#a5cfe5"></i>
                                    </div>
                                    <div class="col-8 text-end">
                                        <h2 class="fw-bold mb-0">
                                            {{ Auth::guard('customer')->user()->masterAddress->count() }}
                                        </h2>
                                    </div>
                                </div>

                                <a href="{{ route('customer.alamat.index') }}" class="btn btn-blue w-100 py-3 px-2">
                                    Lihat Semua Alamat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow rounded-5 border-0 ">
                        <div class="card-body">
                            <h4 class="fw-semibold text-primary-blue">Total AC</h4>
                            <div class="d-block">
                                <div class="row align-items-center justify-between mb-3">
                                    <div class="col-4">
                                        <img src="{{ asset('assets/landing/images/icon-ac.png') }}" alt="icon ac">
                                    </div>
                                    <div class="col-8 text-end">
                                        <h2 class="fw-bold mb-0">
                                            {{ Auth::guard('customer')->user()->acCustomers->count() }}
                                        </h2>
                                    </div>
                                </div>

                                <a href="{{ route('customer.list_ac') }}" class="btn btn-blue w-100 py-3 px-2">
                                    Lihat Semua AC
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="d-block" id="create_order">
                <div class="row g-5">
                    <div class="col-lg-12">
                        <div class="card rounded-5 shadow border-0">
                            <div class="card-body text-center text-md-start">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <img src="{{ asset('assets/landing/images/service-dsb-1.png') }}" alt="amc service"
                                            class="rounded-5 mb-3 w-100">
                                    </div>
                                    <div class="col-md-6">
                                        <h3 class="fw-bold text-primary-blue">Service</h3>
                                        <p class="text-primary-blue fw-lighter">
                                            Perawatan dan pembersihan rutin AC
                                        </p>
                                        <a href="{{ route('customer.create_order') }}"
                                            class="btn btn-outline-blue w-100 ">Pesan
                                            Sekarang</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-block" id="list_orders">
                <div class="card rounded-5 w-100 border-0 my-4 shadow">
                    <div class="card-body p-4">
                        <div class="row justify-content-between mb-3 text-primary-blue g-3">
                            <div class="col-md-6">
                                <h4 class="mb-0 fs-2 text-primary-blue"><i
                                        class="fas fa-shopping-basket me-1 text-primary-blue"></i> Pesanan Aktif</h4>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('customer.list_order') }}" class="btn btn-blue rounded-5 py-2 w-100">Lihat
                                    Semua</a>
                            </div>
                        </div>
                        <ul>
                            @foreach ($orders as $order)
                                <li>
                                    <a href="{{ route('customer.order_detail', hash_id($order->id)) }}">
                                        <div class="card border-0">
                                            <div class="card-body">
                                                <!-- Display order details such as time, distance, location, and buttons -->
                                                <div class="row justify-content-between g-3">
                                                    <div class="col-md-6 order-2 order-md-1">
                                                        <i class="far fa-clock"></i>
                                                        {{ \Carbon\Carbon::parse($order->booked_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY [pukul] HH:mm') }}
                                                    </div>
                                                    <div class="col-md-6 order-1 order-md-2 text-start text-md-end">
                                                        <span
                                                            class="{{ $statusorder[$order->order_status][1] }}">{{ $statusorder[$order->order_status][0] }}</span>
                                                    </div>
                                                </div>
                                                <!-- Display location details -->
                                                <div class="row gy-2 gx-1 align-items-center">
                                                    <div class="col-12">
                                                        <ul class="fa-ul mb-3 text-primary-blue">
                                                            <li class="my-2">
                                                                <span class="fa-li">
                                                                    <i class="fas fa-map-marker-alt text-primary-blue"></i>
                                                                </span>
                                                                <p class="text-primary-blue"
                                                                    style="font-size: 18px;font-weight: 700;">
                                                                    {{ $order->address->address_name }}
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!-- Display service buttons -->
                                                <div class="col-12">
                                                    <div class="row g-3">
                                                        @foreach ($order->serviceCounts as $service)
                                                            <div class="col-auto text-start">
                                                                <button class="btn btn-outline-dark-blue me-1 p-1 px-2"
                                                                    style="font-size: 12px;">
                                                                    {{ $service['service_name'] }} -
                                                                    {{ $service['count'] }} unit
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <hr>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
            <div class="d-block" id="history_orders">
                <div class="card rounded-5 w-100 border-0 my-4 shadow">
                    <div class="card-body p-4">
                        <div class="row justify-content-between mb-3 text-primary-blue g-3">
                            <div class="col-md-6">
                                <h4 class="mb-0 fs-2 text-primary-blue">
                                    <i class="fas fa-hourglass-half me-1 text-primary-blue"></i>
                                    History Pesanan
                                </h4>
                            </div>
                            <div class="col-md-6 d-block d-md-flex justify-content-center justify-content-md-end">
                                <a href="{{ route('customer.list_order') }}"
                                    class="btn btn-blue rounded-5 py-2 px-3 ms-1">30
                                    Hari Terakhir</a>
                                <a href="{{ route('customer.list_order') }}"
                                    class="btn btn-outline-blue rounded-5 py-2 px-3 ms-1">Semua</a>

                            </div>
                        </div>
                        <ul>
                            @foreach ($orders as $order)
                                <li>
                                    <a href="{{ route('customer.order_detail', hash_id($order->id)) }}">
                                        <div class="card border-0">
                                            <div class="card-body">
                                                <!-- Display order details such as time, distance, location, and buttons -->
                                                <div class="row justify-content-between g-3">
                                                    <div class="col-md-6 order-2 order-md-1">
                                                        <i class="far fa-clock"></i>
                                                        {{ \Carbon\Carbon::parse($order->booked_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY [pukul] HH:mm') }}
                                                    </div>
                                                    <div class="col-md-6 order-1 order-md-2 text-start text-md-end">
                                                        <span
                                                            class="{{ $statusorder[$order->order_status][1] }}">{{ $statusorder[$order->order_status][0] }}</span>
                                                    </div>
                                                </div>
                                                <!-- Display location details -->
                                                <div class="row gy-2 gx-1 align-items-center">
                                                    <div class="col-12">
                                                        <ul class="fa-ul mb-3 text-primary-blue">
                                                            <li class="my-2">
                                                                <span class="fa-li">
                                                                    <i class="fas fa-map-marker-alt text-primary-blue"></i>
                                                                </span>
                                                                <p class="text-primary-blue"
                                                                    style="font-size: 18px;font-weight: 700;">
                                                                    {{ $order->address->address_name }}
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!-- Display service buttons -->
                                                <div class="col-12">
                                                    <div class="row g-3">

                                                        @foreach ($order->serviceCounts as $service)
                                                            <div class="col-auto text-start">
                                                                <button class="btn btn-outline-dark-blue me-1 p-1 px-2"
                                                                    style="font-size: 12px;">
                                                                    {{ $service['service_name'] }} -
                                                                    {{ $service['count'] }} unit
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <hr>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>

            <div class="row justify-content-between g-3">
                <div class="col-12 col-md-6">
                    <h4 class="mb-2 fs-2 text-primary-blue">
                        <i class="fas fa-calendar-day me-1 text-primary-blue"></i>
                        Perawatan AC Berikutnya
                    </h4>
                    <p>
                        Berikut AC yang disarankan untuk dilakukan perawatan Berkala Pada Bulan Ini
                    </p>
                </div>
                <div class="col-12 col-md-auto">
                    <button class="btn btn-outline-blue rounded-5 py-2 px-3 ms-1 w-100">
                        {{ $suggest_service->sum('ac_customer_count') }} Unit AC
                    </button>
                </div>
            </div>

            @foreach ($suggest_service as $s)
                <h2 class="fw-bold fs-3 py-3 text-primary-blue">{{ $s->address_name }}</h2>
                @php
                    $ac_customer = $s
                        ->ac_customer()
                        ->where(
                            'next_service',
                            '<=',
                            \Carbon\Carbon::now()
                                ->endOfMonth()
                                ->format('Y-m-d'),
                        )
                        ->get();
                @endphp
                <div class="row g-5">
                    @foreach ($ac_customer as $ac)
                        <div class="col-12 col-md-4">
                            <div class="card rounded-5 shadow border-0">
                                @php
                                    $next_service = $ac->next_service != null ? \Carbon\Carbon::parse($ac->next_service)->format('d F Y') : '-';
                                @endphp
                                <div class="card-body">
                                    <span class="text-secondary-blue">{{ $ac->ac->model }}</span>
                                    <h3 class="fw-bold">{{ $ac->ac->ac_full_name }}</h3>
                                    <p>
                                        {{ $ac->room_name }}
                                    </p>
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
                </div>
            @endforeach

        </div>
    @endsection
    @section('js')
    @endsection
