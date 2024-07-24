@extends('layouts.admin')
@section('title', '')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        <div class="row g-3">
                            {{-- @can('orders-create')
                                <div class="col-12">
                                    <div class="pull-right mb-3">
                                        <a class="btn btn-success" href="{{ route('orders.create') }}"> Create</a>
                                    </div>
                                </div>
                            @endcan --}}
                            <div class="col-12">
                                {{ Form::model($filter, ['route' => 'orders.report_order', 'method' => 'get']) }}
                                <div class="row g-2">
                                    <div class="col-12"><b>Filter</b></div>
                                    <div class="col-auto">
                                        {{ Form::text('booked_date', null, ['class' => 'form-control multi-datepicker', 'autocomplete' => 'off', 'placeholder' => 'Tanggal Booking']) }}
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary" value="search"
                                            name="button_status">Filter</button>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-success" value="download"
                                            name="button_status">download invoice</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="col-12">

                                <table class="table table-bordered">
                                    <thead>
                                        <th>Kode Order</th>
                                        <th>Nama Customer</th>
                                        <th>Nama Alamat</th>
                                        <th>Order status</th>
                                        <th>Sub Total</th>
                                        <th>Diskon</th>
                                        <th>Grand Total</th>
                                    </thead>
                                    @if (!$orders->isEmpty())
                                        <tbody>
                                            @php
                                                $tanggal = !$orders->isEmpty()
                                                    ? formatDate($orders[0]->booked_date, 'Y-m-d')
                                                    : null;
                                                $sub_total_tanggal = 0;
                                                $diskon_tanggal = 0;
                                                $grand_total_tanggal = 0;
                                                $sub_total = 0;
                                                $diskon = 0;
                                                $grand_total = 0;

                                            @endphp
                                            @foreach ($orders as $order)
                                                @if ($loop->first || formatDate($order->booked_date, 'Y-m-d') != $tanggal)
                                                    @php
                                                        $tanggal = formatDate($order->booked_date, 'Y-m-d');
                                                    @endphp
                                                    @if (!$loop->first)
                                                        <tr class="">
                                                            <th class="text-center" colspan="4">Sub Total</th>
                                                            <th>{{ thousand_rupiah($sub_total_tanggal) }}</th>
                                                            <th>{{ thousand_rupiah($diskon_tanggal) }}</th>
                                                            <th>{{ thousand_rupiah($grand_total_tanggal) }}</th>
                                                        </tr>
                                                        @php
                                                            $sub_total_tanggal = 0;
                                                            $diskon_tanggal = 0;
                                                            $grand_total_tanggal = 0;
                                                        @endphp
                                                    @endif
                                                    <tr class="bg-secondary text-white">
                                                        <th colspan="7" class="text-center">
                                                            {{ formatDate($order->booked_date, 'd F Y') }}</th>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>{{ $order->order_code }}</td>
                                                    <td>{{ $order->customer?->nama }}</td>
                                                    <td>{{ $order->address?->address_name }}</td>
                                                    <td>
                                                        <span
                                                            class="{{ $statusorder[$order->order_status][1] }}">{{ $statusorder[$order->order_status][0] }}</span>
                                                    </td>
                                                    <td>{{ thousand_rupiah($order->sub_total) }}</td>
                                                    <td>{{ thousand_rupiah($order->diskon) }}</td>
                                                    <td>{{ thousand_rupiah($order->grand_total) }}</td>
                                                </tr>
                                                @php
                                                    $sub_total += $order->total_base_price;
                                                    $diskon += $order->diskon;
                                                    $grand_total += $order->grand_total;
                                                    $sub_total_tanggal += $order->total_base_price;
                                                    $diskon_tanggal += $order->diskon;
                                                    $grand_total_tanggal += $order->grand_total;
                                                @endphp
                                                @if ($loop->last)
                                                    <tr class="">
                                                        <th class="text-center" colspan="4">Sub total</th>
                                                        <th>{{ thousand_rupiah($sub_total_tanggal) }}</th>
                                                        <th>{{ thousand_rupiah($diskon_tanggal) }}</th>
                                                        <th>{{ thousand_rupiah($grand_total_tanggal) }}</th>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            <tr class="bg-dark text-white">
                                                <th class="text-center" colspan="4">Grand Total</th>
                                                <th>{{ thousand_rupiah($sub_total) }}</th>
                                                <th>{{ thousand_rupiah($diskon) }}</th>
                                                <th>{{ thousand_rupiah($grand_total) }}</th>
                                            </tr>
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
@endsection
