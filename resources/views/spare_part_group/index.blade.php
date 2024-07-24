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
                                <a class="btn btn-success" href="{{ route('master.spare_part_group.create') }}"> Create</a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th>No</th>
                                <th>Nama Group Spare Part</th>
                                <th></th>
                            </thead>

                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                {{-- <a href="{{ route('master.spare_part_group.show', [$d->id]) }}" class="btn btn-info">Show</a> --}}
                                                @can('spare-part-group-edit')
                                                    <a href="{{ route('master.spare_part_group.edit', [$d->id]) }}"
                                                        class="btn btn-primary">Edit</a>
                                                @endcan
                                                @can('spare-part-group-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'onsubmit' => 'return deleteData()',
                                                        'route' => ['master.spare_part_group.destroy', $d->id],
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
