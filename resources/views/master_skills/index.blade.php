@extends('layouts.admin')
@section('title','Skill')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('master_skills-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('master.master_skills.create') }}"> Create New Skill </a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                        <thead>
                            <th>No</th>
                            <th>Nama Skill</th>
                            <th>Deskripsi Skill</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                           @foreach($master_skills as $master_skill)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $master_skill->skill_name }}</td>
                                    <td>{{ $master_skill->skill_desc }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('master.master_skills.show', [$master_skill->id]) }}" class="btn btn-info">Show</a>
                                            @can('master_skills-edit')
                                                <a href="{{ route('master.master_skills.edit', [$master_skill->id]) }}" class="btn btn-primary">Edit</a>
                                            @endcan
                                            @can('master_skills-delete')
                                            {!! Form::open(['method' => 'DELETE','onsubmit'=>'return deleteData()','route' => ['master.master_skills.destroy', $master_skill->id],'style'=>'display:inline']) !!}
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
