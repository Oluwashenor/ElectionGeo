<!DOCTYPE html>
<html class="h-100">

<?php
$appName = "NIN Server";
?>

<head>
    <title>{{$appName}}</title>
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

    .btn-primary {
        background: #8d448b !important;
        border: 1px solid #8d448b !important;
        color: #fff !important;
    }
    </style>
</head>


<body class="d-flex flex-column h-100">
    <div class="titleLayer">
        <nav class="navbar navbar-expand-lg myNav">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">{{$appName}}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @auth
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <div class="d-flex" role="search">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li style="float: right;" class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ Session::get('name')}}
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/profile/{{Auth::user()->email}}">Profile</a>
                                    </li>
                                    <li><a class="dropdown-item" href="/logout">Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                @endauth

                @guest
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">

                        </li>
                    </ul>
                    <div class="d-flex" role="search">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li style="float: right;" class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ Session::get('email') ?? "Admin"}}
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/profile/{{ Session::get('email')}}">Profile</a>
                                    </li>
                                    <li><a class="dropdown-item" href="/logout">Leave</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                @endguest
            </div>
        </nav>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight titleHeader">
            Dashboard
        </h2>
    </div>

    <div class="container content">
        <!-- Button trigger modal -->

        <button style="margin-bottom: 25px;" type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#staticBackdrop">
            Add New User
        </button>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add New Record</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="/create-nin-record">
                        <div class="modal-body">

                            {{csrf_field()}}
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">First Name</label>
                                <input type="text" required class="form-control" name="firstname">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Last Name</label>
                                <input type="text" required class="form-control" name="lastname">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Address</label>
                                <input type="text" required class="form-control" name="address">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">NIN</label>
                                <input type="text" required class="form-control" name="nin">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Date Of Birth</label>
                                <input type="date" required class="form-control" name="dob">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">NIN</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                @php
                $counter = 0;
                @endphp
                <tbody>
                    @foreach ($records as $record)
                    @php
                    $counter++;
                    @endphp
                    <tr>
                        <th scope="row">{{$counter}}</th>
                        <td>{{$record->firstname}}</td>
                        <td>{{$record->lastname}}</td>
                        <td>{{$record->nin}}</td>
                        <td>
                            <a href="/manage-election/{{$record->id}}" style="margin:0 5px;"
                                class="btn btn-primary">Manage</a><a href="/delete-election/{{$record->id}}"
                                class="btn btn-danger">Delete</a>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>


</body>

<footer style="bottom:0" class="footer mt-auto py-3 bg-light">
    <div class="container" style="text-align: center;">
        <span class="text-muted">&copy; {{$appName}} 2023</span>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"
    integrity="sha512-i9cEfJwUwViEPFKdC1enz4ZRGBj8YQo6QByFTF92YXHi7waCqyexvRD75S5NVTsSiTv7rKWqG9Y5eFxmRsOn0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@include('sweetalert::alert')

</html>




<?php
$title = "NIN Database";
?>