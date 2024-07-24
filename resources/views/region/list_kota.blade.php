<label for="city_id" class="form-label">Pilih Kota</label>
{!! Form::select('city_code', $kota, null, [
    'class' => 'form-control select2 mb-3',
    'placeholder' => 'Pilih Kota',
    'id' => 'city_id',
]) !!}
