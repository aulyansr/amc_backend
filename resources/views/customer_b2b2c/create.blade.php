@extends('layouts.admin')
@section('title', 'Create Customer')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">

                @if (count($errors) > 0)
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
                            <h3 class="card-title">New Customer</h3>
                        </div>
                        <div class="card-body">

                            {!! Form::open([
                                'route' => ['customers.customer_b2b2c.store', $customer_id],
                                'method' => 'POST',
                                'enctype' => 'multipart/form-data',
                            ]) !!}
                            @include('customer_b2b2c._form', [
                                'submit' => 'Simpan',
                            ])
                            {!! Form::close() !!}

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

            </div>
        </div>
    </section>
@endsection
