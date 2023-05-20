<!DOCTYPE html>
<html>

<head>
    <title>My App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">

    <style>
    body {
        font-family: "ui-sans-serif", sans-serif;
        background-color: #F3F4F6;
    }

    .nav-item {
        margin: 0 6px;
    }

    .titleLayer {
        padding-top: 9px;
        height: calc(2 * 64px);
        background-color: white;
    }

    .myNav {
        background-color: white;
        border-bottom: 0.5px solid #cccccc;
    }

    .titleHeader {
        font-size: 140%;
        text-align: left;
        margin-top: 20px;
        margin-left: 15px;
        font-weight: bold;
    }

    .content {
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        min-height: 100px;
        margin-top: 4%;
        background-color: white;
        border-radius: 10px;
        padding-top: 20px;

    }
    </style>
</head>

<?php
$title = "ELECTION"
?>

<body>
    <div class="titleLayer">
        <!-- <nav class="navbar navbar-expand-lg navbar-light myNav">
            <div class="container" style="background-color: white;">
                <div class="container-fluid">

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                        </ul>
                    </div>
                </div>
        </nav> -->

        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="/elections">Elections</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/voting">Vote</a>
                        </li>
                        <li style="float: right;" class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                {{Auth::user()->name}}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/logout">Log Out</a></li>
                            </ul>
                        </li>
                        @endauth

                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="/voting">Vote</a>
                        </li>

                        <li style="float: right;" class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                {{ Session::get('email')}}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/logout">Leave</a></li>
                            </ul>
                        </li>
                        @endguest


                    </ul>
                    <!-- <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form> -->
                </div>
            </div>
        </nav>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight titleHeader">
            {{$title}}

        </h2>
    </div>


    @yield('content')

</body>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
</script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"
    integrity="sha512-i9cEfJwUwViEPFKdC1enz4ZRGBj8YQo6QByFTF92YXHi7waCqyexvRD75S5NVTsSiTv7rKWqG9Y5eFxmRsOn0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
// fetch(`https://api.ipgeolocation.io/ipgeo?apiKey=9d6264923565480a8f988d647cf90e8b&ip=129.205.113.166`)
//     .then(response => response.json())
//     .then(data => {
//         // User's geolocation data is available
//         var lat = data.latitude;
//         var lon = data.longitude;
//         console.log(lat, lon);
//         // Use lat and lon to determine whether user is in eligible region
//     })
//     .catch(error => {
//         // Geolocation access was denied or there was an error
//         // Handle error here
//     });
</script>
@include('sweetalert::alert')

</html>