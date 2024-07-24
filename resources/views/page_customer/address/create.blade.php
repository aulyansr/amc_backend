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
                        <div class="card-header">
                            <h3 class="card-title">Tambah Alamat Baru</h3>
                        </div>
                        <div class="card-body">
                            {{ Form::open(['route' => ['customer.alamat.store']]) }}
                            @include('page_customer.address._form')

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
