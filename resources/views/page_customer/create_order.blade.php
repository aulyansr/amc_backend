    @extends('layouts.screen_customer')
    @section('css')
    @endsection
    @section('content')
        <div class="container">
            <div class="card rounded-5 border-0">
                <div class="card-body p-1 p-md-5">
                    <h1 class="fs-2 text-primary-blue"> Buat Order baru </h1>
                    <hr>
                    <div class="d-block">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong>Something went wrong.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    {{ Form::open(['route' => 'customer.store_order']) }}
                    <div class="row g-3 align-items-center">
                        <div class="col-12">
                            <input type="hidden" name="customer" id="customer"
                                value="{{ Auth::guard('customer')->user()->id }}">
                            <input type="hidden" name="main_address" id="main_address" value="{{ $main_address }}">
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    {{ Form::label('address_id', 'Alamat', ['class' => 'form-label label-required']) }}
                                </div>
                                <div class="col-auto ms-auto">
                                    <button type="button" class="btn btn-blue px-3 py-1" data-bs-toggle="modal"
                                        data-bs-target="#createadrress">
                                        Tambah Alamat
                                    </button>
                                </div>
                                <div class="col-12">
                                    <select name="master_address_id" id="address" class="form-select select2" required>
                                        @if ($main_address && !empty($main_address))
                                            <option value="{{ $main_address->id }}"
                                                data-lng="{{ $main_address->longitude }}"
                                                data-lat="{{ $main_address->latitude }}"
                                                data-address="{{ $main_address->completedAddress }}">
                                                {{ $main_address->address_name }}
                                            </option>
                                        @endif
                                    </select>
                                    <p class="form-label"><b>Detail Alamat :</b> <span id="alamat_lengkap"
                                            class="text-black">{{ $main_address?->completedAddress }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            {{ Form::label('booked_date', 'Tanggal dan Jam Pengerjaan', ['class' => 'form-label label-required']) }}
                            {{ Form::text('booked_date', null, ['class' => 'form-control datetime-picker', 'required' => true]) }}
                        </div>
                        <div class="col-12">
                            <div class="row g-3 align-items-center">
                                <div class="col lg-6">
                                    <h4 class="text-primary-blue label-required">Layanan</h4>
                                </div>
                                <div class="col-lg-6 text-lg-end">
                                    <button type="button" class="btn btn-blue px-3 py-2" id="add_service"> + Tambah
                                        Layanan</button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama Service</th>
                                                <th class="d-none">Harga</th>
                                                <th>Jumlah</th>
                                                <th class="d-none">Sub Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="service_body">
                                            @if (isset($order))
                                                @php
                                                    $no = 0;
                                                @endphp
                                                @foreach ($order->serviceCounts as $service)
                                                    <tr class="service_row">
                                                        <td>
                                                            <select name="services[{{ $no }}}][service_id]"
                                                                class="form-control select_service_manual select2" required
                                                                id="service_id{{ $no }}}">
                                                                <option value="">Pilih Service</option>
                                                                @foreach ($services as $key => $value)
                                                                    <option value="{{ $value->id }}"
                                                                        {{ $value->id == $service['service_id'] ? 'selected' : '' }}
                                                                        data-price="{{ $value->price }}">
                                                                        {{ $value->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <div class="input-group-text">Rp</div>
                                                                <input type="text"
                                                                    name="services[{{ $no }}}][harga]"
                                                                    value="{{ thousand_separator($service['price']) }}"
                                                                    class="form-control service_price" readonly>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="services[{{ $no }}}][quantity]"
                                                                value="{{ thousand_separator($service['count']) }}"
                                                                class="form-control client-number service_quantity">
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <div class="input-group-text">Rp</div>
                                                                <input type="text"
                                                                    name="services[{{ $no++ }}}][subtotal]"
                                                                    value="{{ thousand_separator($service['count'] * $service['price']) }}"
                                                                    class="form-control service_subtotal" readonly>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm btn_remove_service p-1"><i
                                                                    class="mdi mdi-trash-can"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center">Total Biaya Service</th>
                                                <th id="total_ac_col" class="d-none">
                                                    <div id="total_ac_text">
                                                        {{ isset($order) ? thousand_separator($order->total_ac) : 0 }}
                                                    </div>
                                                    <input type="hidden" name="total_ac" id="total_ac_input"
                                                        value="{{ isset($order) ? $order->total_ac : 0 }}">
                                                </th>
                                                <th id="sub_total_service_col" colspan="2">
                                                    <div id="sub_total_service_text">
                                                        {{ isset($order) ? thousand_rupiah($order->total_base_price) : 0 }}
                                                    </div>
                                                    <input type="hidden" name="sub_total_service"
                                                        id="sub_total_service_input"
                                                        value="{{ isset($order) ? $order->total_base_price : 0 }}">
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class=" col-12">
                            {{ Form::label('reason', 'Kendala', ['class' => 'form-label label-required']) }}
                            {{ Form::textarea('reason', null, ['class' => 'form-control', 'required' => true]) }}
                        </div>


                        <div class="col-lg-12 col-12">
                            {{ Form::label('grand_total', 'Grand total', ['class' => 'form-label label-required']) }}
                            <div class="input-group">
                                <div class="input-group-text">Rp.</div>
                                {{ Form::text('grand_total', null, ['class' => 'form-control number', 'id' => 'grand_total', 'readonly', 'required' => true]) }}
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row g-3">

                                <div class="col-12 col-md-6  text-lg-end text-center">
                                    <button type="submit" class="btn btn-blue px-5 py-2"><i class="ri-save-line pe-2"></i>
                                        Buat Pesanan</button>
                                </div>
                                <div class="col-12 col-md-6 text-lg-start text-center">
                                    <a href="{{ route('customer.index') }}" class="btn btn-outline-danger px-5 py-2"><i
                                            class="ri-arrow-left-line pe-2"></i> Batalkan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="modal fade modal-lg" id="createadrress" tabindex="-1" aria-labelledby="createadrressLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createadrressLabel">Buat Alamat Baru</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('customer.store_address') }}" method="post">
                        <div class="modal-body">
                            @csrf
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
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary px-3 py-2"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary px-3 py-2"><i
                                        class="ri-save-line pe-2"></i>
                                    {{ isset($address) ? 'Update' : 'Create' }}</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
    @section('js')
        <script>
            var no = 0;
            $(document).ready(function() {
                address();
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
            $('#add_service').click(function(e) {
                e.preventDefault();
                var html = `
                <tr class="service_row">
                    <td class="w-100">
                        <select name="services[${no}][service_id]" class="form-control select_service" required id="service_id${no}">
                            <option value="">Pilih Service</option>
                        </select>
                    </td>
                    <td  class="d-none">
                        <div class="input-group">
                            <div class="input-group-text">Rp</div>
                            <input type="text" name="services[${no}][harga]" class="form-control service_price" readonly>
                        </div>
                    </td>
                    <td>
                        <input type="text" name="services[${no}][quantity]" value="1" class="form-control number service_quantity">
                    </td>
                    <td class="d-none">
                        <div class="input-group">
                            <div class="input-group-text">Rp</div>
                            <input type="text" name="services[${no}][subtotal]" class="form-control service_subtotal" readonly>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm btn_remove_service p-1"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `;

                $('#service_body').append(html);
                service(no);
                no++;
            });
            $(document).on('click', '.btn_remove_service', function() {
                $(this).parents('.service_row').remove();
                sub_total_all_service();
            });

            function sub_total_per_service(selected) {
                let price = $(selected).parents('.service_row').find('.service_price').val().replace(/\./g, '').replace(
                    /\,/g,
                    '.') || 0;
                let quantity = $(selected).parents('.service_row').find('.service_quantity').val().replace(/\./g, '')
                    .replace(
                        /\,/g, '.') || 0;
                let sub_total = parseFloat(price) * parseFloat(quantity);
                $(selected).parents('.service_row').find('.service_subtotal').val(sub_total ? getThousandSeparator(
                        sub_total) :
                    0);
                sub_total_all_service();
            }

            function sub_total_all_service() {
                let sum = 0;
                let total_ac = 0;
                $('.service_quantity').each(function() {
                    total_ac += parseFloat($(this).val().replace(/\./g, '').replace(/\,/g, '.') || 0);
                })
                $('.service_subtotal').each(function() {
                    sum += parseFloat($(this).val().replace(/\./g, '').replace(/\,/g, '.') || 0);
                });
                $('#total_ac_input').val(total_ac || 0);
                $('#total_ac_text').html("<b>" + getThousandSeparator(total_ac) + "</b>");
                $('#sub_total_service_input').val(sum || 0);
                $('#sub_total_service_text').html("<b>Rp " + getThousandSeparator(sum) + "</b>");
                grand_total();
            }

            function grand_total() {
                let sub_total = $('#sub_total_service_input').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
                $('#grand_total').val(sub_total ? getThousandSeparator(sub_total) : 0);
            }

            function service(no) {
                $(document).find(`#service_id${no}`).select2({
                    placeholder: "Pilih Service",
                    theme: 'bootstrap-5',
                    ajax: {
                        url: "{{ route('customer.ajax.get_service') }}",
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            let customer = $('#customer').val(); // Get the selected customer value
                            return {
                                _token: "{{ csrf_token() }}",
                                search: params.term, // search term
                                customer_id: customer
                            };
                        },
                        processResults: function(response) {
                            response = response.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.text,
                                    price: item.price,
                                };
                            });
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }

                });
            }

            function address() {
                let customer_id = $('#customer').val() ? $('#customer').val() : 0;
                let main_address_id = $('#main_address').val() ? $('#main_address').val() : 0;
                if (customer_id) {
                    $("#address").select2({
                        placeholder: "Pilih Alamat",
                        theme: 'bootstrap-5',

                        ajax: {
                            url: "{{ route('customer.ajax.get_address_by_customer') }}",
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
                                response = response.map(function(item) {
                                    return {
                                        id: item.id,
                                        text: item.text,
                                        address: item.address,
                                        lng: item.lng,
                                        lat: item.lat,
                                    };
                                });
                                return {
                                    results: response
                                };

                            },
                            cache: true

                        }
                    });
                    get_distance();
                }
            }
            $(document).on('change', '.select_service', function() {
                var data = $(this).select2('data')[0];
                var price = data.price;
                $(this).parents('.service_row').find('.service_price').val(price ? getThousandSeparator(price) : 0);
                sub_total_per_service(this);
            })
            $(document).on('keyup', '.service_quantity', function() {
                sub_total_per_service(this);
            })

            $('#createadrress form').submit(function(e) {
                e.preventDefault(); // Prevent the default form submission

                var formData = $(this).serialize(); // Serialize the form data
                var url = $(this).attr('action'); // Get the form's action attribute value

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,

                    success: function(response) {
                        // Handle the successful response
                        // Display success toast using SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Alamat Berhasil Dibuat!',
                        }).then(function() {
                            // Close the modal
                            $('#createadrress').modal('hide');

                            // Reset the form fields
                            $('#createadrress form')[0].reset();
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        console.error(error);
                    }
                });
            });
            $('#address').change(function(e) {
                e.preventDefault();
                let data = $(this).select2('data')[0];
                let alamat_lengkap = data.address;
                $('#alamat_lengkap').html(alamat_lengkap);
                get_distance();
            });

            function get_distance() {
                let data = $('#address').find(':selected').data();
                let lat = data.lat;
                let lng = data.lng;
                if (lat && lng) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('customer.ajax.get_distance') }}",
                        data: {
                            lat: lat,
                            lng: lng,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                        }
                    });
                }
            }
        </script>
    @endsection
