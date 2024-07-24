@extends('layouts.admin')
@section('title','Master Ac')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('masterac-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('master.masterac.create') }}"> Create New Ac </a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                        <thead>
                            <th>No</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Nama AC</th>
                            <th>PK AC</th>
                            <th>Status Inverter</th>
                            <th>Tipe Freon</th>
                            <th width="280px">Action</th>
                        </thead>

                        <tbody>
                            @foreach ($masterac as $key => $ac)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ac->brand }}</td>
                                <td>{{ $ac->model }}</td>
                                <td>{{ $ac->ac_name }}</td>
                                <td>{{ $ac->pk }}</td>
                                <td>{{ $ac->is_inverter }}</td>
                                <td>{{ $ac->freon_type }}</td>

                                <td>
                                    {{-- <a class="btn btn-info" href="{{ route('master.masterac.show',$ac->id) }}">Show</a> --}}
                                    <div class="row g-2">
                                        @can('masterac-edit')
                                            <div class="col-auto">
                                                <a class="btn btn-primary" href="{{ route('master.masterac.edit',$ac->id) }}">Edit</a>
                                            </div>
                                        @endcan
                                        @can('masterac-delete')
                                            <div class="col-auto">
                                                {!! Form::open(['method' => 'DELETE','onsubmit'=>'return deleteData()','route' => ['master.masterac.destroy', $ac->id],'style'=>'display:inline']) !!}
                                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            </div>
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
