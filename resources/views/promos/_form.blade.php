<div class="col-12">
    {{ Form::label('image', 'Image', ['class' => 'form-label']) }}
    <div class="input-group">
        <div class="row g-3">
            <div class="col-12">
                <img id="image-preview" class="img-thumbnail mw-100 {{ isset($promo) ? '' : 'd-none' }}"
                    src="{{ isset($promo) ? asset($promo->promo_poster) : '' }}" style="width: 400px;" alt="Preview Image">
            </div>
            <div class="col-12">
                <input type="file" id="image" name="image" class="form-control">
            </div>
        </div>
    </div>
</div>
<div class="col-md-6">
    {{ Form::label('promo_name', 'Promo Name', ['class' => 'form-label']) }}
    {{ Form::text('promo_name', isset($promo) ? $promo->promo_name : '', ['class' => 'form-control']) }}
</div>

<div class="col-md-6">
    {{ Form::label('promo_code', 'Promo Code', ['class' => 'form-label']) }}
    {{ Form::text('promo_code', isset($promo) ? $promo->promo_code : '', ['class' => 'form-control']) }}
</div>

<div class="col-md-12">
    {{ Form::label('promo_description', 'Promo Description', ['class' => 'form-label']) }}
    {{ Form::textarea('promo_description', isset($promo) ? $promo->promo_description : '', ['class' => 'form-control', 'rows' => '3']) }}
</div>



<div class="col-md-6">
    {{ Form::label('discount_amount', 'Discount Amount', ['class' => 'form-label']) }}
    <div class="input-group mb-3">
        {{ Form::number('discount_amount', isset($promo) ? $promo->discount_amount : '', ['class' => 'form-control']) }}
        <label class="input-group-text" for="inputGroupSelect02">%</label>
    </div>

</div>

<div class="col-md-6">
    {{ Form::label('max_amount', 'Max Amount', ['class' => 'form-label']) }}
    {{ Form::number('max_amount', isset($promo) ? $promo->max_amount : '', ['class' => 'form-control']) }}
</div>


<div class="col-md-6">
    {{ Form::label('max_use', 'Max Use', ['class' => 'form-label']) }}
    {{ Form::number('max_use', isset($promo) ? $promo->max_use : '', ['class' => 'form-control', 'value' => '9999']) }}
</div>

<div class="col-md-6">
    {{ Form::label('expired_date', 'Expired Date', ['class' => 'form-label']) }}
    {{ Form::date('expired_date', isset($promo) ? $promo->expired_date : '', ['class' => 'form-control']) }}
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
