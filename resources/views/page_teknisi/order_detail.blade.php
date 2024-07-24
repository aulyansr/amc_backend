    @extends('layouts.screen_technician')
    @section('css')
    @endsection
    @section('content')
        <section class="content-tch">
            <div class="container">
                <div class="row gy-3">
                    <div class="col-12">
                        <div class="col-auto">
                            <p class="text-primary-blue ">Customer</p>
                        </div>
                        <div class="col-auto">
                            <span
                                class="{{ $statusorder[$order->order_status][1] }} {{ $statusorder[$order->order_status][2] }}">{{ $statusorder[$order->order_status][0] }}</span>
                        </div>

                        <div class="card card-homepage">
                            <div class="card-body">
                                <div class="row g-2 mb-2 align-items-center">
                                    <div class="col-12">
                                        <h1 class="text-primary-blue fs-4">{{ $order->customer->nama }}</h1>
                                    </div>
                                </div>
                                <hr>
                                <ul class="fa-ul mb-3">
                                    <li class="my-2">
                                        <span class="fa-li">
                                            <i class="fas fa-map-marker-alt text-primary-blue"></i>
                                        </span>
                                        <p style="font-size: 18px;font-weight: 700;">
                                            <span id="address">{{ $order->address->address_detail }}</span>
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
                        <div class="row g-3 justify-content-between mb-3">
                            <div class="col-auto">
                                <p class="text-primary-blue ">Orders</p>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-info">Cleaning</span>
                            </div>
                        </div>
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
                                <div class="d-flex mb-3">
                                    <p class="text-primary-blue">{{ $order->reason }}</p>

                                </div>
                                <a href="{{ route('technician.edit_order', $order->id) }}" class="btn btn-blue w-100 p-2">
                                    Ubah Order
                                </a>

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row g-3 justify-content-between mb-3 align-items-center">
                            <div class="col-auto">
                                <p class="text-primary-blue ">List AC</p>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('technician.add_detail_ac', $order->id) }}"
                                    class="btn btn-sm btn-primary py-2 px-3">
                                    Tambah AC</a>
                            </div>
                        </div>
                        <div class="card card-homepage">
                            <div class="card-body">
                                <div class="col-12">
                                    @foreach ($ac_customer as $value)
                                        <div class="row justify-content-between g-3 align-items-center mb-3">
                                            <div class="col-12">
                                                <h5 class="mb-0 text-primary-blue">{{ $value->qr_name }}</h5>
                                                <p class="mb-0">{{ $value->ac_customer->ac_name }}</p>
                                                <span class="fs-small text-info">Service Terkahir:</span>
                                                <p>{{ $value->ac_customer->order_details->last() ? $value->ac_customer->order_details->last()->date_complete ?? '-' : '-' }}
                                            </div>
                                            <div class="col-auto">

                                                @if ($order->order_details->where('ac_customer_id', $value->ac_customer->id)->count() > 0)
                                                    <a href="{{ route('technician.upload_image_before', [$order->id, $value->url_unique]) }}"
                                                        class="btn btn-sm btn-danger py-2 px-3">
                                                        Gambar Sebelum</a>
                                                @elseif($order->order_status == 6)
                                                @else
                                                    <a href="{{ route('technician.add_service_ac', [$order->id, $value->url_unique]) }}"
                                                        class="btn btn-sm btn-dark-blue py-2 px-3">Service</a>
                                                @endif

                                            </div>
                                            <div class="col-auto">
                                                @if ($order->order_details->where('ac_customer_id', $value->ac_customer->id)->count() > 0)
                                                    <a href="{{ route('technician.upload_image_after', [$order->id, $value->url_unique]) }}"
                                                        class="btn btn-sm btn-success py-2 px-3">
                                                        Gambar Sesudah</a>
                                                @endif
                                            </div>
                                            <div class="col-auto">
                                                @if (
                                                    $order->order_details->contains(function ($detail) use ($value) {
                                                        return $detail->ac_customer_id === $value->ac_customer->id && $detail->orderDetailAttachments->count() > 0;
                                                    }))
                                                    <a href="{{ route('technician.view_image_before', [$order->id, $value->url_unique]) }}"
                                                        class="btn btn-sm btn-primary py-2 px-3">Lihat Gambar</a>
                                                @endif
                                            </div>
                                        </div>
                                        @if (!$loop->last)
                                            <hr>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($order->order_status == 9)
                        <div class="col-12">
                            <p class="text-primary-blue ">Pending Order</p>
                            <div class="card card-homepage">
                                <div class="card-body">
                                    @foreach ($order->detail_pending_order as $pending)
                                        <h3 class="mb-2 text-primary-blue fs-4">{{ $pending->alasan }}</h3>
                                        <p class="mb-3">
                                            {{ $pending->deskripsi }}
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <form action="{{ route('technician.check_in', $order->id) }}"
                                onsubmit="return changeStatus(event)" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-blue w-100">Menuju Lokasi</button>
                            </form>
                        </div>
                    @endif

                    <div class="col-12">
                        @if (empty($order->work_order) && $order->customer->type == 1)
                            {{-- <div class="col-auto">
                                <button type="button" class="btn btn-dark-blue w-100 my-3" data-bs-toggle="modal"
                                    data-bs-target="#WorkOrderModal">
                                    Upload Work Order
                                </button>
                            </div> --}}
                        @elseif(!empty($order->work_order))
                            <div class="col-auto">
                                <a href="{{ asset('storage/images/orders/work_order/' . $order->work_order) }}" download
                                    class="btn btn-success w-100"
                                    style="padding: 5px 10px; border-radius: 20px;font-size: 13px;">Download Work Order</a>
                            </div>
                        @endif

                        @if ($order->order_status > 2 && $order->order_status < 5 && $pivot->status_team < 5)
                            <form action="{{ route('technician.check_in', $order->id) }}"
                                onsubmit="return changeStatus(event)" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-blue w-100">Menuju Lokasi</button>
                            </form>
                        @endif
                        {{-- @if ($order->order_status != 6)
                            <a href="" class="btn btn-outline-danger w-100"
                                style="padding: 5px 10px; border-radius: 20px;font-size: 13px;">
                                Batalkan
                            </a>
                        @endif --}}
                    </div>


                </div>
            </div>
        </section>
        <!-- WorkOrder Modal -->
        <div class="modal fade" id="WorkOrderModal" tabindex="-1" aria-labelledby="WorkOrderModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="WorkOrderModalLabel">Upload Work Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('technician.upload_work_order', $order->id) }}" method="POST"
                        enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="col-12">
                                @csrf
                                <div class="row g-3">
                                    <div class="row g-3">
                                        <div class="col-12" id="work_order">
                                            <div class="form-group">
                                                <label for="work_order">Work Order</label>
                                                <input type="file" name="work_order" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
    @section('js')
        <script>
            function changeStatus(e) {
                e.preventDefault()
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: `Kamu akan Update order status ke menuju lokasi.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, update it!',
                    confirmButtonColor: '#28a745',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.submit()
                    } else {
                        return false;
                    }
                });
            }
            $(document).ready(function() {
                $('#changeStatusButton').click(function(e) {
                    e.preventDefault();

                    var buttonText = $('#text-status').text();
                    console.log(buttonText);
                    var newStatus;
                    var text = '';
                    if (buttonText == 'Menuju Lokasi') {
                        newStatus = 4;
                        text = 'Menuju Lokasi';
                    } else if (buttonText === 'Mulai Pekerjaan') {
                        newStatus = 5;
                        text = 'Mulai Pekerjaan';
                    } else {
                        newStatus = 4;
                        text = 'Menuju Lokasi';
                    }

                    Swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: `Kamu akan Update order status ke ${text}.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, update it!',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('technician.updateOrderStatus', $order->id) }}',
                                data: {
                                    '_token': '{{ csrf_token() }}',
                                    'new_status': newStatus,
                                },
                                success: function(data) {
                                    $('#text-status').text('Mulai Pekerjaan');
                                    if (newStatus == 5) {
                                        $('#changeStatusButton').addClass('d-none');
                                    }
                                    console.log(data);
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Order status berhasil di ubah.',
                                        icon: 'success',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                    });
                                },
                                error: function(error) {
                                    console.error('Error:', error);
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endsection
