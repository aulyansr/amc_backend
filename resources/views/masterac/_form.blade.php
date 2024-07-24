<div class="row g-3">
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="brand">Brand AC</label>
            {!! Form::text('brand', old('brand') ?? $masterac->brand , ['placeholder' => 'Brand', 'class' => 'form-control ','required', 'id'=>'brand']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="model">Model AC</label>
            {!! Form::text('model', old('model') ?? $masterac->model , ['placeholder' => 'Model', 'class' => 'form-control ','required', 'id'=>'model']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="ac_name">Nama Ac</label>
            {!! Form::text('ac_name', old('ac_name') ?? $masterac->ac_name , ['placeholder' => 'Nama Ac', 'class' => 'form-control ','required', 'id'=>'ac_name']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="is_inverter">Is Inverter ?</label>
            <div class="form-check">
                {!! Form::radio('is_inverter', 'yes', $masterac->is_inverter === 'yes', ['id' => 'yes', 'class' => 'form-check-input']) !!}
                {!!     Form::label('yes', 'Yes', ['class' => 'form-check-label']) !!}
            </div>
            <div class="form-check">
                {!! Form::radio('is_inverter', 'no', $masterac->is_inverter === 'no', ['id' => 'no', 'class' => 'form-check-input']) !!}
                {!! Form::label('no', 'No', ['class' => 'form-check-label']) !!}

            </div>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            {!! Form::label('pk', 'PK AC') !!}
            {!! Form::text('pk', null, ['class' => 'form-control', 'placeholder' => 'PK AC']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="freon_type">Tipe Freon</label>
            {!! Form::text('freon_type', old('freon_type') ?? $masterac->freon_type , ['placeholder' => 'Tipe Freon', 'class' => 'form-control ','required', 'id'=>'freon_type']) !!}
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-lg-6 col-12 text-lg-start text-center">
                <a href="{{ route('master.masterac.index') }}" class="btn btn-danger"><i class="ri-arrow-left-fill pe-2"></i> Back</a>
            </div>
            <div class="col-lg-6 col-12 text-lg-end text-center">
                <button type="submit" class="btn btn-primary"><i class="ri-save-fill pe-2"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
