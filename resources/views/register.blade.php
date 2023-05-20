@extends('layouts.auth-layout')

<?php
$title = "Register";
?>

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="login-wrap p-4 p-md-5">
            <div class="icon d-flex align-items-center justify-content-center">
                <span class="fa fa-user-o"></span>
            </div>
            <h3 class="text-center mb-4">Register Your Account</h3>
            <form action="/registerAction" method="POST" class="login-form">
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
                {{csrf_field()}}
                <div class="form-group">
                    <input type="text" class="form-control rounded-left" placeholder="Email" name="email" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control rounded-left" placeholder="Name" name="name" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control rounded-left" placeholder="Phone" name="phone" required>
                </div>
                <div class="form-group d-flex">
                    <input type="password" class="form-control rounded-left" placeholder="Password" name="password" required>
                </div>
                <div class="form-group d-flex">
                    <input type="password" class="form-control rounded-left" placeholder="Password" name="password_confirmation" required>
                </div>
                <div class="form-group d-flex">
                    <input type="text" class="form-control rounded-left" id="lat" name="lat" placeholder="Latitude" required>
                </div>
                <div class="form-group d-flex">
                    <input type="text" class="form-control rounded-left" id="lon" name="lon" placeholder="Longitude" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary rounded submit p-3 px-5">Get
                        Started</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection