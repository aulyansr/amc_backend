@extends('layouts.admin')
@section('title', '')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .dropify-wrapper .dropify-message p {
            margin: 5px 0 0;
            font-size: 20px;
        }
    </style>
@endsection
@section('content')
    @php
        $serviceCounts = $order->serviceCounts;
        $text = '';
        if ($order->order_status == 1) {
            $text = '*Invoice AMC Servis AC*%0A%0A*Service*%3A%0A';

            foreach ($serviceCounts as $service):
                $text .= '-+' . $service['service_name'] . '+%3A+Rp+' . thousand_rupiah($service['sub_total']) . '%0A';
            endforeach;
            $text .=
                '%0A*Subtotal*%3A+' .
                thousand_rupiah($order->total_base_price) .
                '%0A*Transport+Fee*%3A+' .
                thousand_rupiah($order->transport_fee) .
                '%0A*Diskon*%3A+' .
                thousand_rupiah($order->diskon) .
                '%0A%0A*Grand+Total*%3A+' .
                thousand_rupiah($order->grand_total) .
                '%0A%0ASilakan+transfer+ke+rekening+*111+A.N.+Si+A*.%0A%0ATerima+kasih+telah+menggunakan+layanan+kami!';
        }
    @endphp
    <section class="content">
        <div class="row g-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="col-12 mt-3">
                        @if ($order->order_history->count() > 0)
                            <ul class="nav nav-pills bg-nav-pills border-1 border-black nav-justified mb-3">
                                <li class="nav-item">
                                    <a href="#order1" data-bs-toggle="tab" aria-expanded="false"
                                        class="nav-link rounded-0 active">
                                        <i class="mdi mdi-cart-arrow-down d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Order</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#revisi1" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                        <i class="mdi mdi-book-account d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Data Revisi</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="order1">
                            <div class="card-header bg-blue">
                                <div class="row g-2">
                                    <div class="col-lg-6 col-12">
                                        <h3>Data Order {{ $order->order_code }}</h3>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="row g-3 justify-content-end">
                                            @if ($order->order_status != 0)
                                                @can('orders-invoice')
                                                    @if ($order->complete_invoice)
                                                        <div class="col-auto">
                                                            <a href="{{ asset('storage/invoices/' . $order->complete_invoice) }}"
                                                                download class="btn btn-primary">Download Invoice</a>
                                                        </div>
                                                    @else
                                                        <div class="col-auto">
                                                            <a target="_blank" href="{{ route('orders.invoice', $order->id) }}"
                                                                class="btn btn-secondary">Download Invoice</a>
                                                        </div>
                                                    @endif
                                                @endcan
                                            @endif
                                            @can('orders-completedorder')
                                                @if ($order->order_status < 6 && $order->order_status > 2)
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#completeModal">
                                                            Complete Order
                                                        </button>
                                                    </div>
                                                @endif
                                            @endcan
                                            @can('orders-completedpayment')
                                                @if (
                                                    ($order->payment_status == 0 || $order->payment_status == 1) &&
                                                        $order->order_status != 0 &&
                                                        isset($order->payment_status))
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                            data-bs-target="#paymentModal">
                                                            Selesaikan Pembayaran
                                                        </button>
                                                    </div>
                                                @endif
                                            @endcan
                                            @can('orders-workorder')
                                                @if (empty($order->work_order) && $order->customer->type == 1)
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                            data-bs-target="#WorkOrderModal">
                                                            Upload Work Order
                                                        </button>
                                                    </div>
                                                @elseif(!empty($order->work_order))
                                                    <div class="col-auto">
                                                        <a href="{{ asset('storage/images/orders/work_order/' . $order->work_order) }}"
                                                            download class="btn btn-primary">Download Work Order</a>
                                                    </div>
                                                @endif
                                            @endcan
                                            <div class="col-auto">
                                                <a target="_blank"
                                                    href="https://wa.me/{{ convertPhone($order->customer->phone) }}?text={{ $text }}"
                                                    class="btn btn-success"><i class="mdi mdi-whatsapp"></i> Kirim Pesan Ke
                                                    Customer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <h5>Ref No</h5>
                                            <p>{{ $order->ref_no }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <h5>Tanggal dan Jam Booking</h5>
                                            <p>{{ date('D, d-F-Y / H:i', strtotime($order->booked_date)) }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <h5>Cabang</h5>
                                            <p>{{ $order->branch?->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <h5>Nama Customer</h5>
                                            <p>{{ $order->customer->nama }}</p>
                                        </div>
                                    </div>
                                    @if ($order->customer->type == '2')
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <h5>Nama Customer b2bc</h5>
                                                <p>{{ $order->customer_b2b2c->nama }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <h5>Alamat : </h5>
                                            <p>{{ $order->address->completedAddress }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <h5>Order Status</h5>
                                            <p>
                                                @if (
                                                    $order->teams->groupBy('pivot.status_team')->count() > 1 &&
                                                        ($order->order_status != 0 || $order->order_status != 6))
                                                    @foreach ($order->teams->groupBy('pivot.status_team') as $status => $count)
                                                        @if ($count->first()->pivot->status_team)
                                                            <span
                                                                class="{{ $statusorder[$count->first()->pivot->status_team][1] }}">{{ count($count) . ' ' . $statusorder[$count->first()->pivot->status_team][0] }}</span>
                                                        @else
                                                            <span class="badge bg-danger">{{ count($count) }} Tidak Ada
                                                                Status</span>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <span
                                                        class="{{ $statusorder[$order->order_status][1] }}">{{ $statusorder[$order->order_status][0] }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <h5>Payment Status</h5>
                                            @if (isset($order->payment_status))
                                                <span
                                                    class="{{ $statuspayment[$order->payment_status][1] }}">{{ $statuspayment[$order->payment_status][0] }}</span>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <h5>Metode Order</h5>
                                            <p>{{ $order->order_method }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <h5>Alasan Servis</h5>
                                            <p>{{ $order->reason }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <h5>Keterangan Lainnya</h5>
                                            <p>{{ $order->keterangan }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <h5>Banyak Revisi</h5>
                                            <p>{{ $order->order_history->count() }}</p>
                                        </div>
                                    </div>
                                    @if ($order->payment_type == 'Term Of Payment')
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <h5>Tanggal Jatuh Tempo</h5>
                                                <p>{{ date('d-m-Y', strtotime($order->payment_duedate)) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <h5>Keterangan Pembayaran</h5>
                                                <p>{{ $order->payment_details }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12">
                                        <h3>Detail Order</h3>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <th>Service</th>
                                                    <th>Harga</th>
                                                    <th>Qty</th>
                                                    <th>total harga</th>
                                                    <th>Discount</th>
                                                    <th>Sub Total</th>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->serviceCounts as $service)
                                                        <tr>
                                                            <td>{{ $service['service_name'] }}</td>
                                                            <td>{{ thousand_rupiah($service['price']) }}</td>
                                                            <td>{{ $service['count'] }}</td>
                                                            <td>{{ thousand_rupiah((int) $service['count'] * (int) $service['price']) }}
                                                            </td>
                                                            <td>{{ thousand_rupiah($service['discount']) }}</td>
                                                            <td>{{ thousand_rupiah((int) $service['count'] * (int) $service['price'] - (int) $service['discount']) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    @foreach ($order->spare_part as $spare_part)
                                                        <tr>
                                                            <td>{{ $spare_part->spare_part->name }}</td>
                                                            <td>{{ thousand_rupiah($spare_part->base_price) }}</td>
                                                            <td>{{ $spare_part->quantity }}</td>
                                                            <td>{{ thousand_rupiah($spare_part->quantity * $spare_part->base_price) }}
                                                            </td>
                                                            <td>{{ thousand_rupiah($spare_part->discount) }}</td>
                                                            <td>{{ thousand_rupiah($spare_part->quantity * $spare_part->base_price - $spare_part->discount) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-end" colspan="5">Sub Total</th>
                                                        <th>{{ thousand_rupiah($order->total_base_price) }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-end" colspan="5">Transport Fee</th>
                                                        <th>{{ thousand_rupiah($order->transport_fee) }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-end" colspan="5">Diskon</th>
                                                        <th>{{ thousand_rupiah($order->diskon) }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-end" colspan="5">Grand Total</th>
                                                        <th>{{ thousand_rupiah($order->grand_total) }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    @if (!empty($order->payment_date))
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <h5>Tipe dan Tanggal Pembayaran</h5>
                                                <p>{{ Str::title($order->payment_type) }} -
                                                    {{ date('D, d-F-Y H:i', strtotime($order->payment_date)) }} </p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <h5>Bukti Pembayaran</h5>
                                                @if ($order->file_receipt)
                                                    <a href="{{ asset('storage/images/orders/payment/' . $order->file_receipt) }}"
                                                        download class="btn btn-primary">Download File</a>
                                                @else
                                                    <p>-</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    @if (!$order->teams->isEmpty())
                                        <div class="col-12">
                                            <div class="row g-3">
                                                <div class="col-6">
                                                    <h3>Team yang ditugaskan</h3>
                                                </div>
                                                @can('orders-assignteam')
                                                    @if ($order->order_status < 6 && $order->order_status > 2)
                                                        <div class="col-6 text-lg-end">
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                Add New Team
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endcan
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <th>Nama Team</th>
                                                        <th>Anggota Team</th>
                                                        <th>Status Team</th>
                                                        <th>Hapus Team</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->teams as $team)
                                                            <tr>
                                                                <td>{{ $team->nama }}</td>
                                                                <td>
                                                                    @foreach ($team->technician as $tech)
                                                                        {{ "- $tech->fullname ( {$tech->pivot->status} )" }}
                                                                        <br>
                                                                    @endforeach
                                                                </td>
                                                                <td>
                                                                    @if (!empty($team->pivot->status_team))
                                                                        <span
                                                                            class="{{ $statusorder[$team->pivot->status_team][1] }}">{{ $statusorder[$team->pivot->status_team][0] }}</span>
                                                                    @else
                                                                        <span class="badge bg-danger">Tidak Ada
                                                                            Status</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if (
                                                                        (empty($team->pivot->status_team) || $team->pivot->status_team == 3) &&
                                                                            ($order->order_status < 6 && $order->order_status > 2))
                                                                        <form
                                                                            action="{{ route('orders.deleteassignteam', $order->id) }}"
                                                                            method="POST" onClick="return deleteData()">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="team_id"
                                                                                value="{{ $team->id }}">
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Hapus</button>
                                                                        </form>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($order->customer_b2b2c != '')
                                        <div class="col-12">
                                            <h3>Dokumen Pendukung</h3>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-body text-center">
                                                            <p>Dokumen SPK</p>
                                                            @if ($order->work_order)
                                                                <a href="{{ asset('storage/images/orders/work_order/' . $order->work_order) }}"
                                                                    download class="btn btn-primary">Download File</a>
                                                            @else
                                                                <p>-</p>
                                                            @endif
                                                            <button type="button" class="btn btn-outline-warning"
                                                                data-bs-toggle="modal" data-bs-target="#WorkOrderModal">
                                                                Upload Foto SPK
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-body text-center">

                                                            <p>Work Order Aplikasi (PDF)</p>

                                                            @if ($order->work_order_doc)
                                                                <a href="{{ asset('storage/images/orders/work_order_doc/' . $order->work_order_doc) }}"
                                                                    download class="btn btn-primary">Download File</a>
                                                            @else
                                                                <p>-</p>
                                                            @endif


                                                            <button type="button" class="btn btn-outline-warning"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#WorkOrderModalDoc">
                                                                Upload PDF
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($order->order_status == 1)
                                        @can('orders-payment')
                                            <div class="col-12">
                                                <h3>Upload Bukti Pembayaran</h3>
                                            </div>
                                            @if ($errors->any())
                                                <div class="col-12">
                                                    <div class="alert alert-danger">
                                                        <strong>Whoops!</strong>Something went wrong.<br><br>
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-12">
                                                <form action="{{ route('orders.payment', $order->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row g-3">
                                                        <div class="col-lg-6 col-12">
                                                            <div class="form-group">
                                                                <label for="payment_type">Tipe Pembayaran</label>
                                                                <select name="payment_type" id="payment_type"
                                                                    class="form-control" required>
                                                                    <option value="">Pilih Tipe Pembayaran</option>
                                                                    <option value="cash">Cash</option>
                                                                    <option value="transfer">Transfer</option>
                                                                    @if ($order->customer->type == '1' || $order->customer->type == '2')
                                                                        <option value="Term Of Payment">Term Of Payment
                                                                        </option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-12 d-none" id="payment_duedate_tab">
                                                            <div class="form-group">
                                                                <label for="payment_duedate">Tanggal Jatuh Tempo</label>
                                                                {{ Form::text('payment_duedate', null, ['class' => 'form-control one-datepicker']) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-12 d-none" id="payment_detail_tab">
                                                            <div class="form-group">
                                                                <label for="payment_detail">Detail Pembayaran</label>
                                                                {{ Form::textarea('payment_detail', null, ['class' => 'form-control']) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-12" id="bukti_pembayaran_tab">
                                                            <div class="form-group">
                                                                <label for="bukti_pembayaran">Bukti Pembayaran</label>
                                                                <input type="file" name="bukti_pembayaran"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-end">
                                                            <button type="submit" class="btn btn-primary">Proses</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        @endcan
                                    @elseif($order->order_status == '2')
                                        @can('orders-assignteam')
                                            @include('orders._teams')
                                        @endcan
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="revisi1">
                            <div class="card-header">
                                <h3>Data Revisi Order</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <th>No</th>
                                        <th>Tanggal/Jam Booking</th>
                                        <th>Nama Customer</th>
                                        <th>Nama Alamat</th>
                                        <th>Detail Service</th>
                                        <th>Grand Total</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->order_history as $history)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('D, d-F-Y / H:i', strtotime($history->booked_date)) }}</td>
                                                <td>{{ $history->customer->nama }}</td>
                                                <td>{{ $history->address->address_name }}</td>
                                                <td>
                                                    @foreach ($history->serviceCounts as $count)
                                                        - {{ $count['service_name'] }} ({{ $count['count'] }}) <br>
                                                    @endforeach
                                                </td>
                                                <td>{{ thousand_rupiah($history->grand_total) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('modal')
    {{-- modal teams --}}
    <div class="modal modal-lg fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">assign teams</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('orders._teams')
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    {{-- modal completed order --}}
    <div class="modal modal-lg fade" id="completeModal" tabindex="-1" aria-labelledby="completeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="completeModalLabel">Completed Order</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{ Form::model($order, ['route' => ['orders.completedorder', $order->id], 'method' => 'PUT']) }}
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-group">
                                {{ Form::label('team', 'Team yg Mengerjakan') }}
                                {{ Form::select('team_id', ['' => 'Select a team'] + $order->teams()->pluck('nama', 'teams.id')->toArray(), null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                {{ Form::label('qr', 'Qr Code') }}
                                <select class="form-control" name="qr_id" id="qr">
                                    <option value="">Pilih Qr Code</option>
                                    @foreach ($qr as $index => $value)
                                        <option value="{{ $value->url_unique }}" data-status="{{ $value->status }}">
                                            {{ $value->qr_name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="qr_status" id="qr_status">
                            </div>
                        </div>
                        <div class="col-12 data-qr d-none">
                            <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                    <label for="BrandAC" class="form-label">Pilih Brand AC</label>
                                    <select class="form-control" id="BrandAC" aria-label="BrandAC" name="brandAC">
                                        <option value="">Pilih</option>
                                        <option value="Samsung">Samsung</option>
                                        <option value="Sharp">Sharp</option>
                                        <option value="Gree">Gree</option>
                                        <option value="Daikin">Daikin</option>
                                        <option value="LG">LG</option>
                                        <option value="PANASONIC">PANASONIC</option>
                                        <option value="Midea">Midea</option>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="nama_ac" class="form-label">PRODUK SKU</label>
                                    <input type="text" class="form-control" id="nama_ac" name="nama_ac"
                                        placeholder="Input nama / seri AC exp: AH-A5BEY">
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="model_ac" class="form-label">Model AC</label>
                                    <select class="form-select" aria-label="BrandAC" name="model_ac">
                                        <option selected>Pilih</option>
                                        <option value="Split Wall">Split Wall</option>
                                        <option value="Central">Central</option>
                                        <option value="Standing Floor">Standing Floor</option>
                                    </select>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="daya_pk" class="form-label">Daya PK</label>
                                    <input type="text" class="form-control" name="pk" id="daya_pk"
                                        placeholder="1, 1/2 PK">
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="jenis_freon" class="form-label">Tipe Refrigrant</label>
                                    <input type="text" class="form-control" name="tipe_freon" id="jenis_freon"
                                        placeholder="R-32, R-34">
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="is_inverter">Is Inverter ?</label>
                                        <div class="form-check">
                                            {!! Form::radio('is_inverter', 'yes', null, [
                                                'id' => 'yes',
                                                'class' => 'form-check-input',
                                            ]) !!}
                                            {!! Form::label('yes', 'Yes', ['class' => 'form-check-label']) !!}
                                        </div>
                                        <div class="form-check">
                                            {!! Form::radio('is_inverter', 'no', null, [
                                                'id' => 'no',
                                                'class' => 'form-check-input',
                                            ]) !!}
                                            {!! Form::label('no', 'No', ['class' => 'form-check-label']) !!}

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                {{ Form::label('jenis_service', 'Service yg Dikerjakan') }}
                                @foreach ($order->serviceCountsWithStatus as $index => $value)
                                    <div class="form-check">
                                        <input type="checkbox" name="service[]"
                                            id='service_{{ $value['order_detail_id'] }}'
                                            value="{{ $value['order_detail_id'] }}">
                                        {!! Form::label('service_' . $value['order_detail_id'], $value['service_name'] . ' (' . $value['count'] . ')', [
                                            'class' => 'form-check-label',
                                        ]) !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- <div class="col-12">
                            <label for="Service Selanjutnya" class="form-label">Servis selanjutnya</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="next_service" min="0" required
                                    placeholder="Service Selanjutnya" />
                                <div class="input-group-text">Hari</div>
                            </div>
                        </div> --}}
                    </div>

                </div>
                <div class="modal-footer text-lg-end text-center">
                    {{ Form::submit('Complete this order', ['class' => 'btn btn-primary']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Upload Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('orders.completedpayment', $order->id) }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="col-12">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="row g-3">
                                    <div class="col-12" id="bukti_pembayaran_tab">
                                        <div class="form-group">
                                            <label for="payment_date">Tanggal Pembayaran</label>
                                            <input type="text" name="payment_date"
                                                class="form-control datetime-picker">
                                        </div>
                                    </div>
                                    <div class="col-12" id="bukti_pembayaran_tab">
                                        <div class="form-group">
                                            <label for="bukti_pembayaran">Bukti Pembayaran</label>
                                            <input type="file" name="bukti_pembayaran" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Proses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- WorkOrder Modal -->
    <div class="modal fade" id="WorkOrderModal" tabindex="-1" aria-labelledby="WorkOrderModalLabelDoc"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="WorkOrderModalLabelDoc">Upload Work Order (PDF)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('orders.upload_work_order', $order->id) }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="col-12">
                            @csrf
                            <div class="form-group">
                                <input type="file" name="work_order" class="dropify w-100">
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
    {{-- worker order document --}}

    <div class="modal fade" id="WorkOrderModalDoc" tabindex="-1" aria-labelledby="WorkOrderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="WorkOrderModalLabel">Upload Work Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('orders.upload_work_order_doc', $order->id) }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="col-12">
                            @csrf
                            <div class="form-group">
                                <input type="file" name="work_order_doc" class="dropify w-100">
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
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.dropify').dropify();
    </script>
    <script>
        console.log('test');
        $('#payment_type').change(function(e) {
            console.log($(this).val());
            let payment_type = $(this).val();
            if (payment_type == 'Term Of Payment') {
                $('#payment_duedate_tab').removeClass('d-none');
                $('#payment_detail_tab').removeClass('d-none');
                $('#bukti_pembayaran_tab').addClass('d-none');
            } else {
                $('#payment_duedate_tab').addClass('d-none');
                $('#payment_detail_tab').addClass('d-none');
                $('#bukti_pembayaran_tab').removeClass('d-none');
            }
        });
        let no = 1;
        team('#team_id0')

        function team(id) {
            $(document).find(id).select2({
                placeholder: "Pilih team",
                theme: 'bootstrap-5',
                allowClear: true,
                ajax: {
                    url: "{{ route('ajax.get_teams_available') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            _token: "{{ csrf_token() }}",
                            search: params.term, // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
        }

        $('#add_team').click(function(e) {
            e.preventDefault();
            let html =
                `
        <div class="col-lg-6 col-12 team_form">
            <div class="form-group">
                <div class="row g-3 align-items-center">
                    <div class="col-6">
                        <label for="team_id${no}">Team</label>
                    </div>
                    <div class="col-6 text-end">
                        <button class="btn btn-danger btn-sm delete_team"><i class="mdi mdi-trash-can"></i></button>
                    </div>
                    <div class="col-12">
                        <select name="team_id[]" id="team_id${no}" class="form-control">
                                <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    `;
            $('#team_row').append(html);
            team(`#team_id${no}`);
            no++;
        });
        $(document).on('click', '.delete_team', function() {
            $(this).closest('.team_form').remove();
        })
        $('#qr').change(function(e) {
            let status = $(this).find(':selected').data('status');
            $('#qr_status').val(status);
            if (status == 1) {
                $('.data-qr').addClass('d-none');
            } else {
                $('.data-qr').removeClass('d-none');
            }

        });
        $("#BrandAC").select2({
            placeholder: "Pilih Merk AC",
            tags: true,
            theme: 'bootstrap-5',
        });
    </script>

@endsection
