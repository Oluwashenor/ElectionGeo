@extends('layout')

<?php
$title = "Elections";
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
        <div class="col-lg-5 content">

            <div class="myRow" style="display: flex;
        justify-content: space-between;
        margin: 20px 0;">
                <span class="left-span" id="top-left-lat"> <button type="button" style="margin-bottom: 25px;"
                        class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Add Contestant
                    </button></span>

                <span class="right-span" id="top-left-lng">
                    <a href="/map/{{$election_id}}" class="btn btn-primary">
                        @if($election->top_left_lat == null)
                        Set Coordinates

                        @else
                        Update Coordinates

                        @endif
                    </a>
                </span>


            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Contestant Name</th>
                        <th scope="col">Manage</th>
                    </tr>
                    @php
                    $counter = 0

                    @endphp
                    @foreach ($contestants as $contestant)
                    @php
                    $counter = $counter + 1;
                    @endphp
                    <tr>
                        <th scope="row">{{$counter}}</th>
                        <td>{{$contestant->name}}</td>
                        <td>
                            <a class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop{{$contestant->id}}">Edit</a>
                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop{{$contestant->id}}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="staticBackdropLabel{{$contestant->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="/edit-contestant">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel{{$contestant->id}}">
                                                    Edit
                                                    Contestant</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                {{csrf_field()}}
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label">Contestant
                                                        Name</label>
                                                    <input type="text" class="form-control"
                                                        value="{{$contestant->name}}" name="name">
                                                </div>
                                                <div class="mb-3">
                                                    <input value="{{$contestant->id}}" type="hidden"
                                                        class="form-control" name="contestant_id">
                                                </div>
                                                <input value="{{$election_id}}" type="hidden" class="form-control"
                                                    name="election_id">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <a href="/delete-contestant/{{$contestant->id}}/{{$election_id}}"
                                class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </thead>
                <tbody>


                </tbody>
            </table>
        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-6 content" style="text-align:center;">
            <div style="display:inline-block;width:310px;height:310px;">
                <canvas id="myChart"></canvas>

            </div>
            <div>
                <!-- {{json_encode($vote_result)}} -->

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
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
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