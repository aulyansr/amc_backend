@extends('layouts.admin')
@section('title', 'Detail Teknisi')
@section('content')
    <section class="content">
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Teknisi</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Nama Team</h5>
                                    <p>{{ $technician->teams->first()->nama }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Nama teknisi</h5>
                                    <p>{{ $technician->fullname }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Nama Panggilan</h5>
                                    <p>{{ $technician->nickname ? $technician->nickname : '-' }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Nomor Hp</h5>
                                    <p>{{ $technician->no_hp ? $technician->no_hp : '-' }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Jenis Kelamin</h5>
                                    <p>{{ $technician->gender ? $technician->gender : '-' }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Tanggal Lahir</h5>
                                    <p>{{ $technician->birthdate ? date('d-m-Y', strtotime($technician->birthdate)) : '-' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Tanggal bergabung</h5>
                                    <p>{{ $technician->join_date ? $technician->join_date : '-' }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Email</h5>
                                    <p>{{ $technician->email ? $technician->email : '-' }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <h5>Status Teknisi</h5>
                                    <p>
                                        @if ($technician->is_active == 1)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @if ($technician->is_active == 0)
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <h5>Tanggal Keluar</h5>
                                        <p>{{ $technician->leave_date ? date('d-m-Y', strtotime($technician->email)) : '-' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <h5>Alasan Keluar</h5>
                                        <p>{{ $technician->leave_reason ? $technician->leave_reason : '-' }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
