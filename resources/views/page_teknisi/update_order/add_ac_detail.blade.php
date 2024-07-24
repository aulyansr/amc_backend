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
    </style>
@endsection

@section('content')
    <section class="content-tch">
        <div class="container">
            <div class="row gy-3">
                <div class="col-12">
                    <div class="d-flex justify-content-between mb-3">
                        <p class="text-primary-blue mb-0">Add Detail AC</p>
                        <span class="badge bg-primary"> Cleaning </span>
                    </div>

                    <div class="card card-homepage mb-5">
                        <form action="{{ route('technician.store_detail_ac', ['order' => $order->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="master_customer_id" value="{{ $order->master_customer_id }}">
                            <input type="hidden" name="master_address_id" value="{{ $order->master_address_id }}">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12 text-center">
                                        <div class="btn-group" role="group" aria-label="Radio buttons">
                                            <input type="radio" class="btn-check ac_option" name="ac_option"
                                                id="option1" value="pilih_ac" autocomplete="off" checked>
                                            <label class="btn btn-outline-primary btn-sm" for="option1">Pilih AC</label>
                                            <input type="radio" class="btn-check ac_option" name="ac_option"
                                                id="option2" value="ac_baru" autocomplete="off">
                                            <label class="btn btn-outline-primary btn-sm" for="option2">AC baru</label>
                                        </div>
                                    </div>
                                    <div class="ac_baru col-12 d-none">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="BrandAC" class="form-label">Pilih Brand AC</label>
                                                <select class="form-select" id="BrandAC" aria-label="BrandAC"
                                                    name="brandAC">
                                                    <option selected>Pilih</option>
                                                    <option value="Samsung">Samsung</option>
                                                    <option value="Sharp">Sharp</option>
                                                    <option value="Gree">Gree</option>
                                                    <option value="Daikin">Daikin</option>
                                                    <option value="LG">LG</option>
                                                    <option value="PANASONIC">PANASONIC</option>
                                                    <option value="Midea">Midea</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label for="nama_ac" class="form-label">PRODUK SKU</label>
                                                <input type="text" class="form-control" id="nama_ac" name="nama_ac"
                                                    placeholder="Input nama / seri AC exp: AH-A5BEY">
                                            </div>
                                            <div class="col-12">
                                                <label for="model_ac" class="form-label">Model AC</label>
                                                <select class="form-select" aria-label="BrandAC" name="model_ac">
                                                    <option selected>Pilih</option>
                                                    <option value="Split Wall">Split Wall</option>
                                                    <option value="Cassette">Cassette</option>
                                                    <option value="Central">Central</option>
                                                    <option value="Standing Floor">Standing Floor</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label for="daya_pk" class="form-label">Daya PK</label>
                                                <input type="text" class="form-control" name="pk" id="daya_pk"
                                                    placeholder="1, 1/2 PK">
                                            </div>
                                            <div class="col-12">
                                                <label for="jenis_freon" class="form-label">Tipe Refrigrant</label>
                                                <input type="text" class="form-control" name="tipe_freon"
                                                    id="jenis_freon" placeholder="R-32, R-34">
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="is_inverter">Is Inverter ?</label>
                                                    <div class="form-check">
                                                        {!! Form::radio('is_inverter', 'yes', null, [
                                                            'id' => 'yes',
                                                            'class' => 'form-check-input',
                                                        ]) !!}
                                                        {!! Form::label('yes', 'Yes', ['class' => 'form-check-label']) !!}
                                                    </div>
                                                    <div class="form-check">
                                                        {!! Form::radio('is_inverter', 'no', null, [
                                                            'id' => 'no',
                                                            'class' => 'form-check-input',
                                                        ]) !!}
                                                        {!! Form::label('no', 'No', ['class' => 'form-check-label']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 pilih_ac">
                                        <label for="BrandAC" class="form-label">Pilih Brand AC</label>
                                        <select class="form-select select2" aria-label="BrandAC" name="ac">
                                            <option value="" selected>Pilih</option>
                                            @foreach ($ac as $key => $value)
                                                <option value="{{ $value->id }}">
                                                    {{ "$value->brand - $value->ac_name ( $value->model ) " }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="qr" class="form-label">Pilih Kode Qr</label>
                                        <select class="form-select select2" aria-label="qr" name="qr_id" required>
                                            <option value="" selected>Pilih</option>
                                            @foreach ($qr_list as $key => $value)
                                                <option value="{{ $value->id }}">
                                                    {{ $value->qr_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="nama_ac" class="form-label">Lokasi AC</label>
                                        <input type="text" class="form-control" id="room_name"
                                            placeholder="Ruang Tamu">
                                    </div>
                                    <div class="col-12">
                                        {{-- <button type="submit" class="btn btn-dark-blue w-100 p-2 fs-5">Submit</button> --}}
                                        <button type="submit" class="btn btn-blue w-100">
                                            Tambah AC
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- <div class="card card-homepage mb-5">

                        <div class="card-body">
                            <div class="row g-3">
                                @foreach ($ac as )

                                @endforeach
                            </div>
                        </div>
                    </div> --}}
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
