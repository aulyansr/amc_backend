<div class="row g-3">
    <div class="col-lg-6 col-12">
        {{ Form::label('address_name', 'Nama Alamat', ['class' => 'form-label']) }}
        {{ Form::text('address_name', null, ['class' => 'form-control', 'placeholder' => 'Ex : ZIPKOS Tanjung Duren']) }}
    </div>
    <div class="col-lg-6 col-12">
        {{ Form::label('province_code', 'Nama Provinsi', ['class' => 'form-label']) }}
        {!! Form::select('province_code', $provinsi, null, ['class' => 'form-control select2', 'id' => 'province_id']) !!}
    </div>
    <div class="col-lg-6 col-12 {{ isset($address) ? '' : 'd-none' }}" id="form-kota">
        @if (isset($address))
            @include('region.list_kota')
        @endif
    </div>
    <div class="col-lg-6 col-12 {{ isset($address) ? '' : 'd-none' }}" id="form-kecamatan">
        @if (isset($address))
            @include('region.list_kecamatan')
        @endif
    </div>
    <div class="col-lg-6 col-12 {{ isset($address) ? '' : 'd-none' }}" id="form-kelurahan">
        @if (isset($address))
            @include('region.list_kelurahan')
        @endif
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
        {{ Form::label('latitude', 'Latitude', ['class' => 'form-label']) }}
        {{ Form::text('latitude', null, ['class' => 'form-control']) }}
    </div>
    <div class="col-lg-6 col-12">
        {{ Form::label('longitude', 'Longitude', ['class' => 'form-label']) }}
        {{ Form::text('longitude', null, ['class' => 'form-control']) }}
    </div>
    <div class="col-lg-6 col-12">
        {{ Form::label('jumlah_ac', 'Jumlah AC dialamat ini', ['class' => 'form-label']) }}
        {{ Form::text('jumlah_ac', null, ['class' => 'form-control number']) }}
    </div>
    <div class="col-lg-6 col-12">
        {{ Form::label('address_type', 'Tipe Bangunan di Alamat ini', ['class' => 'form-label']) }}
        {{ Form::text('address_type', null, ['class' => 'form-control', 'placeholder' => 'Ex : Rumah, Kantor']) }}
    </div>
    @if ($customer->type == '1')
        <div class="col-lg-6 col-12">
            {{ Form::label('time_open', 'Jam Buka', ['class' => 'form-label']) }}
            {{ Form::text('time_open', null, ['class' => 'form-control time-picker']) }}
        </div>
        <div class="col-lg-6 col-12">
            {{ Form::label('time_close', 'Jam Tutup', ['class' => 'form-label']) }}
            {{ Form::text('time_close', null, ['class' => 'form-control time-picker']) }}
        </div>
    @endif
    @if ($customer->type == '1')
        <div class="col-lg-6 col-12">
            {{ Form::label('next_service', 'Next Service Order otomatis', ['class' => 'form-label']) }}
            <div class="input-group">
                {{ Form::text('next_service', null, ['class' => 'form-control number']) }}
                <div class="input-group-text">Hari</div>
            </div>
        </div>
    @endif
    <div class="col-12">
        <div class="row">
            <div class="col-lg-6 col-12 text-lg-start text-center">
                <a href="{{ route('customers.show', $master_customer_id) }}" class="btn btn-danger"><i
                        class="ri-arrow-left-line pe-2"></i> Back</a>
            </div>
            <div class="col-lg-6 col-12 text-lg-end text-center">
                <button type="submit" class="btn btn-primary"><i class="ri-save-line pe-2"></i>
                    {{ isset($address) ? 'Update' : 'Create' }}</button>
            </div>
        </div>
    </div>

</div>
@section('script')
    <script>
        $(document).ready(function() {
            @if (!isset($address))
                $('#province_id').val(null).trigger('change');
            @endif
            $('body').on('change', '#province_id', function() {
                let id = $(this).val();
                let route = "{{ route('get.kota') }}";
                if (id) {
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
                                allowClear: true,
                            });
                            $('#form-kota').removeClass('d-none');
                            $('#city_id').val(null).trigger('change');
                            $('#form-kecamatan').addClass('d-none');
                            $('#form-kelurahan').addClass('d-none');
                        }
                    })
                }
            })
            $('body').on('change', '#city_id', function() {
                let id = $(this).val();
                let route = "{{ route('get.kecamatan') }}";
                if (id) {
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
                                allowClear: true,
                            });
                            $('#kecamatan_id').val(null).trigger('change');
                            $('#form-kecamatan').removeClass('d-none');
                            $('#form-kelurahan').addClass('d-none');
                        }
                    })
                }
            })
            $('body').on('change', '#kecamatan_id', function() {
                let id = $(this).val();
                let route = "{{ route('get.kelurahan') }}";
                if (id) {
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
                                allowClear: true,
                            });
                            $('#kelurahan_id').val(null).trigger('change');
                            $('#form-kelurahan').removeClass('d-none');
                        }
                    })
                }
            })
        })
    </script>
@endsection
