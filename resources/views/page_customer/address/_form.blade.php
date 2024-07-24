<div class="row g-3">
    <div class="col-lg-6 col-12">
        {{ Form::label('address_name', 'Nama Alamat', ['class' => 'form-label']) }}
        {{ Form::text('address_name', null, ['class' => 'form-control', 'placeholder' => 'Ex : Rumah']) }}
    </div>
    <div class="col-lg-6 col-12">
        {{ Form::label('province_code', 'Nama Provinsi', ['class' => 'form-label']) }}
        {!! Form::select('province_code', $provinsi, null, [
            'class' => 'form-control select2-province',
            'id' => 'province_id',
        ]) !!}
    </div>
    <div class="col-lg-6 col-12">
        <div id="form-kota">
            @if (isset($address))
                @include('region.list_kota')
            @endif
        </div>
        <div id="kota-info" class="{{ isset($address) ? 'd-none' : '' }}">
            <label for="city_id" class="form-label">Pilih Kota</label>
            <p class="form-control">Silahkan Pilih Provinsi Terlebih Dahulu </p>
        </div>
        <div id="kota-loading" class="d-none">
            <label for="city_id" class="form-label">Pilih Kota</label> <br>
            <div id="kota-spinner" class="spinner-border text-primary" role="status">
                <span class="sr-only">Memuat data...</span>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div id="form-kecamatan">
            @if (isset($address))
                @include('region.list_kecamatan')
            @endif
        </div>
        <div id="kecamatan-info" class="{{ isset($address) ? 'd-none' : '' }}">
            <label for="kecamatan_id" class="form-label">Pilih Kecamatan</label>
            <p class="form-control">Silahkan Pilih Kota Terlebih Dahulu </p>
        </div>
        <div id="kecamatan-loading" class="d-none">
            <label for="kecamatan_id" class="form-label">Pilih Kecamatan</label> <br>
            <div id="kota-spinner" class="spinner-border text-primary" role="status">
                <span class="sr-only">Memuat data...</span>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div id="form-kelurahan">
            @if (isset($address))
                @include('region.list_kelurahan')
            @endif
        </div>
        <div id="kelurahan-info" class="{{ isset($address) ? 'd-none' : '' }}">
            <label for="kelurahan_id" class="form-label">Pilih Kelurahan</label>
            <p class="form-control">Silahkan Pilih Kecamatan Terlebih Dahulu </p>
        </div>
        <div id="kelurahan-loading" class="d-none">
            <label for="kelurahan_id" class="form-label">Pilih Kelurahan</label> <br>
            <div id="kota-spinner" class="spinner-border text-primary" role="status">
                <span class="sr-only">Memuat data...</span>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        {{ Form::label('postal_code', 'Kode Pos', ['class' => 'form-label']) }}
        {{ Form::text('postal_code', null, ['class' => 'form-control', 'placeholder' => '38222', 'pattern' => '[0-9]+', 'title' => 'Kode Pos Hanya Boleh angka tanpa spasi']) }}
    </div>
    <div class="col-lg-6 col-12">
        {{ Form::label('address_detail', 'Alamat Lengkap', ['class' => 'form-label']) }}
        {{ Form::textarea('address_detail', null, ['class' => 'form-control', 'placeholder' => 'Jalan Daan Mogot']) }}
    </div>
    <div class="col-lg-6 col-12">
        {{ Form::label('landmark', 'Blok / Penanda', ['class' => 'form-label']) }}
        {{ Form::text('landmark', null, ['class' => 'form-control', 'placeholder' => 'Dekat Alfamart']) }}
    </div>
    <div class="col-lg-6 col-12">
        {{ Form::label('jumlah_ac', 'Jumlah AC dialamat ini', ['class' => 'form-label']) }}
        {{ Form::text('jumlah_ac', null, ['class' => 'form-control number']) }}
    </div>
    <div class="col-lg-6 col-12">
        {{ Form::label('address_type', 'Tipe Bangunan di Alamat ini', ['class' => 'form-label']) }}
        {{ Form::text('address_type', null, ['class' => 'form-control', 'placeholder' => 'Ex : Rumah, Kantor']) }}
    </div>
    @if (Auth::guard('customer')->user()->type == '1')
        <div class="col-lg-6 col-12">
            {{ Form::label('time_open', 'Jam Buka', ['class' => 'form-label']) }}
            {{ Form::text('time_open', null, ['class' => 'form-control time-picker']) }}
        </div>
        <div class="col-lg-6 col-12">
            {{ Form::label('time_close', 'Jam Tutup', ['class' => 'form-label']) }}
            {{ Form::text('time_close', null, ['class' => 'form-control time-picker']) }}
        </div>
    @endif
    <div class="col-12">
        <div class="row g-3">
            <div class="col-auto">
                <a href="{{ route('customer.alamat.index') }}" class="btn btn-danger px-3 py-2 btn-sm"><i
                        class="fas fa-arrow-left pe-2"></i> Back</a>
            </div>
            <div class="col-auto ms-auto">
                <button type="submit" id="address_submit" class="btn btn-primary btn-sm px-3 py-2">
                    <i class="fas fa-save pe-2"></i> {{ isset($address) ? 'Update' : 'Create' }}</button>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script>
        $(document).ready(function() {
            @if (!isset($address))
                $('#province_id').val(null).trigger('change');
            @endif
            $('.select2-province').select2({
                placeholder: 'Silahkan Dipilih',
                theme: 'bootstrap-5',
            });
            $(document).on('change', '#province_id', function() {
                let id = $(this).val();
                let route = "{{ route('get.kota') }}";
                if (id) {
                    $('#kota-loading, #kecamatan-info, #kelurahan-info').removeClass('d-none');
                    $('#kota-info, #form-kota, #form-kecamatan, #form-kelurahan').addClass('d-none');
                    $('#kecamatan_id').empty().trigger('change');
                    $('#kelurahan_id').empty().trigger('change');
                    $.ajax({
                        type: 'get',
                        url: route,
                        data: {
                            province_id: id
                        },
                        success: function(data) {
                            $('#form-kota').html(data);
                            $('#city_id').select2({
                                placeholder: 'Silahkan Dipilih',
                                theme: 'bootstrap-5',

                            });
                            $('#kota-info, #kota-loading').addClass('d-none');
                            $('#form-kota').removeClass('d-none');
                            $('#city_id').val(null).trigger('change');
                        }
                    })
                } else {
                    $('#form-kota').addClass('d-none');
                    $('#kota-info').removeClass('d-none');
                }
            })
            $('body').on('change', '#city_id', function() {
                let id = $(this).val();
                let route = "{{ route('get.kecamatan') }}";
                if (id) {
                    $('#kecamatan-loading, #kelurahan-info').removeClass('d-none');
                    $('#kecamatan-info,#form-kecamatan, #form-kelurahan').addClass('d-none');
                    $('#kelurahan_id').empty().trigger('change');
                    $.ajax({
                        type: 'get',
                        url: route,
                        data: {
                            city_id: id
                        },
                        success: function(data) {
                            $('#form-kecamatan').html(data);
                            $('#kecamatan_id').select2({
                                placeholder: 'Silahkan Dipilih',
                                theme: 'bootstrap-5',

                            });
                            $('#kecamatan-info, #kecamatan-loading').addClass('d-none');
                            $('#form-kecamatan').removeClass('d-none');
                            $('#kecamatan_id').val(null).trigger('change');
                        }
                    })
                } else {
                    $('#form-kecamatan').addClass('d-none');
                    $('#kecamatan-info').removeClass('d-none');
                }
            })
            $('body').on('change', '#kecamatan_id', function() {
                let id = $(this).val();
                let route = "{{ route('get.kelurahan') }}";
                if (id) {
                    $('#kelurahan-loading').removeClass('d-none');
                    $('#kelurahan-info, #form-kelurahan').addClass('d-none');
                    $.ajax({
                        type: 'get',
                        url: route,
                        data: {
                            kecamatan_id: id
                        },
                        success: function(data) {
                            $('#form-kelurahan').html(data);
                            $('#kelurahan_id').select2({
                                placeholder: 'Silahkan Dipilih',
                                theme: 'bootstrap-5',

                            });
                            $('#kelurahan-info, #kelurahan-loading').addClass('d-none');
                            $('#form-kelurahan').removeClass('d-none');
                            $('#kelurahan_id').val(null).trigger('change');
                        }
                    })
                } else {
                    $('#form-kelurahan').addClass('d-none');
                    $('#kelurahan-info').removeClass('d-none');
                }
            })
        })
    </script>
@endsection
