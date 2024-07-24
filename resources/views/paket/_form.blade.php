<div class="mb-3">
    {{ Form::label('nama_paket', 'Nama Paket', ['class' => 'form-label']) }}
    {{ Form::text('nama_paket', null, ['class' => 'form-control']) }}
</div>
<div class="mb-3">
    {{ Form::label('deskripsi_paket', 'Deskripsi Paket', ['class' => 'form-label']) }}
    {{ Form::textarea('deskripsi_paket', null, ['class' => 'form-control']) }}
</div>

<div class="mb-3">
    {{ Form::label('harga_paket', 'Harga Paket', ['class' => 'form-label']) }}
    <div class="input-group">
        <div class="input-group-text">Rp.</div>
        {{ Form::text('harga_paket', null, ['class' => 'form-control number']) }}
    </div>
</div>
<div class="mb-3">
    {{ Form::label('jumlah_ac', 'Jumlah Service AC', ['class' => 'form-label']) }}
    <div class="input-group">
        {{ Form::text('jumlah_ac', null, ['class' => 'form-control number']) }}
        <div class="input-group-text">AC</div>
    </div>
</div>
<div class="mb-3">
    {{ Form::label('masa_berlaku', 'Masa Berlaku Paket', ['class' => 'form-label']) }}
    {{ Form::select('masa_berlaku', ['' => 'silahkan dipilih', '3 bulan' => '3 bulan', '6 bulan' => '6 bulan', '1 tahun' => '1 tahun'], null, ['class' => 'form-control']) }}
</div>
<div class="mb-3">
    {{ Form::label('status_paket', 'Status Paket', ['class' => 'form-label']) }}
    {{ Form::select('status_paket', ['1' => 'Aktif', '0' => 'Tidak Aktif'], null, ['class' => 'form-control']) }}
</div>
<div class="mb-3">
    {{ Form::label('image', 'Image', ['class' => 'form-label']) }}
    <div class="input-group">
        <div class="row g-3">
            <div class="col-12">
                <img id="image-preview" class="img-thumbnail mw-100 {{ isset($paket) ? '' : 'd-none' }}"
                    src="{{ isset($paket) ? asset('storage/images/paket/' . $paket->foto_paket) : '' }}"
                    style="width: 100px;" alt="Preview Image">
            </div>
            <div class="col-12">
                <input type="file" id="image" name="image" class="form-control">
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="row g-2">
        <div class="col lg-6">
            <h4>Service Untuk Paket Ini</h4>
        </div>
        <div class="col-lg-6 text-lg-end">
            <button class="btn btn-primary btn-sm" id="add_service"><i class="mdi mdi-basket-plus pe-3"></i>Tambah
                Service</button>
        </div>
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>Nama Service</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="service_body">
                        @if (isset($paket))
                            @php
                                $no = 0;
                            @endphp
                            @foreach ($paket->serviceType as $paket_service)
                                <tr class="service_row">
                                    <td>
                                        <select name="services[{{ $no }}][service_type_id]"
                                            class="form-control select_service" required
                                            id="service_id{{ $no }}">
                                            @foreach ($serviceType as $service)
                                                <option value="{{ $service->id }}"
                                                    {{ $paket_service->service_type_id == $service->id ? 'selected' : '' }}>
                                                    {{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm btn_remove_service"><i
                                                class="mdi mdi-trash-can"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
            $('#image-preview').removeClass('d-none');
        });

        let no = {{ isset($paket) ? $no : 0 }};
        option = '';
        @foreach ($serviceType as $key => $value)
            option += `<option value="{{ $value->id }}">{{ $value->name }}</option>`;
        @endforeach
        $('#add_service').click(function(e) {
            e.preventDefault();
            var html = `
                <tr class="service_row">
                    <td>
                        <select name="services[${no}][service_type_id]" class="form-control select_service" required id="service_id${no}">
                            ${option}
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm btn_remove_service"><i class="mdi mdi-trash-can"></i></button>
                    </td>
                </tr>
            `;

            $('#service_body').append(html);
            no++;
        });
        $(document).on('click', '.btn_remove_service', function() {
            $(this).parents('.service_row').remove();
        });
    </script>
@endsection
