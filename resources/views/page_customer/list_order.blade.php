    @extends('layouts.screen_customer')
    @section('css')
    @endsection
    @section('content')
        <div class="container">

            <div class="d-flex align-items-center mb-3">
                <img src="{{ asset('assets/landing/images/ic_todo.png') }}" alt="amc" class="mw-100 me-3">
                <h2 class="m-0 text-primary-blue fs-2 fw-bolder">Daftar Pesanan</h2>
            </div>

            <div class="row gy-3">
                <div class="col-12">
                    <ul class="nav nav-pills" id="orders" role="tablist">
                        <li class="nav-item me-1 mb-2" role="presentation">
                            <button class="nav-link active" id="all_order" data-bs-toggle="tab"
                                data-bs-target="#all_order-pane" type="button" role="tab"
                                aria-controls="all_order-pane" aria-selected="true">Semua</button>
                        </li>
                        <li class="nav-item me-1 mb-2" role="presentation">
                            <button class="nav-link" id="order_on_progress" data-bs-toggle="tab"
                                data-bs-target="#order_on_progress-pane" type="button" role="tab"
                                aria-controls="order_on_progress-pane" aria-selected="false">Dalam Pengerjaan</button>
                        </li>
                        <li class="nav-item me-1 mb-2" role="presentation">
                            <button class="nav-link" id="order-cancel" data-bs-toggle="tab"
                                data-bs-target="#order-cancel-pane" type="button" role="tab"
                                aria-controls="order-cancel-pane" aria-selected="true">Dibatalkan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="order-finish" data-bs-toggle="tab"
                                data-bs-target="#order-finish-pane" type="button" role="tab"
                                aria-controls="order-finish-pane" aria-selected="false">Selesai</button>
                        </li>
                    </ul>
                </div>
                <div class="">
                    <div class="card-body">
                        <div class="tab-content" id="ordersContent">
                            <div class="tab-pane fade show active" id="all_order-pane" role="tabpanel"
                                aria-labelledby="all_order" tabindex="0">
                                <div class="d-block">
                                    <ul>
                                        @foreach ($all_order as $order)
                                            <li class="my-3">
                                                <a href="{{ route('customer.order_detail', hash_id($order->id)) }}">
                                                    <div class="card border-0">
                                                        <div class="card-body">
                                                            <!-- Display order details such as time, distance, location, and buttons -->
                                                            <div class="row justify-content-between g-3">
                                                                <div class="col-md-6 order-2 order-md-1">
                                                                    <i class="far fa-clock"></i>
                                                                    {{ \Carbon\Carbon::parse($order->booked_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY [pukul] HH:mm') }}
                                                                </div>
                                                                <div
                                                                    class="col-md-6 order-1 order-md-2 text-start text-md-end">
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
                                                                <div class="row g-3">
                                                                    @foreach ($order->serviceCounts as $service)
                                                                        <div class="col-auto text-start">
                                                                            <button
                                                                                class="btn btn-outline-dark-blue me-1 p-1 px-2"
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
                                            </li>
                                        @endforeach
                                    </ul>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="order_on_progress-pane" role="tabpanel"
                                aria-labelledby="order_on_progress" tabindex="0">
                                <div class="d-block">
                                    <ul>
                                        @foreach ($on_progress_order as $order)
                                            <li class="my-3">
                                                <a href="{{ route('customer.order_detail', hash_id($order->id)) }}">
                                                    <div class="card border-0">
                                                        <div class="card-body">
                                                            <!-- Display order details such as time, distance, location, and buttons -->
                                                            <div class="row justify-content-between g-3">
                                                                <div class="col-md-6 order-2 order-md-1">
                                                                    <i class="far fa-clock"></i>
                                                                    {{ \Carbon\Carbon::parse($order->booked_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY [pukul] HH:mm') }}
                                                                </div>
                                                                <div
                                                                    class="col-md-6 order-1 order-md-2 text-start text-md-end">
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
                                                                <div class="row g-3">
                                                                    @foreach ($order->serviceCounts as $service)
                                                                        <div class="col-auto text-start">
                                                                            <button
                                                                                class="btn btn-outline-dark-blue me-1 p-1 px-2"
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
                                            </li>
                                        @endforeach
                                    </ul>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="order-cancel-pane" role="tabpanel"
                                aria-labelledby="order-cancel" tabindex="0">
                                <div class="d-block">
                                    <ul>
                                        @foreach ($canceled as $order)
                                            <li class="my-3">
                                                <a href="{{ route('customer.order_detail', hash_id($order->id)) }}">
                                                    <div class="card border-0">
                                                        <div class="card-body">
                                                            <!-- Display order details such as time, distance, location, and buttons -->
                                                            <div class="row justify-content-between g-3">
                                                                <div class="col-md-6 order-2 order-md-1">
                                                                    <i class="far fa-clock"></i>
                                                                    {{ \Carbon\Carbon::parse($order->booked_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY [pukul] HH:mm') }}
                                                                </div>
                                                                <div
                                                                    class="col-md-6 order-1 order-md-2 text-start text-md-end">
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
                                                                <div class="row g-3">
                                                                    @foreach ($order->serviceCounts as $service)
                                                                        <div class="col-auto text-start">
                                                                            <button
                                                                                class="btn btn-outline-dark-blue me-1 p-1 px-2"
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
                                            </li>
                                        @endforeach
                                    </ul>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="order-finish-pane" role="tabpanel"
                                aria-labelledby="order-cancel" tabindex="0">
                                <div class="d-block">
                                    <ul>
                                        @foreach ($finish as $order)
                                            <li class="my-3">
                                                <a href="{{ route('customer.order_detail', hash_id($order->id)) }}">
                                                    <div class="card border-0">
                                                        <div class="card-body">
                                                            <!-- Display order details such as time, distance, location, and buttons -->
                                                            <div class="row justify-content-between g-3">
                                                                <div class="col-md-6 order-2 order-md-1">
                                                                    <i class="far fa-clock"></i>
                                                                    {{ \Carbon\Carbon::parse($order->booked_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY [pukul] HH:mm') }}
                                                                </div>
                                                                <div
                                                                    class="col-md-6 order-1 order-md-2 text-start text-md-end">
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
                                                                <div class="row g-3">
                                                                    @foreach ($order->serviceCounts as $service)
                                                                        <div class="col-auto text-start">
                                                                            <button
                                                                                class="btn btn-outline-dark-blue me-1 p-1 px-2"
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
                                            </li>
                                        @endforeach
                                    </ul>

                                </div>
                            </div>
                        </div>
                        <a href="{{ route('customer.create_order') }}" class="btn btn-outline-blue w-100 ">Buat Pesanan
                            Baru</a>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('js')
    @endsection
