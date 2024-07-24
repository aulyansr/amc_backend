<div class="mb-3">
    {{ Form::label('skill_name', 'Skill_name', ['class'=>'form-label']) }}
    {{ Form::text('skill_name', null, array('class' => 'form-control')) }}
</div>
<div class="mb-3">
    {{ Form::label('skill_desc', 'Skill_desc', ['class'=>'form-label']) }}
    {{ Form::textarea('skill_desc', null, array('class' => 'form-control')) }}
</div>
