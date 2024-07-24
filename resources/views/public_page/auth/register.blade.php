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

    <div class="d-block">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="hv-100 d-flex align-items-center justify-content-center">
                    <div class="p-2 p-lg-5">
                        <img src="{{ asset('assets/landing/images/Logo_AMC_Fixed.png') }}" alt="amc"
                            class="d-block mw-100  my-3 ">
                        <h1 class="text-primary-blue">Register Sekarang</h1>
                        <p>Sudah Punya akun? <a href="{{ route('customer.login') }}" class="text-primary-blue">Login</a>
                        </p>
                        <form class="mb-3" method="POST" action="{{ route('customer.register') }}">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" id="full_name"
                                    aria-describedby="nameHelp">
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" pattern="[0-9]+"
                                    title="Nomor HP Harus angka" id="phone_number" aria-describedby="phoneHelp">
                                <div id="emailHelp" class="form-text">We'll never share your phone number with anyone
                                    else.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    aria-describedby="emailHelp">

                            </div>
                            <button type="submit" class="btn btn-dark-blue ">Register</button>
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
                                        href="https://api.whatsapp.com/send?phone=6285210632227" target="_blank">
                                        <i class="fab fa-whatsapp"></i>
                                        AMC Customer Care
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-md-6 d-none d-md-block">
                <div class="bg-login"></div>
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

</body>
</body>

</html>
