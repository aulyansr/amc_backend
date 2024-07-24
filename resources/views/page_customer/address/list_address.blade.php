@extends('layouts.screen_customer')
@section('css')
@endsection
@section('content')
    <div class="container">
        <div class="row g-3 justify-content-center">

            <div class="col-12">
                <div class="card rounded-3 border-0 shadow">
                    <div class="card-body">
                        <h2 class="fs-2 text-primary-blue">Daftar Alamat</h2>
                        @foreach ($addresses as $address)
                            <div class="card bg-info mb-3">
                                <div class="card-body">
                                    <div class="row g-1 align-items-center">
                                        <div class="col-auto">
                                            <i class="fas fa-home me-1"></i>
                                        </div>
                                        <div class="col-auto">
                                            {{ $address->address_name }}
                                        </div>
                                        @if ($address->is_main)
                                            <div class="col-auto">
                                                <span class="badge text-bg-info text-white">Utama</span>
                                            </div>
                                        @endif
                                        @if ($address->jumlah_ac)
                                            <div class="col-auto">
                                                <span class="badge bg-secondary text-white">Jumlah AC :
                                                    {{ $address->jumlah_ac }}</span>
                                            </div>
                                        @endif
                                        @if ($address->ac_customer->count() >= 0)
                                            <div class="col-auto">
                                                <span class="badge bg-primary text-white">Jumlah Diservice :
                                                    {{ $address->ac_customer->count() }}</span>
                                            </div>
                                        @endif

                                        <div class="col-12 mt-3 ps-3">
                                            {{ $address->completedAddress }}
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="row g-3">
                                                <div class="col-auto">
                                                    <a href="{{ route('customer.alamat.show', hash_id($address->id)) }}"
                                                        class="rounded-5 btn btn-primary btn-sm p-0 px-3 py-1 text-white"><i
                                                            class="fas fa-eye me-1"></i>Lihat Detail</a>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="{{ route('customer.alamat.edit', hash_id($address->id)) }}"
                                                        class="rounded-5 btn btn-warning btn-sm p-0 px-3 py-1 text-black"><i
                                                            class="fas fa-edit me-1"></i>Ubah</a>
                                                </div>
                                                @if (!$address->is_main)
                                                    <div class="col-auto">
                                                        <form
                                                            action="{{ route('customer.alamat.set_main', hash_id($address->id)) }}"
                                                            method="POST" class="form-main">
                                                            @csrf
                                                            <button type="submit"
                                                                class="rounded-5 btn-sm p-0 px-3 py-1 btn btn-blue main-button">Jadikan
                                                                Alamat
                                                                Utama</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                {{ $addresses->links('pagination::simple-bootstrap-5') }}
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('customer.alamat.create') }}"
                                class="btn btn-outline-blue rounded-2 px-5 py-2 w-100">
                                <i class="fas fa-plus me-1"></i>
                                Tambah Alamat
                            </a>
                        </div>
                    </div>

                </div>
            </div>



        </div>
    </div>
@endsection
@section('js')
    <script>
        $('.main-button').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: `Kamu akan Mengubah Alamat Utama ke Alamat Baru.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Saya Yakin!',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('.form-main').submit();
                }
            })
        });
    </script>
@endsection
