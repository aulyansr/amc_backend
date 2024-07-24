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

    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/landing/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing/css/responsive.css') }}">
    @yield('css')


<body>

    <div class="d-block ">
        <nav class="nav-dashboard navbar navbar-expand-lg bg-white  d-block d-md-none ">
            <div class="container-xl">
                <a class="navbar-brand" href="/index.html">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="AMC">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('customer.index') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('customer.index') }}">
                                <i class="fas fa-tachometer-alt me-3"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('customer.list_order') ? 'active' : '' }}"
                                href="{{ route('customer.list_order') }}">
                                <i class="fas fa-shopping-basket me-3"></i> Order
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('customer.alamat.index') ? 'active' : '' }}"
                                href="{{ route('customer.alamat.index') }}">
                                <i class="fas fa-map-marker-alt me-3"></i> Alamat
                            </a>
                        </li>
                        <li class="nav-item position-relative">

                            <a class="nav-link {{ Str::startsWith(request()->path(), 'customer/profile') ? 'active' : '' }}"
                                href="{{ route('customer.profile.index') }}">
                                <i class="fas fa-user-edit me-3"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://wa.me/6285210632227?text=Halo%20AMC,%20Saya%20ingin%20Service%20AC"
                                class="nav-link">
                                <i class="fas fa-question-circle me-3"></i> Hubungi Customer Service
                            </a>
                        </li>


                        <li class="nav-item">
                            <form action="{{ route('customer.logout') }}" id="customerLogout" method="POST">
                                @csrf
                            </form>
                            <a href="{{ route('customer.logout') }}" class="nav-link"
                                onclick="event.preventDefault();document.getElementById('customerLogout').submit();">
                                <i class="fas fa-sign-out-alt me-3"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>

        <div class="sidebar d-none d-md-block">
            <div class="brand-image">
                <img src="{{ asset('assets/landing/images/Logo AMC Fixed.png') }}" alt="amc"
                    class="mw-100 d-block m-auto">
            </div>
            <div class="profile">
                <h4>Hallo,
                    <b>{{ Auth::guard('customer')->user()->type == 1 ? Auth::guard('customer')->user()->company_name : Auth::guard('customer')->user()->name }}</b>
                </h4>
                <span class="text-muted">{{ Auth::guard('customer')->user()->phone }}</span>
            </div>
            <ul class="side-nav">
                <li>
                    <a href="" class="text-muted">
                        Overview
                    </a>
                </li>

                <li>
                    <a href="{{ route('customer.index') }}"
                        class="{{ request()->routeIs('customer.index') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt me-3"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.list_order') }}"
                        class="{{ Route::is(['customer.list_order', 'customer.order_detail']) ? 'active' : '' }}">
                        <i class="fas fa-shopping-basket me-3"></i> Order

                    </a>
                </li>

                <li>
                    <a href="#" class="text-muted">
                        Account
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.alamat.index') }}"
                        class="{{ Str::startsWith(request()->path(), 'customer/alamat') ? 'active' : '' }}">
                        <i class="fas fa-map-marker-alt me-3"></i> Alamat
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.profile.index') }}"
                        class="{{ Str::startsWith(request()->path(), 'customer/profile') ? 'active' : '' }}">
                        <i class="fas fa-user-edit me-3"></i> Profile
                    </a>
                </li>
                <li>
                    <a href="https://wa.me/6285210632227?text=Halo%20AMC,%20Saya%20ingin%20Service%20AC"
                        class="nav-link">
                        <i class="fas fa-question-circle me-3"></i> Hubungi Admin
                    </a>
                </li>
                <li>
                    <form action="{{ route('customer.logout') }}" id="customerLogout2" method="POST">
                        @csrf
                    </form>
                    <a href="{{ route('customer.logout') }}" class="nav-link"
                        onclick="event.preventDefault();document.getElementById('customerLogout2').submit();">
                        <i class="fas fa-sign-out-alt me-3"></i>
                        <span>Sign Out</span>
                    </a>
                </li>
            </ul>

        </div>

        <div class="content-page bg-gray">
            <!-- add content here -->
            @yield('content')
            <!-- add content here -->
        </div>
    </div>

    <!-- jawa script -->
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
    <script>
        function getThousandSeparator(val) {
            return Intl.NumberFormat('id-ID', {
                maximumFractionDigits: 2
            }).format(val);
        }

        function getInputComma(val) {
            if (val.charAt(val.length - 1) === ',' && val.split(',').length !== 3) {
                return val;
            } else if (val.charAt(val.length - 1) === '0' && val.charAt(val.length - 2) === ',' && val.split(',')
                .length !==
                3) {
                return val;
            } else {
                var val = val.replace(',', '.');
                return getThousandSeparator(val);
            }
        }
        $(document).on('keyup', '.number', function(e) {
            var n = $(this).val().replace(/[^\d,]/g, '');
            $(this).val(getInputComma(n));
        });
        $(".datetime-picker").flatpickr({
            enableTime: true,
            dateFormat: "d-m-Y H:i",
        });
        $('.select2').select2({
            placeholder: 'Silahkan Dipilih',
            theme: 'bootstrap-5',
        });
        $(".time-picker").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });
    </script>
    @yield('js')
</body>

</html>
