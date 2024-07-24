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
                                        {{ Form::text('search', null, ['class' => 'form-control', 'id' => 'search', 'placeholder' => 'Search']) }}
                                    </div>
                                    <div class="col-auto">
                                        {{ Form::select('order_status', ['' => 'Select Status'] + $array_status, null, ['class' => 'form-control', 'id' => 'order_status']) }}
                                    </div>
                                    <div class="col-auto">
                                        {{ Form::select('payment_status', ['' => 'Select Status'] + $statusPayment, null, ['class' => 'form-control', 'id' => 'payment_status']) }}
                                    </div>
                                    <div class="col-auto">
                                        {{ Form::text('booked_date', $filter['booked_date'] ?? '', ['class' => 'form-control multi-datepicker', 'autocomplete' => 'off', 'placeholder' => 'Tanggal Booking', 'id' => 'booked_date']) }}
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
                                <table class="table table-bordered table-striped" id="order-table">
                                    <thead>
                                        <th>No</th>
                                        <th>Tanggal/Jam Booking</th>
                                        <th>Kode Order</th>
                                        <th>Ref no</th>
                                        <th>Nama Customer</th>
                                        <th>Order status</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>

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

        $(document).ready(function() {
            var table = $('#order-table').DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: {
                    url: "{{ route('orders.index') }}",
                    data: function(d) {
                        // Add data filtering to the request
                        d.searchFilter = $('#search').val();
                        d.order_status = $('#order_status').val();
                        d.payment_status = $('#payment_status').val();
                        d.booked_date = $('#booked_date').val();
                        d.button_status = '';
                    }
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tanggal_booking',
                        name: 'Tanggal / Jam Booking'
                    },
                    {
                        data: 'order_code',
                        name: 'Kode Order'
                    },
                    {
                        data: 'ref_no',
                        name: 'Ref No'
                    },
                    {
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'status',
                        name: 'Status'
                    },
                    {
                        data: 'actions',
                        name: 'Action',
                        orderable: false,
                        searchable: false,
                    }
                ],
                error: function(xhr, status, error) {
                    // Handle errors here
                    // Log the error, display an alert, or perform any necessary actions
                    // For example, you can log the error message
                    console.log('DataTables error: ' + error);
                }
            });

        });
    </script>
@endsection
