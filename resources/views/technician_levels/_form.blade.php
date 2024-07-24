<div class="mb-3">
    {{ Form::label('name', 'Name', ['class'=>'form-label']) }}
    {{ Form::text('name', null, array('class' => 'form-control')) }}
</div>
<div class="mb-3">
    {{ Form::label('desc', 'Desc', ['class'=>'form-label']) }}
    {{ Form::text('desc', null, array('class' => 'form-control')) }}
</div>
<div class="mb-3">
    {{ Form::label('commision_service', 'Commision_service (%)', ['class'=>'form-label']) }}
    {{ Form::text('commision_service', null, array('class' => 'form-control','pattern' => '[0-9]+', 'title' => 'Inputan ini hanya boleh angka')) }}
</div>
