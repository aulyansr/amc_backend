<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <title>AMC | Aircon Management Company</title>
    @if (env('APP_ENV') === 'production')
        <meta name="description"
            content="AMC bukan merupakan servis AC biasa, dan kami berkomitmen untuk memberikan anda lebih dari yang lain. Anda">
        <meta name="keywords" content="perbaikan AC, Servis AC, indonesia">
        <meta name="author" content="AMC | Aircon Management Company">

        {{-- google analytic --}}
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-RYGJYH5244"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-RYGJYH5244');
        </script>


        <!-- Open Graph Meta Tags for Social Sharing -->
        <meta property="og:title" content="AMC | Aircon Management Company">
        <meta property="og:site" content="@AMC">
        <meta property="og:site_name" content="AMC | Aircon Management Company">
        <meta property="og:description"
            content="            akan bertemu dengan teknisi yang lebih ramah dan berpengalaman, dengan fleksibilitas dan kapasitas yang anda">
        <meta property="og:image" content="{{ asset('assets/image/logo.png') }}">
        <meta property="og:url" content="https://www.acmaintenance.id">
        <meta property="og:type" content="website">

        <!-- Twitter Card Meta Tags for Social Sharing -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="amc">
        <meta name="twitter:site" content="@amc">
        <meta name="twitter:site_name" content="AMC | Aircon Management Company">
        <meta name="twitter:description" content="            butuhkan.">
        <meta name="twitter:image" content="{{ asset('assets/image/logo.png') }}">
        <meta name="twitter:creator" content="@amc">
        <!-- Canonical Link to Avoid Duplicate Content -->
        <link rel="canonical" href="https://www.acmaintenance.id/">

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="57x57" href="{{ 'assetassets/>favico/apple-icon-57x57.png' }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/favico/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/favico/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/favico/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/favico/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/favico/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/favico/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/favico/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favico/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"
            href="{{ asset('assets/favico/android-icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favico/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favico/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favico/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('assets/favico/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#0077B6">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#0077B6">
    @endif
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @yield('css')
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MQLFSTETLC"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-MQLFSTETLC');
    </script>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container-xl">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/landing/images/Logo AMC Fixed.png') }}"
                    alt="AMC | Aircon Management Company">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse main-navbar" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.index') ? 'active' : '' }}"
                            aria-current="page" href="{{ route('landing.index') }}">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.about') ? 'active' : '' }}"
                            href="{{ route('landing.about') }}">ABOUT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.services') ? 'active' : '' }}"
                            href="{{ route('landing.services') }}">SERVICE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.contact') ? 'active' : '' }}"
                            href="{{ route('landing.contact') }}">CONTACT US</a>
                    </li>
                    <li class="nav-item">
                        @if (Auth::guard('customer')->check())
                            <a class="nav-link btn btn-blue text-white px-3 ms-2 py-2"
                                href="{{ route('customer.index') }}">ACCOUNT</a>
                        @else
                            <a class="nav-link btn btn-blue text-white px-3 ms-2 py-2"
                                href="{{ route('customer.showlogin') }}">LOGIN</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- navbar -->

    @yield('content')

    <!-- footer -->
    <footer>
        <div class="container-xl">
            <div class="row align-items-center">

                <div class="col-md-4">
                    <img src="{{ asset('assets/landing/images/logo-amc-putih.png') }}" alt="amc">
                </div>
                <div class="col-md-8">
                    <div class="row justify-content-between">
                        <div class="col-md-4">
                            <div class="d-block same-height-footer mb-3">
                                <h3>Head Office</h3>
                                <ul class="fa-ul">
                                    <li class="mb-3">
                                        <span class="fa-li">
                                            <i class="fas fa-map-pin text-white"></i>
                                        </span>
                                        Jl. Taman Daan Mogot Raya No.17, RT.2/RW.1, Tj. Duren Utara, Kec. Grogol
                                        petamburan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11470
                                    </li>
                                </ul>
                            </div>

                            <div class="d-block same-height-footer mb-3">
                                <h3>We are Socials</h3>
                                <ul class="nav">
                                    <li class="nav-item ms-0 ">
                                        <a class="nav-link ps-0 text-white" aria-current="page"
                                            href="https://www.instagram.com/amc.idn/" target="_blank">
                                            <i class="fab fa-instagram fa-lg text-white"></i>
                                            @amc.idn
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-block same-height-footer mb-3">
                                <h3>Navigasi</h3>
                                <ul>
                                    <li class="mb-3"><a href="{{ route('landing.about') }}">About</a></li>

                                    <li class="mb-3"><a href="{{ route('landing.services') }}">Service</a></li>

                                    <li class=""><a href="{{ route('landing.contact') }}">Contact Us</a></li>

                                </ul>
                            </div>
                            <div class="d-block same-height-footer mb-3">
                                <h3>Informasi </h3>
                                <ul class="fa-ul">
                                    <li class="mb-3">
                                        <a href="mailto:hello@amc.id">
                                            <span class="fa-li">
                                                <i class="far fa-envelope text-white"></i>
                                            </span>
                                            hello@acmaintenance.id
                                        </a>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fa-li">
                                            <i class="fas fa-phone-alt text-white"></i>
                                        </span>
                                        +62 852-1063-2227
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-12">
                    <p class="text-center copyright">
                        © 2023 Copyright by Aircon Management Company. All rights reserved
                    </p>
                </div>

            </div>
        </div>
    </footer>
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
    <script src="{{ asset('assets/landing/js/main.js?v=2') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @if (env('APP_ENV') === 'production')
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "ProfessionalService",
            "name": "AMC | Aircon Management Company",
            "image": "https://acmaintenance.id/assets/landing/images/Logo%20AMC%20Fixed.png",
            "@id": "https://acmaintenance.id/",
            "url": "https://acmaintenance.id/",
            "telephone": "085210632227",
            "priceRange": "95000",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "2, Jl. Taman Daan Mogot Raya No.17, RT.2/RW.1",
                "addressLocality": "Jakarta Barat",
                "postalCode": "11470",
                "addressCountry": "ID"
            },
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": -6.168973899718714,
                "longitude": 106.78427530312827
            },
            "openingHoursSpecification": {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                    "Monday",
                    "Tuesday",
                    "Wednesday",
                    "Thursday",
                    "Friday",
                    "Saturday"
                ],
                "opens": "08:00",
                "closes": "18:00"
            }
        }

    </script>
    @endif
    @yield('modal_order')
    @yield('js')
</body>
</body>

</html>
