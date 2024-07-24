@extends('layouts.admin')
@section('title', 'Detail Services')
@section('content')
    <div class="container-fluid">
        <div class="row g-3 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-blue">
                        <div class="row g-2">
                            <div class="col-12">
                                <h3>Data Service</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 row-cols-1 row-cols-md-6">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Tipe Service</h5>
                                    <p>{{ $service->service_type?->name }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Nama Service</h5>
                                    <p>{{ $service->name }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Service Price (Non Warranty)</h5>
                                    <p>{{ thousand_rupiah($service->price) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Service Price Warranty</h5>
                                    <p>{{ thousand_rupiah($service->price_warranty) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Komisi</h5>
                                    <p>{{ thousand_rupiah($service->komisi) }}</p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Maks. Diskon</h5>
                                    <p>{{ thousand_rupiah(($service->price * $service->max_discount) / 100) }}
                                        ({{ $service->max_discount }} %)</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Durasi Warranty</h5>
                                    <p>{{ $service->completedWarranty }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Teknisi dibutuhkan</h5>
                                    <p>{{ $service->technician_needed }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Status Service</h5>
                                    <p>
                                        @if ($service->is_active == 1)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Show in Mobile Apps ? </h5>
                                    <p>
                                        @if ($service->is_show_mobile == 1)
                                            <span class="badge bg-success">Tampil</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Tampil</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Gambar Service </h5>
                                    <p>
                                        @if (isset($service) && $service->image)
                                            <img id="image-preview" src="{{ $service->image }}" alt="Preview Image"
                                                style="max-width: 100px;" class="img-thumbnail">
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
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
                            <h3>Child Service </h3>
                        </div>
                        @can('orders-create')
                            <div class="col-6 text-end">
                                <div class="pull-right mb-3">
                                    <a class="btn btn-success"
                                        href="{{ route('master.services.service_children.create', $service->id) }}"> Update
                                        Service</a>
                                </div>
                            </div>
                        @endcan

                        <div class="col-12">
                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <th>No</th>
                                    <th>Tipe Service</th>
                                    <th>Nama Service</th>
                                    <th>Harga Non Warranty</th>
                                    <th>Harga Warranty</th>
                                </thead>
                                <tbody>
                                    @foreach ($service->child_services as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->service_type?->name }}</td>
                                            <td>{{ $d->name }}</td>
                                            <td>{{ thousand_rupiah($d->price) }}</td>
                                            <td>{{ thousand_rupiah($d->warranty_price) }}</td>
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
                            <h3>Spare Part Service </h3>
                        </div>
                        @can('orders-create')
                            <div class="col-6 text-end">
                                <div class="pull-right mb-3">
                                    <a class="btn btn-success"
                                        href="{{ route('master.services.service_spare_part.create', $service->id) }}"> Create
                                        Service Spare Part</a>
                                </div>
                            </div>
                        @endcan

                        <div class="col-12">
                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <th>No</th>
                                    <th>Group Spare Part</th>
                                    <th>Nama Spare Part</th>
                                    <th>Harga Non Warranty</th>
                                    <th>Harga Warranty</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($service->spare_part as $sd)
                                        {{-- @dd($sd) --}}
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $sd->spare_part_group?->name }}</td>
                                            <td>{{ $sd->name }}</td>
                                            <td>{{ thousand_rupiah($sd->pivot->price) }}</td>
                                            <td>{{ thousand_rupiah($sd->pivot->price_warranty) }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    {{-- <a href="{{ route('master.service_spare_part.show', [$group->id]) }}" class="btn btn-info">Show</a> --}}
                                                    @can('service_spare_part-edit')
                                                        <a href="{{ route('master.services.service_spare_part.edit', [$service->id, $sd->id]) }}"
                                                            class="btn btn-primary">Edit</a>
                                                    @endcan
                                                    @can('service_spare_part-delete')
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'onsubmit' => 'return deleteData()',
                                                            'route' => ['master.services.service_spare_part.destroy', $service->id, $sd->id],
                                                            'style' => 'display:inline',
                                                        ]) !!}
                                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
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
@endsection
