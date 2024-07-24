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
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />
    <style>
        #map {
            height: 500px;
        }
    </style>
    @yield('css')

<body>

    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 mt-3 text-gray-800">Maps Using Leaflet</h1>

        <div class="row">
            <div class="col-12">

                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Test Search Maps or Get current location </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-12">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

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
    @yield('modal_order')
    @yield('js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet-src.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script src="https://unpkg.com/leaflet-geosearch@3.11.0/dist/geosearch.umd.js"></script>
    <script>
        var map = L.map('map').setView([-6.218839348393466, 106.84869318299677], 22);

        L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);
        const provider = new GeoSearch.OpenStreetMapProvider({
            params: {
                email: 'john@example.com', // auth for large number of requests
            },
        });
        var marker = null;
        const search = new GeoSearch.GeoSearchControl({
            provider: provider,
            style: 'bar',
            marker: {
                // optional: L.Marker    - default L.Icon.Default
                icon: new L.Icon.Default(),
                draggable: true,

            },
        });

        map.addControl(search);
        map.on('geosearch/showlocation', (data) => {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = data.marker;
            findAddress(marker.lat, marker.lng);
        });
        // Event listener for marker click
        map.on('click', function(event) {
            if (marker) {
                // Remove the existing marker if any
                map.removeLayer(marker);
            }

            // Create a new marker at the clicked location
            marker = L.marker(event.latlng, {
                draggable: true
            }).addTo(map);

            // Event listener for marker dragend

            var markerLatLng = marker.getLatLng();
            findAddress(markerLatLng.lat, markerLatLng.lng);


            marker.on('dragend', function(event) {
                if (marker) {
                    var markerLatLng = marker.getLatLng();
                    map.setView(markerLatLng, map.getZoom());
                    findAddress(markerLatLng.lat, markerLatLng.lng);
                }
            });
            // Change the map view to the marker's location
            map.setView(marker.getLatLng(), map.getZoom());
        });

        function findAddress(lat, lng) {
            let address =
                `https://api.distancematrix.ai/maps/api/geocode/json?latlng=${lat},${lng}&key={{ env('DISTANCE_MATRIX_KEY') }}`;
            fetch(address)
                .then(response => response.json())
                .then(data => {
                    // Handle the response data
                    console.log(data);
                })
                .catch(error => {
                    // Handle any errors
                    console.error(error);
                });
        }
    </script>
</body>
</body>

</html>
