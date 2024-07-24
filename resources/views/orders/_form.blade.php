<div class="col-12">
    {{ Form::label('ref_no', 'Ref No', ['class' => 'form-label']) }}
    {{ Form::text('ref_no', null, ['class' => 'form-control']) }}
</div>
<div class="col-lg-6 col-12">
    {{ Form::label('booked_date', 'Tanggal dan Jam Pengerjaan', ['class' => 'form-label']) }}
    {{ Form::text('booked_date', isset($order) ? date('d-m-Y H:i', strtotime($order->booked_date)) : null, ['class' => 'form-control datetime-picker']) }}
</div>
<div class="col-lg-6 col-12">
    {{ Form::label('branch_id', 'Cabang AMC', ['class' => 'form-label']) }}
    {{ Form::select('branch_id', ['' => 'silahkan dipilih'] + $branchs->toArray(), null, ['class' => 'select2 form-control']) }}
</div>
<div class="col-lg-6 col-12">
    {{ Form::label('master_customer_id', 'Nama Customer', ['class' => 'form-label']) }}
    {{ Form::select('master_customer_id', isset($order) ? $customer : ['' => 'silahkan dipilih'], null, ['class' => 'form-control select2', 'id' => 'customer']) }}
</div>

<div class="col-lg-6 col-12 b2b2c d-none">
    {{ Form::label('customer_b2b2c_id', 'Nama Customer B2B2C', ['class' => 'form-label']) }}
    {{ Form::select('customer_b2b2c_id', $b2b2c, null, ['class' => 'form-control select2', 'id' => 'customer_b2b2c']) }}
</div>

<div class="col-lg-6 col-12">
    {{ Form::label('address_id', 'Alamat', ['class' => 'form-label']) }}
    {{ Form::select('master_address_id', isset($order) ? $address : ['' => 'Select Customer First'], null, ['class' => 'form-control select2', 'id' => 'address']) }}
</div>

<div class="col-lg-6 col-12 d-none">
    {{ Form::label('subscription', 'Paket', ['class' => 'form-label']) }}
    {{ Form::select('subscription', isset($order) ? $subscription : ['' => 'Select subscription'], null, ['class' => 'form-control select2', 'id' => 'subscription']) }}
</div>
<div class="col-lg-6 col-12">
    {{ Form::label('service_group', 'Jenis Permintaan', ['class' => 'form-label']) }}
    {{ Form::select('service_group', isset($order) ? $group_service : ['' => 'Select Group Service'], null, ['class' => 'form-control select2', 'id' => 'service_group']) }}
</div>
<div class="col-lg-6 col-12 is_price_warranty_col">
    {{ Form::label('is_price_warranty', 'Warranty', ['class' => 'form-label']) }}
    <div class="form-check">
        <label class="form-check-label">
            {{ Form::radio('is_price_warranty', 'yes', false, ['class' => 'form-check-input', 'id' => 'is_price_warranty_yes']) }}
            Ya
        </label>
    </div>
    <div class="form-check">
        <label class="form-check-label">
            {{ Form::radio('is_price_warranty', 'no', true, ['class' => 'form-check-input', 'id' => 'is_price_warranty_no']) }}
            Tidak
        </label>
    </div>
</div>
<div class="col-lg-6 col-12">
    <div class="form-group">
        <label for="payment_type">Tipe Pembayaran</label>
        <select name="payment_type" id="payment_type" class="form-control" required>
            <option value="">Pilih Tipe Pembayaran</option>
            <option value="cash">Cash</option>
            <option value="transfer">Transfer</option>
            <option value="Term Of Payment">Term Of Payment
            </option>
        </select>
    </div>
</div>
<div class="col-lg-6 col-12 d-none" id="payment_duedate_tab">
    <div class="form-group">
        <label for="payment_duedate">Tanggal Jatuh Tempo</label>
        {{ Form::text('payment_duedate', null, ['class' => 'form-control one-datepicker']) }}
    </div>
