<label for="kecamatan_id" class="form-label">Pilih Kecamatan</label>
{!! Form::select('district_code', $kecamatan, null, [
    'class' => 'form-control select2 mb-3',
    'placeholder' => 'Pilih Kecamatan',
    'id' => 'kecamatan_id',
]) !!}
