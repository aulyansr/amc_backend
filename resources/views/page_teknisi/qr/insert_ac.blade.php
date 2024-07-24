@extends('layouts.screen_technician')
@section('css')
@endsection
@section('content')
    <section class="content">
        <form action="{{ route('technician.store_detail_ac', $qr->url_unique) }}" method="post">
            @csrf
            <div class="container">
                <h1 class="fw-100 fs-4 text-primary-blue mb-3">Tambah Detail AC</h1>
                <p class="text-primary-blue ">Detail Customer</p>
                <div class="card card-homepage mb-5">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                {{ Form::label('master_customer_id', 'Nama Customer', ['class' => 'form-label']) }}
                                {{ Form::select('master_customer_id', ['' => 'silahkan dipilih'], null, ['class' => 'form-select form-control col-12', 'id' => 'customer', 'required']) }}
                            </div>
                            <div class="col-12">
                                {{ Form::label('address_id', 'Alamat', ['class' => 'form-label']) }}
                                {{ Form::select('master_address_id', ['' => 'Pilih Customer Terlebih dahulu'], null, ['class' => 'form-select', 'id' => 'address', 'required']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-primary-blue ">Detail AC</p>
                <div class="card card-homepage mb-5">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 text-center">
                                <div class="btn-group" role="group" aria-label="Radio buttons">
                                    <input type="radio" class="btn-check ac_option" name="ac_option" id="option1"
                                        value="pilih_ac" autocomplete="off" checked>
                                    <label class="btn btn-outline-primary btn-sm" for="option1">Pilih AC</label>
                                    <input type="radio" class="btn-check ac_option" name="ac_option" id="option2"
                                        value="ac_baru" autocomplete="off">
                                    <label class="btn btn-outline-primary btn-sm" for="option2">AC baru</label>
                                </div>
                            </div>
                            <div class="ac_baru col-12 d-none">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="BrandAC" class="form-label">Pilih Brand AC</label>
                                        <select class="form-select" id="BrandAC" aria-label="BrandAC" name="brandAC">
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
                                        <input type="text" class="form-control" name="tipe_freon" id="jenis_freon"
                                            placeholder="R-32, R-34">
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
                                <select class="form-select" aria-label="BrandAC" name="ac">
                                    <option value="" selected>Pilih</option>
                                    @foreach ($ac as $key => $value)
                                        <option value="{{ $value->id }}">
                                            {{ "$value->brand - $value->ac_name ( $value->model ) " }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="nama_ac" class="form-label">Lokasi AC</label>
                                <input type="text" class="form-control" id="room_name" placeholder="Ruang Tamu">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark-blue w-100">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
@section('js')
    <script>
        customer();

        function customer() {
            $("#customer").select2({
                placeholder: "Pilih Customer",
                theme: 'bootstrap-5',
                allowClear: true,
                ajax: {
                    url: "{{ route('technician.ajax.get_customer') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            _token: "{{ csrf_token() }}",
                            search: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }

            });
            address();
        }

        function address() {
            let customer_id = $('#customer').find(':selected').val() ? $('#customer').find(':selected').val() : 0;
            $('#address').val('').change();
            if (customer_id) {
                $("#address").select2({
                    placeholder: "Pilih Alamat",
                    theme: 'bootstrap-5',
                    allowClear: true,
                    width: 'resolve',
                    ajax: {
                        url: "{{ route('technician.ajax.get_address_by_customer') }}",
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                _token: "{{ csrf_token() }}",
                                search: params.term, // search term
                                customer_id: customer_id // customer_id from an input field with the ID "customer_id"
                            };
                        },
                        processResults: function(response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }
                });
            }
        }
        $('#customer').change(function(e) {
            e.preventDefault();
            address();
        });
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
