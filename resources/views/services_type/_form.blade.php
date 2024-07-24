<div class="row g-2">

    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('group', 'Service Group', ['class' => 'form-label']) }}
        {{ Form::select('group', $groups, isset($data) ? $data->services_group_id : old('group'), ['class' => 'form-control']) }}
    </div>
    <div class="mb-3 col-12">
        {{ Form::label('name', 'Nama', ['class' => 'form-label']) }}
        {{ Form::text('name', null, ['class' => 'form-control']) }}
    </div>
    <div class="mb-3 col-12">
        {{ Form::label('description', 'Deskripsi', ['class' => 'form-label']) }}
        {{ Form::textarea('description', null, ['class' => 'form-control']) }}
    </div>
    @if (isset($data))
        <div class="mb-3 col-lg-6 col-12">
            {{ Form::label('is_active', 'Status Service', ['class' => 'form-label']) }}
            {{ Form::select('is_active', ['1' => 'Aktif', '0' => 'Tidak Aktif'], null, ['class' => 'form-control']) }}
        </div>
    @endif
</div>
@section('script')
@endsection
