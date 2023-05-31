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

    #titleDiv span {
        font-size: larger;
    }
</style>


<div class="container" style="margin-top: 15px;margin-bottom:20px;">
    <div id="titleDiv" class="row" style="text-align: center;display:flex;justify-content:center;"><span>Overall
            Stats</span></div>
    <div class="row justify-content-between" style="text-align:center;">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="text-align: center;">{{$allOngoingElectionsCount}}</h5>
                    <p class="card-text" style="text-align: center;">Ongoing Elections</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="text-align: center;">{{$totalUsers}}</h5>
                    <p class="card-text" style="text-align: center;">Total Users</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="text-align: center;">{{$allElectionsCount}}</h5>
                    <p class="card-text" style="text-align: center;">Total Elections</p>
                </div>
            </div>
        </div>
    </div>
</div>


@if($elections != null)
<div class="container">
    <div class="row" id="titleDiv" style="text-align: center;display:flex;justify-content:center;">On Going
        Elections</div>
    <div class="row justify-content-between">
        @foreach($elections as $election)
        <div class="col-lg-3 content" style="height:120px;text-align: center;font-size:larger;">
            {{$election->name}}
            <p><a href="/election-result/{{$election->id}}">View Result</a></p>
        </div>
        @endforeach
    </div>

</div>

@else
<div class="container" style="text-align: center;margin-top:10%;">
    There are currently no elections on going
</div>

@endif

</div>

@endsection