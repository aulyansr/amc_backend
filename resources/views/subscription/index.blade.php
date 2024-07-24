@extends('layouts.admin')
@section('title', 'Subscription')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('subscription-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('subscription.create') }}"> Create New Subscription </a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th>No</th>
                                <th>kode Subscription</th>
                                <th>Nama Customer</th>
                                <th>Nama Subscription</th>
                                <th>Tipe</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Expired</th>
                                <th>Harga Subscription</th>
                                <th>Jumlah Subscription</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                @foreach ($subscription as $key => $subs)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $subs->code }}</td>
                                        <td>{{ $subs->customer?->nama }}</td>
                                        <td>{{ $subs->name }}</td>
                                        <td>{{ $subs->tipe ? $subs->tipe : '-' }}</td>
                                        <td>{{ date('d-m-Y', strtotime($subs->start_date)) }}</td>
                                        <td>{{ $subs->expired_date ? date('d-m-Y', strtotime($subs->expired_date)) : '-' }}
                                        </td>
                                        <td>{{ thousand_rupiah($subs->price_total) }}</td>
                                        <td>{{ $subs->amount_worked }}/{{ $subs->amount_subscription }} AC</td>
                                        <td><span
                                                class="{{ $status[$subs->status][1] }}">{{ $status[$subs->status][0] }}</span>
                                        </td>
                                        <td>
                                            <div class="row g-2">
                                                <div class="col-auto">
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ route('subscription.show', $subs->id) }}">Show</a>
                                                </div>
                                                @if ($subs->status != 'SELESAI')
                                                    <div class="col-auto">
                                                        @can('subscription-edit')
                                                            <a class="btn btn-warning btn-sm"
                                                                href="{{ route('subscription.edit', $subs->id) }}">Edit</a>
                                                        @endcan
                                                    </div>
                                                    <div class="col-auto">
                                                        @can('subscription-delete')
                                                            {{ Form::open([
                                                                'method' => 'DELETE',
                                                                'onsubmit' => 'return deleteData()',
                                                                'route' => ['subscription.destroy', $subs->id],
                                                                'style' => 'display:inline',
                                                            ]) }}
                                                            {{ Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) }}
                                                            {{ Form::close() }}
                                                        @endcan
                                                    </div>
                                                @endif
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
