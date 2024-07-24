<div class="row g-2">
    @foreach ($settings as $setting)
        <div class="col-12">
            <div class="row">
                <div class="col-auto">
                    {{ Form::label('key', ucfirst($setting->key), ['class' => 'form-label']) }}
                </div>
                <div class="col-auto">
                    {{ Form::text("setting[$setting->id][value]", null, ['class' => 'form-control number']) }}
                </div>
            </div>
        </div>
    @endforeach
</div>
