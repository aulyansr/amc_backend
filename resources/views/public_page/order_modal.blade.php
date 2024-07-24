<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="orderModalLabel">Pesan Jasa</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form_order">
                    <div class="mb-3">
                        <label for="wa_name" class="col-form-label">Nama:</label>
                        <input class="validate form-control" id="wa_name" name="wa_name" type="text"
                            placeholder="Nama Lengkap" />
                    </div>
                    <div class="mb-3">
                        <label for="wa_name" class="col-form-label">Email:</label>
                        <input class="validate form-control" id="wa_email" name="wa_email" type="text"
                            placeholder="Email_kamu@mail.com" />
                    </div>
                    <div class="mb-3">
                        <label for="wa_name" class="col-form-label">No Handphone (Whatsapp):</label>
                        <input class="validate form-control" id="wa_number" name="wa_number" type="text"
                            placeholder="08....." />
                    </div>
                    <div class="mb-3">
                        <label for="wa_service_type" class="col-form-label">Jasa:</label>
                        <input class="validate form-control service_type_value" id="service_type_value" name="name"
                            type="text" readonly />
                    </div>
                    <div class="mb-3">
                        <label for="wa_count" class="col-form-label">Jumlah AC:</label>
                        <input class="validate form-control" id="wa_count" name="wa_count" type="text" />
                    </div>
                    <div class="mb-3">
                        <label for="wa_keluhan" class="col-form-label">Keluhan AC:</label>
                        <textarea class="form-control" id="wa_keluhan" rows=5 placeholder="AC tidak dingin, AC Bocor"></textarea>
                    </div>
                    <div>
                        <label for="pengerjaan" class="col-form-label">Tanggal Pengerjaan:</label>
                        <input class="validate form-control datetime-picker" id="pengerjaan" name="pengerjaan"
                            type="text" />
                    </div>
                    <label for="wa_address" class="col-form-label">Alamat Lengkap:</label>
                    <fieldset>
                        <div class="mb-3">
                            {!! Form::select('provinsi', $provinsi, '', [
                                'class' => 'form-control mb-3',
                                'placeholder' => 'Pilih Provinsi',
                                'id' => 'province_id',
                            ]) !!}
                            <div class="form-group" id="form-kota">
                            </div>

                            <div class="form-group" id="form-kecamatan">
                            </div>

                            <div class="form-group" id="form-kelurahan">
                            </div>

                            <textarea class="form-control" id="wa_address" rows=5
                                placeholder="Alamat Lengkap, kota, kecamatan, nama Gedung atau nomor Rumah"></textarea>

                            <div class="mb-3">
                                <label for="input_no_rumah" class="col-form-label">Detail Alamat:</label>
                                <input class="validate form-control" id="input_no_rumah" name="input_no_rumah"
                                    type="text"
                                    placeholder="Warna Rumah / Patokan / Nomor Rumah / Nama Gedung dengan Nomor Unit" />
                            </div>

                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">batal</button>
                <button class="send_form_order btn btn-blue" type="button" title="Send to Whatsapp">Pesan
                    Sekarang</button>
                <div id="text-info" class="col-12 text-center"></div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('body').on('change', '#province_id', function() {
            let id = $(this).val();
            let route = "{{ route('get.kota') }}";
            $.ajax({
                type: 'get',
                url: route,
                data: {
                    province_id: id
                },
                success: function(data) {
                    $('#form-kota').html(data);
                }
            })
        })
        $('body').on('change', '#city_id', function() {
            let id = $(this).val();
            let route = "{{ route('get.kecamatan') }}";
            $.ajax({
                type: 'get',
                url: route,
                data: {
                    city_id: id
                },
                success: function(data) {
                    $('#form-kecamatan').html(data);
                }
            })
        })
        $('body').on('change', '#kecamatan_id', function() {
            let id = $(this).val();
            let route = "{{ route('get.kelurahan') }}";
            $.ajax({
                type: 'get',
                url: route,
                data: {
                    kecamatan_id: id
                },
                success: function(data) {
                    $('#form-kelurahan').html(data);
                }
            })
        })
        $(".datetime-picker").flatpickr({
            enableTime: true,
            dateFormat: "d-m-Y H:i",
        });
    })
</script>
