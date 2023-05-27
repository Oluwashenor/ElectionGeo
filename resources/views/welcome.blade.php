@extends('layout')

<?php
$title = "Dashboard";
?>

@section('content')

<style>
    .btn {
        margin: 0 3px;
    }

    #titleDiv {
        margin-top: 10px;
        margin-bottom: 5px;
    }
</style>


<div class="container" style="margin-top: 15px;margin-bottom:20px;">
    <div id="titleDiv" class="row" style="text-align: center;display:flex;justify-content:center;">Overall Stats</div>
    <div class="row justify-content-between" style="text-align:center;">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="text-align: center;">80</h5>
                    <p class="card-text" style="text-align: center;">Ongoing Elections</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="text-align: center;">80</h5>
                    <p class="card-text" style="text-align: center;">Completed Elections</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="text-align: center;">80</h5>
                    <p class="card-text" style="text-align: center;">Ongoing Elections</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="text-align: center;">80</h5>
                    <p class="card-text" style="text-align: center;">Ongoing Elections</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row" id="titleDiv" style="text-align: center;display:flex;justify-content:center;">On Going
        Elections</div>
    <div class="row justify-content-between">
        <div class="col-lg-3 content">
            <!-- Content for column 1 -->
        </div>
        <div class="col-lg-3 content">
            <!-- Content for column 2 -->
        </div>
        <div class="col-lg-3 content">
            <!-- Content for column 3 -->
        </div>
    </div>

</div>

</div>

@endsection