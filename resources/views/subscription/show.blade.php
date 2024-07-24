@extends('layouts.admin')
@section('title', 'Detail User')
@section('content')
    <section class="content">
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Detail Subscription</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Kode Subscription</h5>
                                    <p>{{ $subscription->code }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Nama Subscription</h5>
                                    <p>{{ $subscription->name }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Nama Customer</h5>
                                    <p>{{ $subscription->customer->nama }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Status Subscription</h5>
                                    <p><span
                                            class="{{ $status[$subscription->status][1] }}">{{ $status[$subscription->status][0] }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Tanggal Subscription</h5>
                                    <p>{{ date('d-m-Y', strtotime($subscription->start_date)) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Tanggal Selesai</h5>
                                    <p>{{ $subscription->end_date ? date('d-m-Y', strtotime($subscription->end_date)) : '-' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Harga Subscription</h5>
                                    <p>{{ thousand_rupiah($subscription->price_total) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Jumlah Subscription</h5>
                                    <p>{{ $subscription->amount_worked }}/{{ $subscription->amount_subscription }} AC</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Detail Order Subscription</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
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
                                    @foreach ($subscription->orders->where('order_status', '!=', 0)->sortByDesc('booked_date') as $order)
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
        </div>
    </section>
@endsection
