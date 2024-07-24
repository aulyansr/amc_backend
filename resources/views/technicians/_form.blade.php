<div class="mb-3">
    {{ Form::label('technician_level_id', 'Level Teknisi', ['class'=>'form-label']) }}
    {{ Form::select('technician_level_id', $technician_levels ,null, ['class' => 'form-control select2']) }}
</div>
<div class="mb-3">
    {{ Form::label('nik', 'Nik', ['class'=>'form-label']) }}
    {{ Form::text('nik',null, array('class' => 'form-control')) }}
</div>
<div class="mb-3">
    {{ Form::label('fullname', 'Nama Lengkap', ['class'=>'form-label']) }}
    {{ Form::text('fullname',null, array('class' => 'form-control')) }}
</div>
<div class="mb-3">
    {{ Form::label('nickname', 'Nama Panggilan', ['class'=>'form-label']) }}
    {{ Form::text('nickname',null, array('class' => 'form-control')) }}
</div>
<div class="mb-3">
    {{ Form::label('no_hp', 'No HP', ['class'=>'form-label']) }}
    {{ Form::text('no_hp',null, array('class' => 'form-control')) }}
</div>
<div class="mb-3">
    {{ Form::label('gender', 'Jenis Kelamin', ['class'=>'form-label']) }}
    {{ Form::select('gender',['laki-laki'=>'Laki-laki','perempuan'=>'Perempuan'],null, array('class' => 'form-control')) }}
</div>
<div class="mb-3">
    {{ Form::label('birthdate', 'Tanggal Lahir', ['class'=>'form-label']) }}
    {{ Form::text('birthdate',null, array('class' => 'form-control one-datepicker')) }}
</div>
<div class="mb-3">
    {{ Form::label('join_date', 'Tanggal Masuk', ['class'=>'form-label']) }}
    {{ Form::text('join_date',null, array('class' => 'form-control one-datepicker')) }}
</div>
<div class="mb-3">
    {{ Form::label('email', 'Email', ['class'=>'form-label']) }}
    {{ Form::email('email',null, array('class' => 'form-control')) }}
</div>
<div class="mb-3">
    {{ Form::label('password', 'Password', ['class'=>'form-label']) }}
    {{ Form::password('password', ['class' => 'form-control']) }}
</div>
<div class="mb-3">
    {{ Form::label('password_confirmation', 'Konfirmasi Password', ['class'=>'form-label']) }}
    {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
</div>
