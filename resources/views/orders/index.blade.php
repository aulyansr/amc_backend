@extends('layouts.admin')
@section('title', '')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        <div class="row g-3">
                            @can('orders-create')
                                <div class="col-12">
                                    <div class="pull-right mb-3">
                                        <a class="btn btn-success" href="{{ route('orders.create') }}"> Create</a>
                                    </div>
                                </div>
                            @endcan
                            <div class="col-12">
                                {{ Form::model($filter, ['route' => 'orders.index', 'method' => 'get']) }}
                                <div class="row g-2">
                                    <div class="col-12"><b>Filter</b></div>
                                    <div class="col-auto">
                                        {{ Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Search']) }}
                                    </div>
                                    <div class="col-auto">
                                        {{ Form::select('order_status', ['' => 'Select Status'] + $array_status, null, ['class' => 'form-control']) }}
                                    </div>
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
                                <table class="table table-bordered table-striped datatable">
                                    <thead>
                                        <th>No</th>
                                        <th>Tanggal/Jam Booking</th>
                                        <th>Cabang</th>
                                        <th>Kode Order</th>
                                        <th>Ref no</th>
                                        <th>Nama Customer</th>
                                        <th>Nama Alamat</th>
                                        <th>Order status</th>
                                        <th>Detail Service</th>
                                        <th>Grand Total</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('D, d-F-Y / H:i', strtotime($order->booked_date)) }}</td>
                                                <td>{{ $order->branch?->name }}</td>
                                                <td>{{ $order->order_code }}</td>
                                                <td>{{ $order->ref_no }}</td>
                                                <td>{{ $order->customer?->type == '2' ? $order->customer_b2b2c?->nama . ' - ' . $order->customer->nama : $order->customer?->nama }}
                                                </td>
                                                <td>{{ optional($order->address)->address_name ?? 'tidak ada alamat' }}
                                                </td>
                                                <td><span
                                                        class="{{ $statusorder[$order->order_status][1] }}">{{ $statusorder[$order->order_status][0] }}</span>
                                                </td>
                                                <td>
                                                    @foreach ($order->serviceCounts as $count)
                                                        - {{ $count['service_name'] }} ({{ $count['count'] }}) <br />
                                                    @endforeach
                                                </td>
                                                <td>{{ thousand_rupiah($order->grand_total) }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('orders.show', [$order->id]) }}"
                                                            class="btn btn-info">Show</a>
                                                        @if ($order->order_status != 0)
                                                            @can('orders-invoice')
                                                                <a target="_blank"
                                                                    href="{{ route('orders.invoice', $order->id) }}"
                                                                    class="btn btn-secondary">Invoice</a>
                                                            @endcan
                                                        @endif
                                                        @if (($order->order_status > 0 && $order->order_status < 2) || $order->order_status == 6)
                                                            @can('orders-edit')
                                                                <a href="{{ route('orders.edit', [$order->id]) }}"
                                                                    class="btn btn-primary">Edit</a>
                                                            @endcan
                                                            @can('orders-delete')
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'onsubmit' => 'return deleteData()',
                                                                    'route' => ['orders.destroy', $order->id],
                                                                    'style' => 'display:inline',
                                                                ]) !!}
                                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                                {!! Form::close() !!}
                                                            @endcan
                                                        @elseif($order->order_status >= 2 && $order->order_status < 6)
                                                            @can('orders-revision')
                                                                <a href="{{ route('orders.revision', [$order->id]) }}"
                                                                    class="btn btn-primary">Revisi</a>
                                                            @endcan
                                                            @can('orders-canceled')
                                                                <button type="button"
                                                                    data-bs-route="{{ route('orders.canceled_order', $order->id) }}"
                                                                    data-bs-canceledorder="{{ $order->id }}"
                                                                    class="btn btn-danger cancel-order">Cancel</button>
                                                            @endcan
                                                        @endif
                                                    </div>
                                                </td>
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
    {{-- Canceled Order --}}
    <!-- Modal -->
    <div class="modal fade" id="canceledOrderModal" tabindex="-1" aria-labelledby="canceledOrderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="canceledOrderModalLabel">Canceled Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="#" id="canceledOrderForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="reason_canceled">Alasan Pembatalan</label>
                                    <textarea name="reason_canceled" id="reason_canceled" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                            <!-- Add additional canceled order details as needed -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).on('click', '.cancel-order', function() {
            const route = $(this).data('bs-route');
            $('#canceledOrderForm').attr('action', route);
            // console.log(route);
            $('#canceledOrderModal').modal('show');
            // Perform further actions with the route value
        });
    </script>
@endsection
