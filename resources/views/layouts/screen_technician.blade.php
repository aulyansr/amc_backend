<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
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
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    @yield('css')

<body class="mobile-screen">
    <!-- navbar -->
    <section id="top_bar_mobile">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="">
                    <img src="{{ asset('assets/landing/images/Logo AMC Fixed.png') }}" alt="amc" class="logo">
                </a>
                <a href="https://wa.me/6282260007198" target="_blank">
                    <img src="{{ asset('assets/landing/images/chat-text-fill.png') }}" alt="amc" class="ic_chat">
                </a>
            </div>
        </div>
    </section>
    <!-- navbar -->
    <section class="running-text-container">

        <div class="running-text d-flex">
            <p>Jangan Lupa Mengembalikan Alat Kerja dan Spare Part Kembali ke HUB</p>
        </div>

    </section>

    @yield('content')

    <!-- footer -->
    <div class="main-menu-mobile">
        <div class="d-block">
            <div class="row g-0">
                <div class="col">
                    <a href="{{ route('technician.home') }}"
                        class="nav-item{{ request()->routeIs('technician.home') ? ' active' : '' }}">
                        <div class="d-block">
                            <img src="{{ asset('assets/landing/images/ic_navbar_home.png') }}" alt="amc"
                                class="mw-100">
                            <span>Home</span>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('technician.orders') }}"
                        class="nav-item{{ request()->routeIs('technician.orders') ? ' active' : '' }}">
                        <div class="d-block">
                            <img src="{{ asset('assets/landing/images/ic_navbar_order.png') }}" alt="amc"
                                class="mw-100">
                            <span>Order</span>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('technician.qr') }}"
                        class="nav-item{{ request()->routeIs('technician.qr') ? ' active' : '' }}">
                        <div class="d-block">
                            <img src="{{ asset('assets/landing/images/ic_navbar_qr.png') }}" alt="amc"
                                class="mw-100">
                            <span>Scan</span>
                        </div>
                    </a>
                </div>
                <div class="col">

                    <form id="logout-form" action="{{ route('technician.logout') }}" method="POST">
                        @csrf
                    </form>
                    <a href="{{ route('logout') }}"
                        class="nav-item{{ request()->routeIs('technician.profile') ? ' active' : '' }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <div class="d-block">
                            <img src="{{ asset('assets/landing/images/ic_navbar_account.png') }}" alt="amc"
                                class="mw-100">
                            <span>Logout</span>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- footer -->

    <!-- jawa script -->
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @include('sweetalert::alert')
    @yield('modal_order')
    @yield('js')
</body>

</html>
