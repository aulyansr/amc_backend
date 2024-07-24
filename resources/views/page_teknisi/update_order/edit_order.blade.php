@extends('layouts.screen_technician')

@section('css')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .services-title {
            font-size: 18px;
            margin-bottom: 0;
            font-weight: 500;
        }

        .btn-indecator {
            background-color: #09557F;
            display: flex;
            align-items: center;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 100%;
            padding: 15px;
            align-content: center;
            justify-content: center;
        }

        .input-quantity {
            width: 50px;
            text-align: center;
            margin: 0 20px
        }

        .select2-container .select2-selection--multiple .select2-selection__rendered {
            display: none;
        }

        .selected-value {
            margin: 10px 0;
            color: #0077B6;
        }

        .selected-value button {
            /* background: transparent; */
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

        .rounded-full {
            border-radius: 100%;
        }
    </style>
@endsection

@section('content')
    <section class="content-tch">
        <div class="container">
            <div class="row gy-3">

                <div class="col-12">
                    <div class="row g-3 justify-content-between mb-3">
                        <div class="col-auto">
                            <p class="text-primary-blue ">Customer</p>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-info">Cleaning</span>
                        </div>
                    </div>
                    <div class="card card-homepage">
                        <div class="card-body">
                            <div class="row g-2 mb-2 align-items-center">
                                <div class="col-12">
                                    <h1 class="text-primary-blue fs-4">{{ $order->customer->nama }}</h1>
                                </div>
                            </div>
                            <hr>
                            <ul class="fa-ul mb-3">
                                <li class="my-2">
                                    <span class="fa-li">
                                        <i class="fas fa-map-marker-alt text-primary-blue"></i>
                                    </span>
                                    <p style="font-size: 18px;font-weight: 700;">
                                        <span id="address">{{ $order->address->address_detail }}</span>
                                    </p>
                                </li>
                                <li class="my-2">
                                    <span class="fa-li">

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <form action="{{ route('technician.update_order', $order->id) }}" method="POST">
                    <p class="text-primary-blue mb-0 fw-bold fs-5">Pilih Pekerjaan</p>
                    <div class="col-12">
                        <div class="card card-homepage">
                            <div class="card-body">
                                @csrf
                                <select id="mySelect" name="service[]" class="js-example-basic-multiple"
                                    multiple="multiple" style="width: 300px;">
                                    @foreach ($services as $key => $value)
                                        <option value="{{ $value->id }}" data-price="{{ $value->price }}">
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="selectedValues"></div>


                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <button type="submit" class="w-100 btn btn-primary">Update</button>
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
                    var id = $(this).val(); // Get the text of the selected option
                    var inputType = $(this).attr('data-type'); // Get the input type attribute

                    // Create the appropriate input element based on the input type
                    var inputElement = $('<div>').addClass(
                            'd-flex align-items-center justify-content-between mb-4')
                        .append(
                            $('<span>').addClass('text-zinc-700').text('Jumlah'),
                            $('<div>').addClass('d-flex align-items-center').append(
                                $('<button>').addClass(
                                    'rounded-circle btn-indecator'
                                ).text('-').click(function() {
                                    event.preventDefault();
                                    // Decrease quantity
                                    var currentValue = parseInt($(this).siblings('input').val());
                                    if (currentValue > 1) {
                                        $(this).siblings('input').val(currentValue - 1);
                                    }
                                }),
                                $('<input>').attr('type', 'number').addClass('form-control input-quantity')
                                .attr('name',
                                    'jumlah[' + id + ']').val(1),
                                $('<button>').addClass(
                                    'rounded-circle btn-indecator'
                                ).text('+').click(function() {
                                    event.preventDefault();
                                    // Increase quantity
                                    var currentValue = parseInt($(this).siblings('input').val());
                                    $(this).siblings('input').val(currentValue + 1);
                                })
                            )
                        );


                    var removeButton = $('<button>').addClass('remove-button btn btn-danger w-100').click(
                        function() {
                            // Remove the value from select element
                            var selectElement = $('#mySelect');
                            var valueToRemove = $(this).closest('.selected-value').find('p').text()
                                .trim();

                            selectElement.find('option:contains(' + valueToRemove + ')').prop(
                                'selected', false); // Deselect the option
                            selectElement.trigger(
                                'change'); // Trigger change event to update Select2 dropdown
                            $(this).closest('.selected-value')
                                .remove(); // Remove the selected value from display
                        });

                    removeButton.append("Hapus");

                    // Append the input element and remove button to the selected values display
                    $('#selectedValues').append($('<div class="selected-value">').append($(
                        '<p class="services-title">').text(
                        value)).append(inputElement).append(removeButton).append($('<hr>')));
                });
            }


        });
    </script>
@endsection
