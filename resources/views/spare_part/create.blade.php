@extends('layouts.admin')
@section('title', 'Spare Part Create')
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
                            <h3 class="card-title">Spare Part</h3>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'master.spare_part.store', 'enctype' => 'multipart/form-data']) !!}

                            @include('spare_part._form')


                            {{ Form::submit('Create', ['class' => 'btn btn-primary']) }}

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
