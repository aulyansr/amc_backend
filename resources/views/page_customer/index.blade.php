    @extends('layouts.screen_customer')
    @section('css')
    @endsection
    @section('content')
        <div class="container">
            <div class="d-block" id="address">
                @php
                    $address = $customer
                        ->masterAddress()
                        ->where('is_main', true)
                        ->first();
                @endphp
                @if ($customer->masterAddress()->count() > 0 && $address)
                    <div class="card rounded-3 w-100 bg-info mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <h4 class="mb-0"> <i class="fas fa-map-marker-alt me-1"></i></i>
                                    {{ $address->address_name }}</h4>
                                <a href="{{ route('customer.alamat.edit', hash_id($address->id)) }}"
                                    class="rounded-5 btn btn-warning btn-sm p-0 px-3 py-1 text-white"><i
                                        class="fas fa-edit me-1"></i>Ubah</a>
                            </div>

                            <p>
                                {{ $address->completedAddress }}
                                <span class="badge text-bg-info text-white">Utama</span>
                            </p>
                        </div>
                    </div>
                @else
                    <div class="card rounded-3 w-100 bg-info mb-4 border-danger">
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
                                            class="btn btn-outline-blue w-100 ">Pesan Sekarang</a>
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
                        <div class="row justify-content-between mb-5 text-primary-blue g-3">
                            <div class="col-md-6">
                                <h4 class="mb-0 fs-2 text-primary-blue"><i
                                        class="fas fa-shopping-basket me-1 text-primary-blue"></i> Semua
                                    Pesanan</h4>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('customer.list_order') }}"
                                    class="btn btn-dark-blue rounded-5 py-2 w-100">Lihat Semua</a>
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
        </div>
    @endsection
    @section('js')
    @endsection
