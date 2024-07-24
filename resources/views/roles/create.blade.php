@extends('layouts.admin')
@section('title','Create Role')
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
                    <h3 class="card-title">New User</h3>
                    </div>
                    <div class="card-body">

                    {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                    <div class="row g-3">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Permission:</strong>
                                <br/>
                                @php
                                    $groupedPermissions = [];
                                @endphp
                                @foreach($permission as $value)
                                    @php
                                        $parts = explode('-', $value->name, 2); // Split by the first dash
                                        $group = $parts[0]; // Get the first element of the resulting array
                                        $title = ucwords(str_replace('_', ' ', $group)); // Convert underscores to spaces and capitalize the words
                                    @endphp

                                    @if (!isset($groupedPermissions[$group]))
                                        @php
                                            $groupedPermissions[$group] = [
                                                'title' => $title,
                                                'permissions' => []
                                            ];
                                        @endphp
                                    @endif

                                    @php
                                        $groupedPermissions[$group]['permissions'][] = $value;
                                    @endphp
                                @endforeach

                                <div class="row g-3">
                                    @foreach ($groupedPermissions as $group => $groupData)
                                        <div class="col-lg-4 col-xl-3 col-md-6 col-12">

                                            <h3>{{ $groupData['title'] }}</h3>

                                            @foreach ($groupData['permissions'] as $value)
                                            <label>
                                                {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                                {{ $value->name }}
                                            </label>
                                            <br/>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
