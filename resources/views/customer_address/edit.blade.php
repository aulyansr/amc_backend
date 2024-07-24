@extends('layouts.admin')
@section('title','Address Customer')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">

                @if ($errors->any())
                    <div class="alert alert-danger">
                    <strong>Whoops!</strong>Something went wrong.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    </div>
                @endif


                <div class="col-md-12">
                    <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Address Customer</h3>
                    </div>
                    <div class="card-body">
                    {{ Form::model($address, array('route' => array('customers.address.update', ['masterCustomer'=>$master_customer_id,'masterAddress'=>$address->id]), 'method' => 'PUT')) }}

                    @include('customer_address._form')

                    {{ Form::close() }}

                    </div>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

            </div>
        </div>
    </section>


@stop
