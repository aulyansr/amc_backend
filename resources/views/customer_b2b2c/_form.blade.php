<div class="row g-3">
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="type">Tipe Customer</label>
            {!! Form::select('type', [0 => 'Publik'], old('type') ?? $customer->type, [
                'placeholder' => 'Tipe Customer',
                'class' => 'form-control',
                'id' => 'type',
                'required',
            ]) !!}
        </div>
    </div>
    <div class="col-lg-6 col-12 {{ isset($customer) && $customer->type == '1' ? '' : 'd-none' }}" id="company_name_col">
        <div class="form-group">
            <label for="company_name">Nama Company Customer</label>
            {!! Form::text('company_name', old('company_name') ?? $customer->company_name, [
                'placeholder' => 'Nama Company',
                'class' => 'form-control',
                'id' => 'company_name',
            ]) !!}
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="nama">name</label>
            {!! Form::text('nama', old('nama') ?? $customer->nama, [
                'placeholder' => 'Nama Customer',
                'class' => 'form-control',
                'id' => 'nama',
            ]) !!}
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="email">email</label>
            {!! Form::email('email', old('email') ?? $customer->email, [
                'placeholder' => 'Email Customer',
                'class' => 'form-control',
                'id' => 'email',
            ]) !!}
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="form-group">
            <label for="phone">Phone</label>
            {!! Form::text('phone', old('phone') ?? $customer->phone, [
                'placeholder' => 'Phone Customer',
                'class' => 'form-control',
                'id' => 'phone',
                'onKeyUp' => 'onlyNumber(this.id)',
            ]) !!}
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-lg-6 col-12 text-lg-start text-center">
                <a href="{{ route('customers.index') }}" class="btn btn-danger"><i class="ri-arrow-left-line pe-2"></i>
                    Back</a>
            </div>
            <div class="col-lg-6 col-12 text-lg-end text-center">
                <button type="submit" class="btn btn-primary"><i class="ri-save-line pe-2"></i>
                    {{ $submit }}</button>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script>
        $('#type').change(function(e) {
            e.preventDefault();
            let type = $('#type').val();
            if (type == 0) {
                $('#company_name_col').addClass('d-none');
            } else {
                $('#company_name_col').removeClass('d-none');
            }
        });
    </script>
@endsection
