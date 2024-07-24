@extends('layouts.admin')
@section('title', '')
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
                            <h3 class="card-title">Spare Part Service Update</h3>
                        </div>
                        <div class="card-body">
                            {{ Form::model($data, ['route' => ['master.services.service_spare_part.update', [$service->id, $data->id]], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}

                            <div class="row g-3">@include('service_spare_part._form')</div>

                            {{ Form::submit('Edit', ['class' => 'btn btn-primary']) }}

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
