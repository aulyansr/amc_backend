@extends('layouts.admin')
@section('title', 'Promos')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('promo-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('master.promos.create') }}"> Create</a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th></th>
                                <th></th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Promo Code</th>
                                <th>Valid Until</th>
                                <th>Kuota</th>
                                <th>Telah Terpaakai</th>
                                <th>Status</th>
                                <th>Action</th>

                            </thead>

                            <tbody>
                                @foreach ($promos as $promo)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if (isset($promo) && $promo->promo_poster)
                                                <img id="image-preview" src="{{ $promo->promo_poster }}" alt="Preview Image"
                                                    style="max-width: 100px;" class="img-thumbnail">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $promo->promo_name }}</td>
                                        <td>{{ $promo->promo_description }}</td>
                                        <td>{{ $promo->promo_code }}</td>
                                        <td>{{ date('d-F-Y', strtotime($promo->expired_date)) }}</td>
                                        <td>{{ $promo->max_use }}</td>
                                        <td>{{ $promo->in_use }}</td>
                                        <td>
                                            {{--  todo: status --}}
                                        </td>

                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('master.promos.show', [$promo->id]) }}"
                                                    class="btn btn-info">Show</a>
                                                @can('promos-edit')
                                                    <a href="{{ route('master.promos.edit', [$promo->id]) }}"
                                                        class="btn btn-primary">Edit</a>
                                                @endcan
                                                @can('promos-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'onsubmit' => 'return deleteData()',
                                                        'route' => ['master.promos.destroy', $promo->id],
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
