@extends('layout')

<?php
$title = "My Profile";
?>

@section('content')

<style>
    .btn {
        margin: 0 3px;
    }

    .form-group {
        padding-bottom: 10px;

    }
</style>


<div class="container">
    <!-- <div class="col-lg-5 content">
            <div class="myRow" style="display: flex;
        justify-content: space-between;
        margin: 20px 0;">
                <span class="left-span" id="top-left-lat"> <button type="button" style="margin-bottom: 25px;"
                        class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Update My Location
                    </button></span>
            </div>
        </div> -->
    <div class="col-lg content" style="padding:10px 2%;">
        <form method="POST" action="/updateProfile">
            {{csrf_field()}}
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" readonly name="email" class="form-control-plaintext" id="staticEmail" value="{{$user->email}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" value="{{$user->name}}" class="form-control" id="name" placeholder="name">
                </div>
            </div>
            <!-- <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Longitude</label>
                <div class="col-sm-10">
                    <input type="text" readonly value="{{$user->info->lon}}" class="form-control" id="longitude" placeholder="Longitude">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Latitude</label>
                <div class="col-sm-10">
                    <input type="text" readonly value="{{$user->info->lat}}" class="form-control" id="latitude" placeholder="Latitude">
                </div>
            </div> -->
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Region</label>
                <div class="col-sm-10">
                    <input type="text" value="{{$user->info->lga}}" readonly class="form-control-plaintext" id="latitude" placeholder="Latitude">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">State</label>
                <div class="col-sm-10">
                    <input type="text" value="{{$user->info->state}}" readonly class="form-control-plaintext" id="state" placeholder="State">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Country</label>
                <div class="col-sm-10">
                    <input type="text" value="{{$user->info->country}}" readonly class="form-control-plaintext" id="country" placeholder="Country">
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
@endsection