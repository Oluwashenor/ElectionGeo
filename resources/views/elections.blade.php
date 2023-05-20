@extends('welcome')

<?php
$title = "Elections";
?>

@section('content')

<div class="container content">
    <!-- Button trigger modal -->

    <button style="margin-bottom: 25px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Create Election
    </button>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Election</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/create-election">
                        {{csrf_field()}}
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Election Name</label>
                            <input type="text" required class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Date Of Election</label>
                            <input type="date" required class="form-control" name="election_date">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Election Name</th>
                    <th scope="col">Election Date</th>
                    <th scope="col">Manage</th>
                </tr>
            </thead>
            @php
            $counter = 0;
            @endphp
            <tbody>
                @foreach ($elections as $election)
                @php
                $counter++;
                @endphp
                <tr>
                    <th scope="row">{{$counter}}</th>
                    <td>{{$election->name}}</td>
                    <td>{{$election->election_date}}</td>
                    <td><a href="/manage-election/{{$election->id}}" class="btn btn-primary">Manage</a></td>

                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>

@endsection