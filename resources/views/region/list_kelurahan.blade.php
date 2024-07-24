<label for="kelurahan_id" class="form-label">Pilih Kelurahan</label>
{!! Form::select('village_code', $kelurahan, null, [
    'class' => 'form-control select2 mb-3',
    'placeholder' => 'Pilih kelurahan',
    'id' => 'kelurahan_id',
]) !!}
