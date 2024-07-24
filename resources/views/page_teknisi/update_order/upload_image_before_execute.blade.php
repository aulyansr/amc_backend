@extends('layouts.screen_technician')

@section('css')
    <style>
        .dropzone {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }

        .dropzone.highlight {
            border-color: #66ccff;
        }

        .dropzone-text {
            font-size: 18px;
        }

        .file-list {
            margin-top: 20px;
        }

        .file-list-item {
            margin-bottom: 5px;
        }

        .text-primary-blue.mb-3 {
            height: 40px;
            overflow: hidden;
        }
    </style>
@endsection
@section('content')
    <section class="content-tch">
        <div class="container">
            <div class="row gy-3">
                <div class="col-12">
                    <div class="d-flex justify-content-between mb-3">
                        <p class="text-primary-blue mb-0 fw-bold fs-5">Foto Sebelum Pengerjaan</p>
                        <span class="badge bg-primary"> {{ $order->service_group?->name }} </span>
                    </div>

                    <div class="row g-3">
                        @foreach ($order_ac as $o)
                            <div class="col-12">
                                <h4 class="bg-primary text-white p-2 rounded-3">{{ $o->service?->name }}</h4>
                            </div>
                            @if (!empty($o->activitiesServices))
                                @foreach ($o->activitiesServices as $as)
                                    <div class="col-6">
                                        <p class="text-primary-blue mb-3">{{ $as->title }}</p>
                                        <div class="card card-homepage mb-3">
                                            <div class="card-body">
                                                <form
                                                    action="{{ route('technician.store_image_before', [$o->id, $as->id]) }}"
                                                    class="dropzone" id="imageUpload">
                                                    @csrf
                                                    <input type="hidden" name="image_id" class="image_id"
                                                        value="{{ $as->id }}">
                                                    <input type="hidden" name="text" class="text"
                                                        value="{{ $as->title }}">
                                                    <div class="fallback">
                                                        <input name="file" type="file" multiple />
                                                    </div>

                                                    <ul class="file-list" id="fileList"></ul>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                        {{-- <div class="col-6">
                            <p class="text-primary-blue mb-3">FOTO SPK TANPA TANDA TANGAN KONSUMEN</p>
                            <div class="card card-homepage mb-3">
                                <div class="card-body">
                                    <form action="/upload" class="dropzone" id="imageUpload">
                                        @csrf
                                        <div class="fallback">
                                            <input name="file" type="file" multiple />
                                        </div>

                                        <ul class="file-list" id="fileList"></ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <p class="text-primary-blue mb-3">FOTO KARTU GARANSI</p>
                            <div class="card card-homepage mb-3">
                                <div class="card-body">
                                    <form action="/upload" class="dropzone" id="imageUpload">
                                        @csrf
                                        <div class="fallback">
                                            <input name="file" type="file" multiple />
                                        </div>

                                        <ul class="file-list" id="fileList"></ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <p class="text-primary-blue mb-3">FOTO FAKTUR PEMBELIAN</p>
                            <div class="card card-homepage mb-3">
                                <div class="card-body">
                                    <form action="/upload" class="dropzone" id="imageUpload">
                                        @csrf
                                        <div class="fallback">
                                            <input name="file" type="file" multiple />
                                        </div>

                                        <ul class="file-list" id="fileList"></ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <p class="text-primary-blue mb-3">FOTO FAKTUR PEMBELIAN</p>
                            <div class="card card-homepage mb-3">
                                <div class="card-body">
                                    <form action="/upload" class="dropzone" id="imageUpload">
                                        @csrf
                                        <div class="fallback">
                                            <input name="file" type="file" multiple />
                                        </div>

                                        <ul class="file-list" id="fileList"></ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <p class="text-primary-blue mb-3">FOTO SUHU HEMBUSAN INDOOR AC</p>
                            <div class="card card-homepage mb-3">
                                <div class="card-body">
                                    <form action="/upload" class="dropzone" id="imageUpload">
                                        @csrf
                                        <div class="fallback">
                                            <input name="file" type="file" multiple />
                                        </div>

                                        <ul class="file-list" id="fileList"></ul>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <p class="text-primary-blue mb-3">FOTO KONDISI AWAL AC DI INDOOR</p>
                            <div class="card card-homepage mb-3">
                                <div class="card-body">
                                    <form action="/upload" class="dropzone" id="imageUpload">
                                        @csrf
                                        <div class="fallback">
                                            <input name="file" type="file" multiple />
                                        </div>

                                        <ul class="file-list" id="fileList"></ul>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <p class="text-primary-blue mb-3">
                                FOTO KONDISI AWAL AC DI OUTDOOR
                            </p>
                            <div class="card card-homepage mb-3">
                                <div class="card-body">
                                    <form action="/upload" class="dropzone" id="imageUpload">
                                        @csrf
                                        <div class="fallback">
                                            <input name="file" type="file" multiple />
                                        </div>

                                        <ul class="file-list" id="fileList"></ul>
                                    </form>
                                </div>
                            </div>
                        </div> --}}


                    </div>

                    <a href="{{ route('technician.orderDetail', ['id' => $order->id]) }}"
                        class="btn btn-outline-primary w-100 mt-3">
                        Selesai
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        $('.select2').select2();

        $('.ac_option').click(function(e) {
            let val = $(this).val();
            if (val === 'ac_baru') {
                $('.ac_baru').removeClass('d-none');
                $('.ac_baru input, .ac_baru select').attr('required', true);
                $('.pilih_ac').addClass('d-none');
                $('.pilih_ac select').removeAttr('required');
            } else {
                $('.ac_baru').addClass('d-none');
                $('.ac_baru input, .ac_baru select').removeAttr('required');
                $('.pilih_ac').removeClass('d-none');
                $('.pilih_ac select').attr('required', true);
            }
        });
        $("#BrandAC").select2({
            placeholder: "Pilih Merk AC",
            tags: true,
            theme: 'bootstrap-5',
        });
    </script>
@endsection
