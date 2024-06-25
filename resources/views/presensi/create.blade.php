@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>

    <style>
        .webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 15px;

        }

        #map {
            height: 200px;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection

@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            <input type="hidden" name="lokasi" id="lokasi">
            <div class="webcam-capture"></div>
        </div>

    </div>
    <div class="row">
        <div class="col">
            @if ($check > 0)
                <button id='takeabsen' class="btn btn-danger btn-block">
                    <ion-icon name="camera-outline"></ion-icon>
                    Absen Pulang</button>
            @else
                <button id='takeabsen' class="btn btn-primary btn-block">
                    <ion-icon name="camera-outline"></ion-icon>
                    Absen Masuk</button>
            @endif

        </div>

    </div>
    <div class="row mt-2">
        <div class="col">

            <div id="map"></div>
        </div>
    </div>
    <audio src="{{ asset('assets/audio/selamat_bekerja.mp3') }}" type="mpeg"  id="notifikasi_in"></audio>
    <audio src="{{ asset('assets/audio/hati_hati_dijalan.mp3') }}" type="mpeg"  id="notifikasi_out"></audio>
    <audio src="{{ asset('assets/audio/berada_diluar_radius.mp3') }}" type="mpeg"  id="diluar_radius"></audio>
@endsection

@push('myScript')
    <script>
        //mengatur tampilan webcame di browser
        Webcam.set({
            height: 480,
            width: 640,
            image_format: 'jpeg',
            jpeg_quality: 80,
        });

        var notifikasi_in = document.getElementById('notifikasi_in');
        var notifikasi_out = document.getElementById('notifikasi_out');
        var diluar_radius = document.getElementById('diluar_radius');
        //pengambilan gambar
        Webcam.attach('.webcam-capture');

        //pengambilan lokasi user dengan JavaScript
        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        } else {
            print("not supported");
            lokasi.value = "not supported";
        }

        function successCallback(position) {
            lokasi.value = position.coords.latitude + ', ' + position.coords.longitude;
            // pengambilan posisi camera map
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // membuat marker map
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

            // membuat bulatan merah map
            // #dirumah
            // var circle = L.circle([2.993583, 99.625632],
            // #dikantor
            // var circle = L.circle([2.9880866, 99.6228656],
            // #dimanapun berada
            var circle = L.circle([position.coords.latitude, position.coords.longitude],
            {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 10
            }).addTo(map);
        }

        function errorCallback() {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
            F
        }

        // fungsi tombol takeabsen
        $('#takeabsen').click(function(e) {
            Webcam.snap(function(uri) {
                image = uri;

            });
            var lokasi = $("#lokasi").val();
            $.ajax({
                type: "POST",
                url: "/presensi/store",
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    lokasi: lokasi,
                },
                cache: false,
                // pengambil response echo
                success: function(response) {
                    //pembentukan array dari response
                    var status = response.split("|")
                    if (status[0] == "Success") {
                        if(status[2] == "in") {
                            //memainkan element audio notifikasi in
                            notifikasi_in.play();

                        } else{
                            //memainkan element audio notifikasi out
                            notifikasi_out.play();
                        }
                        Swal.fire({
                            title: 'Success!',
                            text: status[1],
                            icon: 'success',
                        })
                        //jika absen berhasil akan pindah ke halaman dashboard setelah 3 detik
                        setTimeout("location.href='/dashboard'", 3000);
                    } else {
                        if(status[2]== 'radius'){
                            //memainkan element audio diluar radius
                            diluar_radius.play();
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: status[1],
                            icon: 'error',
                        })

                    }
                }
            })
        });
    </script>
@endpush
