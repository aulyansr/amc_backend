 {{-- @dd($scheduled_order)  --}}
 <div class="container-fluid">
     <div class="row g-3 mb-4">
         <div class="col-12">
             <div class="card">
                 <div class="card-header bg-blue">
                     <div class="row g-2">
                         <div class="col-12">
                             <h3>Data Customer</h3>
                         </div>
                         <div class="col-12">
                             <form action="{{ route('customers.excel_invoice', $customer->id) }}" method="POST">
                                 @csrf
                                 <div class="row g-2">
                                     <div class="col-auto">
                                         <input type="text" name="date" class="form-control multi-datepicker"
                                             required autocomplete="off" placeholder="dd/mm/yyyy">
                                     </div>
                                     <div class="col-auto">
                                         <button type="submit" class="btn btn-primary">Download Invoice</button>
                                     </div>
                                 </div>
                             </form>

                         </div>
                     </div>
                 </div>
                 <div class="card-body">
                     <input type="hidden" name="customer_id" value="{{ $customer->id }}" id="customer_id">
                     <div class="row g-3 row-cols-1 row-cols-md-6">
                         <div class="col col-12">
                             <div class="form-group">
                                 <h5>Tipe Customer</h5>
                                 <p>{{ isset($customer->type) ? $customer->customer_type[$customer->type] : '-' }}</p>
                             </div>
                         </div>
                         @if ($customer->type == '1')
                             <div class="col col-12">
                                 <div class="form-group">
                                     <h5>Nama Company</h5>
                                     <p>{{ $customer->company_name }}</p>
                                 </div>
                             </div>
                         @endif
                         <div class="col col-12">
                             <div class="form-group">
                                 <h5>Nama</h5>
                                 <p>{{ $customer->nama }}</p>
                             </div>
                         </div>
                         <div class="col col-12">
                             <div class="form-group">
                                 <h5>Email</h5>
                                 <p>{{ $customer->email }}</p>
                             </div>
                         </div>
                         <div class="col col-12">
                             <div class="form-group">
                                 <h5>Phone</h5>
                                 <p>{{ $customer->phone }}</p>
                             </div>
                         </div>
                     </div>
                     <div class="d-md-flex justify-content-between mt-3">
                         <div class="d-block">
                             @can('orders-create')
                                 <a class="btn btn-success" href="{{ route('orders.create') }}"> Create New Order</a>
                             @endcan
                         </div>
                         <div class="d-block">
                             @can('mastercustomer-edit')
                                 <a class="btn btn-primary" href="{{ route('customers.edit', $customer->id) }}">Edit</a>
                             @endcan
                             @can('mastercustomer-pin')
                                 @if ($customer->type == 1)
                                     <a class="btn btn-secondary"
                                         href="{{ route('customers.view_pin', $customer->id) }}">{{ $customer->pin ? 'Update PIN' : 'Create PIN' }}</a>
                                 @endif
                             @endcan
                             @can('mastercustomer-delete')
                                 {!! Form::open([
                                     'method' => 'DELETE',
                                     'onsubmit' => 'return deleteData()',
                                     'route' => ['customers.destroy', $customer->id],
                                     'style' => 'display:inline',
                                 ]) !!}
                                 {!! Form::submit('Delete', ['class' => 'btn btn-danger delete-button']) !!}
                                 {!! Form::close() !!}
                             @endcan
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="col-md-4">
             <div class="card shadow rounded-5 border-0">
                 <div class="card-body">
                     <h4 class="fw-semibold text-primary-blue">Alamat</h4>
                     <div class="d-block">
                         <div class="d-block mb-3">
                             <div class="text-end">
                                 <h2 class="fw-bold mb-0">
                                     {{ $customer->masterAddress->count() }}
                                 </h2>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="col-md-4">
             <div class="card shadow rounded-5 border-0 ">
                 <div class="card-body">
                     <h4 class="fw-semibold text-primary-blue">Total AC</h4>
                     <div class="d-block">
                         <div class="d-block mb-3">

                             <div class="text-end">
                                 <h2 class="fw-bold mb-0">
                                     {{ $customer->acCustomers->count() }}
                                 </h2>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="col-md-4">
             <div class="card shadow rounded-5 border-0 ">
                 <div class="card-body">
                     <h4 class="fw-semibold text-primary-blue">Total Order</h4>
                     <div class="d-block">
                         <div class="d-block mb-3">
                             <div class="text-end">
                                 <h2 class="fw-bold mb-0">
                                     {{ $customer->orders->count() }}
                                 </h2>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     {{-- <div class="d-block">
         <div class="card">
             <div class="card-body">
                 <h3>Jadwal Pengerjaan</h3>
                 <div class="col-12">
                     <table class="table ">
                         <thead>
                             <th>Tanggal/Jam Booking</th>
                             <th>Cabang</th>
                             <th>Kode Order</th>
                             <th>Nama Alamat</th>
                             <th>Order status</th>
                             <th>Detail Service</th>
                             <th>Teknisi</th>
                         </thead>
                         <tbody>
                             @foreach ($scheduled_order as $sc)
                                 <tr style="background-color: #f7f7f7">
                                     <td colspan="6">
                                         <h4> {{ $sc->date }} </h4>
                                     </td>
                                     <td>
                                         <h4> {{ $sc->order_count }} Order </h4>
                                     </td>
                                 </tr>
                                 @foreach (App\Models\Order::whereDate('booked_date', $sc->date)->where('master_customer_id', $customer->id)->where('order_status', [3, 4, 5])->orderBy('booked_date', 'asc')->get() as $order)
                                     <tr>
                                         <td>{{ $order->booked_date }}</td>
                                         <td>{{ $order->branch ? $order->branch->name : '' }}</td>
                                         <td>{{ $order->order_code }}</td>
                                         <td>{{ $order->address->address_name }}</td>
                                         <td>
                                             <span class="{{ $statusorder[$order->order_status][1] }}">
                                                 {{ $statusorder[$order->order_status][0] }}
                                             </span>
                                         </td>
                                         <td>
                                             @foreach ($order->serviceCounts as $count)
                                                 - {{ $count['service_name'] }} ({{ $count['count'] }}) <br />
                                             @endforeach
                                         </td>

                                         <td>
                                             @foreach ($order->teams as $team)
                                                 @foreach ($team->technician as $tech)
                                                     {{ "- $tech->fullname" }}
                                                     <br>
                                                 @endforeach
                                             @endforeach
                                         </td>
                                     </tr>
                                 @endforeach
                             @endforeach
                         </tbody>
                     </table>
                 </div>

             </div>
         </div>
     </div> --}}
     <div class="d-block">
         <div class="card">
             <div class="card-body">
                 <h3>Jadwal Pengerjaan</h3>
                 <div class="col-12">
                     <div id="schedule"></div>
                 </div>

             </div>
         </div>
     </div>

     <div class="d-block" id="list_orders">
         <div class="card">
             <div class="card-body table-responsive">
                 <div class="row g-3">
                     <div class="col-6">
                         <h3>History Order</h3>
                     </div>
                     @can('orders-create')
                         <div class="col-6 text-end">
                             <div class="pull-right mb-3">
                                 <a class="btn btn-success" href="{{ route('orders.create') }}"> Create New Order</a>
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
                                 {{ Form::select('order_status', ['' => 'Select Order Status'] + $array_status, null, ['class' => 'form-control']) }}
                             </div>
                             <div class="col-auto">
                                 {{ Form::text('booked_date', null, ['class' => 'form-control multi-datepicker', 'autocomplete' => 'off', 'placeholder' => 'Tanggal Booking']) }}
                             </div>
                             <div class="col-auto">
                                 {{ Form::submit('Search', ['class' => 'btn btn-primary']) }}
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
                                         <td>{{ $order->address->address_name }}</td>
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
                                                         <a data-bs-route="{{ route('orders.canceled_order', $order->id) }}"
                                                             data-bs-toggle="modal" data-bs-target="#canceledOrderModal"
                                                             data-bs-canceledorder="{{ $order->id }}"
                                                             class="btn btn-danger cancel-order">Cancel</a>
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

     <div class="d-block" id="list_orders">
         <div class="card">
             <div class="card-body table-responsive">
                 <div class="row g-3">
                     <div class="col-6">
                         <h3>Upcoming Service</h3>
                     </div>
                     @can('orders-create')
                         <div class="col-6 text-end">
                             <div class="pull-right mb-3">
                                 <a class="btn btn-success" href="{{ route('orders.create') }}"> Create New Order</a>
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
                                 {{ Form::select('order_status', ['' => 'Select Order Status'] + $array_status, null, ['class' => 'form-control']) }}
                             </div>
                             <div class="col-auto">
                                 {{ Form::text('booked_date', null, ['class' => 'form-control multi-datepicker', 'autocomplete' => 'off', 'placeholder' => 'Tanggal Booking']) }}
                             </div>
                             <div class="col-auto">
                                 {{ Form::submit('Search', ['class' => 'btn btn-primary']) }}
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
                                         <td>{{ $order->address->address_name }}</td>
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
                                                         <a data-bs-route="{{ route('orders.canceled_order', $order->id) }}"
                                                             data-bs-toggle="modal" data-bs-target="#canceledOrderModal"
                                                             data-bs-canceledorder="{{ $order->id }}"
                                                             class="btn btn-danger cancel-order">Cancel</a>
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
     <div class="row g-2">
         @can(['masteraddress-list', 'masteraddress-create', 'masteraddress-edit', 'masteraddress-delete'])
             <div class="col-lg-12">
                 <div class="card">
                     <div class="card-header">
                         <h3>Data Alamat Customer</h3>
                     </div>
                     <div class="card-body table-responsive">
                         @can('masteraddress-create')
                             <div class="pull-right mb-3">
                                 <a class="btn btn-success" href="{{ route('customers.address.create', $customer->id) }}">
                                     Create
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
                                         <td class="text-center" colspan="8">No Service available for this
                                             customer.
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
     <div class="row justify-content-between g-3">
         <div class="col-12 col-md-6">
             <h4 class="mb-2 fs-2 text-primary-blue">
                 Perawatan AC Berikutnya
             </h4>
             <p>
                 Berikut AC yang disarankan untuk dilakukan perawatan Berkala Pada Bulan Ini
             </p>
         </div>
         <div class="col-12 col-md-auto">
             <button class="btn btn-outline-blue rounded-5 py-2 px-3 ms-1 w-100">
                 {{ $suggest_service->sum('ac_customer_count') }} Unit AC
             </button>
         </div>
     </div>

     @foreach ($suggest_service as $s)
         <h2 class="fw-bold fs-3 py-3 text-primary-blue">{{ $s->address_name }}</h2>
         @php
             $ac_customer = $s
                 ->ac_customer()
                 ->where('next_service', '<=', \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d'))
                 ->get();
         @endphp
         <div class="row g-5">
             @foreach ($ac_customer as $ac)
                 <div class="col-12 col-md-4">
                     <div class="card rounded-5 shadow border-0">
                         @php
                             $next_service =
                                 $ac->next_service != null
                                     ? \Carbon\Carbon::parse($ac->next_service)->format('d F Y')
                                     : '-';
                         @endphp
                         <div class="card-body">
                             <span class="text-secondary-blue">{{ $ac->ac->model }}</span>
                             <h3 class="fw-bold">{{ $ac->ac->ac_full_name }}</h3>
                             <p>
                                 {{ $ac->room_name }}
                             </p>
                             <div class="mb-3">
                                 <p class="mb-0">
                                     Next Service
                                 </p>
                                 <p class="text-primary-blue">
                                     {{ $next_service }}
                                 </p>
                             </div>
                         </div>
                     </div>
                 </div>
             @endforeach
         </div>
     @endforeach

 </div>
 @section('script')
     <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
     <script>
         document.addEventListener('DOMContentLoaded', function() {
             var calendarEl = document.getElementById('schedule');
             var customer_id = $('#customer_id').val();
             var calendar = new FullCalendar.Calendar(calendarEl, {
                 initialView: 'timeGridWeek',
                 eventDisplay: 'block',
                 slotDuration: '00:15:00', // Each row represents 15 minutes
                 slotMinTime: '06:00:00', // Start time for the time grid
                 slotMaxTime: '24:00:00',
                 // Set the interval for displaying time labels to 1 hour

                 events: {
                     url: "{{ route('ajax.get_schedule_order_by_customer', $customer->id) }}",
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
                 eventDisplay: 'block',

             });
             calendar.render();
         });
     </script>
 @endsection
