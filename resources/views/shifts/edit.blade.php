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
                        <h3 class="card-title">Ubah shifts</h3>
                    </div>
                    <div class="card-body">
                    {{ Form::model($shift, array('route' => array('master.shifts.update', $shift->id), 'method' => 'PUT')) }}

                        @include('shifts._form')

                    {{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}

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
