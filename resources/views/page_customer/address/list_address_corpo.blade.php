@extends('layouts.screen_customer')
@section('css')
@endsection
@section('content')
    <div class="container">

        <div class="row g-3 justify-content-center">
            <div class="card rounded-5 border-0 shadow">
                <div class="card-body">
                    <h2 class="fs-2 text-primary-blue fw-bold mb-3">Daftar Alamat</h2>
                    @foreach ($addresses as $address)
                        <div class="card mb-3 rounded-3 border-0">
                            <div class="card-body p-0">
                                <div class="row g-3 align-items-center ">
                                    <div class="col-auto">
                                        <i class="fas fa-home me-1 text-primary-blue"></i>
                                    </div>
                                    <div class="col-auto">
                                        <p class="fw-bold text-primary-blue">
                                            {{ $address->address_name }}
                                        </p>
                                    </div>

                                    <div class="col-12">
                                        <div class="row justify-content-between align-items-center g-3">
                                            <div class="col-12 col-md-8 order-2 order-md-1">
                                                {{ $address->completedAddress }}
                                            </div>
                                            <div class="col-12 col-md-auto order-1 order-md-2">
                                                <div class="text-center  d-none d-md-block">
                                                    <p class="fs-3 fw-bold">{{ $address->ac_customer->count() }}</p>
                                                    <span class="text-primary-blue">Unit AC</span>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12">
                                        <div class="row justify-content-center justify-content-lg-start">

                                            <div class="col-6 col-md-2">
                                                <a href="{{ route('customer.alamat.show', hash_id($address->id)) }}"
                                                    class="btn btn-blue w-100 px-2 py-2 rounded-5">
                                                    Lihat
                                                </a>
                                            </div>
                                            <div class="col-6 col-md-2">
                                                <a href="{{ route('customer.alamat.edit', hash_id($address->id)) }}"
                                                    class="btn btn-outline-warning  w-100 px-2 py-2 ">
                                                    <i class="fas fa-edit me-1"></i>
                                                    Ubah
                                                </a>
                                            </div>
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
