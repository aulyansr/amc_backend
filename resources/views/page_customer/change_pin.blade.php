@extends('layouts.screen_customer')
@section('css')
@endsection
@section('content')
    <div class="container">
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
                        <div class="card-body">

                            {{ Form::open(['route' => ['customer.profile.update_pin']]) }}
                            <div class="row g-3">
                                <div class="col-12">
                                    <h1 class="fs-2 text-primary-blue"> Ubah PIN </h1>
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="pin_lama">PIN Lama</label>
                                        {{ Form::password('pin_lama', ['class' => 'form-control', 'maxlength' => '6', 'minlength' => '6', 'pattern' => '\d{6}', 'title' => 'PIN harus 6 digit angka']) }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="pin_baru">PIN Baru</label>
                                        {{ Form::password('pin_baru', ['class' => 'form-control', 'maxlength' => '6', 'minlength' => '6', 'pattern' => '\d{6}', 'title' => 'PIN harus 6 digit angka']) }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="pin_baru_confirmed">Konfirmasi PIN Baru</label>
                                        {{ Form::password('pin_baru_confirmed', ['class' => 'form-control', 'maxlength' => '6', 'minlength' => '6', 'pattern' => '\d{6}']) }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-3 justify-content-lg-center">
                                        <div class="col-auto">
                                            <a href="{{ route('customer.profile.index') }}"
                                                class="btn btn-danger btn-sm w-100 px-lg-5 py-lg-2 px-3 py-1">
                                                Kembali
                                            </a>
                                        </div>
                                        <div class="col-auto ms-auto">
                                            <button type="submit"
                                                class="btn btn-primary btn-sm px-lg-5 py-lg-2 px-3 py-1 w-100">Simpan</button>
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
    </div>
@endsection
@section('js')
@endsection
