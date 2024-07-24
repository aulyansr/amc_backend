@extends('layouts.admin')
@section('title','Master Data Shifts')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('shifts-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('master.shifts.create') }}"> Create</a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                        <thead>
                            <th>No</th>
                            <th>name</th>
                            <th>shift from</th>
                            <th>shift to</th>
                            <th>day</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                           @foreach($shifts as $shift)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                					<td>{{ $shift->name }}</td>
                                    <td>{{ $shift->shift_from }}</td>
                                    <td>{{ $shift->shift_to }}</td>
                                    <td>{{ arrayToString(json_decode($shift->day)) }}</td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('master.shifts.show', [$shift->id]) }}" class="btn btn-info">Show</a>
                                            @can('shifts-edit')
                                                <a href="{{ route('master.shifts.edit', [$shift->id]) }}" class="btn btn-primary">Edit</a>
                                            @endcan
                                            @can('shifts-delete')
                                            {!! Form::open(['method' => 'DELETE','onsubmit'=>'return deleteData()','route' => ['master.shifts.destroy', $shift->id],'style'=>'display:inline']) !!}
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
