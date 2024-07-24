@extends('layouts.admin')
@section('title','')
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
                        <h3 class="card-title">orders</h3>
                    </div>
                    <div class="card-body">
                    {{ Form::model($order, array('route' => array('orders.update', $order->id), 'method' => 'PUT')) }}

                        <div class="row g-3">

                            @include('orders._form')
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-6 col-12 text-lg-start text-center">
                                        <a href="{{ route('orders.index') }}" class="btn btn-danger"><i class="ri-arrow-left-line pe-2"></i> Back</a>
                                    </div>
                                    <div class="col-lg-6 col-12 text-lg-end text-center">
                                        <button type="submit" class="btn btn-primary"><i class="ri-save-line pe-2"></i> Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    {{ Form::close() }}

                    </div>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

            </div>
        </div>
    </section>


@endsection
