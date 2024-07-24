@extends('layouts.admin')
@section('title','Roles')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('role-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role </a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                        <thead>
                            <th>No</th>
                            <th>Name</th>
                            <th width="280px">Action</th>
                        </thead>

                        <tbody>
                            @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                                    @can('role-edit')
                                        <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                    @endcan
                                    @can('role-delete')
                                        {!! Form::open(['method' => 'DELETE','onsubmit'=>'return deleteData()','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    @endcan
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
