<div class="row g-2">
    <div class="mb-3 col-12">
        {{ Form::label('distance', 'Total Jarak', ['class' => 'form-label']) }}
        <div class="input-group">
            {{ Form::text('distance', null, ['class' => 'form-control number']) }}
            <div class="input-group-text">KM</div>
        </div>
    </div>
    <div class="mb-3 col-12">
        {{ Form::label('distance_from', 'Jarak Dari', ['class' => 'form-label']) }}
        <div class="input-group">
            {{ Form::text('distance_from', null, ['class' => 'form-control number']) }}
            <div class="input-group-text">KM</div>
        </div>
    </div>
    <div class="mb-3 col-12">
        {{ Form::label('distance_to', 'Sampai Jarak', ['class' => 'form-label']) }}
        <div class="input-group">
            {{ Form::text('distance_to', null, ['class' => 'form-control number']) }}
            <div class="input-group-text">KM</div>
        </div>
    </div>
    <div class="mb-3 col-12">
        {{ Form::label('distance_price', 'Harga Jarak', ['class' => 'form-label']) }}
        <div class="input-group">
            <div class="input-group-text">Rp</div>
            {{ Form::text('distance_price', null, ['class' => 'form-control number']) }}
        </div>
    </div>
    <div class="mb-3 col-12">
        {{ Form::label('distance_price_special', 'Special Harga Jarak', ['class' => 'form-label']) }}
        <div class="input-group">
            <div class="input-group-text">Rp</div>
            {{ Form::text('distance_price_special', null, ['class' => 'form-control number']) }}
        </div>
    </div>
</div>
