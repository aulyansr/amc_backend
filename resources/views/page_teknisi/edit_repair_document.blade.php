@extends('layouts.screen_technician')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .dropify-wrapper .dropify-message p {
            margin: 5px 0 0;
            font-size: 20px;
        }
    </style>
@endsection
@section('content')
    <section class="content-tch">
        <div class="container">
            <h1 class="fs-2 text-center">{{ $repair_type->title }}</h1>
            <div class="text-center">
                ref_no: {{ $order->ref_no }} | Customer: {{ $order->customer->nama }}
            </div>

            <div class="my-5">
                {!! Form::open([
                    'route' => ['technician.update_repair_document', $repair_document_id],
                    'method' => 'PUT',
                    'enctype' => 'multipart/form-data',
                ]) !!}
                {{ csrf_field() }}
                {{ Form::hidden('id', $repair_document_id->id) }}
                {{ Form::hidden('order_id', $order->id) }}
                {{ Form::hidden('repair_attachment_id', $repair_type->id) }}

                @foreach ($repair_type->items as $index => $item)
                    <div class="my-2">
                        <h3 class="fw-bold fs-5 mb-3">
                            Upload {{ $item->title }}
                        </h3>

                        @foreach ($repair_document_id->items->where('repair_attachment_item_id', $item->id) as $documentItem)
                            {{ Form::hidden('repairs[' . $index . '][id]', $documentItem->id) }}
                            {{ Form::hidden('repairs[' . $index . '][repair_attachment_item_id]', $item->id) }}
                            {{ Form::file('repairs[' . $index . '][image]', ['class' => 'dropify', 'data-default-file' => $documentItem->image]) }}

                            <!-- Add any additional fields related to the item here -->
                        @endforeach
                    </div>
                @endforeach


                {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.dropify').dropify();
    </script>
@endsection
