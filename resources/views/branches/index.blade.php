@extends('layouts.admin')
@section('title','')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('branches-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('master.branch.create') }}"> Create</a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                        <thead>
                            <th>No</th>
                            <th>name</th>
                            <th>phone</th>
                            <th>address</th>
                            <th>latitude</th>
                            <th>longitude</th>
                            <th>max</th>

                            <th>Action</th>
                        </thead>

                        <tbody>
                           @foreach($branches as $branch)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                					<td>{{ $branch->name }}</td>
                                    <td>{{ $branch->phone }}</td>
                                    <td>{{ $branch->address }}</td>
                                    <td>{{ $branch->latitude }}</td>
                                    <td>{{ $branch->longitude }}</td>
                                    <td>{{ $branch->max }}</td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('master.branch.show', [$branch->id]) }}" class="btn btn-info">Show</a>
                                            @can('branches-edit')
                                                <a href="{{ route('master.branch.edit', [$branch->id]) }}" class="btn btn-primary">Edit</a>
                                            @endcan
                                            @can('branches-delete')
                                            {!! Form::open(['method' => 'DELETE','onsubmit'=>'return deleteData()','route' => ['master.branch.destroy', $branch->id],'style'=>'display:inline']) !!}
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
@stop
