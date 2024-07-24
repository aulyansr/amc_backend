<div class="mb-3">
    {{ Form::label('branch_id', 'Branch_id', ['class'=>'form-label']) }}
    {{ Form::select('branch_id', $branches ,null, array('class' => 'form-control select2')) }}
</div>
<div class="mb-3">
    {{ Form::label('shift_id', 'Shift_id', ['class'=>'form-label']) }}
    {{ Form::select('shift_id', $shifts ,null, array('class' => 'form-control select2')) }}
</div>
<div class="mb-3">
    {{ Form::label('nama', 'Nama Team', ['class'=>'form-label']) }}
    {{ Form::text('nama', null, array('class' => 'form-control')) }}
</div>
<div class="mb-3">
    {{ Form::label('team_lead', 'Team Leader', ['class' => 'form-label']) }}
    {{ Form::select('team_lead', $technicians, isset($team) ? $team->technician()->wherePivot('status', '=', 'lead')->first()?->id : '', ['class' => 'form-control select2', 'id' => 'team_lead']) }}
</div>
<div class="mb-3">
    {{ Form::label('technician_id', 'Anggota Teknisi', ['class' => 'form-label']) }}
    {{ Form::select('technician_id[]', $technicians,isset($team) ? $team->technician()->wherePivot('status', '!=', 'lead')->pluck('technicians.id as id') : old('technician_id'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'id' => 'technician_id']) }}
</div>
<div class="mb-3">
    {{ Form::label('skill_id', 'Skill Team', ['class'=>'form-label']) }}
    {{ Form::select('skill_id[]', $skills ,isset($team) ? $team->skill()->pluck('master_skills.id as id') : old('skill_id'), array('class' => 'form-control select2','multiple' => 'multiple')) }}
</div>
<div class="mb-3">
    {{ Form::label('is_active', 'Status Team', ['class'=>'form-label']) }}
    {{ Form::select('is_active', [1=>'Aktif', 0=>'Tidak Aktif'] ,null, array('class' => 'form-control select2')) }}
</div>

@section('script')
    <script>
        $(document).ready(function() {
            $('#team_lead').on('select2:select', function(e) {
                console.log(this);
                var selectedTechnician = e.params.data.id;
                $('#technician_id option').prop('disabled', false); // enable all options

                if (selectedTechnician) {
                    $('#technician_id option[value="' + selectedTechnician + '"]').prop('disabled', true); // disable selected option
                }

                $('#technician_id').select2();
            });
        });
    </script>
@endsection
