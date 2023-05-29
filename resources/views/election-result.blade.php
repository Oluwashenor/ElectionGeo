@extends('layout')

<?php
$title = $election->name . "'s " . "Result";
?>

@section('content')

<style>
    .btn {
        margin: 0 3px;
    }

    strong {}
</style>


<div class="container">
    <!-- Button trigger modal -->
    <div class="row">
        <div class="col-lg-5 content" style="overflow-y:auto;overflow-x:hidden;max-height:65vh;">
            <div class="myRow" style="display: flex;
        justify-content:center;
        margin: 10px 0;">
                <span class="left-span" id="top-left-lat">
                    <p class="lead">
                        <strong>Election Summary</strong>
                    </p>
                </span>
            </div>
            <hr>
            <p><strong>Total Votes : </strong><small>2</small></p>
            <p><strong>Election Date :</strong><small>Today</small></p>
            <p><strong>Total Contestants : </strong><small>2</small></p>

            @foreach($vote_result as $contestant)
            <div class="aspirant" style="margin-bottom: 10px;padding:10px;">
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
            <hr>
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
            <div class="myRow" style="display: flex;
        justify-content:center;
        margin: 20px 0;">
                <span class="left-span" id="top-left-lat"> <button type="button" style="margin-bottom: 25px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        View Votes Locations
                    </button></span>
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
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Location Summary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <?php
                        $totalLocation = count($groupedVotersByTown);

                        ?>
                        <!-- {{json_encode($groupedVotersByTown)}} -->
                        <!-- Total Locations - {{$totalLocation}} -->

                        @foreach($groupedVotersByTown as $location)

                        <?php
                        $locationVoteCount = count($location);
                        ?>
                        <p class="lead">
                            <b>Votes From {{json_encode($location[0]->lga)}}</b> - {{$locationVoteCount}}
                        </p>


                        @endforeach
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