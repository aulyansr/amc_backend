@extends('layouts.admin')
@section('title', 'Teams')
@section('content')
    <section class="content">

        <div class="row g-3">
            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <!-- Total Order -->
                            <div class="col-sm-6 col-lg-3">
                                <div class="card rounded-0 shadow-none m-0">
                                    <div class="card-body text-center">
                                        <i class="ri-briefcase-line text-muted font-24"></i>
                                        <h3><span>{{ $total_order }}</span></h3>
                                        <p class="text-muted font-15 mb-0">Total Order</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Order This Month -->
                            <div class="col-sm-6 col-lg-3">
                                <div class="card rounded-0 shadow-none m-0 border-start border-light">
                                    <div class="card-body text-center">
                                        <i class="ri-list-check-2 text-muted font-24"></i>
                                        <h3><span>{{ $order_this_month }}</span></h3>
                                        <p class="text-muted font-15 mb-0">Total Order This Month</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Customer -->
                            <div class="col-sm-6 col-lg-3">
                                <div class="card rounded-0 shadow-none m-0 border-start border-light">
                                    <div class="card-body text-center">
                                        <i class="ri-group-line text-muted font-24"></i>
                                        <h3><span>{{ $most_order['orders_count'] }}</span></h3>
                                        <p class="text-muted font-15 mb-0">Team With Most Order this Month</p>
                                        @foreach ($most_order['teams'] as $fewest)
                                            <p class="text-muted font-15 mb-0"><b>-{{ $fewest->nama }}</b></p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Total Income -->
                            <div class="col-sm-6 col-lg-3">
                                <div class="card rounded-0 shadow-none m-0 border-start border-light">
                                    <div class="card-body text-center">
                                        <i class="ri-line-chart-line text-muted font-24"></i>
                                        <h3><span>{{ $fewest_order['orders_count'] }}</span></h3>
                                        <p class="text-muted font-15 mb-0">Team With Fewest Order this Month</p>
                                        @foreach ($fewest_order['teams'] as $fewest)
                                            <p class="text-muted font-15 mb-0"><b>-{{ $fewest->nama }}</b></p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row-->
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('teams-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('master.teams.create') }}"> Create</a>
                            </div>
                        @endcan
                        {{ Form::model($filter, ['route' => 'master.teams.index', 'method' => 'get']) }}
                        <div class="row g-2 my-2">
                            <div class="col-12"><b>Cek Availability</b></div>
                            <div class="col-auto">
                                {{ Form::date('date', null, ['class' => 'form-control date-picker', 'autocomplete' => 'off', 'placeholder' => 'Tanggal Booking']) }}

                            </div>
                            <div class="col-auto">
                                {!! Form::select('status', $status_team, null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Status',
                                ]) !!}
                            </div>
                            <div class="col-auto">
                                {{ Form::submit('Cek', ['class' => 'btn btn-primary']) }}
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th>No</th>

                                <th>Nama Team</th>
                                <th>Anggota Team</th>
                                <th>Status Aktif</th>
                                <th>Status Sekarang</th>
                                <th>Cabang</th>
                                <th>Order Hari Ini</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                @foreach ($teams as $team)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        {{-- <td>{{ arrayToString(json_decode($team->shift->day))." ( ". $team->shift->shift_from ." - ". $team->shift->shift_to ." )" }}</td> --}}
                                        <td>{{ $team->nama }}</td>
                                        <td>
                                            @foreach ($team->technician as $tech)
                                                {{ "- $tech->fullname" }}
                                                <br>
                                            @endforeach
                                        </td>
                                        {{-- <td>
                                        @foreach ($team->skill as $skill)
                                            {{$loop->iteration.". ". $skill->skill_name }}
                                            <br>
                                        @endforeach
                                    </td> --}}
                                        <td class="text-center">
                                            @if ($team->is_active == 1)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge {{ $team->status_team['color'] }}">{{ $team->status_team['status'] }}</span>
                                        </td>
                                        <td>{{ $team->branch->name }}</td>
                                        <td>{{ $team->count_team_order_today }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('master.teams.show', [$team->id]) }}"
                                                    class="btn btn-info">Show</a>
                                                @can('teams-edit')
                                                    <a href="{{ route('master.teams.edit', [$team->id]) }}"
                                                        class="btn btn-primary">Edit</a>
                                                @endcan
                                                @can('teams-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'onsubmit' => 'return deleteData()',
                                                        'route' => ['master.teams.destroy', $team->id],
                                                        'style' => 'display:inline',
                                                    ]) !!}
                                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
