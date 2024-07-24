<div class="col-lg-6 col-12">
    <div class="form-group">
        <label for="service_children[]">Service Terkait</label>
        {!! Form::select(
            'service_children[]',
            $service_children,
            old('service_children', $service->child_service?->pluck('id')->toArray() ?? null),
            [
                // 'placeholder' => 'Pilih Service',
                'class' => 'form-control select2 ',
                'required',
                'multiple',
                'id' => 'customer',
            ],
        ) !!}
    </div>
</div>
