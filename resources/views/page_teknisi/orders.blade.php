    @extends('layouts.screen_technician')
    @section('css')
    @endsection
    @section('content')
        <section class="content-tch">
            <div class="container">
                <div class="row gx-2 gy-3 align-items-center mb-3">
                    <div class="col-1">
                        <img src="{{ asset('assets/landing/images/ic_todo.png') }}" alt="amc" class="mw-100">
                    </div>
                    <div class="col-5">
                        <p class="mb-0 text-muted">Daftar Pekerjaan</p>
                    </div>
                </div>
                <div class="row gy-3">
                    <div class="col-12">
                        <ul class="nav nav-pills" id="orders" role="tablist">
                            <li class="nav-item me-1 mb-2" role="presentation">
                                <button class="nav-link active" id="order-today" data-bs-toggle="tab"
                                    data-bs-target="#order-today-pane" type="button" role="tab"
                                    aria-controls="order-today-pane" aria-selected="true">Hari Ini</button>
                            </li>
                            <li class="nav-item me-1 mb-2" role="presentation">
                                <button class="nav-link" id="order-tomorow" data-bs-toggle="tab"
                                    data-bs-target="#order-tomorow-pane" type="button" role="tab"
                                    aria-controls="order-tomorow-pane" aria-selected="false">Besok</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="order-finish" data-bs-toggle="tab"
                                    data-bs-target="#order-finish-pane" type="button" role="tab"
                                    aria-controls="order-finish-pane" aria-selected="false">Selesai</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="order-not-complete" data-bs-toggle="tab"
                                    data-bs-target="#order-not-completed-pane" type="button" role="tab"
                                    aria-controls="order-not-complete-pane" aria-selected="false">Belum Selesai</button>
                            </li>
                            <li class="nav-item me-1 mb-2" role="presentation">
                                <button class="nav-link" id="order-cancel" data-bs-toggle="tab"
                                    data-bs-target="#order-cancel-pane" type="button" role="tab"
                                    aria-controls="order-cancel-pane" aria-selected="true">Dibatalkan</button>
                            </li>
                            <li class="nav-item me-1 mb-2" role="presentation">
                                <button class="nav-link" id="order-pending" data-bs-toggle="tab"
                                    data-bs-target="#order-pending-pane" type="button" role="tab"
                                    aria-controls="order-pending-pane" aria-selected="true">Pending</button>
                            </li>
                        </ul>
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
                                                    <a href="{{ route('technician.orderDetail', ['id' => $order->id]) }}">
                                                        <div class="card card-homepage">
                                                            <div class="card-body">
                                                                <!-- Display order details such as time, distance, location, and buttons -->
                                                                <div class=" d-flex justify-content-between">
                                                                    <div>
                                                                        <i class="far fa-clock"></i>
                                                                        {{ \Carbon\Carbon::parse($order->booked_date)->format('H:i') }}
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
                                                                                class="btn btn-outline-dark-blue me-1 mb-2"
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
                                                    <a href="{{ route('technician.orderDetail', ['id' => $order->id]) }}">
                                                        <div class="card card-homepage">
                                                            <div class="card-body">
                                                                <!-- Display order details such as time, distance, location, and buttons -->
                                                                <div class=" d-flex justify-content-between">
                                                                    <div>
                                                                        <i class="far fa-clock"></i>
                                                                        {{ \Carbon\Carbon::parse($order->booked_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY [pukul] HH:mm') }}
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
                                                                                class="btn btn-outline-dark-blue me-1 mb-2"
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
                                <div class="tab-pane fade" id="order-cancel-pane" role="tabpanel"
                                    aria-labelledby="order-cancel" tabindex="0">
                                    <div class="d-block">
                                        <ul>
                                            @foreach ($orders['canceled'] as $order)
                                                <li>
                                                    <a href="{{ route('technician.orderDetail', ['id' => $order->id]) }}">
                                                        <div class="card card-homepage">
                                                            <div class="card-body">
                                                                <!-- Display order details such as time, distance, location, and buttons -->
                                                                <div class=" d-flex justify-content-between">
                                                                    <div>
                                                                        <i class="far fa-clock"></i>
                                                                        {{ \Carbon\Carbon::parse($order->booked_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY [pukul] HH:mm') }}
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
                                                                                class="btn btn-outline-dark-blue me-1 mb-2"
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
                                <div class="tab-pane fade" id="order-finish-pane" role="tabpanel"
                                    aria-labelledby="order-cancel" tabindex="0">
                                    <div class="d-block">
                                        <ul>
                                            @foreach ($orders['finish'] as $order)
                                                <li>
                                                    <a href="{{ route('technician.orderDetail', ['id' => $order->id]) }}">
                                                        <div class="card card-homepage">
                                                            <div class="card-body">
                                                                <!-- Display order details such as time, distance, location, and buttons -->
                                                                <div class=" d-flex justify-content-between">
                                                                    <div>
                                                                        <i class="far fa-clock"></i>
                                                                        {{ \Carbon\Carbon::parse($order->booked_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY [pukul] HH:mm') }}
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
                                                                                class="btn btn-outline-dark-blue me-1 mb-2"
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
                                <div class="tab-pane fade" id="order-not-completed-pane" role="tabpanel"
                                    aria-labelledby="order-cancel" tabindex="0">
                                    <div class="d-block">
                                        <ul>
                                            @foreach ($orders['not_completed'] as $order)
                                                <li>
                                                    <a href="{{ route('technician.orderDetail', ['id' => $order->id]) }}">
                                                        <div class="card card-homepage">
                                                            <div class="card-body">
                                                                <!-- Display order details such as time, distance, location, and buttons -->
                                                                <div class=" d-flex justify-content-between">
                                                                    <div>
                                                                        <i class="far fa-clock"></i>
                                                                        {{ \Carbon\Carbon::parse($order->booked_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY [pukul] HH:mm') }}
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
                                                                                class="btn btn-outline-dark-blue me-1 mb-2"
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
                                <div class="tab-pane fade" id="order-pending-pane" role="tabpanel"
                                    aria-labelledby="order-pending" tabindex="0">
                                    <div class="d-block">
                                        <ul>
                                            @foreach ($orders['pending'] as $order)
                                                <li>
                                                    <a href="{{ route('technician.orderDetail', ['id' => $order->id]) }}">
                                                        <div class="card card-homepage">
                                                            <div class="card-body">
                                                                <!-- Display order details such as time, distance, location, and buttons -->
                                                                <div class=" d-flex justify-content-between">
                                                                    <div>
                                                                        <i class="far fa-clock"></i>
                                                                        {{ \Carbon\Carbon::parse($order->booked_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY [pukul] HH:mm') }}
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
                                                                                class="btn btn-outline-dark-blue me-1 mb-2"
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
