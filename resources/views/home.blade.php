@extends('layouts.admin')
@section('title', 'Dashboard')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/saas/assets/vendor/daterangepicker/daterangepicker.css') }}">

@endsection
@section('content')


    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <!-- Total Order -->
                            <div class="col-sm-6 col-lg-3">
                                <div class="card rounded-0 shadow-none m-0">
                                    <div class="card-body text-center">
                                        <i class="ri-briefcase-line text-muted font-24"></i>
                                        <h3><span>{{ $totalOrder }}</span></h3>
                                        <p class="text-muted font-15 mb-0">Total Order</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Order This Month -->
                            <div class="col-sm-6 col-lg-3">
                                <div class="card rounded-0 shadow-none m-0 border-start border-light">
                                    <div class="card-body text-center">
                                        <i class="ri-list-check-2 text-muted font-24"></i>
                                        <h3><span>{{ $totalOrderThisMonth }}</span></h3>
                                        <p class="text-muted font-15 mb-0">Total Order This Month</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Customer -->
                            <div class="col-sm-6 col-lg-3">
                                <div class="card rounded-0 shadow-none m-0 border-start border-light">
                                    <div class="card-body text-center">
                                        <i class="ri-group-line text-muted font-24"></i>
                                        <h3><span>{{ $totalCustomerThisMonth }}</span></h3>
                                        <p class="text-muted font-15 mb-0">New Customer</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Income -->
                            <div class="col-sm-6 col-lg-3">
                                <div class="card rounded-0 shadow-none m-0 border-start border-light">
                                    <div class="card-body text-center">
                                        <i class="ri-line-chart-line text-muted font-24"></i>
                                        <h3>
                                            {{ thousand_rupiah($totalIncome) }}
                                        </h3>

                                        <p class="text-muted font-15 mb-0">Total Income</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row-->


        <div class="row">

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Top Customer</h4>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-hover mb-0">
                                <tbody>
                                    @foreach ($topCustomers as $customer)
                                        <tr>
                                            <td>
                                                <h5 class="font-14 my-1">
                                                    <a href="{{ route('customers.show', $customer->id) }}"
                                                        class="text-body">
                                                        {{ $customer->nama }}
                                                    </a>
                                                </h5>
                                                {{-- <span class="text-muted font-13">{{ $customer->company_name }}</span> untuk
                                        b to b --}}
                                            </td>
                                            <td>
                                                <span class="badge badge-success-lighten">{{ $customer->orders_count }}
                                                    Order</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive-->
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->


            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Top Technician</h4>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-hover mb-0">
                                <tbody>
                                    @foreach ($topTechnicians as $technician)
                                        <tr>
                                            <td>
                                                <h5 class="font-14 my-1">
                                                    <a href="javascript:void(0);" class="text-body">
                                                        {{ $technician->technician_name }}
                                                    </a>
                                                </h5>
                                                <span class="text-muted font-13">{{ $technician->team_name }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success-lighten">{{ $technician->order_count }}
                                                    Order</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive-->
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Total Income</h4>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-hover mb-0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <h5 class="font-14 my-1">
                                                {{ Carbon\Carbon::now()->format('F Y') }}
                                            </h5>
                                        </td>
                                        <td>
                                            <p>{{ thousand_rupiah($totalIncomeThisMonth) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5 class="font-14 my-1">
                                                {{ Carbon\Carbon::now()->subMonth()->format('F Y') }}
                                            </h5>
                                        </td>
                                        <td>
                                            <p>{{ thousand_rupiah($totalIncomeLastMonth) }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5 class="font-14 my-1">
                                                {{ Carbon\Carbon::now()->subMonth(2)->format('F Y') }}
                                            </h5>
                                        </td>
                                        <td>
                                            <p>{{ thousand_rupiah($totalIncomeLastTwoMonth) }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive-->
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->

        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">Schedule Orders</h4>
                    </div>
                    <div class="card-body">
                        <div id="schedule"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Latest Order</h4>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th>No</th>
                                <th>Tanggal/Jam Booking</th>
                                <th>Cabang</th>
                                <th>Kode Order</th>
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
                                        <td>{{ $order->customer?->nama }}</td>
                                        <td>{{ optional($order->address)->address_name ?? 'tidak ada alamat' }}</td>
                                        <td>
                                            <span
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
                                                @if ($order->order_status < 2)
                                                    @can('orders-edit')
                                                        <a href="{{ route('orders.edit', [$order->id]) }}"
                                                            class="btn btn-primary">Edit</a>
                                                    @endcan
                                                    @can('orders-delete')
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'onsubmit' => 'return
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    deleteData()',
                                                            'route' => ['orders.destroy', $order->id],
                                                            'style' => 'display:inline',
                                                        ]) !!}
                                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->

    </div> <!-- container -->

@endsection
@section('script')
    <script src="{{ asset('assets/saas/assets/js/pages/demo.dashboard.js') }}"></script>

    <!-- Vector Map js -->
    <script src="{{ asset('assets/saas/assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/saas/assets/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}">
    </script>
    <!-- Daterangepicker js -->
    <script src="{{ asset('assets/saas/assets/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/saas/assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.14/index.global.min.js "></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('schedule');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC',
                initialView: 'resourceTimelineDay',
                eventDisplay: 'block',
                slotDuration: '00:15:00', // Each row represents 15 minutes
                slotMinTime: '06:00:00', // Start time for the time grid
                slotMaxTime: '24:00:00',

                resourceAreaHeaderContent: 'Rooms',
                resources: {
                    url: "{{ route('ajax.get_schedule_order_resource') }}",
                    method: 'GET',
                    extraParams: {
                        format: 'json'
                    },
                    failure: function(error) {
                        // Handle AJAX request failure
                        console.log('AJAX request failed with error: ' + error.message);
                        // Show an error message to the user
                    }
                },
                events: {
                    url: "{{ route('ajax.get_schedule_order_event') }}",
                    method: 'GET',
                    extraParams: {
                        format: 'json'
                    },
                    failure: function(error) {
                        // Handle AJAX request failure
                        console.log('AJAX request failed with error: ' + error.message);
                        // Show an error message to the user
                    }
                },
                aspectRatio: 1.5,
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: ''
                },
                schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives'

            });
            calendar.render();
        });
    </script>
@endsection
