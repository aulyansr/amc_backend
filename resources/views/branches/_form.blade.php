<div class="mb-3">
    {{ Form::label('name', 'Name', ['class'=>'form-label']) }}
    {{ Form::text('name', null, array('class' => 'form-control')) }}
</div>
<div class="mb-3">
    {{ Form::label('phone', 'Phone', ['class'=>'form-label']) }}
    {{ Form::text('phone', null, array('class' => 'form-control')) }}
</div>
<div class="mb-3">
    {{ Form::label('address', 'Address', ['class'=>'form-label']) }}
    {{ Form::textarea('address', null, array('class' => 'form-control')) }}
</div>
<div class="mb-3">
    {{ Form::label('latitude', 'Latitude', ['class'=>'form-label']) }}
    {{ Form::text('latitude', null, array('class' => 'form-control')) }}
</div>
<div class="mb-3">
    {{ Form::label('longitude', 'Longitude', ['class'=>'form-label']) }}
    {{ Form::text('longitude', null, array('class' => 'form-control')) }}
</div>
<div class="mb-3">
    {{ Form::label('max', 'Max', ['class'=>'form-label']) }}
    {{ Form::text('max', null, array('class' => 'form-control')) }}
</div>
