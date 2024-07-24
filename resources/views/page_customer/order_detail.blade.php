    @extends('layouts.screen_customer')
    @section('css')
    @endsection
    @section('content')
        <div class="container">
            <div class="row gy-3">
                <div class="col-12">
                    <div class="d-flex justify-content-between mb-3">
                        <p class="text-primary-blue mb-0">Customer</p>
                        @if ($order->order_status == 1)
                            <span class="badge rounded-pill text-bg-danger">UNPAID</span>
                        @else
                            <span
                                class="{{ $statusorder[$order->order_status][1] }}">{{ $statusorder[$order->order_status][0] }}</span>
                        @endif
                    </div>

                    <div class="card card-homepage">
                        <div class="card-body">
                            <div class="row g-2 mb-2 align-items-center">
                                <div class="col-12">
                                    <h1 class="text-primary-blue">{{ $order->customer->nama }}</h1>
                                </div>
                            </div>
                            <hr>
                            <ul class="fa-ul mb-3">
                                <li class="my-2">
                                    <span class="fa-li">
                                        <i class="fas fa-map-marker-alt text-primary-blue"></i>
                                    </span>
                                    <p style="font-size: 18px;font-weight: 700;">
                                        {{ $order->address->address_name }}, {{ $order->address->address_detail }}
                                    </p>
                                </li>
                                <li class="my-2">
                                    <span class="fa-li">

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-primary-blue ">Orders</p>
                    <div class="card card-homepage">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0 text-primary-blue">Order Code: </h3>
                                <h3 class="mb-0 fw-bold">{{ $order->order_code }}</h3>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <p class="text-primary-blue">Order Dibuat</p>
                                <p class="fw-bold">
                                    {{ \Carbon\Carbon::parse($order->created_at)->locale('id')->isoFormat('DD MMMM YYYY [jam] HH:mm') }}
                                </p>
                            </div>

                            <div class="d-flex justify-content-between">
                                <p class="text-primary-blue">Tanggal Pengerjaan</p>
                                <p class="fw-bold">
                                    {{ \Carbon\Carbon::parse($order->booked_date)->locale('id')->isoFormat('DD MMMM YYYY [jam] HH:mm') }}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <div class="div">
                                    <p class="">Layanan</p>
                                </div>
                            </div>
                            @foreach ($order->serviceCounts as $service)
                                <div class="d-flex justify-content-between">
                                    <p class="text-primary-blue">{{ $service['service_name'] }}</p>
                                    <p class="fw-bold">{{ $service['count'] }} unit</p>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-between mb-3">
                                <div class="div">
                                    <p class="">Keluhan</p>
                                </div>
                            </div>
                            <div class="d-flex ">
                                <p class="text-primary-blue">{{ $order->reason }}</p>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-primary-blue ">Biaya</p>
                    <div class="card card-homepage">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="div">
                                    <p class="">Layanan</p>
                                </div>
                            </div>
                            @foreach ($order->serviceCounts as $service)
                                <div class="d-flex justify-content-between">
                                    <p class="text-primary-blue">{{ $service['count'] }} unit
                                        {{ $service['service_name'] }}
                                    </p>
                                    <p class="fw-bold">
                                        {{ 'Rp. ' . number_format($service['price'], 0, ',', '.') }}
                                    </p>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-between mb-3">
                                <div class="div">
                                    <p class="">Biaya Lain</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-primary-blue">Transport Fee</p>
                                <p class="fw-bold">{{ 'Rp. ' . number_format($order->transport_fee, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <div class="div">
                                    <p class="">Discount</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                {{-- <div>
                                    <p class="text-primary-blue mb-0">Voucher</p>
                                    <small class="text-muted" style="font-size:12px">OCTOBREZEE</small>
                                </div>
                                <p class="fw-bold">- Rp. 30.000</p> --}}
                                <p class="text-primary-blue mb-0">Tidak Ada Voucher</p>
                                <p class="fw-bold">0</p>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h3 class="mb-0 text-primary-blue">Grand Total </h3>
                                <h3 class="mb-0 fw-bold">{{ 'Rp. ' . number_format($order->grand_total, 0, ',', '.') }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    @if ($order->order_status == 1)
                        @if (Auth::guard('customer')->user()->type != 1)
                            <h3 class="mt-4 fw-bold">Metode Pembayaran</h3>
                            <p class="">
                                <b>Bank Name:</b> BCA <br>
                                <b>Account Name:</b> PT.Aircon Manajemen Corpora <br>
                                8650626738 <br>

                            <ul>
                                <li>Apabila telah melakukan pembayaran dimohon untuk kirim bukti transfer atau WA Finance
                                    <a class="text-primary-blue" href="https://api.whatsapp.com/send?phone=6285210632227"
                                        target="_blank">
                                        AMC Customer Care
                                    </a>
                                </li>
                            </ul>
                            </p>
                        @endif
                        <div class="row g-3 justify-content-center">
                            <div class="col-12 col-md-7">
                                <a href="https://api.whatsapp.com/send?phone=6285210632227&&text=Bukti%20Pemabayaran%20{{ $order->order_code }}"
                                    class="btn btn-success w-100 px-3 py-2">
                                    Kirim Bukti Pembayaran
                                </a>
                            </div>
                            <div class="col-12 col-md-7">
                                <a href="https://api.whatsapp.com/send?phone=6285210632227&&text=Pembatalan%20Pesanan"
                                    class="btn btn-outline-danger w-100 px-3 py-2">
                                    Batalkan
                                </a>
                            </div>
                        </div>
                    @endif


                </div>



            </div>
        </div>
        </div>
    @endsection
    @section('js')
    @endsection
