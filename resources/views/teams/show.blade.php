@extends('layouts.admin')
@section('title', 'Details Team')
@section('content')
    <section class="content">
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Team</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Nama Team</h5>
                                    <p>{{ $team->nama }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Anggota Team</h5>
                                    @foreach ($team->technician as $tech)
                                        <p>{{ "- $tech->fullname" }}</p>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Status Aktif</h5>
                                    <p>
                                        @if ($team->is_active == 1)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Status Sekarang</h5>
                                    <p>
                                        <span
                                            class="badge {{ $team->status_team['color'] }}">{{ $team->status_team['status'] }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Cabang Team</h5>
                                    <p>{{ $team->branch->name }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Order Hari Ini</h5>
                                    <p>{{ $team->count_team_order_today }} Order</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Total Order di Kerjakan</h5>
                                    <p>{{ $team->orders()->where('order_status', 6)->count() }} Order Selesai</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Order dan Detail</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Tanggal/Jam Booking</th>
                                <th>Kode Order</th>
                                <th>Nama Customer</th>
                                <th>Status Order</th>
                                <th>Detail Yang di kerjakan</th>
                            </thead>
                            <tbody>
                                @foreach ($team->orders->where('order_status', '!=', 0)->sortByDesc('booked_date') as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('D, d-F-Y / H:i', strtotime($order->booked_date)) }}</td>
                                        <td>{{ $order->order_code }}</td>
                                        <td>{{ $order->customer->nama }}</td>
                                        <td>
                                            @if (
                                                $order->teams->groupBy('pivot.status_team')->count() > 1 &&
                                                    ($order->order_status != 0 || $order->order_status != 6))
                                                @foreach ($order->teams->groupBy('pivot.status_team') as $status => $count)
                                                    <span
                                                        class="{{ $statusorder[$count->first()->pivot->status_team][1] }}">{{ count($count) . ' ' . $statusorder[$count->first()->pivot->status_team][0] }}</span>
                                                @endforeach
                                            @else
                                                <span
                                                    class="{{ $statusorder[$order->order_status][1] }}">{{ $statusorder[$order->order_status][0] }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($order->serviceCounts as $count)
                                                - {{ $count['service_name'] }} ({{ $count['count'] }}) <br />
                                            @endforeach
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
