@extends('layouts.admin')
@section('title', 'Customer Address')
@section('content')
    @can(['masteraddress-list', 'masteraddress-create', 'masteraddress-edit', 'masteraddress-delete'])
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Data Alamat Customer</h3>
                </div>
                <div class="card-body table-responsive">
                    @can('masteraddress-create')
                        <div class="pull-right mb-3">
                            <a class="btn btn-success" href="{{ route('customers.address.create', $customer->id) }}"> Create
                                New Address </a>
                        </div>
                    @endcan

                    <table class="table table-bordered table-striped datatable">
                        <thead>
                            <th>No</th>
                            <th>Nama Alamat</th>
                            <th>Tipe Bangunan</th>
                            <th>Alamat</th>
                            @if ($customer->type == '1')
                                <th>Jam Buka & Tutup</th>
                                <th>Next Service</th>
                            @endif
                            <th>Jumlah AC</th>
                            <td>
                                Last Order
                            </td>

                            <th width="280px">Action</th>
                        </thead>

                        <tbody>
                            @foreach ($customer->masterAddress as $key => $ad)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ad->address_name }}</td>
                                    <td>{{ $ad->address_type ? $ad->address_type : '-' }}</td>
                                    <td>
                                        {{ $ad->completedAddress }}

                                    </td>
                                    @if ($customer->type == '1')
                                        <td>{{ $ad->time_open && $ad->time_close ? date('H:i', strtotime($ad->time_open)) . ' - ' . date('H:i', strtotime($ad->time_close)) : '-' }}
                                        </td>
                                        <td>{{ $ad->completedNextService }}
                                        </td>
                                    @endif
                                    <td>{{ $ad->jumlah_ac }}</td>
                                    <td>
                                        @if ($ad->orders !== null && $ad->orders->isNotEmpty())
                                            <a href="{{ route('orders.show', [$ad->orders->last()->id]) }}">
                                                {{ date('D, d-F-Y / H:i', strtotime($ad->orders->last()->booked_date)) }}
                                            </a>
                                        @else
                                            No orders
                                        @endif
                                    </td>

                                    <td>
                                        {{-- <a class="btn btn-info" href="{{ route('customers.address.show',['masterCustomer'=>$customer->id,'masterAddress'=>$ad->id]) }}">Show</a>
                            --}}
                                        <div class="row g-2">
                                            <div class="col-auto">

                                                @can('masteraddress-edit')
                                                    <a class="btn btn-primary"
                                                        href="{{ route('customers.address.edit', ['masterCustomer' => $customer->id, 'masterAddress' => $ad->id]) }}">Edit</a>
                                                @endcan
                                            </div>
                                            <div class="col-auto">

                                                @can('masteraddress-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'onsubmit' => 'return deleteData()',
                                                        'route' => ['customers.address.destroy', ['masterCustomer' => $customer->id, 'masterAddress' => $ad->id]],
                                                        'style' => 'display:inline',
                                                    ]) !!}
                                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger delete-button']) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    @endcan
@endsection
