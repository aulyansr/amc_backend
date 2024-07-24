@extends('layouts.screen_technician')

@section('css')
    <style>
        .dropzone {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }

        .dropzone.highlight {
            border-color: #66ccff;
        }

        .dropzone-text {
            font-size: 18px;
        }

        .file-list {
            margin-top: 20px;
        }

        .file-list-item {
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('content')
    <section class="content-tch">
        <div class="container">
            <div class="row gy-3">
                <div class="col-12">
                    <p class="text-primary-blue">Customer</p>
                    <div class="card card-homepage">
                        <div class="card-body">
                            <div class="row g-2 mb-2 align-items-center">
                                <div class="col-12">
                                    <div class="row g-3 justify-content-between align-content-center">
                                        <div class="col-auto">
                                            <h1 class="text-primary-blue fs-4">{{ $order->customer->nama }}</h1>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge bg-primary">{{ $order->service_group?->name }}</span>
                                        </div>
                                    </div>
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
                            </ul>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $order->address->address_detail }}"
                                class="btn btn-success w-100" target="_blank">
                                Lihat Lokasi di Peta
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-primary-blue">Upload Foto Tiba di Lokasi</p>
                    <div class="card card-homepage mb-3">
                        <div class="card-body">
                            <form action="{{ route('technician.upload_location_image', $order->id) }}" class="dropzone"
                                id="imageUpload" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="fallback">
                                    <input name="file" type="file" value="{{ $order->location_image }}" />
                                </div>

                                <ul class="file-list" id="fileList"></ul>
                            </form>
                        </div>
                    </div>
                    {{-- untuk order dengan tipe service  --}}
                    <div class="row">
                        <div class="col">

                            <button type="button" class="w-100 btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#pendingOrder">Tunda</button>

                        </div>
                        <div class="col">
                            <form action="{{ route('technician.update_start_work', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-100 btn btn-blue">Mulai Pekerjaan</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="modal" id="pendingOrder">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Alasan Penangguhan Pekerjaan</h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('technician.pending_order', $order->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Pilih alasan penangguhan pekerjaan:</p>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="reason1" name="reason"
                                value="Menuggu Spare Part">
                            <label class="form-check-label" for="reason1">Menunggu Spare Part</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="reason2" name="reason"
                                value="Customer Tidak bisa dihubungi">
                            <label class="form-check-label" for="reason2">Customer Tidak bisa dihubungi</label>
                        </div>
                        <div class="form-check mb-3">
                            <input type="radio" class="form-check-input" id="reason3" name="reason" value="lainnya">
                            <label class="form-check-label" for="reason3">Lainnya</label>
                        </div>
                        <div class="form-group">
                            <label for="reasonDescription">Deskripsi:</label>
                            <textarea class="form-control" name="reasonDescription" id="reasonDescription" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" id="tundaBtn">Tunda Pekerjaan</button>
                    </div>
                </form>

                <!-- Modal Footer -->

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        Dropzone.options.imageUpload = {
            acceptedFiles: ".jpeg,.jpg,.png,.gif", // Allow only files with these extensions
            defaultImage: "{{ asset('assets/images/contact-center.png') }}", // Set the URL of the default image
            // addRemoveLinks: true, // Add remove links for each file
            init: function() {
                @if ($order->location_image)
                    var existingFile = {
                        name: "{{ $order->location_image }}",
                        size: 12345
                    }; // Replace with actual file name and size
                    this.emit("addedfile", existingFile);
                    this.emit("thumbnail", existingFile,
                        "{{ asset('storage/images/orders/location/' . $order->location_image) }}");
                @endif
                this.on("getQueuedFiles", function(file) {
                    alert("Added file.");
                });
            },
            success: function(file, response) {
                console.log(response); // Handle success response
            },
            error: function(file, response) {
                console.error(response); // Handle error response
            }
        };
        // console.log(Dropzone);
        var queuedFiles = Dropzone.getUploadingFiles;
        console.log(queuedFiles);
    </script>
@endsection
