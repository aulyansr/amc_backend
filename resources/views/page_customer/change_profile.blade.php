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

                            {{ Form::open(['route' => ['customer.profile.update']]) }}
                            <div class="row g-3">
                                <div class="col-12">
                                    <h1 class="fs-2 text-primary-blue"> Ubah Profile </h1>
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Nama Lengkap</label>
                                        {{ Form::text('name',auth()->guard('customer')->user()->nama,['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        {{ Form::email('email',auth()->guard('customer')->user()->email,['class' => 'form-control']) }}
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
