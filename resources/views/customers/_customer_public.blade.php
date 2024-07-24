@section('content')
    <section class="content">
        <div class="row g-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-blue">
                        <h3>Data Customer</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Tipe Customer</h5>
                                    <p>{{ isset($customer->type) ? $customer->customer_type[$customer->type] : '-' }}</p>
                                </div>
                            </div>
                            @if ($customer->type == '1')
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <h5>Nama Company</h5>
                                        <p>{{ $customer->company_name }}</p>
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Nama</h5>
                                    <p>{{ $customer->nama }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Email</h5>
                                    <p>{{ $customer->email }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Phone</h5>
                                    <p>{{ $customer->phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @can(['masteraddress-list', 'masteraddress-create', 'masteraddress-edit', 'masteraddress-delete'])
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Data Alamat Customer</h3>
                        </div>
                        <div class="card-body table-responsive">
                            @can('masteraddress-create')
                                <div class="pull-right mb-3">
                                    <a class="btn btn-success" href="{{ route('customers.address.create', $customer->id) }}"> Create
                                        New Address </a>
                                </div>
                            @endcan

                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <th>No</th>
                                    <th>Nama Alamat</th>
                                    <th>Tipe Bangunan</th>
                                    <th>Alamat</th>
                                    @if ($customer->type == '1')
                                        <th>Jam Buka & Tutup</th>
                                    @endif
                                    <th>Jumlah AC</th>
                                    <td>
                                        Last Order
                                    </td>
                                    <th width="280px">Action</th>
                                </thead>

                                <tbody>
                                    @foreach ($customer->masterAddress as $key => $ad)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ad->address_name }}</td>
                                            <td>{{ $ad->address_type ? $ad->address_type : '-' }}</td>
                                            <td>
                                                {{ $ad->completedAddress }}

                                            </td>
                                            @if ($customer->type == '1')
                                                <td>{{ $ad->time_open && $ad->time_close ? date('H:i', strtotime($ad->time_open)) . ' - ' . date('H:i', strtotime($ad->time_close)) : '-' }}
                                                </td>
                                            @endif
                                            <td>{{ $ad->jumlah_ac }}</td>
                                            <td>
                                                @if ($ad->orders !== null && $ad->orders->isNotEmpty())
                                                    <a href="{{ route('orders.show', [$ad->orders->last()->id]) }}">
                                                        {{ date('D, d-F-Y / H:i', strtotime($ad->orders->last()->booked_date)) }}
                                                    </a>
                                                @else
                                                    No orders
                                                @endif
                                            </td>

                                            <td>
                                                {{-- <a class="btn btn-info" href="{{ route('customers.address.show',['masterCustomer'=>$customer->id,'masterAddress'=>$ad->id]) }}">Show</a>
                                    --}}
                                                <div class="row g-2">
                                                    <div class="col-auto">

                                                        @can('masteraddress-edit')
                                                            <a class="btn btn-primary"
                                                                href="{{ route('customers.address.edit', ['masterCustomer' => $customer->id, 'masterAddress' => $ad->id]) }}">Edit</a>
                                                        @endcan
                                                    </div>
                                                    <div class="col-auto">

                                                        @can('masteraddress-delete')
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'onsubmit' => 'return deleteData()',
                                                                'route' => ['customers.address.destroy', ['masterCustomer' => $customer->id, 'masterAddress' => $ad->id]],
                                                                'style' => 'display:inline',
                                                            ]) !!}
                                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger delete-button']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            @endcan

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Data Order Customer</h3>
                    </div>
                    <div class="card-body table-responsive">
                        @if ($customer->orders->count() > 0)
                            <form action="{{ route('customers.invoice_customer', $customer->id) }}" id="form-invoice"
                                method="POST">
                                @csrf

                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <th>
                                            <input type="checkbox" id="select-all">
                                        </th>
                                        <th>No</th>
                                        <th>Tanggal/Jam Booking</th>
                                        <th>Kode Order</th>
                                        <th>Nama Alamat</th>
                                        <th>Order status</th>
                                        <th>Detail Service</th>
                                        <th>Grand Total</th>
                                        <th>Status Pembayaran</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>

                                        @foreach ($customer->orders as $key => $order)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="id[]" value="{{ $order->id }}">
                                                </td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('D, d-F-Y / H:i', strtotime($order->booked_date)) }}</td>
                                                <td>{{ $order->order_code }}</td>
                                                <td>{{ $order->address->address_name }}</td>
                                                <td>
                                                    <span
                                                        class="{{ $statusorder[$order->order_status][1] }}">{{ $statusorder[$order->order_status][0] }}</span>
                                                </td>
                                                <td>
                                                    @foreach ($order->serviceCounts as $count)
                                                        - {{ $count['service_name'] }} ({{ $count['count'] }}) <br>
                                                    @endforeach
                                                </td>
                                                <td>{{ thousand_rupiah($order->grand_total) }}</td>
                                                <td>
                                                    @if (isset($order->payment_status))
                                                        <span
                                                            class="{{ $order->statusPayment[1] }}">{{ $order->statusPayment[0] }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                {{-- <td> --}}
                                                {{-- @foreach ($order->teams as $team)
                                                        {{ $team->nama }}
                                                        <ul>
                                                            @foreach ($team->technician as $tech)
                                                                <li>
                                                                    <a href="{{ route('technicians.show', [$tech->id]) }}">
                                                                        {{ $tech->fullname }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endforeach --}}
                                                {{-- </td> --}}
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('orders.show', [$order->id]) }}"
                                                            class="btn btn-info">Show</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="text-end">
                                    <button type="submit" id="button-invoice" class="btn btn-primary">Cetak Invoice yang di
                                        Pilih</button>
                                </div>
                            </form>
                        @else
                            <div class="col-12 text-center">
                                <b>No orders available for this customer.
                                </b>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if ($customer->type == 1)
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Service Customer</h3>
                        </div>
                        <div class="card-body table-responsive">
                            @can('service_coorporate-create')
                                <div class="pull-right mb-3">
                                    <a class="btn btn-success"
                                        href="{{ route('customers.service_corporate.create', $customer->id) }}">
                                        Create
                                        New service </a>
                                </div>
                            @endcan

                            <table class="table table-bordered table-striped ">
                                <thead>
                                    <th>No</th>
                                    <th>Nama Service</th>
                                    <th>Deskripsi</th>
                                    <th>Harga</th>
                                    <th>Komisi</th>
                                    <th>status</th>
                                    <th>Gambar</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @if ($customer->services->count() > 0)
                                        @foreach ($customer->services as $service)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $service->name }}</td>
                                                <td>{{ $service->description }}</td>
                                                <td>{{ thousand_rupiah($service->price) }}</td>
                                                <td>{{ thousand_rupiah($service->commision) }}</td>
                                                <td>
                                                    @if ($service->is_active == 1)
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($service) && $service->image)
                                                        <img id="image-preview"
                                                            src="{{ asset('storage/images/services/' . $service->image) }}"
                                                            alt="Preview Image" style="max-width: 100px;"
                                                            class="img-thumbnail">
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        {{-- <a href="{{ route('master.services.show', [$service->id]) }}" class="btn btn-info">Show</a> --}}
                                                        @can('service_coorporate-edit')
                                                            <a href="{{ route('customers.service_corporate.edit', [$customer->id, $service->id]) }}"
                                                                class="btn btn-primary">Edit</a>
                                                        @endcan
                                                        @can('service_coorporate-delete')
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'onsubmit' => 'return deleteData()',
                                                                'route' => ['master.services.destroy', $service->id],
                                                                'style' => 'display:inline',
                                                            ]) !!}
                                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="8">No Service available for this customer.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // Get the select all checkbox element
            const selectAllCheckbox = $('#select-all');

            // Get all individual checkboxes
            const checkboxes = $('input[name="id[]"]');

            // Add event listener to select all checkbox
            selectAllCheckbox.on('change', function() {
                checkboxes.prop('checked', selectAllCheckbox.prop('checked'));
            });

            // Get the form element
            const form = $('#form-invoice');

            // Add event listener to form submission
            $('#button-invoice').click(function(e) {
                e.preventDefault();
                const selectedOrders = checkboxes.filter(':checked');
                if (selectedOrders.length === 0) {
                    alert('Please select at least one order.'); // Display an alert message
                    return;
                } else {

                    $('#form-invoice').submit();
                }
            });
        });
    </script>
@endsection
