@extends('layouts.auth-layout')

<?php
$title = "E-Mail Confirmation";
?>

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="login-wrap p-4 p-md-5">
            <div class="icon d-flex align-items-center justify-content-center">
                <span class="fa fa-user-o"></span>
            </div>
            <h3 class="text-center mb-4">Enter Your New Password</h3>
            <form class="login-form" method="POST" action="/updatePassword">
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
                {{csrf_field()}}
                <div class="form-group">
                    <input type="email" class="form-control rounded-left" hidden value="{{$email}}" name="email"
                        placeholder="E-Mail" required>
                </div>
                <div class="form-group d-flex">
                    <input type="password" class="form-control rounded-left" placeholder="Password" name="password"
                        required>
                </div>
                <div class="form-group d-flex">
                    <input type="password" class="form-control rounded-left" placeholder="Password"
                        name="password_confirmation" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary rounded submit p-3 px-5">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection