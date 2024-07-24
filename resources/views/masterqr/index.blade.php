@extends('layouts.admin')
@section('title', 'Generate Qr')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        <div class="row g-3">
                            <div class="col-12">
                                @can('masterqr-create')
                                    @if ($status == 0)
                                        <form action="{{ route('master.qrgenerate.store') }}" method="POST">
                                            @csrf
                                            <div class="row g-2 align-items-center">
                                                <div class="col-auto">
                                                    <input type="number" name="number" id="number"
                                                        placeholder="Banyak Qr Generate" class="form-control" required
                                                        min="1">
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-success">Generate QR</button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                @endcan
                            </div>
                            <div class="col-12">
                                <table class="table table-bordered table-striped datatable">
                                    <thead>
                                        <th>No</th>
                                        <th>Kode QR</th>
                                        <th>Qr Code</th>
                                        <th>Status</th>
                                        <th>action</th>
                                    </thead>

                                    <tbody>
                                        @foreach ($masterqr as $key => $qr)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $qr->qr_name }}</td>
                                                <td>{!! QrCode::generate(route('landing.showdetailac', $qr->url_unique)) !!}</td>
                                                <td>{{ $qr->status == '0' || $qr->status == '1' ? \App\Enums\MasterQrStatus::getDescription((int) $qr->status) : '-' }}
                                                </td>
                                                @if ($qr->status == 0)
                                                    <td>
                                                        @can('masterqr-generatepdf')
                                                            <a href="{{ route('master.qrgenerate.generatepdf', $qr->url_unique) }}"
                                                                class="btn btn-info">Export Qr</a>
                                                        @endcan
                                                    </td>
                                                @else
                                                    <td>
                                                        <a class="btn btn-info"
                                                            href="{{ route('master.qrgenerate.show', $qr->url_unique) }}">Show</a>
                                                        @can('masterqr-edit')
                                                            <a class="btn btn-primary"
                                                                href="{{ route('master.qrgenerate.edit', $qr->url_unique) }}">Edit</a>
                                                        @endcan
                                                        @can('masterqr-delete')
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'onsubmit' => 'return deleteData()',
                                                                'route' => ['master.qrgenerate.destroy', $qr->url_unique],
                                                                'style' => 'display:inline',
                                                            ]) !!}
                                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
