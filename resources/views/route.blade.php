<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Rute</title>

    {{-- untuk cdn yang di load pada view RouteSpot ini selain cdn dari leaflet js dan leflet fullscreen
    kita juga me-load cdn leaflet routing machine untuk menampilkan rute dari lokasi kita ke lokasi spot
    yang kita pilih --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>

    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css'
        rel='stylesheet' />
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>

    <style>
        #map {
            height: 100vh;
            z-index: 0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">Laravel SIG</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" aria-current="page" href="/admin/dashboard">Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </section>
    <script>
        var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            mbUrl =
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicmVvbmFsZGkxNSIsImEiOiJjbHIydWN4Z2oxNW1rMnhsbWpoYW5lbDIwIn0._QV7HJJnzCin4a0O6VExWQ';

        var satellite = L.tileLayer(mbUrl, {
                id: 'mapbox/satellite-v9',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            }),
            dark = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: mbAttr
            }),
            streets = L.tileLayer(mbUrl, {
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            });

        if (!navigator.geolocation) {
            console.log("Browser doesn't support");
        } else {
            console.log(navigator.geolocation.getCurrentPosition(getPosition));
        }

        var data{{ $spots->id }} = L.layerGroup();

        // fungsi ini untuk menampilkan map secara penuh pada browser
        var map = L.map('map', {
            center: [{{ $spots->location }}],
            fullscreenControl: {
                pseudoFullscreen: false
            },
            zoom: 10,
            layers: [dark, data{{ $spots->id }}]
        });

        // mengatur baselayer
        var baseLayers = {
            "Streets": dark,
            "Streets2": streets,
            "Satellite": satellite,
        };

        // mengatur overlayers
        var overlays = {
            "{{ $spots->name }}": data{{ $spots->id }},
        };

        L.control.layers(baseLayers, overlays).addTo(map);
        L.marker([{{ $spots->location }}]).bindPopup(
            "<div class='my-2'><img src='{{ Storage::url($spots->image) }}' class='img-fluid'></div>" +
            "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $spots->name }}</div>" +
            "<div class='my-2'><a href='/spot/{{ $spots->id }}' class='btn btn-outline-success btn-sm'>Detail Spot</a></div>"
        ).addTo(map);

        var marker, circle, latPos, longPos

        function getPosition(position) {

            var latPos = position.coords.latitude
            var longPos = position.coords.longitude
            var accuracy = position.coords.accuracy

            if (marker) {
                map.removeLayer(circle)
            }

            marker = L.marker([latPos, longPos])
            circle = L.circle([latPos, longPos]), {
                radius: accuracy
            }

            var featureGroup = L.featureGroup([marker, circle])
                .bindPopup("<div class='text-center'><p><b>Lokasi Kamu Disini</b></p></div>")
                .addTo(map)
            map.fitBounds(featureGroup.getBounds())

            L.Routing.control({
                waypoints: [
                    L.latLng(latPos, longPos),
                    L.latLng({{ $spots->location }}),
                ],

                lineOptions: {
                    styles: [{
                        color: 'green',
                        opacity: 1,
                        weight: 3
                    }]
                },
                createMarker: function() {
                    return null
                }
            }).addTo(map);

        }
    </script>
</body>

</html>
