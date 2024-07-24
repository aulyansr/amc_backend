<div class="row g-3">
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="customer">Customer</label>
            {!! Form::select('customer', $customer->pluck('nama', 'id'), old('customer') ?? $masterqr->master_customer_id, ['placeholder' => 'Pilih Customer', 'class' => 'form-control select2 ','required', 'id'=>'customer']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="is_inverter">Is Inverter ?</label>
            <div class="form-check">
                {!! Form::radio('is_inverter', 'yes', $masterqr->is_inverter === 'yes', ['id' => 'yes', 'class' => 'form-check-input']) !!}
                {!!     Form::label('yes', 'Yes', ['class' => 'form-check-label']) !!}
            </div>
            <div class="form-check">
                {!!     Form::radio('is_inverter', 'no', $masterqr->is_inverter === 'no', ['id' => 'no', 'class' => 'form-check-input']) !!}
                {!!     Form::label('no', 'No', ['class' => 'form-check-label']) !!}

            </div>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="brand">Brand</label>
            {!! Form::text('brand', old('brand') ?? $masterqr->brand , ['placeholder' => 'Brand', 'class' => 'form-control ','required', 'id'=>'brand']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="ac_name">Nama Ac</label>
            {!! Form::text('ac_name', old('ac_name') ?? $masterqr->ac_name , ['placeholder' => 'Nama Ac', 'class' => 'form-control ','required', 'id'=>'ac_name']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="model">Model</label>
            {!! Form::text('model', old('model') ?? $masterqr->model , ['placeholder' => 'Model', 'class' => 'form-control ','required', 'id'=>'model']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="pk">PK</label>
            {!! Form::text('pk', old('pk') ?? $masterqr->pk , ['placeholder' => 'PK', 'class' => 'form-control ','required', 'id'=>'pk']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="freon_type">Tipe Freon</label>
            {!! Form::text('freon_type', old('freon_type') ?? $masterqr->freon_type , ['placeholder' => 'Tipe Freon', 'class' => 'form-control ','required', 'id'=>'freon_type']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="ac_category">Ac Category</label>
            {!! Form::text('ac_category', old('ac_category') ?? $masterqr->ac_category , ['placeholder' => 'Ac Category', 'class' => 'form-control ','required', 'id'=>'ac_category']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="room_name">Nama Ruangan</label>
            {!! Form::text('room_name', old('room_name') ?? $masterqr->room_name , ['placeholder' => 'Nama Ruangan', 'class' => 'form-control ','required', 'id'=>'room_name']) !!}
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-12 text-lg-end text-center">
                <button type="submit" class="btn btn-primary"><i class="ri-save-fill pe-2"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
