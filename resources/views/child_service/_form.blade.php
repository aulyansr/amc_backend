<div class="row g-2">
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('service_type', 'Service Type', ['class' => 'form-label']) }}
        {{ Form::select('service_type', $types, isset($data) ? $data->services_type_id : old('services_type'), ['class' => 'form-control']) }}
    </div>
    <div class="mb-3 col-12">
        {{ Form::label('name', 'Nama', ['class' => 'form-label']) }}
        {{ Form::text('name', null, ['class' => 'form-control']) }}
    </div>

    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('price', 'Harga Service', ['class' => 'form-label']) }}
        <div class="input-group">
            <div class="input-group-text">Rp.</div>
            {{ Form::text('price', null, ['class' => 'form-control number']) }}
        </div>
    </div>
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('warranty_price', 'Harga Service Garansi', ['class' => 'form-label']) }}
        <div class="input-group">
            <div class="input-group-text">Rp.</div>
            {{ Form::text('warranty_price', null, ['class' => 'form-control number']) }}
        </div>
    </div>

</div>
