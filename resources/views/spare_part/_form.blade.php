<div class="row g-2">
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('spare_part_group_id', 'Group', ['class' => 'form-label']) }}
        {{ Form::select('spare_part_group_id', $spare_part_group, isset($data) ? $data->spare_part_group_id : old('spare_part_group_id'), ['class' => 'form-control']) }}
    </div>
    <div class="mb-3 col-12">
        {{ Form::label('name', 'Nama Spare Part', ['class' => 'form-label']) }}
        {{ Form::text('name', null, ['class' => 'form-control']) }}
    </div>

</div>
