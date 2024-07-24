@section('content')
    <section class="content">
        <div class="row g-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Partner</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Tipe Customer</h5>
                                    <p>{{ isset($customer->type) ? $customer->customer_type[$customer->type] : '-' }}</p>
                                </div>
                            </div>
                            @if ($customer->type == '1' || $customer->type == '2')
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
        </div>
    </section>
    <section class="content">
        <div class="row g-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row g-2 justify-content-between">
                            <div class="col-auto">
                                <h4>Data Customer B2B2C</h4>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <a class="btn btn-primary"
                                    href="{{ route('customers.customer_b2b2c.create', $customer->id) }}"><i
                                        class="fa fa-plus"></i> Tambah Customer</a>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer->children as $c)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $c->nama }}</td>
                                                    <td>{{ $c->phone }}</td>
                                                    <td>{{ $c->email }}</td>
                                                    <td>
                                                        <div class="row g-2">
                                                            <div class="col-auto">
                                                                <a class="btn btn-info btn-sm"
                                                                    href="{{ route('customers.show', $c->id) }}">Show</a>
                                                            </div>
                                                            <div class="col-auto">
                                                                <a class="btn btn-warning btn-sm"
                                                                    href="{{ route('customers.customer_b2b2c.edit', [$customer->id, $c->id]) }}">Edit</a>

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
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if ($customer->type == 2)
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Service Customer</h3>
                </div>
                <div class="card-body table-responsive">
                    @can('service_coorporate-create')
                        <div class="pull-right mb-3">
                            <a class="btn btn-success" href="{{ route('customers.service_corporate.create', $customer->id) }}">
                                Create
                                New services</a>
                        </div>
                    @endcan

                    <table class="table table-bordered table-striped datatable">
                        <thead>
                            <th>No</th>
                            <th>Nama Service</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Harga Garansi</th>
                            <th>Komisi</th>
                            <th>Maks. Diskon</th>
                            <th>Warranty</th>
                            <th>Teknisi Dibutuhkan</th>
                            <th>status Service</th>
                            <th>Tampilkan di Mobile?</th>
                            <th>Gambar</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @if ($customer->services->count() > 0)
                                @foreach ($customer->services as $service)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $service->service_type?->name }}</td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ thousand_rupiah($service->price) }}</td>
                                        <td>{{ thousand_rupiah($service->price_warranty) }}</td>
                                        <td>{{ thousand_rupiah($service->commision) }}</td>
                                        <td>{{ thousand_rupiah(($service->price * $service->max_discount) / 100) }}
                                            ({{ $service->max_discount }} %)
                                        </td>
                                        <td>{{ $service->completedWarranty }}</td>
                                        <td>{{ $service->technician_needed }} Orang</td>
                                        <td>
                                            @if ($service->is_active == 1)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($service->is_show_mobile == 1)
                                                <span class="badge bg-success">Tampil</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Tampil</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($service) && $service->image)
                                                <img id="image-preview" src="{{ $service->image }}" alt="Preview Image"
                                                    style="max-width: 100px;" class="img-thumbnail">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('master.services.show', [$service->id]) }}"
                                                    class="btn btn-info">Show</a>
                                                @can('service_coorporate-edit')
                                                    <a href="{{ route('customers.service_corporate.edit', [$customer->id, $service->id]) }}"
                                                        class="btn btn-primary">Edit</a>
                                                @endcan
                                                <form
                                                    action="{{ route('customers.service_corporate.duplicate', [$customer->id, $service->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Duplicate</button>
                                                </form>
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
@endsection
