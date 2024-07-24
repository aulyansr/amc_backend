   @extends('layouts.screen_technician')
   @section('css')
   @endsection
   @section('content')
       <section class="content-tch">
           <div class="container">
               <div class="text-center">
                   <h1>Upload Bukti Perbaikan</h1>
                   <h3 class="fw-100 fs-4 text-primary-blue mb-5">Pilih Jenis Perbaikan</h3>
               </div>
               <p></p>
               @foreach ($repair_types as $type)
                   <a href="{{ route('technician.create_repair_document', ['type' => $type->id, 'order_id' => request()->query('order_id')]) }}"
                       class="btn btn-blue w-100 mb-3 fs-title">
                       {{ $type->title }}
                   </a>
               @endforeach


           </div>
       </section>
   @endsection
   @section('js')
   @endsection
