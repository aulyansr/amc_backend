@extends('layouts.admin')
@section('title','Create Master Ac')
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
                      <h3 class="card-title">New Ac</h3>
                    </div>
                    <div class="card-body">
                    {!! Form::open(array('route' => 'master.masterac.store','method'=>'POST', 'enctype'=>'multipart/form-data')) !!}
                        @include('masterac._form',[
                            'submit' => 'Simpan'
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
