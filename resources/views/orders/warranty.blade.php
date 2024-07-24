@extends('layouts.admin')
@section('title', '')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        <div class="row g-3">
                            <div class="col-12">
                                <table class="table table-bordered table-striped datatable">
                                    <thead>
                                        <th>No</th>
                                        <th>Tanggal/Jam Booking</th>
                                        <th>Cabang</th>
                                        <th>Kode Order</th>
                                        <th>Nama Customer</th>
                                        <th>Nama Alamat</th>
                                        <th>Warranty status</th>
                                        <th>Detail Service</th>
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
                                                <td>{{ $order->address->address_name }}</td>
                                                <td><span
                                                        class="{{ $statusorder[$order->order_status][1] }}">{{ $statusorder[$order->order_status][0] }}</span>
                                                </td>
                                                <td>
                                                    @foreach ($order->serviceCounts as $count)
                                                        - {{ $count['service_name'] }} ({{ $count['count'] }}) <br />
                                                    @endforeach
                                                </td>
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
                                                        @if ($order->order_status == 7)
                                                            @can('orders-warranty')
                                                                <form
                                                                    action="{{ route('orders.confirm_warranty_orders', $order->id) }}"
                                                                    method="POST" class="form-confirm"
                                                                    onsubmit="return confirmData()">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="row g-2">
                                                                        <div class="col-auto">
                                                                            <button type="submit"
                                                                                class="btn btn-success confirm-button"
                                                                                name="status" value="terima">Setujui</button>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <button type="submit"
                                                                                class="btn btn-danger confirm-button"
                                                                                name="status" value="tolak">Tolak</button>
                                                                        </div>
                                                                    </div>


                                                                </form>
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
        $('.cancel-order').click(function() {
            const route = $(this).data('bs-route');
            $('#canceledOrderForm').attr('action', route);
            // Perform further actions with the route value
        });
    </script>
@endsection
