<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Welcome</title>

    <!-- {{-- cdn css leaflet  --}} -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

    <!-- {{-- cdn js leaflet --}} -->
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>

    <!-- {{-- cdn leaflet fullscreen js dan css --}} -->
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css'
        rel='stylesheet' />

    <!-- cdn leafle current location -->
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.css"
        rel="stylesheet">



    <style>
        #map {
            height: 100vh;
            width: 100%;
        }

        .leaflet-control-search .search-control {
            width: 250px;
        }

        .leaflet-control-search .search-input {
            width: 250px;
            height: 30px;
            padding: 7px;
            font-size: 14px;
        }

        .leaflet-control-search .search-tooltip {
            width: 292px;
            background-color: #ffffff;
        }

        @media (min-width: 768px) {
            .leaflet-control-search input[type=text] {
                display: block !important;
            }
        }

        .leaflet-control-search .search-tip {
            background-color: #F7FAFC;
        }

        .leaflet-control-search .search-button {
            margin-top: 6px;
            margin-bottom: 4px;
            margin-left: 3px;
            margin-right: 3px;
            width: 32px;
            height: 29px;
            font-size: 20px;
        }

        .leaflet-control-search .search-cancel {
            margin-top: 10px;
            margin-bottom: 4px;
            margin-left: 3px;
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .leaflet-control-search .search-control {
                width: 200px;
            }

            .leaflet-control-search .search-input {
                width: 200px;
                height: 30px;
                padding: 7px;
                font-size: 14px;
            }

            .leaflet-control-search .search-tooltip {
                width: 242px;
                background-color: #ffffff;
            }
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
            dark = L.tileLayer(mbUrl, {
                id: 'mapbox/dark-v10',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            }),
            streets = L.tileLayer(mbUrl, {
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            });

        var map = L.map('map', {

            zoomControl: false,
            center: [-6.294875476718384, 106.58278553898865],
            zoom: 18,
            layers: [streets]
        });

        var baseLayers = {
            "Satellite": satellite,
            "Streets": streets,
            "Grayscale": dark,
        };

        var overlays = {
            "Streets": streets,
            "Satellite": satellite,
            "Grayscale": dark,
        };

        L.control.zoom({
            position: 'bottomright' // Set the position to bottom right
        }).addTo(map);

        // Get the zoom control element
        var zoomControl = document.getElementsByClassName('leaflet-control-zoom')[0];

        // Add a margin-bottom to the zoom control
        zoomControl.style.marginBottom = '40px';

        L.control.fullscreen({
            position: 'bottomright'
        }).addTo(map);

        var lc = L.control
            .locate({
                position: 'bottomright',
                strings: {
                    title: "Show me where I am, yo!"
                }
            })
            .addTo(map);

        var myIcon = L.icon({
            iconUrl: 'icon/location.svg',
            iconSize: [30, 40],
            iconAnchor: [20, 45],
            // size of the icon
        });

        @foreach ($spots as $item)
            L.marker([{{ $item->location }}], {
                    icon: myIcon
                })
                .bindPopup(
                    "<div class='my-2'><img src='{{ Storage::url($item->image) }}' class='img-fluid' width='700px'></div>" +
                    "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->name }}</div>" +

                    "<div class='my-2'><a href='' class='btn btn-outline-primary btn-sm'>Lihat Rute</a> <a href='' class='btn btn-outline-success btn-sm'>Detail Spot</a></div>" +
                    "<div class='my-2'></div>"

                ).addTo(map);
        @endforeach

        var datas = [
            @foreach ($spots as $key => $value)
                {
                    "loc": [{{ $value->location }}],
                    "title": '{!! $value->name !!}'
                },
            @endforeach

        ];

        var markersLayer = new L.LayerGroup();
        map.addLayer(markersLayer);

        for (i in datas) {


            var title = datas[i].title,
                loc = datas[i].loc,
                marker = new L.Marker(new L.latLng(loc), {
                    title: title,
                    icon: myIcon
                });
            markersLayer.addLayer(marker);

            // melakukan looping data untuk memunculkan popup dari spot yang dipilih
            @foreach ($spots as $item)
                L.marker([{{ $item->location }}], {
                        icon: myIcon
                    }, {
                        title: '{{ $item->title }}'
                    })
                    .bindPopup(
                        "<div class='my-2'><img src='{{ Storage::url($item->image) }}' class='img-fluid' width='700px'></div>" +
                        "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->name }}</div>" +

                        "<div class='my-2'><a href='{{ route('cek-rute', $item->id) }}' class='btn btn-outline-primary btn-sm'>Lihat Rute</a> <a href='/spot/{{ $item->id }}' class='btn btn-outline-success btn-sm'>Detail Spot</a></div>" +
                        "<div class='my-2'></div>"

                    ).addTo(map);
            @endforeach
        }

        L.control.layers(baseLayers, overlays).addTo(map);
    </script>
</body>

</html>
