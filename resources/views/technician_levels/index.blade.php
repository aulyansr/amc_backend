@extends('layouts.admin')
@section('title','Master Data Level Teknisi')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('technician_levels-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('master.technician_levels.create') }}"> Create</a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                        <thead>
                            <th>No</th>
                            <th>name</th>
                            <th>desc</th>
                            <th>commision_service</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                           @foreach($technician_levels as $technician_level)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                					<td>{{ $technician_level->name }}</td>
                                    <td>{{ $technician_level->desc }}</td>
                                    <td>{{ $technician_level->commision_service }} %</td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            {{-- <a href="{{ route('master.technician_levels.show', [$technician_level->id]) }}" class="btn btn-info">Show</a> --}}
                                            @can('technician_levels-edit')
                                                <a href="{{ route('master.technician_levels.edit', [$technician_level->id]) }}" class="btn btn-primary">Edit</a>
                                            @endcan
                                            @can('technician_levels-delete')
                                            {!! Form::open(['method' => 'DELETE','onsubmit'=>'return deleteData()','route' => ['master.technician_levels.destroy', $technician_level->id],'style'=>'display:inline']) !!}
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
