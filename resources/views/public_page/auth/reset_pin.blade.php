<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <title>AMC</title>

    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <!-- font awesome -->
    <link rel="stylesheet" href="{{ asset('assets/landing/font/fontAwesome/all.min.css') }}" />
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <!-- swipper -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/swiper.min.css') }}">
    <!-- Custom Scrollbar -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/jquery.mCustomScrollbar.min.css') }}">
    <!-- nice select -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/nice-select.css') }}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('assets/landing/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing/css/responsive.css') }}">
</head>

<body>

    <div class="d-block bg-gray">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-6">
                <div class="vh-100 d-flex align-items-center justify-content-center">
                    <div class="card rounded-5 border-0 shadow">
                        <div class="card-body">
                            <div class="p-2 p-lg-5 text-center">
                                <img src="{{ asset('assets/landing/images/Logo_AMC_Fixed.png') }}" alt="amc"
                                    class="mw-100  my-3 ">
                                <h1 class="text-primary-blue">Verifikasi Handphone</h1>
                                <p>Silahkan Masukkan nomer HP anda untuk melakukan reset PIN, pastikan nomor Handphone
                                    Anda sudah
                                    diverifikasi.</p>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                @endif
                                <form class="my-3" method="POST" action="{{ route('customer.forgot.update_pin') }}">
                                    @csrf
                                    <input type="hidden" value="{{ $token }}" name="token" id="token">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">No HP</label>
                                        {{ Form::text('phone', null, ['class' => 'form-control', 'onkeyup' => 'return isNumber(event)']) }}
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label class="form-label" for="pin">PIN Baru</label>
                                            {{ Form::password('pin', ['class' => 'form-control', 'maxlength' => '6', 'minlength' => '6', 'pattern' => '\d{6}', 'title' => 'PIN harus 6 digit angka']) }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label class="form-label" for="pin_confirmed">Konfirmasi PIN
                                                Baru</label>
                                            {{ Form::password('pin_confirmed', ['class' => 'form-control', 'maxlength' => '6', 'minlength' => '6', 'pattern' => '\d{6}', 'title' => 'PIN harus 6 digit angka']) }}
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-dark-blue ">Reset PIN</button>
                                </form>
                                <div class="d-block mt-5">
                                    <p>Butuh Bantuan ?</p>
                                    <ul class="list-group list-group-horizontal  justify-content-center">
                                        <li class="me-3">
                                            <a class="nav-link ps-0 text-primary-blue" aria-current="page"
                                                href="https://www.instagram.com/amc.idn/" target="_blank">
                                                <i class="fab fa-instagram"></i>
                                                @amc.idn
                                            </a>
                                        </li>
                                        <li class="me-3">
                                            <a class="nav-link ps-0 text-primary-blue" aria-current="page"
                                                href="https://api.whatsapp.com/send?phone=6285210632227"
                                                target="_blank">
                                                <i class="fab fa-whatsapp"></i>
                                                AMC Customer Care
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- jawa script -->
    <!-- jquery -->
    <script src="{{ asset('assets/landing/js/jquery-3.6.1.slim.min.js') }}"></script>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
    </script>
    <!-- swipper -->
    <script src="{{ asset('assets/landing/js/swiper.min.js') }}"></script>
    <!-- nice select -->
    <script src="{{ asset('assets/landing/js/jquery.nice-select.min.js') }}"></script>
    <!-- custom Scrollbar -->
    <script src="{{ asset('assets/landing/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- matchheight -->
    <script src="{{ asset('assets/landing/js/jquery.matchHeight-min.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/landing/js/main.js') }}"></script>

    <script>
        function isNumber(event) {
            var keyCode = event.which ? event.which : event.keyCode;
            if (!(keyCode >= 48 && keyCode <= 57) && !(keyCode >= 96 && keyCode <= 105)) {
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
