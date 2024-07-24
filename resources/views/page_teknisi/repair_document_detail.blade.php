    @extends('layouts.screen_technician')
    @section('css')
    @endsection
    @section('content')
        <section class="content-tch">
            <div class="container">
                <h1 class="fs-2 text-center">{{ $doc->repair_type->title }}</h1>

                @foreach ($doc->repair_type->items as $index => $item)
                    <div class="my-5">
                        <h3>{{ $item->title }}</h3>
                        <img src="{{ $item->image }}" alt="" width="100%">
                    </div>
                @endforeach

                <a href="{{ route('technician.edit_repair_document', $doc->id) }}" class="btn btn-primary">
                    Ubah Foto
                </a>
            </div>
        </section>
    @endsection
    @section('js')
    @endsection
