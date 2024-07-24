<div class="row g-3">
    <div class="col-lg-6 col-12">
        {{ Form::label('kode', 'Kode Subscription', ['class' => 'form-label']) }}
        {{ Form::text('code', null, ['class' => 'form-control', 'id' => 'kode']) }}
    </div>

    <div class="col-lg-6 col-12">
        <div class="form-group">
            <div class="col-lg-6 col-12">
                {{ Form::label('customer', 'Nama Customer', ['class' => 'form-label']) }}
                {{ Form::select('customer', isset($subscription) ? $customer : ['' => 'silahkan dipilih'], null, ['class' => 'form-control select2', 'id' => 'customer']) }}
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        {{ Form::label('paket', 'Nama Subscription', ['class' => 'form-label']) }}
        {{ Form::select('paket', $paket, null, ['class' => 'form-control', 'id' => 'paket']) }}
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-lg-6 col-12 text-lg-start text-center">
                <a href="{{ route('subscription.index') }}" class="btn btn-danger"><i
                        class="ri-arrow-left-fill pe-2"></i>
                    Back</a>
            </div>
            <div class="col-lg-6 col-12 text-lg-end text-center">
                <button type="submit" class="btn btn-primary"><i class="ri-save-fill pe-2"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script>
        @if (!isset($subcription))
            customer();
        @endif

        function customer() {
            $("#customer").select2({
                placeholder: "Pilih Customer",
                theme: 'bootstrap-5',
                allowClear: true,
                width: "100%",
                ajax: {
                    url: "{{ route('ajax.get_customer') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            _token: "{{ csrf_token() }}",
                            search: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        response = response.map(function(item) {
                            return {
                                id: item.id,
                                text: item.text,
                                type: item.type,
                            };
                        });
                        return {
                            results: response
                        };
                    },
                    cache: true
                }

            });
        }
    </script>
@endsection
