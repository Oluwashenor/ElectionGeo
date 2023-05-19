@extends('welcome')

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

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 content">
                <button type="button" style="margin-bottom: 25px;" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop">
                    Add Contestant
                </button>
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
                                <!-- <a href="/edit-contestant/{{$contestant->id}}/{{$election_id}}"
                                    class="btn btn-secondary">Edit</a> -->
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
            <div class="col-lg-7 content" style="text-align:center;">
                <div style="display:inline-block;width:310px;height:310px;">
                    <canvas id="myChart"></canvas>

                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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