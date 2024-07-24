<div class="row g-2">
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('services_type', 'Service Type', ['class' => 'form-label']) }}
        {{ Form::select('services_type', $types, isset($service) ? $service->services_type_id : old('services_type'), ['class' => 'form-control']) }}
    </div>
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('type_ac', 'AC Type', ['class' => 'form-label']) }}
        {{ Form::select('type_ac', $types_ac, isset($service) ? $service->type_ac : old('type_ac'), ['class' => 'form-control']) }}
    </div>

    <div class="mb-3 col-12">
        {{ Form::label('name', 'Nama', ['class' => 'form-label']) }}
        {{ Form::text('name', null, ['class' => 'form-control']) }}
    </div>
    <div class="mb-3 col-12">
        {{ Form::label('description', 'Deskripsi', ['class' => 'form-label']) }}
        {{ Form::textarea('description', null, ['class' => 'form-control']) }}
    </div>

    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('pk_dari', 'PK dari', ['class' => 'form-label']) }}
        <div class="input-group">
            <div class="input-group-text">Rp.</div>
            {{ Form::text('pk_dari', null, ['class' => 'form-control number']) }}
        </div>
    </div>
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('pk_sampai', 'PK Sampai', ['class' => 'form-label']) }}
        <div class="input-group">
            <div class="input-group-text">Rp.</div>
            {{ Form::text('pk_sampai', null, ['class' => 'form-control number']) }}
        </div>
    </div>
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('price', 'Harga Service', ['class' => 'form-label']) }}
        <div class="input-group">
            <div class="input-group-text">Rp.</div>
            {{ Form::text('price', null, ['class' => 'form-control number']) }}
        </div>
    </div>
    @if (isset($customer) && $customer->type == '2')
        <div class="mb-3 col-lg-6 col-12">
            {{ Form::label('price_warranty', 'Harga Service Garansi', ['class' => 'form-label']) }}
            <div class="input-group">
                <div class="input-group-text">Rp.</div>
                {{ Form::text('price_warranty', null, ['class' => 'form-control number']) }}
            </div>
        </div>
    @endif
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('commision', 'Komisi Service', ['class' => 'form-label']) }}
        <div class="input-group">
            <div class="input-group-text">Rp.</div>
            {{ Form::text('commision', null, ['class' => 'form-control number']) }}
        </div>
    </div>
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('max_discount', 'Max Discount Service', ['class' => 'form-label']) }}
        <div class="input-group">
            {{ Form::text('max_discount', null, ['class' => 'form-control number']) }}
            <div class="input-group-text">%</div>
        </div>
    </div>
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('warranty', 'Warranty', ['class' => 'form-label']) }}
        <div class="input-group">
            {{ Form::text('warranty', null, ['class' => 'form-control number']) }}
            <div class="input-group-text">Days</div>
        </div>
    </div>
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('service_time', 'Service Time', ['class' => 'form-label']) }}
        <div class="input-group">
            {{ Form::text('service_time', null, ['class' => 'form-control number']) }}
            <div class="input-group-text">Minutes</div>
        </div>
    </div>
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('technician_needed', 'Technician Needed', ['class' => 'form-label']) }}
        <div class="input-group">
            {{ Form::text('technician_needed', null, ['class' => 'form-control number']) }}
            <div class="input-group-text">People</div>
        </div>
    </div>

    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('is_active', 'Status Service', ['class' => 'form-label']) }}
        {{ Form::select('is_active', ['1' => 'Aktif', '0' => 'Tidak Aktif'], null, ['class' => 'form-control']) }}
    </div>
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('is_show_mobile', 'Tampilkan di Mobile', ['class' => 'form-label']) }}
        {{ Form::select('is_show_mobile', ['1' => 'Aktif', '0' => 'Tidak Aktif'], null, ['class' => 'form-control']) }}
    </div>
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('image', 'Image', ['class' => 'form-label']) }}
        <div class="input-group">
            <div class="row g-3">
                <div class="col-12">
                    <img id="image-preview" class="img-thumbnail mw-100 {{ isset($service) ? '' : 'd-none' }}"
                        src="{{ isset($service) ? asset('storage/images/services/' . $service->image) : '' }}"
                        style="width: 100px;" alt="Preview Image">
                </div>
                <div class="col-12">
                    <input type="file" id="image" name="image" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <h3>Select Repair Activity:</h3>
        @foreach ($repairAttachmentItems as $item)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="activity_items[]" value="{{ $item->id }}"
                    id="activity_item_{{ $item->id }}"
                    {{ isset($service) && $service->activities->contains($item->id) ? 'checked' : '' }}>
                <label class="form-check-label" for="activity_item_{{ $item->id }}">
                    {{ $item->title }}
                </label>
            </div>
        @endforeach
    </div>

</div>
@section('script')
    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
            $('#image-preview').removeClass('d-none');
        });
    </script>
@endsection