</div>
<div class="col-lg-6 col-12 d-none" id="payment_detail_tab">
    <div class="form-group">
        <label for="payment_detail">Detail Pembayaran</label>
        {{ Form::textarea('payment_detail', null, ['class' => 'form-control']) }}
    </div>
</div>
<div class="col-lg-6 col-12" id="bukti_pembayaran_tab">
    <div class="form-group">
        <label for="bukti_pembayaran">Bukti Pembayaran</label>
        <input type="file" name="bukti_pembayaran" class="form-control">
    </div>
</div>
<div class="col-12">
    <div class="row g-3">
        <div class="col lg-6">
            <h4>Service</h4>
        </div>
        <div class="col-lg-6 text-lg-end">
            <button class="btn btn-primary btn-sm" id="add_service"><i class="mdi mdi-basket-plus pe-3"></i>Tambah
                Service</button>
        </div>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th width="20%">Nama Service</th>
                        <th width="15%">Harga</th>
                        <th width="10%">Quantity AC</th>
                        <th width="20%">Total Harga</th>
                        <th width="15%">Discount AC</th>
                        <th width="20%">Sub Total</th>
                        <th width="1%"></th>
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
                                    <select name="services[{{ $no }}][service_id]"
                                        class="form-control select_service_manual select2 {{ $service['service_name'] }}"
                                        required id="service_id{{ $no }}">
                                        <option value="">Pilih Service</option>
                                        @foreach ($services as $key => $value)
                                            <option value="{{ $value->id }}"
                                                {{ $value->id == $service['service_id'] ? 'selected' : '' }}
                                                data-price="{{ $value->price }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="text" name="services[{{ $no }}][harga]"
                                            value="{{ thousand_separator($service['price']) }}"
                                            class="form-control service_price" readonly>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="services[{{ $no }}][quantity]"
                                        value="{{ thousand_separator($service['count']) }}"
                                        class="form-control client-number service_quantity">
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="text" name="services[{{ $no }}][subtotal]"
                                            value="{{ thousand_separator($service['count'] * $service['price']) }}"
                                            class="form-control service_total_harga" readonly>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="text" name="services[{{ $no }}][discount]"
                                            value="{{ thousand_separator($service['discount']) }}"
                                            class="form-control client-number service_discount"
                                            data-max_discount="{{ ($service['max_discount'] * $service['price']) / 100 }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="text" name="services[{{ $no++ }}][subtotal]"
                                            value="{{ thousand_separator((int) $service['count'] * (int) $service['price'] - (int) $service['discount']) }}"
                                            class="form-control service_subtotal" readonly>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm btn_remove_service"><i
                                            class="mdi mdi-trash-can"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    <input type="hidden" name="change_services" value="false" class="select_service">
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center" colspan="2">Sub Total Service</th>
                        <th id="total_ac_col">
                            <div id="total_ac_text">{{ isset($order) ? thousand_separator($order->total_ac) : 0 }}
                            </div>
                            <input type="hidden" name="total_ac" id="total_ac_input"
                                value="{{ isset($order) ? $order->total_ac : 0 }}">
                        </th>
                        <th id="total_harga_service_col">
                            <div id="total_harga_service_text">
                                {{ isset($order) ? thousand_rupiah($order->total_base_price) : 0 }}</div>
                            <input type="hidden" name="total_harga_service" id="total_harga_service_input"
                                value="{{ isset($order) ? $order->total_base_price : 0 }}">
                        </th>
                        <th id="diskon_service_col">
                            <div id="diskon_service_text">
                                {{ isset($order) ? thousand_rupiah($order->diskon) : 0 }}</div>
                            <input type="hidden" name="diskon_service" id="diskon_service_input"
                                value="{{ isset($order) ? $order->diskon : 0 }}">
                        </th>
                        <th id="sub_total_service_col" colspan="2">
                            <div id="sub_total_service_text">
                                {{ isset($order) ? thousand_rupiah($order->total_base_price) : 0 }}</div>
                            <input type="hidden" name="sub_total_service" id="sub_total_service_input"
                                value="{{ isset($order) ? $order->total_base_price : 0 }}">
                        </th>
                    </tr>
                    <tr>
                        <th colspan="6"></th>
                    </tr>
                    <tr>
                        <th colspan="4">Total Harga Service</th>
                        <th colspan="3" id="total_harga">
                            <?= isset($order) ? thousand_rupiah($order->total_base_price) : thousand_rupiah(0) ?></th>
                    </tr>
                    <tr>
                        <th colspan="3">Biaya Transport</th>
                        <th>
                            <div class="input-group">
                                {{ Form::text('location_range', $order->location_range ?? 0, ['class' => 'form-control number', 'id' => 'location_range', 'data-transport' => $setting?->value ?? 0]) }}
                                <div class="input-group-text">KM</div>
                            </div>
                        </th>
                        <th colspan="3">
                            <div class="input-group">
                                <div class="input-group-text">+ Rp.</div>
                                {{ Form::text('transport_fee', $order->transport_fee ?? 0, ['class' => 'form-control number', 'id' => 'transport_fee']) }}
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4">Diskon</th>
                        <th colspan="3">
                            <div class="input-group">
                                <div class="input-group-text">- Rp.</div>
                                {{ Form::text('diskon', $order->diskon ?? 0, ['class' => 'form-control number', 'id' => 'diskon', 'readonly']) }}
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4">Grand Total</th>
                        <th colspan="3">
                            <div class="input-group">
                                <div class="input-group-text">Rp.</div>
                                {{ Form::text('grand_total', null, ['class' => 'form-control number', 'id' => 'grand_total', 'readonly']) }}
                            </div>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-lg-6 col-12">
    {{ Form::label('reason', 'Kendala', ['class' => 'form-label']) }}
    {{ Form::textarea('reason', null, ['class' => 'form-control']) }}
