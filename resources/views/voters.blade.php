@extends('welcome')

<?php
$title = "Voting Module";
?>

@section('content')

<div class="container content">
    <!-- Button trigger modal -->




    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Election Name</th>
                    <th scope="col">Election Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($elections as $election)
                @php
                $counter = 0;
                $counter = $counter + 1;
                $data = $election;
                $data
                @endphp
                <tr>

                    <th scope="row">1</th>
                    <td>{{$election->name}}</td>
                    <td>{{$election->election_date}}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{$election->id}}">
                            Vote
                        </button>
                        <div class="modal fade" id="staticBackdrop{{$election->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel{{$election->id}}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel{{$election->id}}">Vote</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="/submit-vote">
                                        <div class="modal-body">

                                            <div class="form-check">
                                                <input class="form-control" type="hidden" name="election" value="{{$election->id}}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control" name="email">
                                            </div>
                                            {{csrf_field()}}
                                            @foreach($data->contestants as $contestant)
                                            <div class="form-check">
                                                <input required class="form-check-input" type="radio" name="contestant" value="{{$contestant->id}}" id="contestant">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    {{$contestant->name}}
                                                </label>
                                            </div>
                                            @endforeach

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit Vote</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>

                @endforeach

            </tbody>
        </table>
    </div>

</div>

@endsection