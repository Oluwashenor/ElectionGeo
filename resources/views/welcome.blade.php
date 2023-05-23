@extends('layout')

<?php
$title = "Dashboard";
?>

@section('content')

<style>
    .btn {
        margin: 0 3px;
    }
</style>


<div class="container">
    <div class="row">
        <div class="col-lg-5 content">

            <div class="myRow" style="display: flex;
        justify-content: space-between;
        margin: 20px 0;">
                <span class="left-span" id="top-left-lat"> <button type="button" style="margin-bottom: 25px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Add Contestant
                    </button></span>

            </div>
        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-6 content" style="text-align:center;">
            <div style="display:inline-block;width:310px;height:310px;">
                <canvas id="myChart"></canvas>

            </div>
            <div>

            </div>

        </div>
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