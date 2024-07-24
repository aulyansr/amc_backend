<div class="row g-2">
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
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('is_mobile', 'Tampilkan Mobile ?', ['class' => 'form-label']) }}
        {{ Form::select('is_mobile', ['1' => 'Tampilkan', '0' => 'Tidak Tampilkan'], null, ['class' => 'form-control']) }}
    </div>
    <div class="mb-3 col-lg-6 col-12">
        {{ Form::label('image', 'Image', ['class' => 'form-label']) }}
        <div class="input-group">
            <div class="row g-3">
                <div class="col-12">
                    <img id="image-preview" class="img-thumbnail mw-100 {{ isset($data) ? '' : 'd-none' }}"
                        src="{{ isset($data) ? asset('storage/images/services_group/' . $data->image) : '' }}"
                        style="width: 100px;" alt="Preview Image">
                </div>
                <div class="col-12">
                    <input type="file" id="image" name="image" class="form-control">
                </div>
            </div>
        </div>
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
