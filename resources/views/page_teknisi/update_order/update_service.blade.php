@extends('layouts.screen_technician')

@section('css')
    <style>
        .select2-container .select2-selection--multiple .select2-selection__rendered {
            display: none;
        }

        .selected-value {
            margin: 10px 0;
            color: #0077B6;
        }

        .selected-value button {
            background: transparent;
        }

        .close-icon {
            width: 20px
        }

        .select2-container--default .select2-selection--multiple {
            padding: 10px;
            border: 1px solid #0077B6;
            border-radius: 10px;
        }

        .select2-container--open .select2-dropdown--below {
            border: 1px solid #0077B6;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            margin-top: 20px;
            border-radius: 10px;
        }

        .select2-container--open li {
            padding: 10px;
        }
    </style>
@endsection

@section('content')
    <section class="content-tch">
        <div class="container">
            <div class="row gy-3">

                <div class="col-12">
                    <div class="d-flex justify-content-between mb-3">
                        <p class="text-primary-blue mb-0 fw-bold fs-5">Update Pengerjaan</p>
                        <span class="badge bg-primary"> Cleaning </span>
                    </div>
                    <div class="card card-homepage">
                        <div class="card-body">


                            <div class="d-flex justify-content-between">
                                <p class="text-primary-blue">Produk SKU</p>
                                <p class="fw-bold">{{ $qr->ac_customer->ac_name }}</p>
                            </div>

                            <div class="d-flex justify-content-between">
                                <p class="text-primary-blue">Jenis AC</p>
                                <p class="fw-bold">{{ $qr->ac_customer->ac->model }}</p>
                            </div>

                            <div class="d-flex justify-content-between">
                                <p class="text-primary-blue">Daya PK</p>
                                <p class="fw-bold">{{ $qr->ac_customer->ac->pk }} PK</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-primary-blue">Tipe Refrigrant</p>
                                <p class="fw-bold">{{ $qr->ac_customer->ac->freon_type }}</p>
                            </div>

                        </div>
                    </div>

                </div>

                <p class="text-primary-blue mb-0 fw-bold fs-5">Pilih Pekerjaan</p>
                <form action="{{ route('technician.store_service_ac', ['order' => $order->id, 'qr' => $qr->url_unique]) }}"
                    method="POST">
                    @csrf
                    <div class="col-12">
                        <div class="card card-homepage">
                            <div class="card-body">
                                <select id="mySelect" name="service[]" class="js-example-basic-multiple"
                                    multiple="multiple" style="width: 300px;">
                                    @if (!empty($order->serviceCounts))
                                        @foreach ($order->ServiceCountsWithStatus as $key => $value)
                                            <option value="{{ $value['order_detail_id'] }}">
                                                {{ $value['service_name'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div id="selectedValues"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-blue w-100">Mulai Pekerjaan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: 'Pilih Service'
            });

            $('#mySelect').on('change', function() {
                var selectedOptions = $(this).find('option:selected');
                displaySelectedValues(selectedOptions);
            });

            // Function to display selected values
            function displaySelectedValues(selectedOptions) {
                $('#selectedValues').empty();
                selectedOptions.each(function() {
                    var value = $(this).text(); // Get the text of the selected option
                    var removeButton = $('<button>').addClass('remove-button').click(function() {
                        // Remove the value from select element
                        var selectElement = $('#mySelect');
                        var valueToRemove = $(this).closest('.selected-value').text()
                            .trim(); // Get the text of value to remove
                        selectElement.find('option:contains(' + valueToRemove + ')').prop(
                            'selected', false); // Deselect the option
                        selectElement.trigger(
                            'change'); // Trigger change event to update Select2 dropdown
                        $(this).closest('.selected-value')
                            .remove(); // Remove the selected value from display
                    });
                    removeButton.append($('<img>').attr('src',
                            "{{ asset('assets/landing/images/close-icon.svg') }}").attr('alt', 'amc')
                        .addClass('close-icon'));
                    $('#selectedValues').append($('<div class="selected-value">').text(value).append(
                        removeButton));
                });
            }
        });
    </script>
@endsection
