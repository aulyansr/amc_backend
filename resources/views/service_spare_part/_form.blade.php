<div class="col-12">
    <div class="form-group">
        <label for="">Nama Spare Part</label>
        {!! Form::select('spare_part_id', $spare_part, isset($data) ? $data->id : old('spare_part'), [
            'class' => 'form-control select2',
        ]) !!}
    </div>
</div>
<div class="mb-3 col-lg-6 col-12">
    {{ Form::label('', 'Harga Spare Part', ['class' => 'form-label']) }}
    <div class="input-group">
        <div class="input-group-text">Rp.</div>
        {{ Form::text('price',isset($data)? $data->services()->wherePivot('service_id', $service->id)->first()->pivot->price: old('price'),['class' => 'form-control number']) }}
    </div>
</div>
<div class="mb-3 col-lg-6 col-12">
    {{ Form::label('', 'Harga Spare Part Garansi', ['class' => 'form-label']) }}
    <div class="input-group">
        <div class="input-group-text">Rp.</div>
        {{ Form::text('price_warranty',isset($data)? $data->services()->wherePivot('service_id', $service->id)->first()->pivot->price_warranty: old('price_warranty'),['class' => 'form-control number']) }}
    </div>
</div>
