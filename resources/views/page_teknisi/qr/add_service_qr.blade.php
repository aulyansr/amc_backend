@extends('layouts.screen_technician')
@section('css')
@endsection
@section('content')
    <section class="content">
        <div class="container">
            <form action="{{ route('technician.store_service', $qr->url_unique) }}" method="POST">
                @csrf

                <h1 class="fw-100 fs-4 text-primary-blue mb-3">Tambah Service AC</h1>
                <p class="text-primary-blue ">Detail Customer dan AC</p>
                <div class="card card-homepage mb-5">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="BrandAC" class="form-label">Nama Customer</label>
                                <p>{{ $ac->customerName }}</p>
                            </div>
                            <div class="col-12">
                                <label for="nama_ac" class="form-label">Alamat</label>
                                <p>{{ $ac->addressCompleted }}</p>
                            </div>

                            <div class="col-12">
                                <label for="model_ac" class="form-label">Brand AC</label>
                                <p>{{ $ac->ac->acFullName }}</p>
                            </div>

                            <div class="col-12">
                                <label for="daya_pk" class="form-label">Daya PK</label>
                                <p>{{ $ac->ac->pk }}</p>
                            </div>

                            <div class="col-12">
                                <label for="jenis_freon" class="form-label">Tipe Refrigrant</label>
                                <p>{{ $ac->ac->freon_type }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-primary-blue ">Tambah History Layanan</p>
                <div class="card card-homepage">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <input type="hidden" name="ac_customer" value="{{ $qr->master_ac_customer_id }}">
                                <label for="orders" class="form-label">Order Number</label>
                                <select name="order" id="order" class="form-control" required>
                                    <option value="">Pilih Order</option>
                                    @foreach ($orders as $order)
                                        <option value="{{ $order->id }}">{{ $order->order_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="" class="form-label">Layanan Service</label>
                            </div>
                            <div class="col-12">
                                <div class="row g-2 layanan">

                                </div>
                            </div>
                            {{-- <div class="col-12">
                                <label for="Service Selanjutnya" class="form-label">Servis selanjutnya</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="next_service" min="0" required
                                        placeholder="Service Selanjutnya" />
                                    <div class="input-group-text">Hari</div>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark-blue w-100">Submit</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('js')
    <script>
        $('#order').change(function(e) {
            e.preventDefault();
            let order = $(this).val();
            $('.layanan').html('');
            if (order) {
                // Show loading indicator
                $('.layanan').html('<div class="loading">Loading...</div>');

                $.ajax({
                    url: '{{ route('technician.ajax.get_service_counts') }}',
                    method: 'POST',
                    data: {
                        order_id: order,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        let no = 0;
                        let html = '';
                        $.each(response, function(key, value) {
                            html += `
            <div class="col-12 form-check">
              <input type="checkbox" class="form-check-input" id="serviceCheck${no}" name="service[]" value="${value.order_detail_id}">
              <label class="form-check-label" for="serviceCheck${no}">${value.service_name} ( jumlah :${value.count})</label>
            </div>
          `;
                            no++;
                        });
                        $('.layanan').html(html);
                    },
                    error: function(error) {
                        // Handle any error that occurred during the request
                        console.error(error);
                    },
                    complete: function() {
                        // Hide loading indicator
                        $('.layanan .loading').remove();
                    }
                });
            }
        });
    </script>
@endsection
