@extends('layouts.admin')
@section('title', 'Child Services')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('child_service-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('master.child_service.create') }}"> Create</a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th>No</th>
                                <th>Tipe Service</th>
                                <th>Nama Service</th>
                                <th>Harga Non Warranty</th>
                                <th>Harga Warranty</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                @foreach ($data as $service)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $service->service_type?->name }}</td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ thousand_rupiah($service->price) }}</td>
                                        <td>{{ thousand_rupiah($service->warranty_price) }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                {{-- <a href="{{ route('master.child_service.show', [$service->id]) }}" class="btn btn-info">Show</a> --}}
                                                @can('child_service-edit')
                                                    <a href="{{ route('master.child_service.edit', [$service->id]) }}"
                                                        class="btn btn-primary">Edit</a>
                                                @endcan
                                                @can('child_service-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'onsubmit' => 'return deleteData()',
                                                        'route' => ['master.child_service.destroy', $service->id],
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
