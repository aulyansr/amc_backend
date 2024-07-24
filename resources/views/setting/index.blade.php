@extends('layouts.admin')
@section('title', 'Services')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('services-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('master.services.create') }}"> Create</a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th>No</th>
                                <th>Nama Service</th>
                                <th>Harga</th>
                                <th>Komisi</th>
                                <th>Maks. Diskon</th>
                                <th>Warranty</th>
                                <th>status</th>
                                <th>Gambar</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ thousand_rupiah($service->price) }}</td>
                                        <td>{{ thousand_rupiah($service->commision) }}</td>
                                        <td>{{ thousand_rupiah(($service->price * $service->max_discount) / 100) }}
                                            ({{ $service->max_discount }} %)
                                        </td>
                                        <td>{{ $service->completedWarranty }}</td>
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
                                                    alt="Preview Image" style="max-width: 100px;" class="img-thumbnail">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                {{-- <a href="{{ route('master.services.show', [$service->id]) }}" class="btn btn-info">Show</a> --}}
                                                @can('services-edit')
                                                    <a href="{{ route('master.services.edit', [$service->id]) }}"
                                                        class="btn btn-primary">Edit</a>
                                                @endcan
                                                @can('services-delete')
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
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
