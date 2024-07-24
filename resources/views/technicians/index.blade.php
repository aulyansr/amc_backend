@extends('layouts.admin')
@section('title','')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('technicians-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('technicians.create') }}"> Create</a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                        <thead>
                            <th>No</th>
                            <th>Level</th>
                            <th>Nama Lengkap</th>
                            <th>Panggilan</th>
                            <th>No HP</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Tanggal Masuk</th>
                            <th>email</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                           @foreach($technicians as $technician)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                					<td>{{ $technician->technician_level->name }}</td>
                                    <td>{{ $technician->fullname }}</td>
                                    <td>{{ $technician->nickname }}</td>
                                    <td>{{ $technician->no_hp }}</td>
                                    <td>{{ $technician->gender }}</td>
                                    <td>{{ formatIndonesiaDate($technician->birthdate) }}</td>
                                    <td>{{ formatIndonesiaDate($technician->join_date) }}</td>
                                    <td>{{ $technician->email }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('technicians.show', [$technician->id]) }}" class="btn btn-info">Show</a>
                                            @can('technicians-edit')
                                                <a href="{{ route('technicians.edit', [$technician->id]) }}" class="btn btn-primary">Edit</a>
                                            @endcan
                                            @can('technicians-delete')
                                            {!! Form::open(['method' => 'DELETE','onsubmit'=>'return deleteData()','route' => ['technicians.destroy', $technician->id],'style'=>'display:inline']) !!}
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
