@extends('layouts.admin')
@section('title', 'PIN Customer')
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
                            <h3 class="card-title">PIN Customer</h3>
                        </div>
                        <div class="card-body">

                            {!! Form::model($customer, [
                                'method' => 'put',
                                'enctype' => 'multipart/form-data',
                                'route' => ['customers.update_pin', $customer->id],
                            ]) !!}
                            <div class="row g-3">
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label for="pin">Pin</label>
                                        {{ Form::password('pin', [
                                            'placeholder' => 'Pin',
                                            'class' => 'form-control',
                                            'id' => 'pin',
                                        ]) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label for="pin_confirmed">Konfirmasi PIN</label>
                                        {{ Form::password('pin_confirmed', [
                                            'placeholder' => 'Pin',
                                            'class' => 'form-control',
                                            'id' => 'pin_confirmed',
                                        ]) }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-3">
                                        <div class="col-lg-6 col-12 text-lg-start text-center">
                                            <a href="{{ route('customers.index') }}" class="btn btn-danger"><i
                                                    class="ri-arrow-left-line pe-2"></i>
                                                Back</a>
                                        </div>
                                        <div class="col-lg-6 col-12 text-lg-end text-center">
                                            <button type="submit" class="btn btn-primary"><i class="ri-save-line pe-2"></i>
                                                Simpan</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
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
