@extends('layouts.admin')
@section('title','Permissions')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        @can('permission-create')
                        <div class="pull-right">
                            <a class="btn btn-success" href="{{ route('permissions.create') }}"> Create New Permission </a>
                        </div><br>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th>No</th>
                                <th>Name</th>
                                <th width="280px">Action</th>
                            </thead>
                            <tbody>
                                @foreach ($info as $i => $product)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <form action="{{ route('permissions.destroy',$product->id) }}" method="POST" onsubmit="return deleteData()">
                                            <a class="btn btn-info" href="{{ route('permissions.show',$product->id) }}">Show</a>
                                            @can('permission-edit')
                                            <a class="btn btn-primary" href="{{ route('permissions.edit',$product->id) }}">Edit</a>
                                            @endcan


                                            @csrf
                                            @method('DELETE')
                                            @can('permission-delete')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                            @endcan
                                        </form>
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
