<div class="row g-2 mb-3">
    <div class="col-12">
        {{ Form::label('name', 'Nama Shift', ['class'=>'form-label']) }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>
    <div class="col-12">
        {{ Form::label('shift_from', 'Jam Shift', ['class'=>'form-label']) }}
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                {{ Form::text('shift_from', null, array('class' => 'form-control time-picker')) }}
            </div>
            <div class="col-auto">
                Sampai
            </div>
            <div class="col-auto">
                {{ Form::text('shift_to', null, array('class' => 'form-control time-picker')) }}
            </div>
        </div>
    </div>
    <div class="col-12">
        {{ Form::label('day', 'Day', ['class'=>'form-label']) }}
        {{ Form::select('day[]',
        [
            'Senin'=>'Senin',
            'Selasa'=>'Selasa',
            'Rabu'=>'Rabu',
            'Kamis'=>'Kamis',
            'Jumat'=>'Jumat',
            'Sabtu'=>'Sabtu',
            'Minggu'=>'Minggu',
        ]
        ,isset($shift) ? json_decode($shift->day) : '' ,array('class' => 'form-control select2','multiple' => 'multiple')) }}
    </div>
</div>
