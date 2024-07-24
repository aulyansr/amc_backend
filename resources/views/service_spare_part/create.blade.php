@extends('layouts.admin')
@section('title', 'Create Service Spare Part')
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
                            <h3 class="card-title">New Service Spare part</h3>
                        </div>
                        <div class="card-body">
                            {!! Form::open([
                                'route' => ['master.services.service_spare_part.store', $service->id],
                                'method' => 'POST',
                                'enctype' => 'multipart/form-data',
                            ]) !!}
                            <div class="row g-3">
                                @include('service_spare_part._form', [
                                    'submit' => 'Simpan',
                                ])

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-12 text-lg-start text-center">
                                            <a href="{{ route('master.masterac.index') }}" class="btn btn-danger"><i
                                                    class="ri-arrow-left-fill pe-2"></i>
                                                Back</a>
                                        </div>
                                        <div class="col-lg-6 col-12 text-lg-end text-center">
                                            <button type="submit" class="btn btn-primary"><i class="ri-save-fill pe-2"></i>
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
