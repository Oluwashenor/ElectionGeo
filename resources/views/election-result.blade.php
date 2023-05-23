@extends('layout')

<?php
$title = $election->name . "'s " . "Result";
?>

@section('content')

<style>
    .btn {
        margin: 0 3px;
    }
</style>


<div class="container">
    <!-- Button trigger modal -->
    <div class="row">
        <div class="col-lg-5 content" style="overflow-y:auto;overflow-x:hidden;max-height:65vh;">
            <div class="myRow" style="display: flex;
        justify-content: space-between;
        margin: 20px 0;">
                <span class="left-span" id="top-left-lat"> Contestants Summary</span>
            </div>



            @foreach($vote_result as $contestant)
            <div class="aspirant" style="margin-bottom: 20px;padding:10px;">
                <div class="row">
                    <!-- <div class="col-2">
                        <img width="50px" src="~/images/avatar.png" alt="img" />
                    </div> -->
                    <div class="col-10">
                        <div class="card-body" style="padding:3px">
                            <h6 class="card-title"> {{$contestant->contestant_name}} </h6>
                            <p class="card-subtitle mb-2 text-muted">{{$contestant->total_vote}} Votes</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <span class="card-subtitle mb-2 text-muted"> </span>
                        <div class="progress" role="progressbar" aria-label="label" aria-valuenow="{{$contestant->vote_percentage}}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: {{$contestant->vote_percentage}}%; background-color:{{$contestant->color}}">
                                {{$contestant->vote_percentage}}%
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            @endforeach
        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-6 content" style="text-align:center;">
            <div style="display:inline-block;width:310px;height:310px;">
                <canvas id="myChart"></canvas>

            </div>
            <!-- <div>
                {{json_encode($vote_result)}}

            </div> -->

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
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Contestant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/create-contestant">
                        {{csrf_field()}}
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Contestant Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <input value="{{$election_id}}" type="hidden" class="form-control" name="election_id">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </div>
    </div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js">
</script>

<script>
    var vote_result = @json($vote_result);
    const ctx = document.getElementById('myChart');
    var chartJ = new Chart(ctx, {
        type: 'doughnut',
        data: {

            datasets: [{
                label: 'Result',
                data: vote_result.map(x => x.total_vote),
                backgroundColor: vote_result.map(x => x.color),
                hoverOffset: 4
            }],

            labels: vote_result.map(x => x.contestant_name)
        },
    });
</script>


@endsection