</div>
<div class="col-lg-6 col-12">
    {{ Form::label('keterangan', 'Keterangan Lainnya', ['class' => 'form-label']) }}
    {{ Form::textarea('keterangan', null, ['class' => 'form-control']) }}
</div>
<div class="col-12">
    <div class="row g-3">
        <div class="col-lg-6">
            <h3>Tugaskan Team</h3>
        </div>
        <div class="col-lg-6 text-lg-end">
            <button class="btn btn-primary" id="add_team"><i class="mdi mdi-account-multiple-plus pe-3"></i>Tambah
                Team</button>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="row g-3" id="team_row">
        <div class="col-lg-6 col-12 team_form">
            <div class="form-group">
                <div class="row g-3 align-items-center">
                    <div class="col-6">
                        <label for="team_id0">Team</label>
                    </div>
                    <div class="col-6 text-end">
                        <button class="btn btn-danger btn-sm delete_team"><i class="mdi mdi-trash-can"></i></button>
                    </div>
                    <div class="col-12">
                        <select name="team_id[]" id="team_id0" class="form-control">
                            <option value=""></option>
                        </select>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="col-lg-6 col-12">
    {{ Form::label('location_range', 'Jarak lokasi customer', ['class' => 'form-label']) }}
    <div class="input-group">
        {{ Form::text('location_range', $order->location_range ?? 0, ['class' => 'form-control number', 'id' => 'location_range']) }}
        <div class="input-group-text">KM</div>
    </div>
