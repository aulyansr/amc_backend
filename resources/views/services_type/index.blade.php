@extends('layouts.admin')
@section('title', 'Services')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('services_type-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('master.services_type.create') }}"> Create</a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th>No</th>
                                <th>Service Group</th>
                                <th>Nama Service</th>
                                <th>Description</th>
                                <th>status</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                @foreach ($data as $service)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $service->services_group?->name }}</td>
                                        <td>{{ $service->name }}</td>
                                        <td>{!! $service->description !!}</td>
                                        <td>
                                            @if ($service->is_active == 1)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                {{-- <a href="{{ route('master.services_type.show', [$service->id]) }}" class="btn btn-info">Show</a> --}}
                                                @can('services_type-edit')
                                                    <a href="{{ route('master.services_type.edit', [$service->id]) }}"
                                                        class="btn btn-primary">Edit</a>
                                                @endcan
                                                @can('services_type-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'onsubmit' => 'return deleteData()',
                                                        'route' => ['master.services_type.destroy', $service->id],
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
