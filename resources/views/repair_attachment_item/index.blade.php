@extends('layouts.admin')
@section('title', '')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('repair_attachment_items-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('master.repair_attachment_item.create') }}"> Create</a>
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
                                @foreach ($repair_attachment_items as $repair_attachment_item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $repair_attachment_item->title }}</td>
                                        <td>{{ $repair_attachment_item->description }}</td>

                                        <td>
                                            <div class="d-flex gap-2">

                                                @can('repair_attachment_items-edit')
                                                    <a href="{{ route('master.repair_attachment_item.edit', [$repair_attachment_item->id]) }}"
                                                        class="btn btn-primary">Edit</a>
                                                @endcan
                                                @can('repair_attachment_items-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'onsubmit' => 'return deleteData()',
                                                        'route' => ['master.repair_attachment_item.destroy', $repair_attachment_item->id],
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
