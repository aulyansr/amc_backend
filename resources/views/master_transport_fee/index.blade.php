@extends('layouts.admin')
@section('title', 'Transport Fee')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('transport_fee-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('master.transport_fee.create') }}"> Create</a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th>No</th>
                                <th>Total Jarak</th>
                                <th>Jarak Dari</th>
                                <th>Jarak Sampai</th>
                                <th>Harga Jarak</th>
                                <th>Harga Jarak Special</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                @foreach ($data as $group)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $group->distance }}</td>
                                        <td>{{ $group->distance_from }}</td>
                                        <td>{{ $group->distance_to }}</td>
                                        <td>{{ thousand_rupiah($group->distance_price) }}</td>
                                        <td>{{ thousand_rupiah($group->distance_price_special) }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                {{-- <a href="{{ route('master.transport_fee.show', [$group->transport_fee_id]) }}" class="btn btn-info">Show</a> --}}
                                                @can('transport_fee-edit')
                                                    <a href="{{ route('master.transport_fee.edit', [$group->transport_fee_id]) }}"
                                                        class="btn btn-primary">Edit</a>
                                                @endcan
                                                @can('transport_fee-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'onsubmit' => 'return deleteData()',
                                                        'route' => ['master.transport_fee.destroy', $group->transport_fee_id],
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
@endsection