</div> --}}
{{-- <div class="col-lg-6 col-12">
    {{ Form::label('transport_fee', 'Biaya Transportasi', ['class' => 'form-label']) }}
    <div class="input-group">
        <div class="input-group-text">Rp.</div>
        {{ Form::text('transport_fee', $order->transport_fee ?? 0, ['class' => 'form-control number', 'id' => 'transport_fee']) }}
    </div>
</div>
<div class="col-lg-6 col-12">
    {{ Form::label('sub_total', 'Sub Total Service +  Transport Fee', ['class' => 'form-label']) }}
    <div class="input-group">
        <div class="input-group-text">Rp.</div>
        {{ Form::text('sub_total', null, ['class' => 'form-control number', 'id' => 'sub_total', 'readonly']) }}
    </div>
</div> --}}
{{-- <div class="col-lg-6 col-12">
    {{ Form::label('diskon', 'Total Diskon', ['class' => 'form-label']) }}
    <div class="input-group">
        <div class="input-group-text">Rp.</div>
        {{ Form::text('diskon', $order->diskon ?? 0, ['class' => 'form-control number', 'id' => 'diskon', 'readonly']) }}
    </div>
</div> --}}
{{-- <div class="col-lg-6 col-12">
    {{ Form::label('grand_total', 'Grand_total', ['class' => 'form-label']) }}
    <div class="input-group">
        <div class="input-group-text">Rp.</div>
        {{ Form::text('grand_total', null, ['class' => 'form-control number', 'id' => 'grand_total', 'readonly']) }}
    </div>
</div> --}}
@section('script')
    <script>
        let no = {{ isset($order) ? $no : 0 }};
        @if (!isset($order))
            customer();
        @endif
        function customer() {
            $("#customer").select2({
                placeholder: "Pilih Customer",
                theme: 'bootstrap-5',
                allowClear: true,
                ajax: {
                    url: "{{ route('ajax.get_customer') }}",
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
                        response = response.map(function(item) {
                            return {
                                id: item.id,
                                text: item.text,
                                type: item.type,
                            };
                        });
                        return {
                            results: response
                        };
                    },
                    cache: true
                }

            });
            subscription();
            address();

        }

        function b2b2c(type, id) {
            console.log("b2b2c " + type, id);
            if (type == 2) {
                $("#customer_b2b2c").val('').change();
                $(".b2b2c").removeClass('d-none');

                $("#customer_b2b2c").select2({
                    placeholder: "Pilih Customer",
                    theme: 'bootstrap-5',
                    allowClear: true,
                    ajax: {
                        url: "{{ route('ajax.get_customer_b2b2c') }}",
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                _token: "{{ csrf_token() }}",
                                search: params.term, // search term
                                customer_id: id // search term
                            };
                        },
                        processResults: function(response) {
                            response = response.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.text,

                                };
                            });
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }

                });
            } else {
                $(".b2b2c").addClass('d-none');
            }
        }

        function address() {
            let customer_id = $('#customer').find(':selected').val() ? $('#customer').find(':selected').val() : 0;
            var data = $('#customer').select2('data')[0];
            var type = data.type;
            if (type == 2) {
                customer_id = $('#customer_b2b2c').find(':selected').val() ? $('#customer_b2b2c').find(':selected').val() :
                    0;
            }
            $('#address').val('').change();
            if (customer_id) {
                $("#address").select2({
                    placeholder: "Pilih Alamat",
                    theme: 'bootstrap-5',
                    allowClear: true,
                    ajax: {
                        url: "{{ route('ajax.get_address_by_customer') }}",
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
                                    type: item.type,
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
        }
        $('#address').change(function(e) {
            get_distance();
        });

        function get_distance() {
            let cabangId = $('#branch_id').find(':selected').val() ? $('#branch_id').find(':selected').val() : 0;
            let customerAddressId = $('#address').find(':selected').val() ? $('#address').find(':selected').val() : 0;
            console.log(cabangId, customerAddressId);
            $.ajax({
                url: "{{ route('ajax.get_count_distance') }}",
                type: 'GET',
                data: {
                    cabang_id: cabangId,
                    customer_address_id: customerAddressId
                },
                success: function(response) {
                    // Handle the response
                    $('#location_range').val(getThousandSeparator(response.distance));
                    $('#transport_fee').val(getThousandSeparator(response.price));
                    sub_total_plus_transport();
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.log(error);
                }
            });
        }

        function subscription() {
            let customer_id = $('#customer').find(':selected').val() ? $('#customer').find(':selected').val() : 0;
            console.log('test');
            $('#subscription').val('').change();
            if (customer_id) {
                $("#subscription").select2({
                    placeholder: "Pilih Subscription",
                    theme: 'bootstrap-5',
                    allowClear: true,
                    ajax: {
                        url: "{{ route('ajax.get_customer_subscription') }}",
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
        }

        function subscription() {
            $('#service_group').val('').change();
            $("#service_group").select2({
                placeholder: "Pilih Jenis Permintaan",
                theme: 'bootstrap-5',
                allowClear: true,
                ajax: {
                    url: "{{ route('ajax.get_service_group') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            _token: "{{ csrf_token() }}",
                            search: params.term, // search term
                        };
                    },
                    processResults: function(response) {
                        console.log(response);
                        response = response.map(function(item) {
                            return {
                                id: item.id,
                                text: item.text,
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

        function service(no) {
            $(document).find(`#service_id${no}`).select2({
                placeholder: "Pilih Service",
                theme: 'bootstrap-5',
                allowClear: true,
                ajax: {
                    url: "{{ route('ajax.get_service') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        let customer = $('#customer').val(); // Get the selected customer value
                        let subscription = $('#subscription').val(); // Get the selected customer value
                        let service_group = $('#service_group').val(); // Get the selected customer value
                        var data = $('#customer').select2('data')[0];
                        var type = data.type;
                        return {
                            _token: "{{ csrf_token() }}",
                            search: params.term, // search term
                            customer_id: customer,
                            subscription: subscription,
                            service_group: service_group,
                            type: type,
                        };
                    },
                    processResults: function(response) {
                        console.log(response);
                        response = response.map(function(item) {
                            return {
                                id: item.id,
                                text: item.text,
                                price: item.price,
                                max_discount: item.max_discount * item.price / 100,
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

        function add_spare_part(service_id) {
            $.ajax({
                type: "GET",
                url: "{{ route('ajax.get_service_spare_part') }}",
                data: {
                    service_id: service_id,
                },
                dataType: "JSON",
                success: function(response) {
                    console.log(response);
                    $.each(response, function(index, val) {
                        add_spare_part_as_service(val);
                    });
                }
            });
        }
        $('#customer').change(function(e) {
            e.preventDefault();
            var data = $(this).select2('data')[0];
            var type = data.type;
            var id = data.id;
            address();
            subscription();
            b2b2c(type, id);
        });
        $('#customer_b2b2c').change(function(e) {
            e.preventDefault();
            console.log($(this).select2('data')[0])
            address();

        });
        $('.select_service_manual').change(function(e) {
            e.preventDefault();
            console.log('test');
            $('.check_service').val('true');
        });
        $('#add_service').click(function(e) {
            e.preventDefault();
            var html = `
                <tr class="service_row">
                    <td>
                        <select name="services[${no}][service_id]" class="form-control select_service" required id="service_id${no}">
                            <option value="">Pilih Service</option>
                        </select>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-text">Rp</div>
                            <input type="text" name="services[${no}][harga]" class="form-control service_price" readonly>
                        </div>
                    </td>
                    <td>
                        <input type="text" name="services[${no}][quantity]" value="1" class="form-control client-number service_quantity">
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-text">Rp</div>
                            <input type="text" name="services[${no}][subtotal_before_discount]"
                                value="0"
                                class="form-control service_total_harga" readonly>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-text">Rp</div>
                            <input type="text" name="services[${no}][discount]"
                                value="0"
                                class="form-control client-number service_discount"
                                data-max_discount="0">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-text">Rp</div>
                            <input type="text" name="services[${no}][subtotal]" class="form-control service_subtotal" readonly>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm btn_remove_service"><i class="mdi mdi-trash-can"></i></button>
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
        $('.number').keyup(function(e) {
            if ($(this).attr('id') === 'transport_fee') {
                sub_total_plus_transport();
            } else if ($(this).attr('id') === 'diskon') {
                grand_total();
            }
        })
        $(document).on('change', '.select_service', function() {
            var data = $(this).select2('data')[0];
            var id = $(this).find(':selected').val();
            var service_id = $(this).parents('.service_row').find('.service_id').val();
            if (id) {
                add_spare_part(id);
            }
            var price = data.price;
            var max_discount = data.max_discount;
            $(this).parents('.service_row').find('.service_price').val(price ? getThousandSeparator(price) : 0);
            $(this).parents('.service_row').find('.service_discount').data('max_discount', max_discount);
            sub_total_per_service(this);
        })
        $(document).on('change', '.select_service_manual', function() {
            var data = $(this).find(':selected').data('price');
            var price = data;
            $(this).parents('.service_row').find('.service_price').val(price ? getThousandSeparator(price) : 0);
            sub_total_per_service(this);
        })
        $(document).on('keyup', '.service_quantity', function() {
            sub_total_per_service(this);
        })
        $(document).on('keyup', '.service_discount', function() {
            let max_discount = $(this).data('max_discount');
            let quantity = $(this).parents('.service_row').find('.service_quantity').val().replace(/\./g, '')
                .replace(
                    /\,/g,
                    '.'
                );
            let value = $(this).val().replace(/\./g, '').replace(/\,/g, '.') || 0;
            let total_max_discount = quantity * max_discount;
            if (total_max_discount && value < total_max_discount) {
                sub_total_all_discount();
                sub_total_per_service(this);
            } else {
                $(this).val(getThousandSeparator(total_max_discount));
                sub_total_all_discount();
                sub_total_per_service(this);
            }
        })
        $(document).on('keyup', '#location_range', function() {
            let range = $(this).val().replace(/\./g, '').replace(/\,/g, '.') || 0;
            let price = $(this).data('transport');
            let total_transport = Math.ceil(range) * price;
            $('#transport_fee').val(getThousandSeparator(total_transport));
            sub_total_plus_transport();
        })

        function sub_total_all_discount() {
            let sum = 0;
            $('.service_discount').each(function() {
                sum += parseFloat($(this).val().replace(/\./g, '').replace(/\,/g, '.') || 0);
            });
            $('#diskon').val(sum ? getThousandSeparator(sum) : 0);
        }

        function sub_total_per_service(selected) {
            let price = $(selected).parents('.service_row').find('.service_price').val().replace(/\./g, '').replace(/\,/g,
                '.') || 0;
            let quantity = $(selected).parents('.service_row').find('.service_quantity').val().replace(/\./g, '').replace(
                /\,/g, '.') || 0;
            let discount = $(selected).parents('.service_row').find('.service_discount').val().replace(/\./g, '').replace(
                /\,/g, '.') || 0;
            let total_harga = (parseFloat(price) * parseFloat(quantity));
            let sub_total = (parseFloat(price) * parseFloat(quantity)) - parseFloat(discount);
            $(selected).parents('.service_row').find('.service_subtotal').val(sub_total ? getThousandSeparator(sub_total) :
                0);
            $(selected).parents('.service_row').find('.service_total_harga').val(total_harga ? getThousandSeparator(
                    total_harga) :
                0);
            sub_total_all_service();
        }

        function sub_total_all_service() {
            let sum = 0;
            let total_harga = 0;
            let diskon = 0;
            let total_ac = 0;
            $('.service_quantity').each(function() {
                total_ac += parseFloat($(this).val().replace(/\./g, '').replace(/\,/g, '.') || 0);
            })
            $('.service_subtotal').each(function() {
                sum += parseFloat($(this).val().replace(/\./g, '').replace(/\,/g, '.') || 0);
            });
            $('.service_total_harga').each(function() {
                total_harga += parseFloat($(this).val().replace(/\./g, '').replace(/\,/g, '.') || 0);
            });
            $('.service_discount').each(function() {
                diskon += parseFloat($(this).val().replace(/\./g, '').replace(/\,/g, '.') || 0);
            });
            $('#total_ac_input').val(total_ac || 0);
            $('#total_ac_text').html("<b>" + getThousandSeparator(total_ac) + "</b>");
            $('#sub_total_service_input').val(sum || 0);
            $('#sub_total_service_text').html("<b>Rp " + getThousandSeparator(sum) + "</b>");
            $('#total_harga_service_input').val(total_harga || 0);
            $('#total_harga_service_text').html("<b>Rp " + getThousandSeparator(total_harga) + "</b>");
            $('#total_harga').html("<b>Rp " + getThousandSeparator(total_harga) + "</b>");
            $('#diskon_service_input').val(diskon || 0);
            $('#diskon_service_text').html("<b>Rp " + getThousandSeparator(diskon) + "</b>");
            sub_total_plus_transport();
        }

        function sub_total_plus_transport() {
            // let transport_fee = $('#transport_fee').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
            // let sub_total_all_service = $('#sub_total_service_input').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
            // let sub_total_plus_transport = parseFloat(transport_fee) + parseFloat(sub_total_all_service);
            // $('#sub_total').val(sub_total_plus_transport ? getThousandSeparator(sub_total_plus_transport) : 0);
            grand_total();
        }

        function add_spare_part_as_service(data) {
            var html = `
                <tr class="service_row">
                    <td>
                        <input type="text" name="sparepart[${no}][spare_part_name]" class="form-control" value="${data.name}" readonly required id="service_id${no}">
                        <input type="hidden" name="sparepart[${no}][spare_part_id]" value="${data.pivot.spare_part_id}" required>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-text">Rp</div>
                            <input type="text" name="sparepart[${no}][harga]" class="form-control service_price" value="${data.pivot.price}" readonly>
                        </div>
                    </td>
                    <td>
                        <input type="text" name="sparepart[${no}][quantity]" value="1" class="form-control client-number service_quantity">
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-text">Rp</div>
                            <input type="text" name="sparepart[${no}][subtotal_before_discount]"
                                class="form-control service_total_harga" value="${data.pivot.price}" readonly>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-text">Rp</div>
                            <input type="text" name="sparepart[${no}][discount]"
                                value="0"
                                class="form-control client-number service_discount"
                                data-max_discount="100">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-text">Rp</div>
                            <input type="text" name="sparepart[${no}][subtotal]" value="${data.pivot.price}" class="form-control service_subtotal" readonly>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm btn_remove_service"><i class="mdi mdi-trash-can"></i></button>
                    </td>
                </tr>
            `;
            $('#service_body').append(html);
            no++;
            sub_total_all_service();
        }

        function grand_total() {
            let transport_fee = $('#transport_fee').val().replace(/\./g, '').replace(/\,/g, '.') || 0;
            let sub_total_all_service = $('#sub_total_service_input').val().replace(/\./g, '').replace(/\,/g, '.') || 0;

            let sub_total = parseFloat(transport_fee) + parseFloat(sub_total_all_service);
            let grand_total = parseFloat(sub_total);
            $('#grand_total').val(grand_total ? getThousandSeparator(grand_total) : 0);
        }
        $('#payment_type').change(function(e) {
            console.log($(this).val());
            let payment_type = $(this).val();
            if (payment_type == 'Term Of Payment') {
                $('#payment_duedate_tab').removeClass('d-none');
                $('#payment_detail_tab').removeClass('d-none');
                $('#bukti_pembayaran_tab').addClass('d-none');
            } else {
                $('#payment_duedate_tab').addClass('d-none');
                $('#payment_detail_tab').addClass('d-none');
                $('#bukti_pembayaran_tab').removeClass('d-none');
            }
        });
        $(document).on('click', '.delete_team', function() {
            $(this).closest('.team_form').remove();
        })
        let no_team = 1;
        team('#team_id0')

        function team(id) {
            $(document).find(id).select2({
                placeholder: "Pilih team",
                theme: 'bootstrap-5',
                allowClear: true,
                ajax: {
                    url: "{{ route('ajax.get_teams_available') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            _token: "{{ csrf_token() }}",
                            search: params.term, // search term
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
        $('#add_team').click(function(e) {
            e.preventDefault();
            let html =
                `
        <div class="col-lg-6 col-12 team_form">
            <div class="form-group">
                <div class="row g-3 align-items-center">
                    <div class="col-6">
                        <label for="team_id${no_team}">Team</label>
                    </div>
                    <div class="col-6 text-end">
                        <button class="btn btn-danger btn-sm delete_team"><i class="mdi mdi-trash-can"></i></button>
                    </div>
                    <div class="col-12">
                        <select name="team_id[]" id="team_id${no_team}" class="form-control">
                                <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    `;
            $('#team_row').append(html);
            team(`#team_id${no_team}`);
            no++;
        });
    </script>
@endsection
