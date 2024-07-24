<div class="mb-3">
    {{ Form::label('image', 'Image', ['class' => 'form-label']) }}
    <div class="input-group">
        <div class="row g-3">
            <div class="col-12">
                <img id="image-preview" class="img-thumbnail mw-100 {{ isset($repair_attachment_item) ? '' : 'd-none' }}"
                    src="{{ isset($repair_attachment_item) ? $repair_attachment_item->image : '' }}" style="width: 400px;"
                    alt="Preview Image">
            </div>
            <div class="col-12">
                <input type="file" id="image" name="image" class="form-control">
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    {{ Form::label('title', 'title', ['class' => 'form-label']) }}
    {{ Form::text('title', null, ['class' => 'form-control']) }}
</div>
<div class="mb-3">
    {{ Form::label('description', 'description', ['class' => 'form-label']) }}
    {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5']) }}
</div>
<div class="mb-3">
    {{ Form::label('row_count', 'Jumlah Baris', ['class' => 'form-label']) }}
    {{ Form::text('row_count', null, ['class' => 'form-control']) }}
</div>
<div class="d-block mb-3">
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="image_capture_time" id="before_capture" value="0"
            {{ isset($repair_attachment_item) && $repair_attachment_item->image_capture_time == '0' ? 'checked' : '' }}>
        <label class="btn btn-outline-primary" for="before_capture">Sebelum Pengerjaan</label>

        <input type="radio" class="btn-check" name="image_capture_time" id="after_capture" value="1"
            {{ isset($repair_attachment_item) && $repair_attachment_item->image_capture_time == '1' ? 'checked' : '' }}>
        <label class="btn btn-outline-primary" for="after_capture">Setelah Pengerjaan</label>
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
