@extends('layouts.admin')
@section('title', 'Group Services')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('services_group-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('master.services_group.create') }}"> Create</a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th>No</th>
                                <th>Nama Group</th>
                                <th>Description</th>
                                <th>Gambar</th>
                                <th>Status Aktif</th>
                                <th>Tampilkan Mobile ?</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                @foreach ($data as $group)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $group->name }}</td>
                                        <td>{!! $group->description !!}</td>
                                        <td>
                                            @if (isset($group) && $group->image)
                                                <img id="image-preview" src="{{ $group->image }}" alt="Preview Image"
                                                    style="max-width: 100px;" class="img-thumbnail">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($group->is_active == 1)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($group->is_mobile == 1)
                                                <span class="badge bg-success">Tampil</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Tampil</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                {{-- <a href="{{ route('master.services_group.show', [$group->id]) }}" class="btn btn-info">Show</a> --}}
                                                @can('services_group-edit')
                                                    <a href="{{ route('master.services_group.edit', [$group->id]) }}"
                                                        class="btn btn-primary">Edit</a>
                                                @endcan
                                                @can('services_group-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'onsubmit' => 'return deleteData()',
                                                        'route' => ['master.services_group.destroy', $group->id],
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
