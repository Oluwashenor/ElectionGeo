@extends('layout')

<?php
$title = "My Profile";
?>

@section('content')
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

<style>
.btn {
    margin: 0 3px;
}

.form-group {
    padding-bottom: 10px;

}

.locationCard {
    max-width: fit-content;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    background-color: #fff;
    padding: 5px;
}
</style>


<div class="container">
    <div class="col-lg content" style="padding:20px 2%;">
        <button onclick="locationUpdate()" type="submit" class="btn btn-secondary"> <span style=""
                class="material-symbols-outlined">
                location_on
            </span></button>
        <form method="POST" action="/updateProfile">
            {{csrf_field()}}

            <div class="form-group row" style="margin-top: 2%;">
                <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" readonly name="email" class="form-control-plaintext" id="staticEmail"
                        value="{{$user->email}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" value="{{$user->name}}" class="form-control" id="name"
                        placeholder="name">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Longitude</label>
                <div class="col-sm-10">
                    <input type="text" name="lon" readonly value="{{$user->info->lon ?? ''}}"
                        class="form-control-plaintext" id="longitude" placeholder="Longitude">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Latitude</label>
                <div class="col-sm-10">
                    <input type="text" name="lat" readonly value="{{$user->info->lat  ?? ''}}"
                        class="form-control-plaintext" id="latitude" placeholder="Latitude">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Region</label>
                <div class="col-sm-10">
                    <input type="text" value="{{$user->info->lga  ?? ''}}" readonly class="form-control-plaintext"
                        id="latitude" placeholder="Region">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">State</label>
                <div class="col-sm-10">
                    <input type="text" value="{{$user->info->state  ?? ''}}" readonly class="form-control-plaintext"
                        id="state" placeholder="State">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Country</label>
                <div class="col-sm-10">
                    <input type="text" value="{{$user->info->country  ?? ''}}" readonly class="form-control-plaintext"
                        id="country" placeholder="Country">
                </div>
            </div>
            <div class="form-group row">

                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="pull-left">
            <button type="button" class="btn btn-default btn-lg">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </button>
        </div>

        <div class="pull-right">
            <button type="button" class="btn btn-default btn-lg">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </button>
        </div>
    </div>
    <!-- Modal -->

</div>

</div>
<script>
function locationUpdate() {
    console.log("Trying to Fetch Location");
    if (navigator.geolocation) {
        console.log("Location");
        var options = {
            enableHighAccuracy: true // Add this option to enable high accuracy
        };
        navigator.geolocation.getCurrentPosition(showPosition, showError, options);
    } else {
        console.log("Geolocation is not supported");
        // Geolocation is not supported
    }

    function showPosition(position) {
        console.log("Trying to get coordinates");
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        console.log("Latitude :", latitude);
        console.log("Longitude :", longitude);
        let latElement = document.getElementById("latitude");
        latElement.value = latitude;
        let lonElement = document.getElementById("longitude");
        lonElement.value = longitude;
    }

    function showError(error) {
        console.log(error);
    }
}
</script>

@endsection