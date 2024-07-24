@extends('layouts.admin')
@section('title', 'Customers')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-account-multiple widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Customers</h5>
                        <h3 class="mt-3 mb-3">{{ $customers->count() }}</h3>
                    </div> <!-- end card-body-->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-account-multiple widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Customers This Month</h5>
                        <h3 class="mt-3 mb-3">
                            {{ $customers->filter(function ($customer) {
                                    return $customer->created_at->format('Y-m') === now()->format('Y-m');
                                })->count() }}
                        </h3>
                    </div> <!-- end card-body-->
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        @can('mastercustomer-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('customers.create') }}"> Create New Customer </a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th>No</th>
                                <th>Tipe Customer</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th width="280px">Action</th>
                            </thead>

                            <tbody>
                                @foreach ($customers as $key => $customer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ isset($customer->type) ? $customer->customer_type[$customer->type] : '-' }}
                                        </td>
                                        <td>{{ $customer->nama }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>
                                            <div class="row g-2">
                                                <div class="col-auto">
                                                    <a class="btn btn-info"
                                                        href="{{ route('customers.show', $customer->id) }}">Show</a>
                                                </div>
                                                <div class="col-auto">
                                                    @can('mastercustomer-edit')
                                                        <a class="btn btn-primary"
                                                            href="{{ route('customers.edit', $customer->id) }}">Edit</a>
                                                    @endcan
                                                </div>
                                                <div class="col-auto">
                                                    @can('mastercustomer-pin')
                                                        @if ($customer->type == 1)
                                                            <a class="btn btn-secondary"
                                                                href="{{ route('customers.view_pin', $customer->id) }}">{{ $customer->pin ? 'Update PIN' : 'Create PIN' }}</a>
                                                        @endif
                                                    @endcan
                                                </div>
                                                <div class="col-auto">
                                                    @can('mastercustomer-delete')
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'onsubmit' => 'return deleteData()',
                                                            'route' => ['customers.destroy', $customer->id],
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
        </div>
    </section>
@endsection
