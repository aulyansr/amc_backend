@extends('layouts.admin')
@section('title', 'Paket')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body table-responsive">
                        @can('services-create')
                            <div class="pull-right mb-3">
                                <a class="btn btn-success" href="{{ route('master.paket.create') }}"> Create</a>
                            </div>
                        @endcan

                        <table class="table table-bordered table-striped datatable">
                            <thead>
                                <th>No</th>
                                <th>Nama Paket</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Jumlah AC</th>
                                <th>Masa Berlaku</th>
                                <th>status</th>
                                <th>Gambar</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                @foreach ($paket as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->nama_paket }}</td>
                                        <td>{{ $p->deskripsi_paket }}</td>
                                        <td>{{ thousand_rupiah($p->harga_paket) }}</td>
                                        <td>{{ thousand_separator($p->jumlah_ac) }}</td>
                                        <td>{{ $p->masa_berlaku }}</td>
                                        <td>
                                            @if ($p->status == 1)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($paket) && $p->foto_paket)
                                                <img id="image-preview" src="{{ $p->foto_paket }}" alt="Preview Image"
                                                    style="max-width: 100px;" class="img-thumbnail">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                {{-- <a href="{{ route('master.paket.show', [$p->id]) }}" class="btn btn-info">Show</a> --}}
                                                @can('services-edit')
                                                    <a href="{{ route('master.paket.edit', [$p->id]) }}"
                                                        class="btn btn-primary">Edit</a>
                                                @endcan
                                                @can('services-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'onsubmit' => 'return deleteData()',
                                                        'route' => ['master.paket.destroy', $p->id],
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
