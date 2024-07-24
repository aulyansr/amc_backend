@extends('layouts.admin')
@section('title', '')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('repair_attachments-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('master.repair_attachment.create') }}"> Create</a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th>No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                @foreach ($repair_attachment as $repair_attachment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $repair_attachment->title }}</td>
                                        <td>{{ $repair_attachment->description }}</td>

                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('master.repair_attachment.show', [$repair_attachment->id]) }}"
                                                    class="btn btn-info">Show</a>
                                                @can('repair_attachments-edit')
                                                    <a href="{{ route('master.repair_attachment.edit', [$repair_attachment->id]) }}"
                                                        class="btn btn-primary">Edit</a>
                                                @endcan
                                                @can('repair_attachments-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'onsubmit' => 'return deleteData()',
                                                        'route' => ['master.repair_attachment.destroy', $repair_attachment->id],
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
@stop
