@extends('layouts.auth-layout')

<?php
$title = "Login";
?>

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="login-wrap p-4 p-md-5">
            <div class="icon d-flex align-items-center justify-content-center">
                <span class="fa fa-user-o"></span>
            </div>
            <h3 class="text-center mb-4">Login To Vote</h3>
            <form class="login-form" method="POST" action="/voterslogin">
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
                {{csrf_field()}}
                <div class="form-group">
                    <input type="email" class="form-control rounded-left" name="email" placeholder="Email" required>
                </div>
                <div class="form-group d-flex">
                    <input type="string" class="form-control rounded-left" name="name" placeholder="Full Name" required>
                </div>
                <div class="form-group d-flex">
                    <input type="hidden" class="form-control rounded-left" id="lat" name="lat" placeholder="Latitude">
                </div>
                <div class="form-group d-flex">
                    <input type="hidden" class="form-control rounded-left" id="lon" name="lon" placeholder="Longitude">
                </div>
                <div style="align: center;" class="w-50">
                    <a href="/adminlogin">Admin Login</a>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary rounded submit p-3 px-5">Proceed To Vote</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection